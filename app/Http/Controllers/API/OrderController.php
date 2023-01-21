<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductListResource;
use App\Mail\updateOrderEmail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $search = request('search',false);
        $perPage = request('per_page',20);
        $sortBy = request('sortBy','created_at');
        $order = request('order','desc');

        $query = Order::query();
        if($search){
            $query->where('id','like',"%{$search}%");
        }
        $query->orderBy($sortBy,$order);
        return OrderListResource::collection($query->paginate($perPage));
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function update(OrderRequest $request,Order $order)
    {
        $data = $request->validated();

        $order->update($data);

        Mail::to($order->user)->send(new updateOrderEmail($order));

        return new OrderResource(($order));

    }
}
