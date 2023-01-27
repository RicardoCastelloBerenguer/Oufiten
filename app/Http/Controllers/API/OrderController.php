<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\API\UserListResource;
use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\UserResource;
use App\Mail\updateOrderEmail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $search = request('search',false);
        $perPage = request('per_page',20);
        $sortBy = request('sortBy','created_at');
        $order = request('order','desc');


        if($search && !is_null($search)){
            $user = DB::table('users')
                ->where('name', 'like', "%{$search}%")
                ->get();
            $userCollection = UserResource::collection($user)[0];
        }

        $query = Order::query();

        if($search){
            $query->where('created_by','=',$userCollection->id);
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
