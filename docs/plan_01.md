# Kế hoạch chi tiết xây dựng Website TS Battery với Laravel 12 & MySQL

Dự án xây dựng website giới thiệu và bán sản phẩm cho thương hiệu **TS Battery** (Slogan: **Power Your Everyday**). Mã nguồn tổ chức theo cấu trúc **Modular** dễ bảo trì, giao diện tuân theo phong cách **Minimal Ecommerce UI** kết hợp các điểm nhấn công nghệ tinh tế như **hiệu ứng Backdrop Blur** và **màn hình Splash tải nhanh**.

---

## User Review Required

> [!IMPORTANT]
> 1. **Hiệu ứng Backdrop Blur (Kính mờ cao cấp)**:
>    - Sử dụng thuộc tính `backdrop-filter: blur(12px)` cho các thành phần đè lên nền: **Sticky Header (khi cuộn trang)**, **Cart Drawer (giỏ hàng kéo ra)**, **Product Detail Modal** và **Mobile Menu Nav**.
>    - Giúp tạo chiều sâu cho giao diện tối giản mà không cần dùng nhiều màu sắc hay đổ bóng phức tạp.
> 2. **Splash Screen tải nhanh (Vẽ chữ TS)**:
>    - Sử dụng một màn hình phủ nhẹ (overlay) chứa logo SVG của **TS Battery**. Dùng CSS `stroke-dasharray` và `stroke-dashoffset` để vẽ nhanh nét chữ **TS** trong vòng **0.8 - 1 giây**.
>    - **Tối ưu trải nghiệm**: Splash sẽ biến mất ngay khi trang web tải xong (`DOMContentLoaded` hoặc dùng Session Storage để chỉ hiển thị splash một lần duy nhất trong phiên làm việc của người dùng nhằm đảm bảo **không gây cảm giác chậm web** khi duyệt qua lại các trang).

---

## Proposed Changes (Phase 1: MVP)

Dự án được triển khai trực tiếp vào thư mục [e:/landing_pin](file:///e:/landing_pin).

### 1. Cấu trúc Module & Tên Thương Hiệu

#### [MODIFY] [app.blade.php](file:///e:/landing_pin/resources/views/layouts/app.blade.php)
- Cập nhật `<title>` thành `TS Battery - Power Your Everyday`.
- Tích hợp thành phần **Splash Screen SVG** ngay đầu thẻ `<body>` với hiệu ứng biến mất nhanh:
  ```html
  <div id="splash-screen" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-300">
      <svg class="w-32 h-32" viewBox="0 0 100 100">
          <!-- Đường vẽ nét chữ T và S bằng SVG -->
          <path id="logo-path" d="M20 20 H80 M50 20 V80 M30 80 Q50 80 50 60 Q50 40 70 40 Q80 40 80 60" fill="none" stroke="#2E9F5B" stroke-width="8" stroke-linecap="round"/>
      </svg>
  </div>
  ```
- Thêm đoạn script JS cực ngắn để ẩn splash:
  ```javascript
  document.addEventListener('DOMContentLoaded', () => {
      const splash = document.getElementById('splash-screen');
      if (sessionStorage.getItem('splash_shown')) {
          splash.style.display = 'none';
      } else {
          setTimeout(() => {
              splash.classList.add('opacity-0');
              setTimeout(() => {
                  splash.style.display = 'none';
                  sessionStorage.setItem('splash_shown', 'true');
              }, 300);
          }, 1000); // Vẽ nét chữ TS trong 1s rồi ẩn ngay lập tức
      }
  });
  ```

#### [NEW] [create_settings_table.php](file:///e:/landing_pin/database/migrations/create_settings_table.php)
- Seed dữ liệu cấu hình mặc định cho thương hiệu:
  - `brand_name` = `TS Battery`
  - `brand_slogan` = `Power Your Everyday`
  - `enable_shopping_cart` = `1`

---

### 2. Giao diện sử dụng Backdrop Blur

#### [NEW] [cart-drawer.blade.php](file:///e:/landing_pin/resources/views/livewire/components/cart-drawer.blade.php)
- Khi giỏ hàng mở ra, lớp nền phía sau (backdrop overlay) sẽ sử dụng class Tailwind `backdrop-blur-sm bg-black/10` để làm mờ nhẹ nội dung trang web chính, giúp giỏ hàng nổi bật rõ ràng trên màn hình.

#### [MODIFY] [product-catalog.blade.php](file:///e:/landing_pin/resources/views/livewire/product-catalog.blade.php)
- Các bộ lọc khi cuộn trang hoặc menu phụ sẽ đè lên lưới sản phẩm với hiệu ứng blur mượt mà.
- Khớp logo và slogan **TS Battery - Power Your Everyday** trên phần Hero Section.

---

## Verification Plan

### Automated Tests
- Khởi tạo database và chạy seed:
  ```bash
  php artisan migrate:fresh --seed
  ```

### Manual Verification
1. **Kiểm tra Splash Screen**:
   - Khi truy cập trang web lần đầu, hoạt ảnh vẽ chữ **TS** diễn ra mượt mà và biến mất trong vòng 1.3s (bao gồm hiệu ứng fade-out).
   - F5 tải lại trang hoặc chuyển sang trang chi tiết sản phẩm: Đảm bảo Splash Screen **không hiển thị lại** (sử dụng Session Storage) giúp trải nghiệm duyệt web cực kỳ nhanh và liền mạch.
2. **Kiểm tra hiệu ứng Backdrop Blur**:
   - Mở Giỏ hàng (Cart Drawer) hoặc bộ lọc di động: Đảm bảo lớp nền trang web phía sau bị mờ đi tinh tế (`backdrop-filter: blur(...)`).
   - Cuộn trang và kiểm tra Sticky Header xem có làm mờ nhẹ phần nội dung cuộn bên dưới hay không.
