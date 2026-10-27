@echo off
setlocal
set "PHP_EXE="

for %%P in ("C:\xampp\php\php.exe" "D:\xampp\php\php.exe" "D:\XAMPP\php\php.exe") do (
    if not defined PHP_EXE if exist "%%~P" set "PHP_EXE=%%~P"
)

if not defined PHP_EXE (
    for /f "delims=" %%P in ('where php.exe 2^>nul') do (
        if not defined PHP_EXE set "PHP_EXE=%%P"
    )
)

if not defined PHP_EXE (
    echo Khong tim thay PHP. Hay cai XAMPP hoac them php.exe vao PATH.
    echo Neu XAMPP da cai o noi khac, sua duong dan trong CHAY_BAI.bat.
    pause
    exit /b 1
)

if not exist "%~dp0vendor\autoload.php" (
    echo Thieu PHPMailer trong thu muc vendor. Hay giai nen lai file ZIP day du.
    pause
    exit /b 1
)

"%PHP_EXE%" -r "exit(PHP_VERSION_ID >= 80200 && extension_loaded('openssl') ? 0 : 1);"
if errorlevel 1 (
    echo Can PHP 8.2 tro len va extension OpenSSL. Hay kiem tra XAMPP/php.ini.
    pause
    exit /b 1
)
powershell -NoProfile -Command "try { $l = [System.Net.Sockets.TcpListener]::new([System.Net.IPAddress]::Loopback,8000); $l.Start(); $l.Stop(); exit 0 } catch { exit 1 }"
if errorlevel 1 (
    echo Cong 8000 dang ban. Dong may chu Lab 8 cu roi chay lai.
    pause
    exit /b 1
)
if /i not "%~1"=="--no-browser" start "" /b powershell -NoProfile -WindowStyle Hidden -Command "Start-Sleep -Seconds 2; Start-Process 'http://127.0.0.1:8000/index.php'"
echo Mo http://127.0.0.1:8000/index.php de lam bai.
echo Giu cua so nay khi su dung. Nhan Ctrl+C de dung may chu.
"%PHP_EXE%" -d upload_max_filesize=8M -d post_max_size=10M -S 127.0.0.1:8000 -t "%~dp0"
endlocal
