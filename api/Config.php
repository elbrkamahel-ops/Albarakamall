<?php

/* =========================================================
   مول البركة
   Database Configuration
========================================================= */

declare(strict_types=1);


/* =========================================================
   إعدادات قاعدة البيانات
========================================================= */

/*
   غيّر هذه البيانات حسب بيانات MySQL
   الموجودة في الاستضافة.
*/

define('DB_HOST', 'localhost');

define('DB_NAME', 'albaraka_store');

define('DB_USER', 'YOUR_DATABASE_USER');

define('DB_PASS', 'YOUR_DATABASE_PASSWORD');

define('DB_CHARSET', 'utf8mb4');


/* =========================================================
   الاتصال بقاعدة البيانات
========================================================= */

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn =
        'mysql:host=' . DB_HOST .
        ';dbname=' . DB_NAME .
        ';charset=' . DB_CHARSET;


    try {

        $pdo = new PDO(
            $dsn,
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE =>
                    PDO::ERRMODE_EXCEPTION,

                PDO::ATTR_DEFAULT_FETCH_MODE =>
                    PDO::FETCH_ASSOC,

                PDO::ATTR_EMULATE_PREPARES =>
                    false
            ]
        );

        return $pdo;

    } catch (PDOException $e) {

        http_response_code(500);

        header(
            'Content-Type: application/json; charset=utf-8'
        );

        echo json_encode(
            [
                'success' => false,
                'error' => 'database_connection_failed'
            ],
            JSON_UNESCAPED_UNICODE
        );

        exit;
    }
}


/* =========================================================
   JSON Response
========================================================= */

function jsonResponse(
    array $data,
    int $status = 200
): never {

    http_response_code($status);

    header(
        'Content-Type: application/json; charset=utf-8'
    );

    header(
        'Cache-Control: no-store'
    );

    echo json_encode(
        $data,
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );

    exit;
}


/* =========================================================
   قراءة JSON
========================================================= */

function getJsonInput(): array
{
    $input =
        file_get_contents('php://input');

    if (!$input) {
        return [];
    }

    $data =
        json_decode(
            $input,
            true
        );

    return is_array($data)
        ? $data
        : [];
}


/* =========================================================
   تنظيف النصوص
========================================================= */

function cleanString(
    mixed $value
): string {

    return trim(
        (string)$value
    );

}


/* =========================================================
   رقم الهاتف
========================================================= */

function cleanPhone(
    mixed $value
): string {

    $phone =
        preg_replace(
            '/[^0-9+]/',
            '',
            (string)$value
        );

    return trim($phone);

}


/* =========================================================
   CORS
========================================================= */

header(
    'Access-Control-Allow-Origin: *'
);

header(
    'Access-Control-Allow-Headers: Content-Type, Authorization'
);

header(
    'Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS'
);


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {

    http_response_code(204);

    exit;
}
