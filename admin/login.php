<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/auth.php';

if (
    isset($_SESSION['admin_id']) &&
    (int) $_SESSION['admin_id'] > 0
) {
    header('Location: /admin/');
    exit;
}

$error = '';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    $username = trim(
        (string) (
            $_POST['username'] ?? ''
        )
    );

    $password = (string) (
        $_POST['password'] ?? ''
    );


    if (
        $username === '' ||
        $password === ''
    ) {

        $error =
            'من فضلك أدخل اسم المستخدم وكلمة المرور.';

    } else {

        /*
        |--------------------------------------------------------------------------
        | استخدم دالة تسجيل الدخول الموجودة في auth.php
        |--------------------------------------------------------------------------
        */

        try {

            if (
                function_exists('adminLogin')
            ) {

                $loggedIn =
                    adminLogin(
                        $username,
                        $password
                    );

                if ($loggedIn) {

                    header(
                        'Location: /admin/'
                    );

                    exit;

                }

                $error =
                    'اسم المستخدم أو كلمة المرور غير صحيحة.';

            } else {

                $error =
                    'دالة تسجيل الدخول غير موجودة في auth.php.';

            }

        } catch (
            Throwable $e
        ) {

            error_log(
                'Admin login error: '
                . $e->getMessage()
            );

            $error =
                'حدث خطأ أثناء تسجيل الدخول.';

        }

    }

}

?>
<!DOCTYPE html>

<html
    lang="ar"
    dir="rtl"
>

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="robots"
        content="noindex,nofollow"
    >

    <title>
        تسجيل دخول الإدارة | مول البركة
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            min-height: 100vh;

            font-family:
                Arial,
                Tahoma,
                sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #f5f7fa,
                    #e8edf3
                );

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 20px;

        }

        .login-wrapper {

            width: 100%;

            max-width: 430px;

        }

        .login-card {

            background: #ffffff;

            border-radius: 20px;

            padding: 35px;

            box-shadow:
                0 20px 60px
                rgba(0,0,0,.12);

        }

        .brand {

            text-align: center;

            margin-bottom: 30px;

        }

        .logo {

            width: 75px;

            height: 75px;

            margin: 0 auto 15px;

            border-radius: 20px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: #111827;

            color: #ffffff;

            font-size: 22px;

            font-weight: 800;

        }

        .brand h1 {

            margin: 0 0 8px;

            font-size: 25px;

            color: #111827;

        }

        .brand p {

            margin: 0;

            color: #6b7280;

            font-size: 14px;

        }

        .form-group {

            margin-bottom: 20px;

        }

        label {

            display: block;

            margin-bottom: 8px;

            color: #374151;

            font-size: 14px;

            font-weight: 700;

        }

        input {

            width: 100%;

            height: 50px;

            padding: 0 15px;

            border: 1px solid #d1d5db;

            border-radius: 10px;

            font-size: 15px;

            outline: none;

            transition: .2s;

        }

        input:focus {

            border-color: #111827;

            box-shadow:
                0 0 0 3px
                rgba(17,24,39,.08);

        }

        .error {

            background: #fef2f2;

            color: #b91c1c;

            border: 1px solid #fecaca;

            border-radius: 10px;

            padding: 12px 14px;

            margin-bottom: 20px;

            font-size: 14px;

        }

        .login-button {

            width: 100%;

            height: 52px;

            border: 0;

            border-radius: 10px;

            background: #111827;

            color: #ffffff;

            font-size: 16px;

            font-weight: 700;

            cursor: pointer;

            transition: .2s;

        }

        .login-button:hover {

            background: #000000;

        }

        .back-link {

            display: block;

            text-align: center;

            margin-top: 20px;

            color: #6b7280;

            text-decoration: none;

            font-size: 13px;

        }

        .back-link:hover {

            color: #111827;

        }

        .footer {

            text-align: center;

            margin-top: 20px;

            color: #9ca3af;

            font-size: 12px;

        }

    </style>

</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        <div class="brand">

            <div class="logo">
                البركة
            </div>

            <h1>
                مول البركة
            </h1>

            <p>
                تسجيل الدخول إلى لوحة الإدارة
            </p>

        </div>


        <?php if ($error !== ''): ?>

            <div class="error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            action=""
            autocomplete="on"
        >

            <div class="form-group">

                <label
                    for="username"
                >
                    اسم المستخدم
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    autocomplete="username"
                    required
                    autofocus
                >

            </div>


            <div class="form-group">

                <label
                    for="password"
                >
                    كلمة المرور
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="current-password"
                    required
                >

            </div>


            <button
                type="submit"
                class="login-button"
            >
                تسجيل الدخول
            </button>

        </form>


        <a
            href="/"
            class="back-link"
        >
            العودة إلى الموقع
        </a>

    </div>


    <div class="footer">

        لوحة إدارة مول البركة

    </div>

</div>

</body>

</html>
