<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Update Category API
|--------------------------------------------------------------------------
| File:
| api/v1/categories/update.php
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
| Method
|--------------------------------------------------------------------------
*/

if (requestMethod() !== 'PUT' && requestMethod() !== 'PATCH') {

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
| Request Data
|--------------------------------------------------------------------------
*/

$data = getJsonInput();

if (empty($data)) {
    $data = $_POST;
}


/*
|--------------------------------------------------------------------------
| Category ID
|--------------------------------------------------------------------------
*/

$id = cleanInt(
    $data['id'] ?? $_GET['id'] ?? 0
);


if ($id <= 0) {

    errorResponse(
        'رقم القسم غير صحيح.',
        422
    );

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

$icon = cleanString(
    $data['icon'] ?? ''
);

$sortOrder = cleanInt(
    $data['sort_order'] ?? 0
);

$status = cleanString(
    $data['status'] ?? 'active'
);


/*
|--------------------------------------------------------------------------
| Validation
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


if (!in_array(
    $status,
    ['active', 'inactive'],
    true
)) {

    errorResponse(
        'حالة القسم غير صحيحة.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/

try {

    $db = getDatabaseConnection();


    /*
    |--------------------------------------------------------------------------
    | Check Existing Category
    |--------------------------------------------------------------------------
    */

    $check = $db->prepare(
        "
        SELECT
            id,
            name,
            slug,
            description,
            image,
            icon,
            sort_order,
            status

        FROM categories

        WHERE id = :id

        LIMIT 1
        "
    );


    $check->execute([
        ':id' => $id
    ]);


    $existing = $check->fetch();


    if (!$existing) {

        errorResponse(
            'القسم غير موجود.',
            404
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Generate Slug If Empty
    |--------------------------------------------------------------------------
    */

    if ($slug === '') {

        $slug = generateCategorySlug(
            $name
        );

    }


    $slug = strtolower(
        trim($slug)
    );


    $slug = preg_replace(
        '/\s+/',
        '-',
        $slug
    );


    $slug = preg_replace(
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
    | Check Duplicate Name
    |--------------------------------------------------------------------------
    */

    $checkName = $db->prepare(
        "
        SELECT id

        FROM categories

        WHERE name = :name

        AND id != :id

        LIMIT 1
        "
    );


    $checkName->execute([
        ':name' => $name,
        ':id' => $id
    ]);


    if ($checkName->fetch()) {

        errorResponse(
            'يوجد قسم آخر بنفس الاسم.',
            409
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Check Duplicate Slug
    |--------------------------------------------------------------------------
    */

    $checkSlug = $db->prepare(
        "
        SELECT id

        FROM categories

        WHERE slug = :slug

        AND id != :id

        LIMIT 1
        "
    );


    $checkSlug->execute([
        ':slug' => $slug,
        ':id' => $id
    ]);


    if ($checkSlug->fetch()) {

        errorResponse(
            'معرف القسم مستخدم بالفعل.',
            409
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare(
        "
        UPDATE categories

        SET

            name = :name,

            slug = :slug,

            description = :description,

            image = :image,

            icon = :icon,

            sort_order = :sort_order,

            status = :status

        WHERE id = :id
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

        ':icon' =>
            $icon ?: null,

        ':sort_order' =>
            $sortOrder,

        ':status' =>
            $status,

        ':id' =>
            $id

    ]);


    /*
    |--------------------------------------------------------------------------
    | Get Updated Category
    |--------------------------------------------------------------------------
    */

    $result = $db->prepare(
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


    $result->execute([
        ':id' => $id
    ]);


    $category = $result->fetch();


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
        'تم تعديل القسم بنجاح.'
    );


} catch (PDOException $e) {

    error_log(
        'Update Category PDO Error: ' .
        $e->getMessage()
    );


    if ($e->getCode() === '23000') {

        errorResponse(
            'لا يمكن حفظ القسم بسبب تعارض في البيانات.',
            409
        );

    }


    errorResponse(
        'حدث خطأ أثناء تعديل القسم.',
        500
    );


} catch (Throwable $e) {

    error_log(
        'Update Category Error: ' .
        $e->getMessage()
    );


    errorResponse(
        'حدث خطأ أثناء تعديل القسم.',
        500
    );

}


/*
|--------------------------------------------------------------------------
| Generate Slug
|--------------------------------------------------------------------------
*/

function generateCategorySlug(
    string $name
): string {

    $slug = strtolower(
        trim($name)
    );


    $slug = preg_replace(
        '/\s+/',
        '-',
        $slug
    );


    $slug = preg_replace(
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
