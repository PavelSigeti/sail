<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->insert([
            'name' => 'admin',
//            'surname' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123'),
//            'team_id' => 1,
//            'university_id' => 1,
//            'nickname' => 'Admin',
            'role' => 'admin',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        User::factory()->count(3)->create();
    }
}
