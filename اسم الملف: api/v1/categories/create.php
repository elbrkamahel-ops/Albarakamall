<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Create Category API
|--------------------------------------------------------------------------
| File:
| api/v1/categories/create.php
|--------------------------------------------------------------------------
*/


require_once __DIR__ . '/../../../config/config.php';

require_once __DIR__ . '/../../../config/database.php';

require_once __DIR__ . '/../../../config/auth.php';



/*
|--------------------------------------------------------------------------
| Initialize API
|--------------------------------------------------------------------------
*/

initializeApi();



/*
|--------------------------------------------------------------------------
| Allow POST Only
|--------------------------------------------------------------------------
*/

if (
    requestMethod() !== 'POST'
) {

    errorResponse(
        'طريقة الطلب غير مسموحة.',
        405
    );

}



/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

requireAdminLogin();



/*
|--------------------------------------------------------------------------
| CSRF Protection
|--------------------------------------------------------------------------
*/

requireCsrfToken();



/*
|--------------------------------------------------------------------------
| Read Request
|--------------------------------------------------------------------------
*/

$data =
    getJsonInput();


if (
    empty($data)
) {

    $data = $_POST;

}



/*
|--------------------------------------------------------------------------
| Input
|--------------------------------------------------------------------------
*/

$name =
    cleanString(
        $data['name'] ?? ''
    );


$slug =
    cleanString(
        $data['slug'] ?? ''
    );


$description =
    cleanString(
        $data['description'] ?? ''
    );


$image =
    cleanString(
        $data['image'] ?? ''
    );


$icon =
    cleanString(
        $data['icon'] ?? ''
    );


$sortOrder =
    cleanInt(
        $data['sort_order'] ?? 0
    );


$status =
    cleanString(
        $data['status'] ?? 'active'
    );



/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

if (
    $name === ''
) {

    errorResponse(
        'اسم القسم مطلوب.',
        422
    );

}


if (
    mb_strlen(
        $name
    ) < 2
) {

    errorResponse(
        'اسم القسم قصير جدًا.',
        422
    );

}



/*
|--------------------------------------------------------------------------
| Generate Slug
|--------------------------------------------------------------------------
*/

if (
    $slug === ''
) {

    $slug =
        generateCategorySlug(
            $name
        );

}


$slug =
    strtolower(
        trim($slug)
    );


$slug =
    preg_replace(
        '/\s+/',
        '-',
        $slug
    );


$slug =
    preg_replace(
        '/[^a-zA-Z0-9\-_]/',
        '',
        $slug
    );


if (
    $slug === ''
) {

    errorResponse(
        'تعذر إنشاء معرف القسم.',
        422
    );

}



/*
|--------------------------------------------------------------------------
| Validate Status
|--------------------------------------------------------------------------
*/

if (
    !in_array(
        $status,
        [
            'active',
            'inactive'
        ],
        true
    )
) {

    $status = 'active';

}



/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/

try {

    $db =
        getDatabaseConnection();



    /*
    |--------------------------------------------------------------------------
    | Check Duplicate Name
    |--------------------------------------------------------------------------
    */

    $checkName =
        $db->prepare(
            "
            SELECT id

            FROM categories

            WHERE name = :name

            LIMIT 1
            "
        );


    $checkName->execute(
        [
            ':name' =>
                $name
        ]
    );


    if (
        $checkName->fetch()
    ) {

        errorResponse(
            'هذا القسم موجود بالفعل.',
            409
        );

    }



    /*
    |--------------------------------------------------------------------------
    | Check Duplicate Slug
    |--------------------------------------------------------------------------
    */

    $checkSlug =
        $db->prepare(
            "
            SELECT id

            FROM categories

            WHERE slug = :slug

            LIMIT 1
            "
        );


    $checkSlug->execute(
        [
            ':slug' =>
                $slug
        ]
    );


    if (
        $checkSlug->fetch()
    ) {

        errorResponse(
            'معرف القسم مستخدم بالفعل.',
            409
        );

    }



    /*
    |--------------------------------------------------------------------------
    | Insert Category
    |--------------------------------------------------------------------------
    */

    $stmt =
        $db->prepare(
            "
            INSERT INTO categories
            (
                name,
                slug,
                description,
                image,
                icon,
                sort_order,
                status
            )

            VALUES
            (
                :name,
                :slug,
                :description,
                :image,
                :icon,
                :sort_order,
                :status
            )
            "
        );


    $stmt->execute(
        [

            ':name' =>
                $name,

            ':slug' =>
                $slug,

            ':description' =>
                $description ?: null,

            ':image' =>
                $image ?: null,

            ':icon' =>
                $icon ?: null,

            ':sort_order' =>
                $sortOrder,

            ':status' =>
                $status

        ]
    );



    /*
    |--------------------------------------------------------------------------
    | New Category ID
    |--------------------------------------------------------------------------
    */

    $categoryId =
        (int)
        $db->lastInsertId();



    /*
    |--------------------------------------------------------------------------
    | Get Created Category
    |--------------------------------------------------------------------------
    */

    $getCategory =
        $db->prepare(
            "
            SELECT

                id,
                name,
                slug,
                description,
                image,
                icon,
                sort_order,
                status,
                created_at,
                updated_at

            FROM categories

            WHERE id = :id

            LIMIT 1
            "
        );


    $getCategory->execute(
        [
            ':id' =>
                $categoryId
        ]
    );


    $category =
        $getCategory->fetch();



    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [
            'category' =>
                $category

        ],
        'تم إنشاء القسم بنجاح.'
    );


} catch (
    PDOException $e
) {


    /*
    |--------------------------------------------------------------------------
    | Duplicate Key
    |--------------------------------------------------------------------------
    */

    if (
        $e->getCode() === '23000'
    ) {

        errorResponse(
            'القسم موجود بالفعل.',
            409
        );

    }



    /*
    |--------------------------------------------------------------------------
    | Log
    |--------------------------------------------------------------------------
    */

    error_log(
        'Create Category API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء إنشاء القسم.',
        500
    );


} catch (
    Throwable $e
) {

    error_log(
        'Create Category API Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء إنشاء القسم.',
        500
    );

}



/*
|--------------------------------------------------------------------------
| Generate Category Slug
|--------------------------------------------------------------------------
*/

function generateCategorySlug(
    string $name
): string {

    /*
    | للأسماء العربية نستخدم معرفًا زمنيًا آمنًا
    | إذا لم ينتج عن النص Slug لاتيني.
    */

    $slug =
        strtolower(
            trim($name)
        );


    $slug =
        preg_replace(
            '/\s+/',
            '-',
            $slug
        );


    $slug =
        preg_replace(
            '/[^a-zA-Z0-9\-_]/',
            '',
            $slug
        );


    if (
        $slug !== ''
    ) {

        return $slug;

    }


    return 'category-' .
        date('YmdHis') .
        '-' .
        bin2hex(
            random_bytes(3)
        );

}
