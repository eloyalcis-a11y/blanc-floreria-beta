<?php
$orders = App\Models\Order::all();
$updatedCount = 0;
foreach ($orders as $order) {
    if ($order->discount > 0 && $order->unit_price > 0) {
        $percentage = round(($order->discount / $order->unit_price) * 100, 2);
        if ($percentage > 100) $percentage = 100;
        $order->discount = $percentage;
        $order->save();
        $updatedCount++;
    }
}
echo "Updated $updatedCount orders.\n";
