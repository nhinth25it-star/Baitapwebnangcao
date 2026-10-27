# Kết quả kiểm thử bản cuối

Ngày kiểm tra: 26/10/2026. Môi trường Windows, PHP 8.2.12, PHPMailer 7.1.1.

| Kiểm tra | Kết quả |
|---|---|
| Form renders three exercises | PASSED |
| Missing sender configuration rejected | PASSED |
| Setup GET rejected | PASSED |
| Setup invalid CSRF rejected | PASSED |
| Setup invalid sender rejected | PASSED |
| Session configuration saved and password hidden | PASSED |
| GET send rejected | PASSED |
| Invalid CSRF rejected | PASSED |
| Invalid email rejected | PASSED |
| Exercise 1 SMTP with verified STARTTLS | PASSED |
| Exercise 2 attachment transmitted | PASSED |
| Vietnamese subject and escaped HTML | PASSED |
| Exercise 3 distinct SMTP recipients | PASSED |
| Blank message rejected | PASSED |
| Session configuration cleared | PASSED |
| Sending after clear rejected | PASSED |
| No SMTP server errors | PASSED |

- Kiểm tra cú pháp: toàn bộ 82 tệp PHP đạt.
- BAT: chạy trực tiếp với --no-browser, tìm được PHP, kiểm tra điều kiện môi trường, khởi động 127.0.0.1:8000 thành công.
- Trình duyệt: trang tải được, 4 biểu mẫu hiển thị; lưu và xóa cấu hình hoạt động; rộng 390 px không tràn ngang.
- SMTP giả lập: 3 email được tiếp nhận; STARTTLS xác minh chứng chỉ bằng CA thử nghiệm, không tắt kiểm tra TLS. Chỉ địa chỉ SMTP và cổng được thay trong bản sao kiểm thử; cấu hình phiên giữ nguyên như bản giao.
- Gmail thật: NOT_RUN, chưa có tài khoản người dùng để kiểm tra giao thư thực tế.
- SQL: NOT_RUN, phần tùy chọn trong README.
- Tự mở trình duyệt của BAT: NOT_RUN; có thể mở thủ công URL hiển thị trong cửa sổ.

Máy chủ SMTP chấp nhận thư chưa bảo đảm thư đã vào hộp thư đến.
