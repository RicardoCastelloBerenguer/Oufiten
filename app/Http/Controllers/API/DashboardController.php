<?php

namespace App\Http\Controllers\API;

use App\Enums\AddressType;
use App\Enums\CustomerStatus;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderListResource;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function customersTotal()
    {
        return Customer::query()->get()->count();
    }
    public function totalProfit()
    {
        return Order::query()->where('status',OrderStatus::Paid->value)->sum('total_price');
    }
    public function paidOrders()
    {
        return Order::query()->where('status',OrderStatus::Paid->value)
            ->orWhere('status',OrderStatus::Completed->value)
            ->count();
    }
    public function activeProducts()
    {
        return Product::query()->where('show_catalogue','=',true)->count();
    }

    public function ordersPaidByCountry()
    {
        $ordersBy = Order::query()
            ->select(['c.name', DB::raw('count(orders.id) as count')])
            ->join('users', 'created_by', '=', 'users.id')
            ->join('customer_addresses AS a', 'users.id', '=', 'a.customer_id')
            ->join('countries AS c', 'a.country_code', '=', 'c.code')
            ->whereIn('status', [OrderStatus::Paid->value,OrderStatus::Completed->value])
            ->where('a.type', AddressType::Billing->value)
            ->groupBy('c.name')->get();

        return $ordersBy;
    }

    public function latestCustomers()
    {
        return Customer::query()
            ->select('id','first_name' , 'last_name' , 'u.email' , 'phone','customers.created_at')
            ->join('users AS u','u.id','=','customers.user_id')
            ->orderBy('customers.created_at','desc')
            ->limit(5)
            ->get();
    }

    public function latestOrders()
    {
        $orders = Order::query()
            //->whereIn('status', [OrderStatus::Paid->value,OrderStatus::Completed->value])
            ->limit(18)
            ->orderBy('created_at','desc')
            ->get();

        return OrderListResource::collection($orders);
    }



}
