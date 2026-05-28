<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Product\Models\Category;
use App\Modules\Product\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tạo các danh mục pin
        $categories = [
            ['name' => 'Pin Laptop', 'slug' => 'pin-laptop'],
            ['name' => 'Pin Điện Thoại', 'slug' => 'pin-dien-thoai'],
            ['name' => 'Pin Sạc Dự Phòng', 'slug' => 'pin-sac-du-phong'],
            ['name' => 'Pin AA/AAA Chuyên Dụng', 'slug' => 'pin-aa-aaa'],
            ['name' => 'Pin Công Nghiệp Lithium', 'slug' => 'pin-cong-nghiep-lithium'],
        ];

        $catModels = [];
        foreach ($categories as $cat) {
            $catModels[$cat['slug']] = Category::firstOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name']]
            );
        }

        // 2. Tạo danh sách sản phẩm pin mẫu
        $products = [
            [
                'category_slug' => 'pin-aa-aaa',
                'name' => 'Pin Sạc Panasonic Eneloop Pro AA',
                'sku' => 'PAN-ENELPRO-AA',
                'price' => 450000.00,
                'sale_price' => 390000.00,
                'stock' => 150,
                'thumbnail' => 'panasonic-eneloop-pro.jpg',
                'description' => 'Pin sạc Panasonic Eneloop Pro AA là dòng pin sạc cao cấp nhất của Panasonic, dung lượng cực cao 2500mAh, độ bền tuyệt vời, phù hợp cho các thiết bị tiêu thụ điện năng lớn như máy ảnh, đèn flash, đồ chơi công nghệ cao.',
                'specifications' => [
                    'Dung lượng' => '2500 mAh',
                    'Điện áp' => '1.2 V',
                    'Thương hiệu' => 'Panasonic',
                    'Loại pin' => 'Ni-MH',
                    'Chu kỳ sạc' => '500 lần',
                    'Bảo hành' => '12 tháng',
                    'Xuất xứ' => 'Nhật Bản'
                ]
            ],
            [
                'category_slug' => 'pin-sac-du-phong',
                'name' => 'Pin Dự Phòng Siêu Nhanh Anker Prime 24K',
                'sku' => 'ANK-PRIME-24K',
                'price' => 2990000.00,
                'sale_price' => 2650000.00,
                'stock' => 45,
                'thumbnail' => 'anker-prime-24k.jpg',
                'description' => 'Pin sạc dự phòng Anker Prime công suất cực đại 140W, dung lượng khủng 24,000mAh. Thiết kế màn hình LCD thông minh hiển thị chi tiết dòng điện, công suất và thời gian sạc còn lại. Hỗ trợ sạc nhanh đồng thời 3 thiết bị.',
                'specifications' => [
                    'Dung lượng' => '24,000 mAh',
                    'Công suất tối đa' => '140 W',
                    'Thương hiệu' => 'Anker',
                    'Cổng sạc' => '2 x USB-C, 1 x USB-A',
                    'Loại pin' => 'Lithium-ion',
                    'Bảo hành' => '18 tháng',
                    'Xuất xứ' => 'Trung Quốc'
                ]
            ],
            [
                'category_slug' => 'pin-laptop',
                'name' => 'Pin Laptop Dell Latitude E7440 Li-Polymer',
                'sku' => 'DELL-E7440-47WH',
                'price' => 850000.00,
                'sale_price' => null,
                'stock' => 30,
                'thumbnail' => 'dell-latitude-e7440.jpg',
                'description' => 'Pin thay thế cao cấp cho dòng máy Dell Latitude E7440, dung lượng chuẩn 47Wh đảm bảo thời lượng sử dụng bền bỉ từ 3 - 5 giờ liên tục. Sử dụng cell pin Polymer cao cấp giúp chống chai pin và an toàn tuyệt đối khi sử dụng.',
                'specifications' => [
                    'Dung lượng' => '47 Wh (4 cell)',
                    'Điện áp' => '7.4 V',
                    'Thương hiệu' => 'Dell',
                    'Loại pin' => 'Li-Polymer',
                    'Bảo hành' => '6 tháng',
                    'Trọng lượng' => '300 g'
                ]
            ],
            [
                'category_slug' => 'pin-dien-thoai',
                'name' => 'Pin iPhone 13 Pro Max Pisen Dung Lượng Siêu Cao',
                'sku' => 'PIS-IP13PM-UHC',
                'price' => 1250000.00,
                'sale_price' => 1100000.00,
                'stock' => 80,
                'thumbnail' => 'pisen-iphone-13promax.jpg',
                'description' => 'Pin Pisen Ultra dung lượng siêu cao dành riêng cho iPhone 13 Pro Max, nâng cấp dung lượng hơn 10% so với pin gốc của Apple. An toàn chống cháy nổ, chu kỳ sạc xả lên đến 800 lần, đạt chuẩn kiểm định khắt khe của châu Âu.',
                'specifications' => [
                    'Dung lượng' => '4750 mAh',
                    'Thương hiệu' => 'Pisen',
                    'Dòng máy hỗ trợ' => 'iPhone 13 Pro Max',
                    'Loại pin' => 'Li-Polymer',
                    'Bảo hành' => '12 tháng',
                    'Bảo hiểm cháy nổ' => '2 triệu USD'
                ]
            ],
            [
                'category_slug' => 'pin-cong-nghiep-lithium',
                'name' => 'Pin Lưu Trữ Lithium LiFePO4 TS Battery 12V 100Ah',
                'sku' => 'TSB-LFP-12100',
                'price' => 8900000.00,
                'sale_price' => 8200000.00,
                'stock' => 15,
                'thumbnail' => 'ts-lifepo4-12v-100ah.jpg',
                'description' => 'Pin lưu trữ năng lượng công nghiệp LiFePO4 thương hiệu TS Battery. Dung lượng thực tế 100Ah, tuổi thọ chu kỳ sạc xả trên 3500 lần (DOD 80%). Tích hợp mạch quản lý pin thông minh (BMS) bảo vệ quá dòng, quá áp, ngắn mạch.',
                'specifications' => [
                    'Dung lượng' => '100 Ah',
                    'Điện áp định mức' => '12.8 V',
                    'Thương hiệu' => 'TS Battery',
                    'Loại pin' => 'LiFePO4 (Lithium Sắt Phốt Phát)',
                    'Chu kỳ sạc' => '3500+ lần',
                    'Tích hợp BMS' => 'Có',
                    'Bảo hành' => '36 tháng',
                    'Xuất xứ' => 'Việt Nam'
                ]
            ],
            [
                'category_slug' => 'pin-sac-du-phong',
                'name' => 'Pin Sạc Dự Phòng Samsung 20000mAh 25W',
                'sku' => 'SS-EB-P5300',
                'price' => 1190000.00,
                'sale_price' => 990000.00,
                'stock' => 60,
                'thumbnail' => 'samsung-20000-25w.jpg',
                'description' => 'Sạc dự phòng Samsung chính hãng dung lượng lớn 20,000mAh hỗ trợ sạc siêu nhanh PD 25W. Vỏ ngoài làm bằng vật liệu tái chế bảo vệ môi trường, thiết kế màu xám hiện đại, nhỏ gọn và cầm nắm chắc chắn.',
                'specifications' => [
                    'Dung lượng' => '20,000 mAh',
                    'Công suất tối đa' => '25 W',
                    'Thương hiệu' => 'Samsung',
                    'Cổng sạc' => '2 x USB-C, 1 x USB-A',
                    'Loại pin' => 'Lithium-ion',
                    'Bảo hành' => '12 tháng',
                    'Xuất xứ' => 'Việt Nam'
                ]
            ]
        ];

        foreach ($products as $prod) {
            $catId = $catModels[$prod['category_slug']]->id;
            unset($prod['category_slug']);
            
            $prod['category_id'] = $catId;
            $prod['slug'] = Str::slug($prod['name']);
            $prod['status'] = true;

            Product::updateOrCreate(
                ['sku' => $prod['sku']],
                $prod
            );
        }
    }
}
