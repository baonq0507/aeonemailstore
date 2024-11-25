<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Level;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://www.cvtaobao3.online/api/getProduct');
        $data = $response->json();

        $products = $data['products'];

        $product_level1 = collect($products)->filter(function($item) {
            $keywords = ['Túi', 'Quần', 'Giày', 'Dép', 'Máy chiếu', 'Áo'];
            foreach ($keywords as $keyword) {
                if (str_contains(strtolower($item['name']), $keyword)) {
                    return true;
                }
            }
            return false;
        });
        $product_level2 = collect($products)->filter(function($item) {
            $keywords = ['Điện thoại', 'Tủ lạnh', 'Máy tính', 'Chuột', 'Xe máy', 'Mũ', 'Moto', 'Samsung', 'Apple', 'Computer', 'Laptop', 'Desktop', 'PC', 'iPad', 'Window'];
            foreach ($keywords as $keyword) {
                if (str_contains(strtolower($item['name']), $keyword)) {
                    return true;
                }
            }
            return false;
        });
        $product_level3 = collect($products)->filter(function($item) {
            $keywords = ['Son', 'Nước hoa', 'Mỹ phẩm', 'kem nền', 'Xe đạp', 'Tủ lạnh', 'Quần', 'Skin', 'Skincare', 'Serum', 'Lotion', 'Face', 'HEALTH'];
            foreach ($keywords as $keyword) {
                if (str_contains(strtolower($item['name']), $keyword)) {
                    return true;
                }
            }
            return false;
        });
        $product_level4 = collect($products)->filter(function($item) {
            $keywords = ['Đồng hồ', 'Máy ảnh', 'Âm thanh', 'Móc hút mùi', 'Móc áo', 'Camera', 'SereneLife', 'Canon', 'Headphones', 'Earphones'];
            foreach ($keywords as $keyword) {
                if (str_contains(strtolower($item['name']), $keyword)) {
                    return true;
                }
            }
            return false;
        });
        $level1 = Level::where('name', 'Thành viên mới')->first();
        $level2 = Level::where('name', 'Thành viên vàng')->first();
        $level3 = Level::where('name', 'Thành viên bạch kim')->first();
        $level4 = Level::where('name', 'Thành viên kim cương')->first();

        foreach ($product_level1 as $item) {
            Product::create([
                'name' => $item['name'],
                'level_id' => $level1->id,
                'price' => rand(50, 199),
                'image' => $this->downloadImage($item['image']),
            ]);
        }
        foreach ($product_level2 as $item) {
            Product::create([
                'name' => $item['name'],
                'level_id' => $level2->id,
                'price' => rand(200, 999),
                'image' => $this->downloadImage($item['image']),
            ]);
        }

        foreach ($product_level3 as $item) {
            Product::create([
                'name' => $item['name'],
                'level_id' => $level3->id,
                'price' => rand(1000, 2999),
                'image' => $this->downloadImage($item['image']),
            ]);
        }

        foreach ($product_level4 as $item) {
            Product::create([
                'name' => $item['name'],
                'level_id' => $level4->id,
                'price' => rand(3000, 4999),
                'image' => $this->downloadImage($item['image']),
            ]);
        }

        $dataCategoryLv1 = ['womens-bags', 'mens-bags', 'mans-dresses', 'womens-jewellery', 'mens-shoes', 'mens-shirts', 'womens-dresses', 'womens-shoes'];
        $dataCategoryLv2 = ['smartphones', 'laptops', 'motorcycle', 'smartphones'];
        $dataCategoryLv3 = ['fragrances', 'motorcycle', 'home-decoration', 'beauty'];
        $dataCategoryLv4 = ['mens-watches', 'womens-watches'];

        foreach ($dataCategoryLv1 as $category) {
            $response = Http::get('https://dummyjson.com/products/category/' . $category . '?limit=0');
            $data = $response->json();
            foreach ($data['products'] as $product) {
                foreach ($product['images'] as $image) {
                    Product::create([
                        'name' => $this->generateModel($product['title']),
                        'price' => rand(50, 199),
                        'image' => $this->downloadImage($image),
                        'level_id' => 1,
                    ]);
                }
            }
        }

        foreach ($dataCategoryLv2 as $category) {
            $response = Http::get('https://dummyjson.com/products/category/' . $category . '?limit=0');
            $data = $response->json();
            foreach ($data['products'] as $product) {
                foreach ($product['images'] as $image) {
                    Product::create([
                        'name' => $this->generateModel($product['title']),
                        'price' => rand(200, 999),
                        'image' => $this->downloadImage($image),
                        'level_id' => 2,
                    ]);
                }
            }
        }

        foreach ($dataCategoryLv3 as $category) {
            $response = Http::get('https://dummyjson.com/products/category/' . $category . '?limit=0');
            $data = $response->json();
            foreach ($data['products'] as $product) {
                foreach ($product['images'] as $image) {
                    Product::create([
                        'name' => $this->generateModel($product['title']),
                        'price' => rand(1000, 2999),
                        'image' => $this->downloadImage($image),
                        'level_id' => 3,
                    ]);
                }
            }
        }

        foreach ($dataCategoryLv4 as $category) {
            $response = Http::get('https://dummyjson.com/products/category/' . $category . '?limit=0');
            $data = $response->json();
            foreach ($data['products'] as $product) {
                foreach ($product['images'] as $image) {
                    Product::create([
                        'name' => $this->generateModel($product['title']),
                        'price' => rand(3000, 4999),
                        'image' => $this->downloadImage($image),
                        'level_id' => 4,
                    ]);
                }
            }
        }

        $brandTulanh = ['Samsung', 'LG', 'Panasonic', 'Sharp', 'Sony', 'Toshiba', 'Philips'];

        $brandDienThoai = ['Samsung', 'Apple', 'Huawei', 'Xiaomi', 'Oppo', 'Vivo', 'Realme', 'OnePlus', 'Google', 'Motorola', 'Nokia', 'BlackBerry', 'HTC', 'Lenovo', 'Asus', 'Sony', 'LG', 'Panasonic', 'Sharp', 'Philips'];

        $brandLaptop = ['Samsung', 'Apple', 'Huawei', 'Xiaomi', 'Oppo', 'Vivo', 'Realme', 'OnePlus', 'Google', 'Motorola', 'Nokia', 'BlackBerry', 'HTC', 'Lenovo', 'Asus', 'Sony', 'LG', 'Panasonic', 'Sharp', 'Philips'];

        $brandComputer = ['Samsung', 'Apple', 'Huawei', 'Xiaomi', 'Oppo', 'Vivo', 'Realme', 'OnePlus', 'Google', 'Motorola', 'Nokia', 'BlackBerry', 'HTC', 'Lenovo', 'Asus', 'Sony', 'LG', 'Panasonic', 'Sharp', 'Philips'];

        $brandWatch = ['Samsung', 'Apple', 'Huawei', 'Xiaomi', 'Oppo', 'Vivo', 'Lenovo', 'Asus', 'Sony', 'LG', 'Sharp', 'Philips', 'Rolex'];

        $brandQuanao = ['Nike','Adidas', 'Uniqlo', 'Zara', 'H&M'];

        $brandGiay = ['Nike', 'Adidas', 'Converse', 'Vans', 'Puma', 'Reebok', 'Fila', 'Asics', 'New Balance', 'Under Armour', 'Skechers', 'Hush Puppies', 'Clarks', 'Geox'];

        $brandXemay = ['Honda', 'Yamaha', 'Suzuki', 'Piaggio', 'Honda Wave', 'Honda Hornet', 'Honda Hornet 200', 'Honda Hornet 200i', 'Honda Hornet 200j', 'Honda Hornet 200s'];

        $brandMayAnh = ['Canon', 'Sony', 'Nikon', 'Fujifilm', 'Panasonic', 'Olympus', 'Leica', 'Sigma', 'Tamron', 'Zeiss'];

        $imageXemay = [
            "https://cdn.dummyjson.com/products/images/motorcycle/Generic%20Motorcycle/1.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Generic%20Motorcycle/2.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Generic%20Motorcycle/3.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Generic%20Motorcycle/4.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Kawasaki%20Z800/1.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Kawasaki%20Z800/2.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Kawasaki%20Z800/3.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Kawasaki%20Z800/4.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/MotoGP%20CI.H1/1.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/MotoGP%20CI.H1/2.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/MotoGP%20CI.H1/3.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/MotoGP%20CI.H1/4.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Scooter%20Motorcycle/1.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Scooter%20Motorcycle/2.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Scooter%20Motorcycle/3.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Scooter%20Motorcycle/4.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Sportbike%20Motorcycle/1.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Sportbike%20Motorcycle/2.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Sportbike%20Motorcycle/3.png",
            "https://cdn.dummyjson.com/products/images/motorcycle/Sportbike%20Motorcycle/4.png"
        ];

        for ($i = 0; $i < 50; $i++) {
            $brandRadom = $brandXemay[rand(0, count($brandXemay) - 1)];
            Product::create([
                'name' => $brandRadom . ' ' . $this->generateModel($brandRadom),
                'price' => rand(1000, 2999),
                'image' => $this->downloadImage($imageXemay[rand(0, count($imageXemay) - 1)]),
                'level_id' => 3,
            ]);
        }

        $imageQuanao = [
            "https://cdn.dummyjson.com/products/images/mens-shirts/Blue%20&%20Black%20Check%20Shirt/1.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Blue%20&%20Black%20Check%20Shirt/2.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Blue%20&%20Black%20Check%20Shirt/3.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Blue%20&%20Black%20Check%20Shirt/4.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Gigabyte%20Aorus%20Men%20Tshirt/1.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Gigabyte%20Aorus%20Men%20Tshirt/2.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Gigabyte%20Aorus%20Men%20Tshirt/3.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Gigabyte%20Aorus%20Men%20Tshirt/4.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Man%20Plaid%20Shirt/1.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Man%20Plaid%20Shirt/2.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Man%20Plaid%20Shirt/3.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Man%20Plaid%20Shirt/4.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Man%20Short%20Sleeve%20Shirt/1.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Man%20Short%20Sleeve%20Shirt/2.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Man%20Short%20Sleeve%20Shirt/3.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Man%20Short%20Sleeve%20Shirt/4.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Men%20Check%20Shirt/1.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Men%20Check%20Shirt/2.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Men%20Check%20Shirt/3.png",
            "https://cdn.dummyjson.com/products/images/mens-shirts/Men%20Check%20Shirt/4.png"
        ];

        for ($i = 0; $i < 30; $i++) {
            $brandRadom = $brandQuanao[rand(0, count($brandQuanao) - 1)];
            Product::create([
                'name' => $brandRadom . ' ' . $this->generateModel($brandRadom),
                'price' => rand(1000, 2999),
                'image' => $this->downloadImage($imageQuanao[rand(0, count($imageQuanao) - 1)]),
                'level_id' => 3,
            ]);
        }

        $imageDongHo = [
            "https://cdn.dummyjson.com/products/images/mens-watches/Brown%20Leather%20Belt%20Watch/1.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Brown%20Leather%20Belt%20Watch/2.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Brown%20Leather%20Belt%20Watch/3.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Longines%20Master%20Collection/1.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Longines%20Master%20Collection/2.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Longines%20Master%20Collection/3.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Rolex%20Cellini%20Date%20Black%20Dial/1.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Rolex%20Cellini%20Date%20Black%20Dial/2.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Rolex%20Cellini%20Date%20Black%20Dial/3.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Rolex%20Cellini%20Moonphase/1.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Rolex%20Cellini%20Moonphase/2.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Rolex%20Cellini%20Moonphase/3.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Rolex%20Datejust/1.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Rolex%20Datejust/2.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Rolex%20Datejust/3.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Rolex%20Submariner%20Watch/1.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Rolex%20Submariner%20Watch/2.png",
            "https://cdn.dummyjson.com/products/images/mens-watches/Rolex%20Submariner%20Watch/3.png"
        ];

        for ($i = 0; $i < 30; $i++) {
            $brandRadom = $brandWatch[rand(0, count($brandWatch) - 1)];
            Product::create([
                'name' => $brandRadom . ' ' . $this->generateModel($brandRadom),
                'price' => rand(3000, 4999),
                'image' => $this->downloadImage($imageDongHo[rand(0, count($imageDongHo) - 1)]),
                'level_id' => 4,
            ]);
        }


        $imageDienThoai = [
            "https://cdn.dummyjson.com/products/images/smartphones/iPhone%205s/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/iPhone%205s/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/iPhone%205s/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/iPhone%206/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/iPhone%206/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/iPhone%206/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/iPhone%2013%20Pro/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/iPhone%2013%20Pro/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/iPhone%2013%20Pro/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/iPhone%20X/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/iPhone%20X/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/iPhone%20X/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Oppo%20A57/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Oppo%20A57/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Oppo%20A57/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Oppo%20F19%20Pro%20Plus/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Oppo%20F19%20Pro%20Plus/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Oppo%20F19%20Pro%20Plus/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Oppo%20K1/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Oppo%20K1/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Oppo%20K1/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Oppo%20K1/4.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Realme%20C35/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Realme%20C35/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Realme%20C35/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Realme%20X/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Realme%20X/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Realme%20X/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Realme%20XT/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Realme%20XT/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Realme%20XT/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Samsung%20Galaxy%20S7/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Samsung%20Galaxy%20S7/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Samsung%20Galaxy%20S7/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Samsung%20Galaxy%20S8/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Samsung%20Galaxy%20S8/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Samsung%20Galaxy%20S8/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Samsung%20Galaxy%20S10/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Samsung%20Galaxy%20S10/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Samsung%20Galaxy%20S10/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Vivo%20S1/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Vivo%20S1/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Vivo%20S1/3.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Vivo%20X21/1.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Vivo%20X21/2.png",
            "https://cdn.dummyjson.com/products/images/smartphones/Vivo%20X21/3.png"
        ];
        for ($i = 0; $i < 30; $i++) {
            $brandRadom = $brandDienThoai[rand(0, count($brandDienThoai) - 1)];
            Product::create([
                'name' => $brandRadom . ' ' . $this->generateModel($brandRadom),
                'price' => rand(5000, 9999),
                'image' => $this->downloadImage($imageDienThoai[rand(0, count($imageDienThoai) - 1)]),
                'level_id' => 4,
            ]);
        }
    }

    public function generateModel($brand) {
        $faker = Faker::create();
        return $brand . ' ' . $faker->company . ' ' . rand(100, 999);
    }

    // download image from url and save to public/images
    public function downloadImage($url) {
        // ex url
        // https://cdn.dummyjson.com/products/images/smartphones/Vivo%20X21/3.png
        $filename = basename($url);
        $path = 'products/' . $filename;

        if (!Storage::disk('public')->exists($path)) {
            $imageContent = file_get_contents($url);
            Storage::disk('public')->put($path, $imageContent);
        }

        return Storage::url($path);
    }
}


