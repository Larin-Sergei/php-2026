<?php

session_start();

$backgroundPath = __DIR__ . '/noise.jpg';
$fontPath = __DIR__ . '/fonts/arial.ttf';

if (!extension_loaded('gd')) {
    http_response_code(500);
    exit('Для работы CAPTCHA необходимо расширение PHP GD.');
}

if (!file_exists($backgroundPath) || !file_exists($fontPath)) {
    http_response_code(500);
    exit('Не найден файл noise.jpg или fonts/arial.ttf.');
}

$image = imagecreatefromjpeg($backgroundPath);

if ($image === false) {
    http_response_code(500);
    exit('Не удалось загрузить noise.jpg.');
}

$width = imagesx($image);
$height = imagesy($image);

$characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$length = random_int(5, 6);
$captchaText = '';

for ($i = 0; $i < $length; $i++) {
    $captchaText .= $characters[random_int(0, strlen($characters) - 1)];
}

$_SESSION['captcha_code'] = $captchaText;

$fontSize = 24;
$step = 40;
$totalWidth = ($length - 1) * $step;
$startX = max(10, (int) (($width - $totalWidth) / 2));

for ($i = 0; $i < $length; $i++) {
    $color = imagecolorallocate(
        $image,
        random_int(0, 100),
        random_int(0, 100),
        random_int(0, 100)
    );

    $x = $startX + $i * $step;
    $y = (int) ($height / 2 + $fontSize / 2);

    imagettftext(
        $image,
        $fontSize,
        random_int(-12, 12),
        $x,
        $y,
        $color,
        $fontPath,
        $captchaText[$i]
    );
}

header('Content-Type: image/jpeg');
header('Cache-Control: no-store, no-cache, must-revalidate');

imagejpeg($image);
exit;
