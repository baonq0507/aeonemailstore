<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Level;
class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'name' => 'Thành viên mới',
                'order' => 60,
                'commission' => 0.2,
                'min_balance' => 0,
                'description' => 'Túi xách | Quần áo nữ | Quần áo nam | Giày | Dép | Máy chiếu',
                'valid_days' => 365,
                'image' => 'images/lv1.png',
            ],
            [
                'name' => 'Thành viên vàng',
                'order' => 180,
                'commission' => 0.4,
                'min_balance' => 3000000,
                'description' => 'Son môi | Nước hoa | Kem nền | Gương | Xe đạp | Tủ lạnh | Quần',
                'valid_days' => 365,
                'image' => 'images/lv2.png',
            ],
            [
                'name' => 'Thành viên bạch kim',
                'order' => 240,
                'commission' => 0.5,
                'min_balance' => 5000000,
                'description' => 'Đồng hồ | Máy ảnh | Âm thanh | Máy chủ | Máy hút bụi | Móc áo',
                'valid_days' => 365,
                'image' => 'images/lv3.jpg',
            ],
            [
                'name' => 'Thành viên kim cương',
                'order' => 300,
                'commission' => 0.6,
                'min_balance' => 10000000,
                'description' => 'Đồng hồ | Máy ảnh | Âm thanh | Máy chủ | Máy hút bụi | Móc áo',
                'valid_days' => 365,
                'image' => 'images/lv4.jpg',
            ],
        ];
        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
