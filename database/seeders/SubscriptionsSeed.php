<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscription::create([
            'name'      => 'Subscription 1',
            'price'     => 200,
            'month'     => 1,
        ]);
        Subscription::create([
            'name'      => 'Subscription 2',
            'price'     => 1000,
            'month'     => 12,
        ]);
    }
}
