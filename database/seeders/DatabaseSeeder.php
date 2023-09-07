<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Admin::factory(10)->create();

        // \App\Models\Admin::create([
        //     'username'=>'alkut',
        //     'password'=>Hash::make('password')
        // ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        for($i =0;$i<=10;$i++){
            Category::create([
                'name'=>'category '.$i
            ]);
        }

    }
}
