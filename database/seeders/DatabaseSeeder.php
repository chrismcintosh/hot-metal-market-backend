<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'chrismcintosh',
            'email' => 'chris@mcintosh.io',
            'password' => Hash::make('password')
        ]);

        \App\Models\Product::factory(10)->create();
    }
}
