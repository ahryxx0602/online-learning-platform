# TASK LIST - Online Learning Platform
> Ngày làm việc: 2026-03-29

---

## PHASE 1 — Video Player (Bài 304–305)

- [ ] **304.1** Thêm Plyr.js (hoặc Video.js) vào `resources/views/layouts/client.blade.php`
- [ ] **304.2** Tạo modal/popup player trong `Modules/Courses/resources/views/clients/detail.blade.php`
- [ ] **304.3** Viết JavaScript gọi API `/data/trial/{lessonId}` và truyền URL vào player
- [ ] **304.4** Bind sự kiện click vào nút "Học thử" trong curriculum
- [ ] **305.1** Tạo route + controller stream video: `GET /stream/trial/{lessonId}`
- [ ] **305.2** Xử lý HTTP headers cho video stream (Content-Type, Accept-Ranges)
- [ ] **305.3** Fix lỗi hiển thị player trên mobile / CSS

---

## PHASE 2 — Trang xem video bài giảng (Bài 306–308)

- [ ] **306.1** Tạo route `GET /khoa-hoc/{courseSlug}/bai-hoc/{lessonSlug}` (middleware: auth:student)
- [ ] **306.2** Tạo `WatchController` trong `Modules/Courses/app/Http/Controllers/Clients/`
- [ ] **306.3** Tạo layout mới `watch.blade.php` (sidebar curriculum + video area)
- [ ] **307.1** Sidebar: danh sách module + bài học, đánh dấu bài đang xem
- [ ] **307.2** Tự động load bài tiếp theo khi video kết thúc (JS event)
- [ ] **308.1** Tạo migration bảng `student_lesson_progress` (student_id, lesson_id, is_completed, watched_seconds)
- [ ] **308.2** API `POST /bai-hoc/{lessonId}/progress` lưu tiến độ xem
- [ ] **308.3** Hiển thị icon checkmark cho bài đã hoàn thành

---

## PHASE 3 — Tài liệu & Ẩn/hiện bài giảng (Bài 309–311)

- [ ] **309.1** Route `GET /bai-hoc/{lessonId}/tai-lieu` để download tài liệu
- [ ] **309.2** Controller stream/download file từ storage (chỉ cho học viên đã mua)
- [ ] **310.1** Thêm cột `status` vào `lessons` table (nếu chưa có) qua migration
- [ ] **310.2** Admin: thêm nút toggle ẩn/hiện trong trang quản lý bài giảng
- [ ] **310.3** Route AJAX `PATCH /admin/lessons/{id}/toggle-status`
- [ ] **311.1** Tạo `LessonActiveScope` scope trong Lesson model
- [ ] **311.2** Áp dụng scope vào tất cả query phía client
- [ ] **311.3** Tối ưu eager loading `with(['video', 'document', 'children'])` để tránh N+1

---

## PHASE 4 — Vite Assets Bundling (Bài 312)

- [ ] **312.1** Cài `npm install` các packages cần thiết (vite, laravel-vite-plugin, sass)
- [ ] **312.2** Tạo `vite.config.js` cấu hình entry point cho client và admin
- [ ] **312.3** Chuyển `mix()` → `@vite()` directive trong blade templates
- [ ] **312.4** Test build: `npm run build`, fix lỗi nếu có

---

## PHASE 5 — Xác thực học viên / Student Auth (Bài 313–325)

- [ ] **313.1** Thêm guard `student` trong `config/auth.php` (provider: students, model: Student)
- [ ] **313.2** Student model: implements `Authenticatable`, `MustVerifyEmail`, thêm `$fillable`, `$hidden`
- [ ] **313.3** Tạo middleware `AuthStudent` redirect về `/dang-nhap` nếu chưa đăng nhập
- [ ] **314.1** Route group: `prefix('')` cho guest, `prefix('tai-khoan')` cho authenticated
- [ ] **314.2** Tạo `StudentLoginController`: `showLoginForm()`, `login()`, `logout()`
- [ ] **315.1** Tạo view `clients/auth/login.blade.php`
- [ ] **315.2** Xử lý remember me, flash error messages
- [ ] **316.1** Test login/logout flow hoàn chỉnh
- [ ] **317.1** Tạo `StudentRegisterController`: `showRegisterForm()`, `register()`
- [ ] **317.2** Tạo view `clients/auth/register.blade.php`
- [ ] **317.3** Validation: name, email unique:students, password confirmed, phone
- [ ] **318.1** Middleware `CheckStudentStatus`: kiểm tra `status` sau login, redirect nếu bị khóa
- [ ] **318.2** Hiển thị thông báo "Tài khoản bị khóa, liên hệ hỗ trợ"
- [ ] **319.1** Gửi email xác thực sau khi đăng ký (Event: `Registered`)
- [ ] **319.2** Route xác thực: `GET /xac-thuc-email/{id}/{hash}`
- [ ] **320.1** Config queue driver = database, chạy `php artisan queue:table && migrate`
- [ ] **320.2** Dispatch email notification qua queue
- [ ] **321.1** Route + Controller resend: `POST /xac-thuc-email/gui-lai`
- [ ] **321.2** Rate limit resend (max 1 lần/60 giây)
- [ ] **322.1** Tạo `StudentForgotPasswordController`: form nhập email
- [ ] **322.2** Gửi email chứa link reset (dùng `password.reset` notification)
- [ ] **323.1** `StudentResetPasswordController`: form đặt lại mật khẩu
- [ ] **323.2** Validate token, cập nhật password, redirect login
- [ ] **324.1** Tạo Event `StudentPasswordReset` và Listener log/notification
- [ ] **325.1** Tạo custom Notification class email forgot password (đẹp hơn default)

---

## PHASE 6 — Trang tài khoản học viên (Bài 326–340)

- [ ] **326.1** Phân tích và tạo layout trang tài khoản (`clients/account/layout.blade.php`)
- [ ] **326.2** Sidebar menu: Thông tin, Đổi mật khẩu, Khóa học của tôi, Đơn hàng
- [ ] **327.1** Route group `prefix('tai-khoan')->middleware('auth:student')`
- [ ] **327.2** Active menu: dùng `request()->routeIs()` để highlight menu
- [ ] **328.1** `GET /tai-khoan/thong-tin` → hiển thị form thông tin
- [ ] **328.2** Tạo view form (name, email readonly, phone, address, avatar)
- [ ] **329.1** `POST /tai-khoan/thong-tin` → validate + cập nhật DB
- [ ] **329.2** Upload avatar: validate image, store vào `storage/app/public/students/avatars/`
- [ ] **330.1** Hiển thị flash message thành công/lỗi sau khi update
- [ ] **331.1** `POST /tai-khoan/doi-mat-khau`: validate current_password + Hash::check()
- [ ] **331.2** Cập nhật password mới, logout session khác (nếu cần)
- [ ] **332.1** Tạo migration bảng `orders` và `order_items`
- [ ] **332.2** Tạo models `Order` và `OrderItem` với relationships
- [ ] **333.1** `GET /tai-khoan/khoa-hoc-cua-toi`: query courses từ orders đã paid
- [ ] **333.2** View: hiển thị danh sách khóa học với thumbnail, tiến độ, nút "Vào học"
- [ ] **334.1** Pagination 9 items/trang
- [ ] **335.1** `GET /tai-khoan/don-hang`: danh sách đơn hàng
- [ ] **335.2** View: bảng đơn hàng (mã đơn, ngày, tổng tiền, trạng thái)
- [ ] **336.1** Filter theo trạng thái (dropdown)
- [ ] **337.1** Tìm kiếm theo mã đơn
- [ ] **338.1** Pagination
- [ ] **339.1** `GET /tai-khoan/don-hang/{orderId}`: chi tiết đơn hàng
- [ ] **339.2** View: danh sách sản phẩm, discount, tổng tiền
- [ ] **340.1** Nút in hóa đơn (print CSS hoặc tạo PDF đơn giản)

---

## PHASE 7 — Trang thanh toán / Checkout (Bài 341–347)

- [ ] **341.1** `POST /gio-hang/them/{courseId}`: thêm vào cart (session)
- [ ] **341.2** `GET /gio-hang`: view giỏ hàng
- [ ] **341.3** `DELETE /gio-hang/{courseId}`: xóa khỏi giỏ
- [ ] **342.1** `GET /thanh-toan`: checkout page (tóm tắt đơn + form thông tin)
- [ ] **342.2** Validate: không cho mua khóa đã sở hữu
- [ ] **343.1** Hiển thị tổng tiền, học viên phải đăng nhập mới checkout được
- [ ] **344.1** `POST /thanh-toan`: tạo `Order` + `OrderItem` records
- [ ] **344.2** Generate mã đơn hàng unique (vd: `OLP-20260329-XXXX`)
- [ ] **345.1** Xử lý thanh toán COD: set status=pending, redirect trang cảm ơn
- [ ] **346.1** Trang xác nhận đơn hàng: hiển thị mã đơn, hướng dẫn chuyển khoản
- [ ] **347.1** Gửi email xác nhận đơn hàng sau khi tạo thành công (queue)

---

## PHASE 8 — Mã giảm giá / Coupon (Bài 348–366)

- [ ] **348.1** Phân tích và thiết kế logic mã giảm giá
- [ ] **349.1** Thiết kế database: `coupons`, `coupon_student`, `coupon_course`
- [ ] **350.1** Tạo migration cho 3 bảng trên
- [ ] **351.1** Tạo `Coupon` model với relationships (students, courses)
- [ ] **351.2** Admin: CRUD coupon (list, create, edit, delete)
- [ ] **351.3** Seeder: tạo 3-5 coupon mẫu để test
- [ ] **352.1** API `POST /thanh-toan/kiem-tra-ma` → validate coupon (AJAX)
- [ ] **352.2** Xử lý lỗi: không tồn tại, đã hết hạn, không đủ điều kiện
- [ ] **353.1** Kiểm tra thời gian áp dụng (start_date <= now <= end_date)
- [ ] **354.1** Tính số tiền giảm: percent (%) hoặc fixed (VNĐ)
- [ ] **354.2** Áp dụng `max_discount_amount` cap cho loại percent
- [ ] **355.1** Cập nhật `Order` thêm cột `coupon_id`, `discount_amount`
- [ ] **355.2** Lưu discount vào order khi submit checkout
- [ ] **356.1** Cập nhật UI checkout: ô nhập mã + nút áp dụng
- [ ] **357.1** AJAX cập nhật tổng tiền sau khi nhập mã
- [ ] **357.2** Tạo/hiển thị QR code của mã giảm giá (dùng `bacon/bacon-qr-code`)
- [ ] **358.1** Ràng buộc coupon chỉ dùng được cho student cụ thể (pivot `coupon_student`)
- [ ] **359.1** Ràng buộc coupon chỉ áp dụng cho khóa học cụ thể (kiểm tra cart items)
- [ ] **360.1** Hiển thị lỗi khi khóa học trong giỏ không thuộc coupon
- [ ] **361.1** Xử lý trường hợp cart có nhiều khóa học, chỉ một số thỏa điều kiện
- [ ] **362.1** Giới hạn `max_uses` toàn hệ thống (check `used_count`)
- [ ] **362.2** Giới hạn mỗi học viên dùng tối đa 1 lần (check bảng `coupon_usages`)
- [ ] **363.1** Admin: nút reset coupon (clear `used_count`, clear `coupon_usages`)
- [ ] **363.2** Form thiết lập điều kiện coupon trong admin
- [ ] **364.1** Endpoint `GET /thanh-toan/trang-thai/{orderId}` cho polling
- [ ] **364.2** JavaScript: setInterval poll mỗi 5 giây
- [ ] **365.1** Server: trả về JSON {status, message}, stop polling khi status != pending
- [ ] **366.1** Hiển thị UI: spinner khi chờ, icon thành công/thất bại khi xong

---

## PHASE 9 — Thanh toán trực tuyến VNPAY (Bài 367–373)

- [ ] **367.1** Đọc tài liệu VNPAY sandbox, lấy credentials (TMN_CODE, HASH_SECRET, URL)
- [ ] **367.2** Thêm VNPAY config vào `.env` và `config/payment.php`
- [ ] **368.1** Tạo `VnpayService` class: `createPaymentUrl()`, `verifySignature()`
- [ ] **368.2** Route `GET /thanh-toan/vnpay/{orderId}` → redirect sang VNPAY
- [ ] **369.1** Webhook route `POST /webhook/vnpay` (exclude CSRF trong `bootstrap/app.php`)
- [ ] **369.2** Verify HMAC-SHA512 signature
- [ ] **370.1** Xử lý response codes: 00=success, các code lỗi khác
- [ ] **370.2** Cập nhật order status, ghi log
- [ ] **370.3** Idempotent check: skip nếu order đã xử lý
- [ ] **371.1** Return URL `GET /thanh-toan/ket-qua`: redirect sau khi thanh toán VNPAY
- [ ] **371.2** Poll order status và hiển thị kết quả (dùng long polling đã có)
- [ ] **372.1** Cài ngrok, tạo tunnel đến localhost
- [ ] **372.2** Cập nhật VNPAY sandbox với ngrok webhook URL
- [ ] **373.1** Test end-to-end: tạo order → VNPAY → webhook → cập nhật → UI
- [ ] **373.2** Xử lý edge cases: timeout 15 phút, thanh toán trùng, refund

---

## Checklist cuối ngày

- [ ] Chạy `php artisan optimize:clear` sau khi thêm routes/config mới
- [ ] Test các luồng chính: học thử → đăng ký → mua → xem bài
- [ ] Commit code theo từng phase
- [ ] Cập nhật file này với status thực tế

---

## Ghi chú kỹ thuật

| Vấn đề | Giải pháp |
|--------|-----------|
| Guard student | Thêm vào `config/auth.php`, dùng `auth:student` middleware |
| Video streaming | Dùng `response()->stream()` hoặc redirect đến storage URL với signed URL |
| Queue | `QUEUE_CONNECTION=database` trong `.env`, chạy `php artisan queue:work` |
| CSRF webhook | Thêm route vào exception list trong `bootstrap/app.php` |
| N+1 query | Dùng `with()` eager loading ở tất cả các controller |
| Coupon QR | Package `bacon/bacon-qr-code` hoặc dùng API bên ngoài |
