<?php
require __DIR__ . '/functions.php';
startFormSession();

try {
    checkPost();
    if (postText('action') === 'clear') {
        unset($_SESSION['smtp_config']);
        header('Location: index.php?config=cleared');
        exit;
    }

    $username = postText('username');
    $password = preg_replace('/\s+/', '', postText('password'));
    $fromName = postText('from_name');
    $fixedTo = postText('fixed_to');

    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('Gmail người gửi không hợp lệ.');
    }
    if ($password === '' || strlen($password) < 8) {
        throw new InvalidArgumentException('Hãy nhập mật khẩu ứng dụng Gmail.');
    }
    if ($fromName === '') {
        throw new InvalidArgumentException('Tên người gửi không được để trống.');
    }
    if ($fixedTo !== '' && !filter_var($fixedTo, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('Email nhận cố định cho Bài 1 không hợp lệ.');
    }

    $_SESSION['smtp_config'] = [
        'username' => $username,
        'password' => $password,
        'from_name' => $fromName,
        'fixed_to' => $fixedTo,
    ];
    session_regenerate_id(true);
    header('Location: index.php?config=saved');
    exit;
} catch (Throwable $error) {
    showError($error);
}
