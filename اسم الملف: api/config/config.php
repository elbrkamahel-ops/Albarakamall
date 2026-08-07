<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Application Configuration
|--------------------------------------------------------------------------
| File:
| api/config/config.php
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
*/

date_default_timezone_set('Africa/Cairo');



/*
|--------------------------------------------------------------------------
| Application
|--------------------------------------------------------------------------
*/

define(
    'APP_NAME',
    'مول البركة أولاد الجارحي'
);


define(
    'APP_VERSION',
    '1.0.0'
);


define(
    'APP_ENV',
    'production'
);



/*
|--------------------------------------------------------------------------
| Website
|--------------------------------------------------------------------------
*/

define(
    'SITE_URL',
    'https://albaraka.io'
);


define(
    'ADMIN_URL',
    SITE_URL . '/admin'
);


define(
    'API_URL',
    SITE_URL . '/api'
);



/*
|--------------------------------------------------------------------------
| Store Information
|--------------------------------------------------------------------------
*/

define(
    'STORE_PHONE',
    '01119511185'
);


define(
    'STORE_ADDRESS',
    'شارع الشيخ عبدالرحمن تاج البنفسج ٩'
);


define(
    'STORE_CURRENCY',
    'جنيه'
);


define(
    'STORE_CURRENCY_CODE',
    'EGP'
);



/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
*/

define(
    'API_VERSION',
    'v1'
);


define(
    'API_PREFIX',
    API_URL . '/' . API_VERSION
);



/*
|--------------------------------------------------------------------------
| Security
|--------------------------------------------------------------------------
*/

define(
    'SESSION_NAME',
    'albaraka_admin_session'
);


define(
    'CSRF_TOKEN_NAME',
    'albaraka_csrf_token'
);



/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

define(
    'DEFAULT_PAGE_SIZE',
    20
);


define(
    'MAX_PAGE_SIZE',
    100
);



/*
|--------------------------------------------------------------------------
| Uploads
|--------------------------------------------------------------------------
*/

define(
    'UPLOADS_PATH',
    dirname(__DIR__, 2) . '/uploads'
);


define(
    'PRODUCTS_UPLOAD_PATH',
    UPLOADS_PATH . '/products'
);


define(
    'CATEGORIES_UPLOAD_PATH',
    UPLOADS_PATH . '/categories'
);



/*
|--------------------------------------------------------------------------
| Allowed Image Types
|--------------------------------------------------------------------------
*/

define(
    'ALLOWED_IMAGE_TYPES',
    [
        'image/jpeg',
        'image/png',
        'image/webp'
    ]
);



/*
|--------------------------------------------------------------------------
| Maximum Upload Size
|--------------------------------------------------------------------------
| 5 MB
|--------------------------------------------------------------------------
*/

define(
    'MAX_IMAGE_SIZE',
    5 * 1024 * 1024
);



/*
|--------------------------------------------------------------------------
| CORS
|--------------------------------------------------------------------------
*/

define(
    'CORS_ALLOWED_ORIGIN',
    SITE_URL
);



/*
|--------------------------------------------------------------------------
| Response Helpers
|--------------------------------------------------------------------------
*/

function jsonResponse(
    $data = [],
    int $statusCode = 200
): void {

    http_response_code(
        $statusCode
    );


    header(
        'Content-Type: application/json; charset=utf-8'
    );


    echo json_encode(
        $data,
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );


    exit;

}



/*
|--------------------------------------------------------------------------
| Success Response
|--------------------------------------------------------------------------
*/

function successResponse(
    $data = [],
    string $message = 'تمت العملية بنجاح.'
): void {

    jsonResponse(
        [
            'success' => true,

            'message' => $message,

            'data' => $data
        ],
        200
    );

}



/*
|--------------------------------------------------------------------------
| Error Response
|--------------------------------------------------------------------------
*/

function errorResponse(
    string $message,
    int $statusCode = 400,
    $errors = []
): void {

    jsonResponse(
        [
            'success' => false,

            'message' => $message,

            'errors' => $errors
        ],
        $statusCode
    );

}



/*
|--------------------------------------------------------------------------
| Request Method
|--------------------------------------------------------------------------
*/

function requestMethod(): string
{
    return strtoupper(
        $_SERVER['REQUEST_METHOD'] ?? 'GET'
    );
}



/*
|--------------------------------------------------------------------------
| JSON Request Body
|--------------------------------------------------------------------------
*/

function getJsonInput(): array
{
    $input =
        file_get_contents(
            'php://input'
        );


    if (!$input) {

        return [];

    }


    $data =
        json_decode(
            $input,
            true
        );


    if (!is_array($data)) {

        return [];

    }


    return $data;
}



/*
|--------------------------------------------------------------------------
| Clean String
|--------------------------------------------------------------------------
*/

function cleanString(
    $value
): string {

    if (
        $value === null
    ) {

        return '';

    }


    return trim(
        strip_tags(
            (string) $value
        )
    );

}



/*
|--------------------------------------------------------------------------
| Integer Helper
|--------------------------------------------------------------------------
*/

function cleanInt(
    $value,
    int $default = 0
): int {

    if (
        !is_numeric($value)
    ) {

        return $default;

    }


    return (int) $value;

}



/*
|--------------------------------------------------------------------------
| Float Helper
|--------------------------------------------------------------------------
*/

function cleanFloat(
    $value,
    float $default = 0
): float {

    if (
        !is_numeric($value)
    ) {

        return $default;

    }


    return (float) $value;

}



/*
|--------------------------------------------------------------------------
| Boolean Helper
|--------------------------------------------------------------------------
*/

function cleanBool(
    $value
): bool {

    return filter_var(
        $value,
        FILTER_VALIDATE_BOOLEAN
    );

}



/*
|--------------------------------------------------------------------------
| Generate Random Token
|--------------------------------------------------------------------------
*/

function generateToken(
    int $length = 64
): string {

    return bin2hex(
        random_bytes(
            max(
                16,
                (int) ($length / 2)
            )
        )
    );

}



/*
|--------------------------------------------------------------------------
| CORS Headers
|--------------------------------------------------------------------------
*/

function setCorsHeaders(): void
{

    header(
        'Access-Control-Allow-Origin: ' .
        CORS_ALLOWED_ORIGIN
    );


    header(
        'Access-Control-Allow-Credentials: true'
    );


    header(
        'Access-Control-Allow-Headers: Content-Type, Authorization, X-CSRF-Token'
    );


    header(
        'Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS'
    );


    /*
    | معالجة طلب OPTIONS
    */

    if (
        requestMethod() === 'OPTIONS'
    ) {

        http_response_code(204);

        exit;

    }

}



/*
|--------------------------------------------------------------------------
| Initialize API
|--------------------------------------------------------------------------
*/

function initializeApi(): void
{

    setCorsHeaders();


    header(
        'X-Content-Type-Options: nosniff'
    );


    header(
        'X-Frame-Options: SAMEORIGIN'
    );


    header(
        'Referrer-Policy: strict-origin-when-cross-origin'
    );

}
