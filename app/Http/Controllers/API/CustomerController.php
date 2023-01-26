<?php

namespace App\Http\Controllers\API;

use App\Enums\AddressType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\API\CustomerListResource;
use App\Http\Resources\API\CustomerResource;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Exception;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search',false);
        $perPage = request('per_page',20);
        $sortBy = request('sortBy','created_at');
        $order = request('order','desc');

        $query = Customer::query();
        if($search){
            $query->where('first_name','like',"%{$search}%");
        }
        $query->orderBy($sortBy,$order);

        return CustomerListResource::collection($query->paginate($perPage));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    /*public function store(CustomerRequest $request)
    {
        $data = $request->validated();
        $data['is_admin'] = true;
        $data['email_verified_at'] = date('Y-m-d H:i:s');
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $customer = new Customer();

        $names =  explode(" " , $user->name);
        $customer->user_id=$user->id;
        $customer->first_name = $names[0];
        $customer->last_name = $names[1] ?? '';
        $customer->save();

        return new UserResource($user);
    }*/
    public function show(Customer $customer)
    {
        if($customer->shippingAddress && $customer->billingAddress)
        return new CustomerResource($customer);
        else
            return response($customer);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customerData=$request->validated();

        $customerData['updated_by'] = $request->user()->id;
        $shippingData = $customerData['shippingAddress'];
        $billingData = $customerData['billingAddress'];

        $customer->update($customerData);

        if ($customer->shippingAddress) {
            $customer->shippingAddress->update($shippingData);
        } else {
            $shippingData['customer_id'] = $customer->user_id;
            $shippingData['type'] = AddressType::Shipping->value;
            CustomerAddress::create($shippingData);
        }
        if ($customer->billingAddress) {
            $customer->billingAddress->update($billingData);
        } else {
            $billingData['customer_id'] = $customer->user_id;
            $billingData['type'] = AddressType::Billing->value;
            CustomerAddress::create($billingData);
        }

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $user = $customer->user;

        $names =  explode(" " , $user->name);
        $customer->user_id=$user->id;
        $customer->first_name = $names[0];
        $customer->last_name = $names[1] ?? '';

        $customer->update();

        return response(['message' => 'Datos del cliente borrados corectamente']);
    }
}
