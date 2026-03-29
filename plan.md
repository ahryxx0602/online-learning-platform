# KẾ HOẠCH THỰC HIỆN - Online Learning Platform
> Cập nhật: 2026-03-29

## Tổng quan các chức năng còn lại (Bài 304 → 373)

Dự án sử dụng Laravel 12 + nwidart/laravel-modules. Tất cả tính năng mới đều tạo trong module tương ứng.

---

## PHASE 1 — Video Player (Bài 304–305)
**Mục tiêu:** Tích hợp player cho học thử bài giảng và stream video.

### Bài 304: Tích hợp Player
- Thêm thư viện video player vào client layout (Plyr.js hoặc Video.js)
- Tạo component modal/popup player trong `Modules/Courses/resources/views/clients/`
- Gọi API `/data/trial/{lessonId}` (đã có) để lấy URL video
- Bind sự kiện click vào nút "Học thử" trên trang chi tiết khóa học

### Bài 305: Stream Video + Fix lỗi Player
- Tạo controller stream video (trả về response stream thay vì redirect URL)
- Xử lý headers: `Content-Type`, `Accept-Ranges`, `Content-Range` cho HLS-like behavior
- Fix lỗi CORS nếu video host khác domain
- Đảm bảo player hiển thị đúng trên mobile

---

## PHASE 2 — Trang xem video bài giảng (Bài 306–308)
**Mục tiêu:** Trang học toàn bộ bài giảng (chỉ học viên đã mua).

### Bài 306–308: Lesson Watch Page
- Route: `GET /khoa-hoc/{courseSlug}/bai-hoc/{lessonSlug}` (guard: student)
- Controller: `Modules/Courses/app/Http/Controllers/Clients/WatchController.php`
- Layout riêng cho trang xem video (sidebar curriculum + video area)
- Hiển thị danh sách bài học trong sidebar, đánh dấu bài đang xem
- Tự động chuyển bài tiếp theo khi video kết thúc
- Lưu progress: cột `user_lesson_progress` hoặc bảng riêng

---

## PHASE 3 — Tài liệu bài giảng + Ẩn/hiện bài giảng (Bài 309–311)
### Bài 309: Download tài liệu
- Route: `GET /bai-hoc/{lessonId}/tai-lieu`
- Stream/download file từ storage (private disk)
- Chỉ học viên đã mua mới tải được

### Bài 310: Ẩn/hiện bài giảng & module
- Admin: Toggle `status` cho lesson và module (parent lesson)
- Thêm cột `status` vào `lessons` table nếu chưa có
- Eloquent Scope: `ActiveScope` lọc bài giảng đang active
- Client không thấy bài giảng đã ẩn

### Bài 311: Eloquent Scope tối ưu
- Viết `LessonScope` và áp dụng cho các query liên quan
- Tối ưu N+1 query với `with()` eager loading

---

## PHASE 4 — Assets Bundling với Vite (Bài 312)
### Bài 312
- Cài `vite` + `laravel-vite-plugin`
- Cấu hình `vite.config.js` cho client và admin assets
- Xử lý lỗi thường gặp (port conflict, manifest not found)
- Chuyển từ `mix()` sang `vite()` trong blade templates

---

## PHASE 5 — Xác thực học viên (Bài 313–325)
**Mục tiêu:** Hệ thống auth riêng cho học viên (guard: `student`).

### Cấu hình Guard
- Thêm guard `student` trong `config/auth.php`
- Provider dùng `Modules\Students\Models\Student`
- Student model implements `Authenticatable`, `MustVerifyEmail`

### Bài 313–316: Login/Logout
- Module: tạo thêm trong `Modules/Auth/` (hoặc tạo module `MemberAuth`)
- Routes: `GET/POST /dang-nhap`, `POST /dang-xuat`
- Controller: `StudentLoginController`
- Middleware: `auth:student` cho các route cần xác thực
- View: `resources/views/clients/auth/login.blade.php`

### Bài 317: Đăng ký
- Routes: `GET/POST /dang-ky`
- Controller: `StudentRegisterController`
- Validation: name, email (unique:students), password (confirmed), phone
- View: form đăng ký

### Bài 318: Khóa tài khoản
- Column `status` trong students table (0=active, 1=locked)
- Middleware check `status` sau khi login
- Thông báo lỗi khi tài khoản bị khóa

### Bài 319–321: Xác thực email
- Student model implements `MustVerifyEmail`
- Gửi email xác thực sau khi đăng ký
- Route xác thực: `GET /xac-thuc-email/{id}/{hash}`
- Resend: `POST /xac-thuc-email/gui-lai`

### Bài 320: Notification Queue
- Config queue driver (database hoặc redis)
- Dispatch notification qua queue để không block response
- `php artisan queue:work`

### Bài 322–325: Forgot/Reset Password
- `POST /quen-mat-khau` → gửi email link reset
- `GET /dat-lai-mat-khau/{token}` → form nhập password mới
- `POST /dat-lai-mat-khau` → lưu password mới
- Custom notification class cho email forgot password

---

## PHASE 6 — Trang tài khoản học viên (Bài 326–340)
**Mục tiêu:** Khu vực cá nhân của học viên sau khi đăng nhập.

### Bài 326–327: Layout & Routing
- Route group: `prefix('tai-khoan')->middleware('auth:student')`
- Active menu highlight với Route::currentRouteName()
- Layout: sidebar menu + content area

### Bài 328–330: Cập nhật thông tin
- `GET/POST /tai-khoan/thong-tin`
- Upload avatar (store vào public disk)
- Validation + cập nhật DB
- Flash message thành công/lỗi

### Bài 331: Đổi mật khẩu
- `POST /tai-khoan/doi-mat-khau`
- Validate current_password với `Hash::check()`
- Update password

### Bài 332–334: Khóa học của tôi
- `GET /tai-khoan/khoa-hoc-cua-toi`
- Query các khóa học đã mua qua bảng `orders` + `order_items`
- Hiển thị tiến độ học (dựa trên `lesson_progress`)
- Pagination

### Bài 335–338: Đơn hàng
- `GET /tai-khoan/don-hang`
- Danh sách đơn hàng với trạng thái (pending, paid, cancelled)
- Filter theo trạng thái, tìm kiếm theo mã đơn
- Pagination

### Bài 339–340: Chi tiết đơn hàng
- `GET /tai-khoan/don-hang/{orderId}`
- Hiển thị chi tiết: sản phẩm, giá, discount, tổng tiền
- Nút tải hóa đơn (PDF hoặc in trang)

---

## PHASE 7 — Trang thanh toán / Checkout (Bài 341–347)
**Mục tiêu:** Luồng mua khóa học.

### Database cần tạo
```sql
-- orders table
id, student_id, code (unique), total_price, discount_amount,
final_price, status (pending/paid/cancelled/refunded),
payment_method, note, created_at, updated_at

-- order_items table
id, order_id, course_id, price, created_at, updated_at
```

### Bài 341: Cart / Thêm vào giỏ
- Session-based cart (không cần bảng DB)
- `POST /gio-hang/them/{courseId}`
- `GET /gio-hang` → view giỏ hàng
- `DELETE /gio-hang/{courseId}` → xóa khỏi giỏ

### Bài 342–343: Checkout page
- `GET /thanh-toan` → form thanh toán (thông tin học viên, tóm tắt đơn hàng)
- Validate: không mua khóa đã sở hữu
- Tạo order với status=pending

### Bài 344–347: Xử lý đơn hàng
- `POST /thanh-toan` → tạo Order + OrderItems
- Thanh toán COD/chuyển khoản → status=paid ngay
- Redirect đến trang cảm ơn / xác nhận đơn hàng
- Gửi email xác nhận đơn hàng

---

## PHASE 8 — Mã giảm giá (Bài 348–366)
**Mục tiêu:** Hệ thống coupon/discount code.

### Database (Bài 349–350)
```sql
-- coupons table
id, code (unique), type (percent/fixed), value,
min_order_amount, max_discount_amount,
start_date, end_date, max_uses, used_count,
is_active, created_at, updated_at

-- coupon_student (pivot - ràng buộc theo học viên)
coupon_id, student_id

-- coupon_course (pivot - ràng buộc theo khóa học)
coupon_id, course_id
```

### Bài 351–354: Logic áp dụng mã
- `POST /thanh-toan/kiem-tra-ma-giam-gia` → AJAX validate
- Kiểm tra: tồn tại, hết hạn, đủ điều kiện, giới hạn dùng
- Tính toán số tiền giảm (percent hoặc fixed)

### Bài 355–357: Cập nhật UI
- Hiển thị discount trên checkout page
- QR Code cho mã giảm giá
- Cập nhật tổng tiền theo thời gian thực (AJAX)

### Bài 358–361: Ràng buộc mã
- Mã chỉ dùng được cho học viên cụ thể
- Mã chỉ áp dụng cho khóa học cụ thể

### Bài 362–363: Giới hạn & Reset
- Giới hạn số lần dùng toàn hệ thống
- Giới hạn mỗi học viên chỉ dùng 1 lần
- Reset coupon (admin)

### Bài 364–366: HTTP Long Polling
- Client poll status thanh toán mỗi 3–5 giây
- Server endpoint: `GET /thanh-toan/kiem-tra-trang-thai/{orderId}`
- Trả về order status, tự dừng khi status != pending

---

## PHASE 9 — Thanh toán trực tuyến / VNPAY (Bài 367–373)
**Mục tiêu:** Tích hợp cổng thanh toán VNPAY.

### Bài 367: Tổng quan luồng
- Luồng: Tạo order → Redirect sang VNPAY → VNPAY callback → Cập nhật order
- Cần: VNPAY sandbox credentials (TMN_CODE, HASH_SECRET, URL)

### Bài 368–370: Webhook
- `POST /webhook/vnpay` (exclude CSRF)
- Verify chữ ký HMAC-SHA512
- Cập nhật order status dựa trên response code
- Idempotent: check order chưa được xử lý trước khi update

### Bài 371: Cập nhật UI realtime
- Sau khi redirect về từ VNPAY, poll order status
- Hiển thị spinner → thành công / thất bại

### Bài 372: Public Webhook với Ngrok
- Cài ngrok, expose localhost
- Cấu hình VNPAY sandbox dùng ngrok URL

### Bài 373: Tích hợp thật với cổng thanh toán
- Test end-to-end với VNPAY sandbox
- Xử lý các edge cases: timeout, gian lận, double payment

---

## Thứ tự ưu tiên thực hiện hôm nay

```
1. [PHASE 1] Video Player (304-305)        ~1h
2. [PHASE 2] Watch Page (306-308)          ~1.5h
3. [PHASE 3] Tài liệu + Ẩn/hiện (309-311) ~1h
4. [PHASE 4] Vite (312)                   ~30m
5. [PHASE 5] Student Auth (313-325)        ~3h
6. [PHASE 6] Account pages (326-340)       ~2.5h
7. [PHASE 7] Checkout (341-347)            ~2h
8. [PHASE 8] Coupon (348-366)              ~3h
9. [PHASE 9] VNPAY (367-373)               ~2h
```

**Tổng ước tính: ~16.5h** — cần chia thành nhiều ngày thực tế, nhưng có thể bắt đầu từ Phase 1 hôm nay.
