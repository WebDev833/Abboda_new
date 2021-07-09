<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'order_id' => '#123321325',
          'order_status' => 'Completed',
          'customer_name' => 'John DOE',
          'customer_phone' => '+1 2314567890',
          'customer_email' => 'useremail@gmail.com',
          'order_address' => '#123 abc city state country 123450',
          'order_items' => 'Order Items Resource', // need to be a collection
          'driver_name' => 'John Doe', // below all -> conditional resource
          'driver_vehicle' => 'Motercycle',
          'merchant_name' => 'Dominos',
          'merchant_address' => '#123 abc city state country 123450',
          'items_cost' => '$540',
          'delivery_cost' => '$40',
          'payment_type' => 'Online Payment',
          'total' => '$800',
        ];
        //return parent::toArray($request);
    }
}
