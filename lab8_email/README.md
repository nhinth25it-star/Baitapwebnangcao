# Bài làm Lab 8 - Email

## 1. Yêu cầu và kết quả

Bài làm dựa trên 3 bài tập ở trang 6-11 của tài liệu được cung cấp.

| Bài | Tệp xử lý | Chức năng |
| --- | --- | --- |
| 1 | `bai1.php` | Gửi email với địa chỉ nhận, tiêu đề và nội dung cố định |
| 2 | `index.php`, `mail.php` | Nhập người nhận, tiêu đề, nội dung; chọn tệp đính kèm tùy ý |
| 3 | `bai3.php` | Gửi cùng một nội dung đến nhiều địa chỉ; bỏ địa chỉ trùng |

Các tệp dùng chung: `config.php` chứa cấu hình, `functions.php` chứa hàm xử lý, `style.css` định dạng giao diện. Thư viện PHPMailer được đóng kèm trong `vendor/`; `composer.lock` cố định phiên bản 7.1.1. Yêu cầu PHP 8.2 trở lên, có OpenSSL.

## 2. Cấu hình và chạy

1. Giải nén toàn bộ file ZIP vào một thư mục. Không mở website bên trong ZIP.
2. Cài XAMPP nếu máy chưa có PHP. `CHAY_BAI.bat` tự tìm PHP ở các vị trí XAMPP phổ biến (`C:\xampp`, `D:\xampp`, `D:\XAMPP`) hoặc trong PATH. Nếu cài XAMPP ở vị trí khác, sửa danh sách đường dẫn trong file BAT bằng Notepad.
3. Nhấp đúp `CHAY_BAI.bat`. Cửa sổ này chạy máy chủ PHP và tự mở trình duyệt vào trang bài. Nếu trình duyệt chưa tự mở, truy cập <http://127.0.0.1:8000/index.php>.
4. Trong mục **Cấu hình Gmail**, nhập Gmail người gửi, mật khẩu ứng dụng, tên người gửi và email nhận cố định cho Bài 1. Nhấn **Lưu cấu hình**.
5. Mật khẩu ứng dụng tạo tại <https://myaccount.google.com/apppasswords>; tài khoản cần bật Xác minh 2 bước. Nhập mật khẩu ứng dụng 16 ký tự, không phải mật khẩu Gmail. Tài khoản trường/cơ quan có thể bị quản trị viên giới hạn tính năng này.
6. Dùng biểu mẫu Bài 1, Bài 2 và Bài 3. Mỗi người dùng máy tính tự nhập tài khoản Gmail của mình.
7. Nhấn Ctrl+C trong cửa sổ chạy bài để dừng website. Cấu hình được giữ trong phiên PHP trên máy đang chạy, không ghi vào mã nguồn. Nhấn **Xóa cấu hình đã lưu** sau khi dùng, nhất là trên máy dùng chung.

Nếu cổng 8000 đang bận, đóng chương trình đang dùng cổng đó hoặc đổi số `8000` trong `CHAY_BAI.bat`, sau đó mở địa chỉ có cổng mới.

## 3. Giải thích cách làm

### Bài 1

`index.php` tạo nút gửi. Khi nhấn nút, trình duyệt gửi POST tới `bai1.php`. Tệp này lấy địa chỉ nhận cố định từ cấu hình đã lưu trong phiên, tạo đối tượng gửi thư bằng `createMailer()`, thêm người nhận qua `addAddress()`, đặt tiêu đề/nội dung và gọi `send()`.

Bài 1 gửi kèm `dinh-kem-mau.txt` có sẵn trong gói. Đề dùng ảnh `4.jpg` làm ví dụ; ở đây dùng tệp văn bản để người nhận giải nén là có đủ tệp chạy. Có thể đổi đường dẫn ở dòng `addAttachment()` sang ảnh của bạn. Bài 2 cho chọn tệp trực tiếp.

### Bài 2

Biểu mẫu giữ các tên trường theo đề: `email`, `tieude`, `content`, `file`. Thuộc tính `method="post"` gửi dữ liệu tới `mail.php`; `enctype="multipart/form-data"` cho phép tải tệp lên.

`mail.php` kiểm tra email và trường bắt buộc, sau đó tạo thư. `setMessage()` tạo nội dung HTML; chữ do người dùng nhập được chuyển ký tự đặc biệt bằng `htmlspecialchars` để không bị hiểu là mã HTML. Có cả `AltBody` cho trình đọc thư chỉ hỗ trợ văn bản.

`attachUpload()` kiểm tra lỗi tải lên, nguồn tệp tải lên và giới hạn 5 MB. Tệp được gắn trực tiếp từ đường dẫn tạm của PHP; PHP tự thu dọn tệp tạm sau yêu cầu, nên không cần tạo thư mục lưu tệp trên website.

### Bài 3

`emailList()` tách chuỗi bằng dấu phẩy, dấu chấm phẩy hoặc khoảng trắng/xuống dòng, kiểm tra từng địa chỉ rồi bỏ trùng. Một địa chỉ không hợp lệ sẽ khiến toàn bộ yêu cầu bị từ chối trước khi gửi. `bai3.php` duyệt danh sách:

```php
foreach ($emails as $email) {
    $mail->addAddress($email);
}
$mail->send();
```

Ví dụ đầu vào:

```text
a@example.com, b@example.com; a@example.com
```

Danh sách kết quả gồm 2 địa chỉ. Đây chỉ là dữ liệu minh họa; thay bằng hộp thư thật của bạn khi thử. Các địa chỉ nằm trong trường To và có thể nhìn thấy nhau, giống cách `addAddress()` trong đề. Nếu cần ẩn danh sách, thay bằng `addBCC()` theo yêu cầu sử dụng thực tế.

### Phần SQL tùy chọn trong đề

Đề ghi “có thể lấy email từ cơ sở dữ liệu SQL”, vì vậy phiên bản chạy chính dùng danh sách nhập tay và không cần database. Nếu giảng viên yêu cầu SQL, thay bước lấy `$emails` trong `bai3.php` bằng ví dụ sau, sau khi kiểm tra tên bảng/cột thật:

```php
$pdo = new PDO(
    getenv('DB_DSN'),
    getenv('DB_USER'),
    getenv('DB_PASSWORD'),
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
// contacts và email là tên minh họa, cần sửa cho đúng database của bạn.
$rows = $pdo->query('SELECT email FROM contacts WHERE email IS NOT NULL')
            ->fetchAll(PDO::FETCH_COLUMN);
$emails = emailList(implode(',', $rows));
```

Ví dụ giá trị `DB_DSN`: `mysql:host=127.0.0.1;port=3306;dbname=lab8;charset=utf8mb4`. Không có database nào được tạo hoặc thay đổi trong bài làm này. Phần SQL minh họa chưa được chạy vì không có schema và kết nối database của bạn.

## 4. Các điểm đã sửa so với mã mẫu

- Không sao chép tài khoản/mật khẩu trong PDF; không tự thêm người nhận phụ trong mã mẫu.
- Dùng mật khẩu ứng dụng và STARTTLS ở cổng 587. Không tắt xác minh chứng chỉ TLS.
- Kiểm tra POST đúng cách thay cho `isset($_POST)` vốn không xác định được phương thức gửi.
- Kiểm tra tệp bằng `$_FILES['file']['error']`, tránh lỗi chỉ số `name` không có dấu nháy trong mẫu.
- Biểu mẫu có mã CSRF: mã ngẫu nhiên gắn với phiên truy cập để hạn chế yêu cầu gửi giả mạo từ trang khác.
- Không đưa thông tin lỗi SMTP chi tiết có thể chứa dữ liệu cấu hình ra giao diện.
- Thông báo thành công có nghĩa SMTP đã chấp nhận thư; vẫn cần kiểm tra hộp thư để xác nhận giao thư thực tế.

## 5. Kiểm tra và giới hạn

- Đã kiểm tra cú pháp tất cả tệp PHP.
- Đã chạy kiểm thử HTTP và SMTP giả lập nội bộ có STARTTLS và xác minh chứng chỉ: cả 3 bài gửi đúng luồng; tệp đính kèm, tiếng Việt và loại email trùng hoạt động trong kiểm thử.
- Đã kiểm tra từ chối phương thức GET, mã CSRF sai, email sai và nội dung bắt buộc bị bỏ trống.
- Bản cuối đã vượt qua 17 kiểm tra HTTP/SMTP giả lập, bao gồm lưu/xóa cấu hình trên phiên và gửi sau khi xóa cấu hình. Chi tiết ở `KIEM_THU.md`.
- Đã kiểm tra trình duyệt: mở trang, lưu/xóa cấu hình bằng tài khoản minh họa không gửi thật, màn hình rộng 390 px không tràn ngang. Đã chạy BAT bằng tham số kiểm tra `--no-browser`; thao tác tự mở trình duyệt chưa được chạy tự động trong kiểm thử.
- Chưa xác nhận thư vào hộp thư Gmail thật; SQL chỉ là phần tùy chọn minh họa, chưa chạy.
- Đây là bài lab chạy cục bộ. Giới hạn 20 địa chỉ/lần giúp tránh gửi nhầm số lượng lớn trong lúc thực hành; Gmail vẫn áp dụng giới hạn tài khoản của họ.
- Máy chủ có thể chấp nhận một số người nhận rồi báo lỗi ở người nhận khác. Khi xảy ra lỗi, kiểm tra hộp thư trước khi thử lại để tránh nhận trùng.

## 6. Câu hỏi có thể gặp khi vấn đáp

**SMTP là gì?** Giao thức chuyển thư từ ứng dụng đến máy chủ email.

**Vì sao dùng PHPMailer?** Thư viện hỗ trợ đăng nhập SMTP, mã hóa kết nối, tiếng Việt và tệp đính kèm, phù hợp yêu cầu đề.

**Vì sao không dùng mật khẩu Gmail thông thường?** Luồng thực hành này dùng mật khẩu ứng dụng; tài khoản cần cho phép tính năng đó.

**Vì sao phải dùng multipart/form-data?** Biểu mẫu cần định dạng này để truyền dữ liệu tệp cùng các trường văn bản.

**addAddress và send khác nhau thế nào?** `addAddress()` đưa người nhận vào thư; `send()` mới thực hiện gửi qua SMTP.

**Vì sao phải kiểm tra ở PHP dù HTML đã có required?** Người dùng có thể bỏ qua kiểm tra HTML và gửi yêu cầu trực tiếp đến PHP.

## Nguồn đối chiếu

- Tài liệu bài tập: Lab 8. Email.pdf do người dùng cung cấp.
- Google, mật khẩu ứng dụng: <https://support.google.com/accounts/answer/185833?hl=vi>
- PHPMailer, hướng dẫn và ví dụ chính thức: <https://github.com/PHPMailer/PHPMailer>

Hướng dẫn bật “ứng dụng kém an toàn” trong PDF là nội dung cũ; bài làm dùng mật khẩu ứng dụng theo hướng dẫn Google hiện tại.

## 7. Xử lý lỗi thường gặp

- Thiếu PHP: cài XAMPP có PHP 8.2 trở lên; không cần bật Apache hoặc MySQL khi dùng BAT.
- Cổng 8000 đang bận: dừng cửa sổ chạy bài cũ. Nếu muốn đổi cổng, thay mọi số 8000 trong BAT bằng cùng một số mới.
- Thiếu OpenSSL: kiểm tra extension=openssl trong php.ini của PHP đang dùng.
- Lỗi chứng chỉ: cấu hình openssl.cafile trong php.ini trỏ tới bộ chứng chỉ CA hợp lệ. Giữ xác minh TLS được bật.
- Không thấy mật khẩu ứng dụng: kiểm tra Xác minh 2 bước và giới hạn tài khoản trường/cơ quan theo hướng dẫn Google.
- Gửi thất bại: kiểm tra Internet, quyền dùng mật khẩu ứng dụng và cổng 587 có bị mạng chặn không. Không dùng mật khẩu đăng nhập Gmail thông thường.
- Tệp lớn bị từ chối: giới hạn của bài là 5 MB; BAT đặt giới hạn nhận POST cao hơn để PHP có thể hiển thị lỗi rõ ràng.

Để gửi bài cho người khác: chỉ gửi toàn bộ Lab8_Email.zip. Không gửi tài khoản hay mật khẩu ứng dụng; người nhận tự nhập thông tin của họ. Không cần Composer hoặc database cho 3 bài chính.
