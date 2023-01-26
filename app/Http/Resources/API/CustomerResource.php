<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

class CustomerResource extends JsonResource
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
        $shipping = $this->shippingAddress;
        $billing = $this->billingAddress;

        return [
            'id' => $this->user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->user->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'shippingAddress' => [
                'address1' => $shipping->address1,
                'address2' => $shipping->address2,
                'city' => $shipping->city,
                'community' => $shipping->community,
                'country_code' => $shipping->country->code,
                'zipcode' => $shipping->zipcode,
                'country' => $shipping->country,
            ],
            'billingAddress' => [
                'address1' => $billing->address1,
                'address2' => $billing->address2,
                'city' => $billing->city,
                'community' => $billing->community,
                'country_code' => $billing->country->code,
                'zipcode' => $billing->zipcode,
                'country' => $billing->country,
            ],
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:s')
        ];
    }
}
