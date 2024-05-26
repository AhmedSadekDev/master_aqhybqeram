<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class ContentsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Content::create([
            'title' => 'من نحن',
            'value' => 'سيبلات سيبلاتن يبلات',
        ]);
        Content::create([
            'title' => 'الشروط والأحكام',
            'value' => 'سيبلات سيبلاتن يبلات',
        ]);
    }
}
