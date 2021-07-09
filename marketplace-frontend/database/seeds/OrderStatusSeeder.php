<?php

use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order_statuses = array(
            array(
                'name' => 'New Order Received',
                'active' => '1',

            ),
            array(
                'name' => 'Order awaiting confirmation.',
                'active' => '1',

            ),
            array(
                'name' => 'Order cancelled by user.',
                'active' => '1',

            ),
            array(
                'name' => 'Order Cancelled by Manager.',
                'active' => '1',

            ),
            array(
                'name' => 'Order Cancelled by Driver.',
                'active' => '1',

            ),
            array(
                'name' => 'Order Accepted by Driver.',
                'active' => '1',

            ),
            array(
                'name' => 'Driver on the way.',
                'active' => '1',

            ),
            array(
                'name' => 'Completed',
                'active' => '1',

            ),
            array(
                'name' => 'Awaiting online payment',
                'active' => '1',

            ),
        );
        foreach ($order_statuses as $status) {
            $staObj = new \App\OrderStatus;
            $staObj->name = $status['name'];
            $staObj->active = (bool) $status['active'];
            $staObj->save();
        }
    }
}
