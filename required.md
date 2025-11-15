____
# 📘 DỰ ÁN WEBSITE HỌC TRỰC TUYẾN
____
## 1. Tổng quan và phân tích chức năng dự án
Hệ thống website học trực tuyến cho phép học viên xem khóa học, học bài giảng video, tải tài liệu, mua khóa học và quản lý quá trình học tập.
Trang quản trị giúp quản trị viên quản lý toàn bộ khóa học, giảng viên, học viên, tin tức và đơn hàng.

## 2. Chức năng hệ thống
### 2.1. Dành cho người dùng
- Hiển thị danh sách khóa học
- Hiển thị thông tin chi tiết khóa học
- Xem video bài giảng
- Download tài liệu bài giảng
- Học thử bài giảng
- Đăng ký/ Đăng nhập
- Trang tài khoản: Thông tin cá nhân, khóa học của tôi
- Mua khóa học
- Giỏ hàng
- Hiển thi danh sách tin tức
- Hiển thị chi tiết tin tức

### 2.1. Dành cho quản trị
- Quản lý danh mục
- Quản lý học viên
- Quản lý khóa học
- Quản lý giảng viên
- Quản lý bài giảng
- Quản lý danh mục tin tức
- Quản lý tin tức
- Kích hoạt khóa học cho học viên
- Quản lý file tài liệu
- Quản lý video
- Quản lý đơn hàng
- Quản lý người dùng (Quản lý hệ thống)
- Phân quyền quản trị hệ thống
- Báo cáo thông kê

### 2.3. API
- Xây dựng API hoàn chỉnh
## 3. Phân tích Database

### 3.1. Table categories - Danh mục khóa học
| Field      | Type         |
| ---------- | ------------ |
| id         | int          |
| name       | varchar(200) |
| slug       | varchar(200) |
| parent_id  | int          |
| created_at | timestamp    |
| updated_at | timestamp    |

### 3.2. Table courses - Khóa học
| Field       | Type         |
| ----------- | ------------ |
| id          | int          |
| name        | varchar(255) |
| slug        | varchar(255) |
| detail      | text         |
| teacher_id  | int          |
| thumbnail   | varchar(255) |
| price       | float        |
| sale_price  | float        |
| code        | varchar(100) |
| durations   | float        |
| is_document | tinyint      |
| supports    | text         |
| status      | tinyint      |
| created_at  | timestamp    |
| updated_at  | timestamp    |


### 3.3. Table lessons - Bài giảng
| Field       | Type         |
| ----------- | ------------ |
| id          | int          |
| name        | varchar(255) |
| slug        | varchar(255) |
| video_id    | int          |
| document_id | int          |
| parent_id   | int          |
| is_trial    | tinyint      |
| views       | int          |
| position    | int          |
| duration    | float        |
| description | text         |
| created_at  | timestamp    |
| updated_at  | timestamp    |


### 3.4. Table categories_courses - Liên kết giữa **Danh mục** và **Khóa học**
| Field       | Type      |
| ----------- | --------- |
| id          | int       |
| category_id | int       |
| course_id   | int       |
| created_at  | timestamp |
| updated_at  | timestamp |


### 3.5. Table teacher - Giảng viên
| Field       | Type         |
| ----------- | ------------ |
| id          | int          |
| name        | varchar(100) |
| slug        | varchar(100) |
| description | text         |
| exp         | float        |
| image       | varchar(255) |
| created_at  | timestamp    |
| updated_at  | timestamp    |


### 3.6. Table videos - Video bài giảng
| Field      | Type         |
| ---------- | ------------ |
| id         | int          |
| name       | varchar(255) |
| url        | varchar(255) |
| created_at | timestamp    |
| updated_at | timestamp    |


### 3.7. Table documents - Tài liệu
| Field      | Type         |
| ---------- | ------------ |
| id         | int          |
| name       | varchar(255) |
| url        | varchar(255) |
| size       | float        |
| created_at | timestamp    |
| updated_at | timestamp    |


### 3.8. Table categories_posts - Danh mục tin tức
| Field      | Type         |
| ---------- | ------------ |
| id         | int          |
| name       | varchar(200) |
| slug       | varchar(200) |
| parent_id  | int          |
| created_at | timestamp    |
| updated_at | timestamp    |


### 3.9. Table posts - Tin tức
| Field       | Type         |
| ----------- | ------------ |
| id          | int          |
| title       | varchar(255) |
| slug        | varchar(255) |
| content     | text         |
| except      | text         |
| thumbnail   | varchar(255) |
| category_id | int          |
| created_at  | timestamp    |
| updated_at  | timestamp    |


### 3.10. Table Students - Học viên
| Field      | Type         |
| ---------- | ------------ |
| id         | int          |
| name       | varchar(100) |
| email      | varchar(100) |
| phone      | varchar(20)  |
| password   | varchar(100) |
| address    | varchar(255) |
| status     | tinyint      |
| created_at | timestamp    |
| updated_at | timestamp    |


### 3.11. Table students_course - Khóa học của học viên
| Field      | Type      |
| ---------- | --------- |
| id         | int       |
| course_id  | int       |
| student_id | int       |
| created_at | timestamp |
| updated_at | timestamp |


### 3.12. Table orders - Đơn hàng
| Field      | Type      |
| ---------- | --------- |
| id         | int       |
| student_id | int       |
| total      | float     |
| status     | tinyint   |
| created_at | timestamp |
| updated_at | timestamp |


### 3.13. Table order_details - Chi tiết đơn hàng
| Field      | Type      |
| ---------- | --------- |
| id         | int       |
| order_id   | int       |
| course_id  | int       |
| price      | float     |
| created_at | timestamp |
| updated_at | timestamp |


### 3.14. Table orders_status - Trạng thái đơn hàng
| Field      | Type         |
| ---------- | ------------ |
| id         | int          |
| name       | varchar(200) |
| created_at | timestamp    |
| updated_at | timestamp    |


### 3.15. Table users - Quản trị hệ thống
| Field      | Type         |
| ---------- | ------------ |
| id         | int          |
| name       | varchar(100) |
| email      | varchar(100) |
| password   | varchar(100) |
| group_id   | int          |
| created_at | timestamp    |
| updated_at | timestamp    |


### 3.16. Table groups - Nhóm quyền
| Field       | Type         |
| ----------- | ------------ |
| id          | int          |
| name        | varchar(100) |
| permissions | text         |
| created_at  | timestamp    |
| updated_at  | timestamp    |


### 3.17. Table modules - Module hệ thống
| Field | Type         |
| ----- | ------------ |
| id    | int          |
| name  | varchar(100) |
| title | varchar(200) |
| role  | text         |


### 3.18. Table settings - Thiết lập hệ thống
| Field | Type         |
| ----- | ------------ |
| id    | int          |
| name  | varchar(100) |
| value | text         |

