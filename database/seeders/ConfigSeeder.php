<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Config;
class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $config = [
            [
                'key' => 'min_deposit',
                'value' => '10'
            ],
            [
                'key' => 'max_deposit',
                'value' => '1000'
            ],
            [
                'key' => 'deposit_fee',
                'value' => '0.05'
            ],
            [
                'key' => 'name_website',
                'value' => 'AeonmailStore'
            ],
            [
                'key' => 'title_website',
                'value' => 'AeonmailStore'
            ],
            [
                'key' => 'description_website',
                'value' => 'AeonmailStore'
            ],
            [
                'key' => 'livechat_id',
                'value' => '1234567890'
            ]

        ];
        foreach ($config as $item) {
            Config::create($item);
        }
    }
}
