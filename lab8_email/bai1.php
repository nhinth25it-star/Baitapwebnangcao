<?php
require __DIR__ . '/functions.php';
startFormSession();
try {
    checkPost();
    $config = require __DIR__ . '/config.php';
    if (!filter_var($config['fixed_to'], FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('Hãy nhập email nhận cố định trong phần Cấu hình Gmail ở trang chính.');
    }
    $mail = createMailer();
    $mail->addAddress($config['fixed_to']);
    setMessage($mail, 'Bài 1 - Gửi thư từ PHP', 'Chào bạn! Chúc bạn học tập tốt!');
    $mail->addAttachment(__DIR__ . '/dinh-kem-mau.txt', 'dinh-kem-mau.txt');
    $mail->send();
    showResult('Gửi thành công', 'Máy chủ SMTP đã chấp nhận email bài 1. Hãy kiểm tra hộp thư đến và thư rác.');
} catch (Throwable $error) {
    showError($error);
}
