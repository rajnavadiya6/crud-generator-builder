<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            'name'              => 'Super Admin',
            'email'             => 'admin@admin.com',
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('123456'),
        ];

        $user = User::create($input);
    }
}
