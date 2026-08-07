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
| POST Only
|--------------------------------------------------------------------------
*/

if (requestMethod() !== 'POST') {

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

requireCsrfToken();


/*
|--------------------------------------------------------------------------
| Request
|--------------------------------------------------------------------------
*/

$data = getJsonInput();

if (empty($data)) {

    $data = $_POST;

}


/*
|--------------------------------------------------------------------------
| Input
|--------------------------------------------------------------------------
*/

$name = cleanString(
    $data['name'] ?? ''
);

$slug = cleanString(
    $data['slug'] ?? ''
);

$description = cleanString(
    $data['description'] ?? ''
);

$image = cleanString(
    $data['image'] ?? ''
);

$status = cleanString(
    $data['status'] ?? 'active'
);

$sortOrder = cleanInt(
    $data['sort_order'] ?? 0
);


/*
|--------------------------------------------------------------------------
| Validate Name
|--------------------------------------------------------------------------
*/

if ($name === '') {

    errorResponse(
        'اسم القسم مطلوب.',
        422
    );

}


if (mb_strlen($name) < 2) {

    errorResponse(
        'اسم القسم قصير جدًا.',
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

    errorResponse(
        'حالة القسم غير صحيحة.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Generate Slug
|--------------------------------------------------------------------------
*/

if ($slug === '') {

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


if ($slug === '') {

    errorResponse(
        'معرف القسم غير صالح.',
        422
    );

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

    $nameStmt =
        $db->prepare(
            "
            SELECT id

            FROM categories

            WHERE name = :name

            LIMIT 1
            "
        );


    $nameStmt->execute([
        ':name' => $name
    ]);


    if ($nameStmt->fetch()) {

        errorResponse(
            'اسم القسم موجود بالفعل.',
            409
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Check Duplicate Slug
    |--------------------------------------------------------------------------
    */

    $slugStmt =
        $db->prepare(
            "
            SELECT id

            FROM categories

            WHERE slug = :slug

            LIMIT 1
            "
        );


    $slugStmt->execute([
        ':slug' => $slug
    ]);


    if ($slugStmt->fetch()) {

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
                status,
                sort_order
            )

            VALUES
            (
                :name,
                :slug,
                :description,
                :image,
                :status,
                :sort_order
            )
            "
        );


    $stmt->execute([

        ':name' =>
            $name,

        ':slug' =>
            $slug,

        ':description' =>
            $description ?: null,

        ':image' =>
            $image ?: null,

        ':status' =>
            $status,

        ':sort_order' =>
            $sortOrder

    ]);


    /*
    |--------------------------------------------------------------------------
    | New ID
    |--------------------------------------------------------------------------
    */

    $categoryId =
        (int)
        $db->lastInsertId();


    /*
    |--------------------------------------------------------------------------
    | Get Category
    |--------------------------------------------------------------------------
    */

    $resultStmt =
        $db->prepare(
            "
            SELECT

                id,
                name,
                slug,
                description,
                image,
                status,
                sort_order,
                created_at,
                updated_at

            FROM categories

            WHERE id = :id

            LIMIT 1
            "
        );


    $resultStmt->execute([
        ':id' => $categoryId
    ]);


    $category =
        $resultStmt->fetch();


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [

            'category' => [

                'id' =>
                    (int)
                    $category['id'],

                'name' =>
                    $category['name'],

                'slug' =>
                    $category['slug'],

                'description' =>
                    $category['description'],

                'image' =>
                    $category['image'],

                'status' =>
                    $category['status'],

                'sort_order' =>
                    (int)
                    $category['sort_order'],

                'created_at' =>
                    $category['created_at'],

                'updated_at' =>
                    $category['updated_at']

            ]

        ],

        'تم إنشاء القسم بنجاح.'
    );


} catch (PDOException $e) {

    error_log(
        'Create Category PDO Error: ' .
        $e->getMessage()
    );


    if (
        $e->getCode() === '23000'
    ) {

        errorResponse(
            'لا يمكن إنشاء القسم بسبب تعارض في البيانات.',
            409
        );

    }


    errorResponse(
        'حدث خطأ أثناء إنشاء القسم.',
        500
    );


} catch (Throwable $e) {

    error_log(
        'Create Category Error: ' .
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


    if ($slug !== '') {

        return $slug;

    }


    return 'category-' .
        date('YmdHis') .
        '-' .
        bin2hex(
            random_bytes(3)
        );
}
