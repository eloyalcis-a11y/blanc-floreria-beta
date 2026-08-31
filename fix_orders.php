<?php
use App\Models\Order;
Order::whereIn('order_number', ['#Blanc2291', '#Blanc2290'])
      ->orWhereIn('id', [51, 50])
      ->update(['status' => 'Confirmado']);
