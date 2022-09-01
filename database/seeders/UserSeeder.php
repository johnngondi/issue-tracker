<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'super@admin.com',
                'password' => Hash::make('S3cr3t!ve'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('model_has_roles')->insert([
            [
                'role_id' => 1,
                'model_type' => 'App\Models\User',
                'model_id' => 1
            ],
            [
                'role_id' => 2,
                'model_type' => 'App\Models\User',
                'model_id' => 1
            ]

        ]);
    }
}
