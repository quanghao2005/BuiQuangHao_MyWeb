<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Add 7 hours to all orders to fix the UTC offset
$orders = \App\Models\Order::all();
foreach ($orders as $order) {
    if ($order->created_at) {
        $order->created_at = $order->created_at->addHours(7);
        // Turn off timestamps to avoid modifying updated_at if not needed
        $order->timestamps = false;
        $order->save();
    }
}
echo "Fixed times for " . $orders->count() . " orders.\n";
