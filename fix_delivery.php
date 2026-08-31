<?php
use App\Models\Order;
$orders = Order::where('source', 'Shopify')->whereNull('delivery_date')->get();
foreach($orders as $o) {
    $o->delivery_date = $o->created_at->toDateString();
    $o->save();
}
