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
                'description' => 'Pin sạc Panasonic Eneloop Pro AA là dòng pin sạc cao cấp nhất của Panasonic, dung lượng cực cao 2500mAh, độ bền tuyệt vời, phù hợp cho các thiết bị tiêu thụ điện năng lớn như máy ảnh, đèn flash, đồ chơi công nghệ cao.',
                'content' => '<h2>Tại sao nên lựa chọn Pin Sạc Panasonic Eneloop Pro AA?</h2><p><strong>Panasonic Eneloop Pro AA</strong> là dòng pin sạc cao cấp hàng đầu thế giới hiện nay, được thiết kế chuyên dụng cho các thiết bị công nghệ có mức tiêu thụ điện năng cực lớn.</p><h3>Đặc điểm nổi bật:</h3><ul><li><strong>Dung lượng cực khủng 2500mAh:</strong> Đảm bảo cho các thiết bị của bạn hoạt động bền bỉ trong thời gian dài hơn hẳn các loại pin thông thường.</li><li><strong>Khả năng giữ năng lượng vượt trội:</strong> Nhờ công nghệ tự xả siêu thấp, pin giữ tới 85% dung lượng ngay cả khi không sử dụng trong vòng 1 năm.</li><li><strong>Hoạt động bền bỉ ở nhiệt độ thấp:</strong> Pin có thể sử dụng bình thường ngay cả ở môi trường cực lạnh lên đến -20 độ C.</li><li><strong>Thân thiện với môi trường:</strong> Được sạc sẵn bằng năng lượng mặt trời ngay từ nhà máy tại Nhật Bản, sẵn sàng sử dụng ngay sau khi mở hộp.</li></ul><h3>Ứng dụng thực tế:</h3><p>Sản phẩm cực kỳ lý tưởng cho các nhiếp ảnh gia chuyên nghiệp sử dụng đèn Flash máy ảnh, tay cầm chơi game không dây (Xbox, PlayStation), đồ chơi điều khiển từ xa cao cấp và các thiết bị y tế cầm tay.</p>',
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
                'description' => 'Pin sạc dự phòng Anker Prime công suất cực đại 140W, dung lượng khủng 24,000mAh. Thiết kế màn hình LCD thông minh hiển thị chi tiết dòng điện, công suất và thời gian sạc còn lại. Hỗ trợ sạc nhanh đồng thời 3 thiết bị.',
                'content' => '<h2>Đánh giá chi tiết Pin Dự Phòng Siêu Nhanh Anker Prime 24K 140W</h2><p>Nếu bạn đang tìm kiếm một trạm năng lượng di động siêu mạnh mẽ, có thể sạc được cho cả laptop công suất lớn và nhiều thiết bị cùng lúc, <strong>Anker Prime 24K</strong> chính là sự lựa chọn số một.</p><h3>Công nghệ sạc nhanh đột phá</h3><p>Trang bị công nghệ Power Delivery 3.1 mới nhất, cổng USB-C đơn trên Anker Prime có thể cho ra công suất sạc tối đa lên tới 140W, dễ dàng sạc đầy 50% pin MacBook Pro 16 inch chỉ trong vòng chưa đầy 30 phút.</p><h3>Màn hình LCD thông minh trực quan</h3><p>Màn hình màu kỹ thuật số cao cấp hiển thị thời gian thực về lượng pin còn lại, công suất sạc đầu vào và đầu ra của từng cổng sạc, giúp bạn dễ dàng kiểm soát nguồn năng lượng mọi lúc.</p><h3>Thiết kế nhỏ gọn, dung lượng 24,000mAh khủng</h3><ul><li>Sử dụng cell pin chất lượng cao tối ưu hóa kích thước, nhỏ hơn tới 40% so với các dòng pin cùng công suất trên thị trường.</li><li>Dung lượng 24,000mAh cho phép sạc đầy iPhone 14 gần 5 lần hoặc MacBook Air hơn 1 lần.</li><li>Hệ thống an toàn MultiProtect kiểm soát nhiệt độ thông minh, bảo vệ thiết bị của bạn tuyệt đối 24/7.</li></ul>',
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
                'description' => 'Pin thay thế cao cấp cho dòng máy Dell Latitude E7440, dung lượng chuẩn 47Wh đảm bảo thời lượng sử dụng bền bỉ từ 3 - 5 giờ liên tục. Sử dụng cell pin Polymer cao cấp giúp chống chai pin và an toàn tuyệt đối khi sử dụng.',
                'content' => '<h2>Giải pháp hồi sinh thời lượng pin cho Laptop Dell Latitude E7440</h2><p>Sau một thời gian dài sử dụng, pin laptop của bạn bị chai, báo pin ảo hoặc nhanh hết pin? Pin thay thế cao cấp <strong>Dell Latitude E7440 Li-Polymer 47Wh</strong> sẽ giúp chiếc laptop doanh nhân của bạn hoạt động mượt mà trở lại.</p><h3>Những nâng cấp đáng giá:</h3><ul><li><strong>Cell pin Polymer cao cấp:</strong> Đảm bảo mật độ năng lượng cao, trọng lượng nhẹ và khả năng chống phồng pin tuyệt đối.</li><li><strong>Dung lượng chuẩn 47Wh:</strong> Đạt hiệu suất thực tế từ 3 - 5 giờ làm việc văn phòng liên tục.</li><li><strong>Mạch bảo vệ thông minh:</strong> Tích hợp IC quản lý nguồn cao cấp, chống quá tải, quá dòng và ngắt mạch tự động để bảo vệ an toàn cho bo mạch của laptop.</li></ul><h3>Hướng dẫn sử dụng tăng tuổi thọ pin mới:</h3><p>Trong 3 lần sạc đầu tiên, bạn nên sạc đầy pin liên tục trong 8 tiếng, sau đó dùng cạn pin đến khoảng 5-10% rồi mới sạc tiếp để kích hoạt toàn bộ cell pin đạt trạng thái tối ưu nhất.</p>',
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
                'description' => 'Pin Pisen Ultra dung lượng siêu cao dành riêng cho iPhone 13 Pro Max, nâng cấp dung lượng hơn 10% so với pin gốc của Apple. An toàn chống cháy nổ, chu kỳ sạc xả lên đến 800 lần, đạt chuẩn kiểm định khắt khe của châu Âu.',
                'content' => '<h2>Nâng cấp vượt trội với Pin Pisen Ultra Dung Lượng Siêu Cao cho iPhone 13 Pro Max</h2><p>Pin điện thoại của bạn đã giảm hiệu năng và máy bắt đầu giật lag? Pin <strong>Pisen Ultra dung lượng siêu cao</strong> là giải pháp thay thế hoàn hảo nhất hiện nay, mang lại trải nghiệm sử dụng còn lâu hơn cả pin nguyên bản mới tinh của máy.</p><h3>Đặc điểm công nghệ vượt trội:</h3><ul><li><strong>Tăng dung lượng thêm 10%:</strong> Với dung lượng cực khủng lên tới 4750 mAh (so với 4352 mAh gốc), kéo dài thêm từ 1.5 - 2 giờ sử dụng hỗn hợp.</li><li><strong>Cell pin Li-Polymer xếp lớp mật độ cao:</strong> Tối ưu hóa không gian bên trong máy, không gây phồng hay chèn ép màn hình.</li><li><strong>Mạch kiểm soát điện áp độc quyền:</strong> Đảm bảo dòng điện ra ổn định như pin zin, không gây nóng máy khi sạc nhanh.</li><li><strong>Gói bảo hiểm cháy nổ 2 triệu USD:</strong> Minh chứng cho chất lượng và độ an toàn đạt tiêu chuẩn quốc tế của Pisen.</li></ul>',
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
                'description' => 'Pin lưu trữ năng lượng công nghiệp LiFePO4 thương hiệu TS Battery. Dung lượng thực tế 100Ah, tuổi thọ chu kỳ sạc xả trên 3500 lần (DOD 80%). Tích hợp mạch quản lý pin thông minh (BMS) bảo vệ quá dòng, quá áp, ngắn mạch.',
                'content' => '<h2>Pin Lưu Trữ Lithium LiFePO4 TS Battery 12V 100Ah - Đỉnh cao công nghệ năng lượng xanh</h2><p>Sản phẩm pin lưu trữ chuyên dụng thế hệ mới của <strong>TS Battery</strong> sử dụng công nghệ hóa chất Lithium Sắt Phốt Phát (LiFePO4) tiên tiến, là giải pháp lý tưởng thay thế hoàn toàn cho ắc quy chì truyền thống.</p><h3>Ưu điểm vượt trội so với Ắc quy chì:</h3><ul><li><strong>Tuổi thọ siêu bền:</strong> Đạt trên 3500 chu kỳ sạc xả ở độ sâu xả (DOD) 80%, tương đương thời gian sử dụng từ 8 - 10 năm liên tục (ắc quy chì chỉ đạt 300 - 500 chu kỳ).</li><li><strong>Trọng lượng siêu nhẹ:</strong> Chỉ bằng 1/3 trọng lượng của một bình ắc quy chì có cùng dung lượng, cực kỳ dễ dàng di chuyển và lắp đặt.</li><li><strong>Hiệu suất sạc xả cao:</strong> Đạt tới 95%, sạc đầy cực nhanh và xả dòng lớn ổn định mà không bị tụt áp sâu.</li></ul><h3>Tích hợp Hệ thống Quản lý Pin BMS Thông Minh:</h3><p>Hệ thống BMS tích hợp sâu bên trong giúp giám sát thời gian thực nhiệt độ, điện áp và dòng điện của từng cell pin độc lập. Bảo vệ an toàn tuyệt đối khỏi nguy cơ quá sạc, xả quá sâu, quá dòng và ngắn mạch.</p><h3>Ứng dụng thực tế đa dạng:</h3><p>Sử dụng lưu trữ điện cho hệ thống năng lượng mặt trời áp mái hộ gia đình, nguồn dự phòng UPS cho văn phòng/máy chủ, nguồn điện cho xe golf, thuyền điện, và các hoạt động dã ngoại cắm trại ngoài trời.</p>',
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
                'description' => 'Sạc dự phòng Samsung chính hãng dung lượng lớn 20,000mAh hỗ trợ sạc siêu nhanh PD 25W. Vỏ ngoài làm bằng vật liệu tái chế bảo vệ môi trường, thiết kế màu xám hiện đại, nhỏ gọn và cầm nắm chắc chắn.',
                'content' => '<h2>Đánh giá nhanh Pin Sạc Dự Phòng Samsung 20000mAh 25W chính hãng</h2><p>Pin dự phòng <strong>Samsung EB-P5300 20,000mAh</strong> mang lại nguồn điện dồi dào cho mọi chuyến hành trình của bạn với thiết kế tối giản, tinh tế cùng khả năng tương thích sạc siêu nhanh 25W hoàn hảo.</p><h3>Điểm nhấn thiết kế và tính năng:</h3><ul><li><strong>Dung lượng khủng 20,000mAh:</strong> Sạc đầy điện thoại thông minh của bạn nhiều lần mà không lo hết pin giữa chừng.</li><li><strong>Sạc siêu nhanh PD 25W:</strong> Hỗ trợ chuẩn sạc Power Delivery và Super Fast Charging độc quyền của Samsung, giúp rút ngắn tối đa thời gian chờ đợi.</li><li><strong>Sạc đồng thời 3 thiết bị:</strong> Thiết kế 2 cổng USB-C và 1 cổng USB-A tiện lợi giúp bạn chia sẻ nguồn năng lượng với bạn bè một cách dễ dàng.</li><li><strong>Chất liệu bền vững, an toàn:</strong> Vỏ ngoài sử dụng vật liệu tái chế thân thiện với môi trường kết hợp công nghệ an toàn đa lớp bảo vệ chống quá tải nhiệt.</li></ul>',
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
