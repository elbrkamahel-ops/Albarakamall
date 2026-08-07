<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Authentication Configuration
|--------------------------------------------------------------------------
| File:
| api/config/auth.php
|--------------------------------------------------------------------------
*/


require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';



/*
|--------------------------------------------------------------------------
| Start Secure Session
|--------------------------------------------------------------------------
*/

function startAdminSession(): void
{

    if (
        session_status() === PHP_SESSION_ACTIVE
    ) {

        return;

    }


    $isHttps =
        (
            isset($_SERVER['HTTPS']) &&
            $_SERVER['HTTPS'] !== 'off'
        );


    session_name(
        SESSION_NAME
    );


    session_set_cookie_params(
        [
            'lifetime' => 0,

            'path' => '/',

            'domain' => '',

            'secure' => $isHttps,

            'httponly' => true,

            'samesite' => 'Lax'
        ]
    );


    session_start();

}



/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

function loginAdmin(
    string $email,
    string $password
): bool {

    startAdminSession();


    $email =
        strtolower(
            trim($email)
        );


    if (
        $email === '' ||
        $password === ''
    ) {

        return false;

    }


    $db =
        getDatabaseConnection();


    $sql = "

        SELECT

            id,

            name,

            email,

            password,

            role,

            status

        FROM admins

        WHERE email = :email

        LIMIT 1

    ";


    $stmt =
        $db->prepare(
            $sql
        );


    $stmt->execute(
        [
            ':email' => $email
        ]
    );


    $admin =
        $stmt->fetch();


    if (!$admin) {

        return false;

    }


    /*
    | التحقق من حالة الحساب
    */

    if (
        isset($admin['status']) &&
        $admin['status'] !== 'active'
    ) {

        return false;

    }


    /*
    | التحقق من كلمة المرور
    */

    if (
        !password_verify(
            $password,
            $admin['password']
        )
    ) {

        return false;

    }


    /*
    | تجديد Session ID
    */

    session_regenerate_id(
        true
    );


    /*
    | حفظ بيانات المدير في الجلسة
    */

    $_SESSION['admin_id'] =
        (int) $admin['id'];


    $_SESSION['admin_name'] =
        $admin['name'];


    $_SESSION['admin_email'] =
        $admin['email'];


    $_SESSION['admin_role'] =
        $admin['role'] ?? 'admin';


    $_SESSION['admin_logged_in'] =
        true;


    $_SESSION['admin_login_time'] =
        time();


    return true;

}



/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

function logoutAdmin(): void
{

    startAdminSession();


    $_SESSION = [];


    /*
    | حذف Cookie الخاصة بالجلسة
    */

    if (
        ini_get(
            'session.use_cookies'
        )
    ) {

        $params =
            session_get_cookie_params();


        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );

    }


    session_destroy();

}



/*
|--------------------------------------------------------------------------
| Check Login
|--------------------------------------------------------------------------
*/

function isAdminLoggedIn(): bool
{

    startAdminSession();


    return (
        isset(
            $_SESSION['admin_logged_in']
        ) &&
        $_SESSION['admin_logged_in'] === true &&
        !empty(
            $_SESSION['admin_id']
        )
    );

}



/*
|--------------------------------------------------------------------------
| Require Login
|--------------------------------------------------------------------------
*/

function requireAdminLogin(): void
{

    if (
        !isAdminLoggedIn()
    ) {

        errorResponse(
            'يجب تسجيل الدخول أولاً.',
            401
        );

    }

}



/*
|--------------------------------------------------------------------------
| Current Admin
|--------------------------------------------------------------------------
*/

function getCurrentAdmin(): ?array
{

    if (
        !isAdminLoggedIn()
    ) {

        return null;

    }


    return [

        'id' =>
            (int) $_SESSION['admin_id'],

        'name' =>
            $_SESSION['admin_name'] ?? '',

        'email' =>
            $_SESSION['admin_email'] ?? '',

        'role' =>
            $_SESSION['admin_role'] ?? 'admin'

    ];

}



/*
|--------------------------------------------------------------------------
| Admin ID
|--------------------------------------------------------------------------
*/

function getCurrentAdminId(): ?int
{

    if (
        !isAdminLoggedIn()
    ) {

        return null;

    }


    return (int)
        $_SESSION['admin_id'];

}



/*
|--------------------------------------------------------------------------
| Role Check
|--------------------------------------------------------------------------
*/

function hasAdminRole(
    string $role
): bool {

    if (
        !isAdminLoggedIn()
    ) {

        return false;

    }


    $currentRole =
        $_SESSION['admin_role'] ?? '';


    return (
        $currentRole === $role
    );

}



/*
|--------------------------------------------------------------------------
| Admin Or Super Admin
|--------------------------------------------------------------------------
*/

function canManageSystem(): bool
{

    if (
        !isAdminLoggedIn()
    ) {

        return false;

    }


    $role =
        $_SESSION['admin_role'] ?? '';


    return in_array(
        $role,
        [
            'admin',
            'super_admin'
        ],
        true
    );

}



/*
|--------------------------------------------------------------------------
| Password Hash
|--------------------------------------------------------------------------
*/

function hashAdminPassword(
    string $password
): string {

    return password_hash(
        $password,
        PASSWORD_DEFAULT
    );

}



/*
|--------------------------------------------------------------------------
| Password Validation
|--------------------------------------------------------------------------
*/

function validateAdminPassword(
    string $password
): array {

    $errors = [];


    if (
        strlen($password) < 8
    ) {

        $errors[] =
            'كلمة المرور يجب أن تكون 8 أحرف على الأقل.';

    }


    if (
        !preg_match(
            '/[A-Za-z]/',
            $password
        )
    ) {

        $errors[] =
            'كلمة المرور يجب أن تحتوي على حرف واحد على الأقل.';

    }


    if (
        !preg_match(
            '/[0-9]/',
            $password
        )
    ) {

        $errors[] =
            'كلمة المرور يجب أن تحتوي على رقم واحد على الأقل.';

    }


    return $errors;

}



/*
|--------------------------------------------------------------------------
| CSRF Token
|--------------------------------------------------------------------------
*/

function getCsrfToken(): string
{

    startAdminSession();


    if (
        empty(
            $_SESSION[
                CSRF_TOKEN_NAME
            ]
        )
    ) {

        $_SESSION[
            CSRF_TOKEN_NAME
        ] =
            generateToken(64);

    }


    return $_SESSION[
        CSRF_TOKEN_NAME
    ];

}



/*
|--------------------------------------------------------------------------
| Verify CSRF Token
|--------------------------------------------------------------------------
*/

function verifyCsrfToken(
    ?string $token
): bool {

    startAdminSession();


    if (
        empty($token)
    ) {

        return false;

    }


    $sessionToken =
        $_SESSION[
            CSRF_TOKEN_NAME
        ] ?? '';


    return hash_equals(
        $sessionToken,
        $token
    );

}



/*
|--------------------------------------------------------------------------
| Require CSRF Token
|--------------------------------------------------------------------------
*/

function requireCsrfToken(): void
{

    $token =
        $_SERVER[
            'HTTP_X_CSRF_TOKEN'
        ] ?? null;


    if (
        !$token
    ) {

        $token =
            $_POST[
                CSRF_TOKEN_NAME
            ] ?? null;

    }


    if (
        !verifyCsrfToken(
            $token
        )
    ) {

        errorResponse(
            'رمز الحماية غير صالح.',
            419
        );

    }

}



/*
|--------------------------------------------------------------------------
| Login Response
|--------------------------------------------------------------------------
*/

function getAdminSessionData(): array
{

    if (
        !isAdminLoggedIn()
    ) {

        return [

            'logged_in' => false

        ];

    }


    return [

        'logged_in' => true,

        'admin' =>
            getCurrentAdmin(),

        'csrf_token' =>
            getCsrfToken()

    ];

}
