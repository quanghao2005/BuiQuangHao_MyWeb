<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::where('email', 'A@gmail.com')->first();
if ($user) {
    \App\Models\Customer::where('id', 14)->update(['user_id' => $user->id]);
    echo "Success!\n";
} else {
    echo "User not found\n";
}
