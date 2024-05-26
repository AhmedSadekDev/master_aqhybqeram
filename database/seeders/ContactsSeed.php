<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 30; $i++) { 
            Contact::create([
                'name'      => "User-$i",
                'email'     => "User-$i@gmail.com",
                'message'   => "User-User-User-User-User-User-User",
            ]);
        }
    }
}
