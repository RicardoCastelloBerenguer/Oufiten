<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $orderItems = [];

        foreach ($this->orderItems as $item){
            $orderItems[] = new OrderItemsResource($item);
        }

        return [
            'id' => $this->id,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'order_items' => $orderItems,
            'customer' => new CustomerResource($this->user->customer),
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
