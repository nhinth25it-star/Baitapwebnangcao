<?php
require __DIR__ . '/functions.php';
startFormSession();
$mailConfig = require __DIR__ . '/config.php';
$configured = filter_var($mailConfig['username'], FILTER_VALIDATE_EMAIL) && $mailConfig['password'] !== '';
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab 8 - Gửi email</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <h1>Lab 8 · Gửi email bằng PHP</h1>
    <p>Chạy file <strong>CHAY_BAI.bat</strong>, sau đó mở trang này và nhập cấu hình Gmail một lần.</p>
    <?php if (isset($_GET['config']) && $_GET['config'] === 'saved'): ?>
        <p class="notice">Đã lưu cấu hình Gmail trong phiên trình duyệt này.</p>
    <?php elseif (isset($_GET['config']) && $_GET['config'] === 'cleared'): ?>
        <p class="notice">Đã xóa cấu hình Gmail khỏi phiên trình duyệt này.</p>
    <?php endif; ?>
    <section>
        <h2>Cấu hình Gmail</h2>
        <p><?= $configured ? 'Đã cấu hình cho tài khoản ' . escapeHtml($mailConfig['username']) . '.' : 'Chưa cấu hình. Hãy nhập Gmail người gửi và mật khẩu ứng dụng.' ?></p>
        <p class="hint">Mật khẩu được giữ trong phiên làm việc PHP, không ghi vào mã nguồn. Mỗi người dùng máy tính cần tự nhập tài khoản của mình.</p>
        <form action="setup.php" method="post" autocomplete="off">
            <input type="hidden" name="csrf" value="<?= escapeHtml($_SESSION['csrf']) ?>">
            <label>Gmail người gửi <input type="email" name="username" required autocomplete="username" value="<?= escapeHtml($mailConfig['username']) ?>"></label>
            <label>Mật khẩu ứng dụng Gmail <input type="password" name="password" required autocomplete="new-password" placeholder="Nhập mật khẩu ứng dụng 16 ký tự"></label>
            <label>Tên người gửi <input type="text" name="from_name" required maxlength="100" value="<?= escapeHtml($mailConfig['from_name']) ?>"></label>
            <label>Email nhận cố định cho Bài 1 <input type="email" name="fixed_to" value="<?= escapeHtml($mailConfig['fixed_to']) ?>" placeholder="Có thể để trống nếu chưa làm Bài 1"></label>
            <button type="submit">Lưu cấu hình</button>
        </form>
        <?php if ($configured): ?>
            <form action="setup.php" method="post">
                <input type="hidden" name="csrf" value="<?= escapeHtml($_SESSION['csrf']) ?>">
                <input type="hidden" name="action" value="clear">
                <button class="secondary" type="submit">Xóa cấu hình đã lưu</button>
            </form>
        <?php endif; ?>
    </section>
    <section>
        <h2>Bài 1. Gửi email cố định</h2>
        <p>Gửi lời chào và tệp mẫu đến địa chỉ nhận cố định đã nhập trong phần cấu hình Gmail.</p>
        <form action="bai1.php" method="post">
            <input type="hidden" name="csrf" value="<?= escapeHtml($_SESSION['csrf']) ?>">
            <button type="submit">Gửi email cố định</button>
        </form>
    </section>
    <section>
        <h2>Bài 2. Gửi email có tệp đính kèm</h2>
        <form action="mail.php" enctype="multipart/form-data" method="post">
            <input type="hidden" name="csrf" value="<?= escapeHtml($_SESSION['csrf']) ?>">
            <label>Email người nhận <input type="email" name="email" required placeholder="nguoinhan@example.com"></label>
            <label>Tiêu đề <input type="text" name="tieude" required maxlength="150"></label>
            <label>Nội dung <textarea name="content" id="editor" rows="6" required maxlength="20000"></textarea></label>
            <label>Tệp đính kèm (không bắt buộc, tối đa 5 MB) <input type="file" name="file"></label>
            <button type="submit">Gửi email</button>
        </form>
    </section>
    <section>
        <h2>Bài 3. Gửi đến nhiều địa chỉ</h2>
        <form action="bai3.php" method="post">
            <input type="hidden" name="csrf" value="<?= escapeHtml($_SESSION['csrf']) ?>">
            <label>Danh sách email <textarea name="emails" rows="3" required placeholder="a@example.com, b@example.com"></textarea></label>
            <p class="hint">Ngăn cách bằng dấu phẩy, chấm phẩy hoặc xuống dòng. Địa chỉ trùng chỉ nhận một lần; tối đa 20 địa chỉ.</p>
            <label>Tiêu đề <input type="text" name="tieude" required maxlength="150"></label>
            <label>Nội dung <textarea name="content" rows="6" required maxlength="20000"></textarea></label>
            <button type="submit">Gửi đến danh sách</button>
        </form>
    </section>
</main>
</body>
</html>
