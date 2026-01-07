<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run()
{
    \App\Models\Setting::create([
        'use_discount' => true,
        // add other default settings
    ]);
}

}
