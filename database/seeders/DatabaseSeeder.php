<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'full_name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone_number' => '0909090909',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'invite_code' => 'admin',
            'referrer_id' => null,
            'product_id' => null,
            'level_id' => null,
            'status' => true,
            'bank_name' => 'Vietcombank',
            'bank_account' => '1234567890',
            'bank_owner' => 'Nguyễn Văn A',
            'bank_number' => '1234567890',
            'password2' => '12345678',
            'address' => 'Hà Nội',
        ]);

        $this->call([
            LevelSeeder::class,
            ProductSeeder::class,
            ConfigSeeder::class,
        ]);
    }
}
