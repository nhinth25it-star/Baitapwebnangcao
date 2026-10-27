<?php
$saved = $_SESSION['smtp_config'] ?? [];
return [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'username' => $saved['username'] ?? (getenv('SMTP_USERNAME') ?: ''),
    'password' => $saved['password'] ?? str_replace(' ', '', getenv('SMTP_PASSWORD') ?: ''),
    'from_name' => $saved['from_name'] ?? (getenv('SMTP_FROM_NAME') ?: 'Sinh viên - Lab 8'),
    'fixed_to' => $saved['fixed_to'] ?? (getenv('LAB_FIXED_TO') ?: ''),
];
