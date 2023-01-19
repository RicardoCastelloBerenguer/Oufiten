<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Http\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $user = $request->user();

        $cartItems = Cart::getCartItems();
        $idsItems= Arr::pluck($cartItems,'product_id');
        $products = Product::query()->whereIn('id',$idsItems)->get();
        $cartItems = Arr::keyBy($cartItems,'product_id');

        $lineItems=[];

        //dd($cartItems);
        $total_price = 0;
        $orderItems=[];

        foreach ($products as $product){
            $total_price+=$product->price * $cartItems[$product->id]['quantity'];
            $lineItems[] =[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $product->title,
                        'images' => [$product->image]
                    ],
                    'unit_amount' => $product->price*100,
                ],
                'quantity' => $cartItems[$product->id]['quantity'],
            ];
            $orderItems [] = [
                'product_id' => $product->id,
                'quantity' => $cartItems[$product->id]['quantity'],
                'unit_price' => $product->price
            ];
        }

        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('payment.success',[],'yes').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel',[],'yes'),
            'customer_creation' => 'always'
        ]);

        $orderData=[
            'total_price' => $total_price,
            'status' => OrderStatus::Unpaid,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];


        $order = Order::create($orderData);


        $paymentData =[
            'order_id' => $order->id,
            'amount' => $total_price,
            'status'=> PaymentStatus::Pending,
            'type' => PaymentType::CreditCard,
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'session_id' => $checkout_session->id
        ];

        foreach ($orderItems as $orderItem){
            $orderItem['order_id']=$order->id;
            OrderItem::create($orderItem);
        }

        Payment::create($paymentData);

        CartItem::query()->where('user_id','=', $user->id)->delete();

        return redirect($checkout_session->url);
    }

    public function success(Request $request)
    {

        $user = $request->user();

        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

        try {
            $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);

            if(!$session)
                return view('payment.cancel',['message' => 'La sesión de tu pago es inválida']);

            $customer = $stripe->customers->retrieve($session->customer);

            /** @var \App\Models\Payment $payment */
            $payment = Payment::query()->where(['session_id' => $session->id])->first();

            if(!$payment)
                return view('payment.cancel',['message' => 'El pago no existe']);
            else if ($payment->status==PaymentStatus::Paid->value){
                //return view('payment.success');
                return view('payment.success' , compact('session' , 'customer'));
            }

            $payment->status=PaymentStatus::Paid;

            $payment->update();

            $order = $payment->order;

            $order->status = OrderStatus::Paid;

            $order->update();

            return view('payment.success' , compact('session' , 'customer'));
        }catch (\Exception $e){
            return view('payment.cancel',['message' => $e->getMessage()]);
        }
    }

    public function cancel(Request $request)
    {

    }

    public function resumeOrderPayment(Request $request,Order $order)
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

        $orderItems = $order->orderItems;

        $lineItems=[];

        foreach ($orderItems as $orderItem){
            $lineItems[] =[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $orderItem->product->title,
                        'images' => [$orderItem->product->image],
                    ],
                    'unit_amount' => $orderItem->product->price*100,
                ],
                'quantity' => $orderItem->quantity,
            ];
        };

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('payment.success',[],'yes').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel',[],'yes'),
            'customer_creation' => 'always'
        ]);

        $payment = $order->payment;

        $payment->session_id = $checkout_session->id;

        $payment->update();

        return redirect($checkout_session->url);
    }

    public function webhook(Request $request)
    {

        // webhook.php
        //
        // Use this sample code to handle webhook events in your integration.
        //
        // 1) Paste this code into a new file (webhook.php)
        //
        // 2) Install dependencies
        //   composer require stripe/stripe-php
        //
        // 3) Run the server on http://localhost:4242
        //   php -S localhost:4242



        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = 'whsec_45862b3ad4e5fa9632d3b4d787392f0e511b5b582f26ef3ff7f46557a98a3416';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('' , 401);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('' , 402);
        }

// Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':

                $paymentIntent = $event->data->object;
                $session = $paymentIntent;

                /** @var \App\Models\Payment $payment */
                $payment = Payment::query()->where(['session_id' => $session->id])->first();

                if(!$payment)
                    return view('payment.cancel',['message' => 'El pago no existe']);
                else if ($payment->status==PaymentStatus::Paid->value){
                    //return view('payment.success');
                    return view('payment.cancel',['message' => 'Este pago ya se completó, gracias por su compra']);
                }

                $payment->status=PaymentStatus::Paid;

                $payment->update();

                $order = $payment->order;

                $order->status = OrderStatus::Paid;

                $order->update();

            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('' , 200);
    }
}
