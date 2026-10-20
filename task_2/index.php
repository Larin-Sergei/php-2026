
<?php

session_start();

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userAnswer = strtoupper(trim($_POST['captcha'] ?? ''));
    $correctAnswer = $_SESSION['captcha_code'] ?? '';

    if ($correctAnswer !== '' && hash_equals($correctAnswer, $userAnswer)) {
        $message = 'Верно! Проверка CAPTCHA пройдена.';
        $messageType = 'success';
    } else {
        $message = 'Неверно! Попробуйте ещё раз.';
        $messageType = 'error';
    }

    unset($_SESSION['captcha_code']);
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f4f8;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            width: 360px;
            max-width: calc(100% - 48px);
            padding: 28px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-top: 0;
        }

        p {
            color: #555;
            line-height: 1.5;
        }

        .captcha-image {
            display: block;
            width: 100%;
            height: auto;
            margin: 18px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            box-sizing: border-box;
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 18px;
            margin-bottom: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .message {
            margin-top: 16px;
            padding: 12px;
            border-radius: 6px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <main class="container">
        <h1>Проверка CAPTCHA</h1>

        <p>Введите символы, изображённые на картинке.</p>

        <form method="post" action="index.php">
            <img
                class="captcha-image"
                src="captcha.php"
                alt="Изображение с проверочным кодом"
            >

            <label for="captcha">Проверочный код</label>

            <input
                type="text"
                id="captcha"
                name="captcha"
                placeholder="Введите символы"
                autocomplete="off"
                required
            >

            <button type="submit">Проверить</button>
        </form>

        <?php if ($message !== ''): ?>
            <div class="message <?= htmlspecialchars($messageType) ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
