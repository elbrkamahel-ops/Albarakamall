<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Update Product API
|--------------------------------------------------------------------------
| File:
| api/v1/products/update.php
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

if (
    requestMethod() !== 'PUT' &&
    requestMethod() !== 'PATCH'
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
| Product ID
|--------------------------------------------------------------------------
*/

$id = cleanInt(
    $data['id'] ?? $_GET['id'] ?? 0
);

if ($id <= 0) {

    errorResponse(
        'رقم المنتج غير صحيح.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Input
|--------------------------------------------------------------------------
*/

$categoryId = cleanInt(
    $data['category_id'] ?? 0
);

$name = cleanString(
    $data['name'] ?? ''
);

$slug = cleanString(
    $data['slug'] ?? ''
);

$description = cleanString(
    $data['description'] ?? ''
);

$sku = cleanString(
    $data['sku'] ?? ''
);

$price = cleanFloat(
    $data['price'] ?? 0
);

$oldPrice = (
    isset($data['old_price']) &&
    $data['old_price'] !== ''
)
    ? cleanFloat($data['old_price'])
    : null;

$stock = cleanFloat(
    $data['stock'] ?? 0
);

$unit = cleanString(
    $data['unit'] ?? 'قطعة'
);

$image = cleanString(
    $data['image'] ?? ''
);

$status = cleanString(
    $data['status'] ?? 'active'
);

$featured = cleanBool(
    $data['featured'] ?? false
);

$sortOrder = cleanInt(
    $data['sort_order'] ?? 0
);


/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

if ($name === '') {

    errorResponse(
        'اسم المنتج مطلوب.',
        422
    );

}

if (mb_strlen($name) < 2) {

    errorResponse(
        'اسم المنتج قصير جدًا.',
        422
    );

}

if ($price < 0) {

    errorResponse(
        'سعر المنتج غير صحيح.',
        422
    );

}

if (
    $oldPrice !== null &&
    $oldPrice < 0
) {

    errorResponse(
        'السعر القديم غير صحيح.',
        422
    );

}

if ($stock < 0) {

    errorResponse(
        'المخزون لا يمكن أن يكون سالبًا.',
        422
    );

}

if ($unit === '') {
    $unit = 'قطعة';
}

if (!in_array(
    $status,
    ['active', 'inactive'],
    true
)) {

    errorResponse(
        'حالة المنتج غير صحيحة.',
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
    | Existing Product
    |--------------------------------------------------------------------------
    */

    $existingStmt = $db->prepare(
        "
        SELECT id

        FROM products

        WHERE id = :id

        LIMIT 1
        "
    );

    $existingStmt->execute([
        ':id' => $id
    ]);

    if (!$existingStmt->fetch()) {

        errorResponse(
            'المنتج غير موجود.',
            404
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    if ($categoryId > 0) {

        $categoryStmt = $db->prepare(
            "
            SELECT id

            FROM categories

            WHERE id = :id

            AND status = 'active'

            LIMIT 1
            "
        );

        $categoryStmt->execute([
            ':id' => $categoryId
        ]);

        if (!$categoryStmt->fetch()) {

            errorResponse(
                'القسم المحدد غير موجود أو غير نشط.',
                422
            );

        }

    } else {

        $categoryId = null;

    }


    /*
    |--------------------------------------------------------------------------
    | Generate Slug
    |--------------------------------------------------------------------------
    */

    if ($slug === '') {

        $slug = generateProductSlug(
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
            'معرف المنتج غير صالح.',
            422
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Duplicate Slug
    |--------------------------------------------------------------------------
    */

    $slugStmt = $db->prepare(
        "
        SELECT id

        FROM products

        WHERE slug = :slug

        AND id != :id

        LIMIT 1
        "
    );

    $slugStmt->execute([
        ':slug' => $slug,
        ':id' => $id
    ]);

    if ($slugStmt->fetch()) {

        errorResponse(
            'معرف المنتج مستخدم بالفعل.',
            409
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Duplicate SKU
    |--------------------------------------------------------------------------
    */

    if ($sku !== '') {

        $skuStmt = $db->prepare(
            "
            SELECT id

            FROM products

            WHERE sku = :sku

            AND id != :id

            LIMIT 1
            "
        );

        $skuStmt->execute([
            ':sku' => $sku,
            ':id' => $id
        ]);

        if ($skuStmt->fetch()) {

            errorResponse(
                'رمز المنتج SKU مستخدم بالفعل.',
                409
            );

        }

    } else {

        $sku = null;

    }


    /*
    |--------------------------------------------------------------------------
    | Update Product
    |--------------------------------------------------------------------------
    */

    $stmt = $db->prepare(
        "
        UPDATE products

        SET

            category_id = :category_id,

            name = :name,

            slug = :slug,

            description = :description,

            sku = :sku,

            price = :price,

            old_price = :old_price,

            stock = :stock,

            unit = :unit,

            image = :image,

            status = :status,

            featured = :featured,

            sort_order = :sort_order

        WHERE id = :id
        "
    );

    $stmt->execute([

        ':category_id' =>
            $categoryId,

        ':name' =>
            $name,

        ':slug' =>
            $slug,

        ':description' =>
            $description ?: null,

        ':sku' =>
            $sku,

        ':price' =>
            $price,

        ':old_price' =>
            $oldPrice,

        ':stock' =>
            $stock,

        ':unit' =>
            $unit,

        ':image' =>
            $image ?: null,

        ':status' =>
            $status,

        ':featured' =>
            $featured ? 1 : 0,

        ':sort_order' =>
            $sortOrder,

        ':id' =>
            $id

    ]);


    /*
    |--------------------------------------------------------------------------
    | Get Updated Product
    |--------------------------------------------------------------------------
    */

    $resultStmt = $db->prepare(
        "
        SELECT

            p.id,

            p.category_id,

            c.name AS category_name,

            c.slug AS category_slug,

            p.name,

            p.slug,

            p.description,

            p.sku,

            p.price,

            p.old_price,

            p.stock,

            p.unit,

            p.image,

            p.status,

            p.featured,

            p.sort_order,

            p.created_at,

            p.updated_at

        FROM products p

        LEFT JOIN categories c
            ON c.id = p.category_id

        WHERE p.id = :id

        LIMIT 1
        "
    );

    $resultStmt->execute([
        ':id' => $id
    ]);

    $product =
        $resultStmt->fetch();


    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    successResponse(
        [
            'product' =>
                $product
        ],
        'تم تعديل المنتج بنجاح.'
    );


} catch (PDOException $e) {

    error_log(
        'Update Product PDO Error: ' .
        $e->getMessage()
    );

    if ($e->getCode() === '23000') {

        errorResponse(
            'لا يمكن حفظ المنتج بسبب تعارض في البيانات.',
            409
        );

    }

    errorResponse(
        'حدث خطأ أثناء تعديل المنتج.',
        500
    );


} catch (Throwable $e) {

    error_log(
        'Update Product Error: ' .
        $e->getMessage()
    );

    errorResponse(
        'حدث خطأ أثناء تعديل المنتج.',
        500
    );

}


/*
|--------------------------------------------------------------------------
| Generate Product Slug
|--------------------------------------------------------------------------
*/

function generateProductSlug(
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

    return 'product-' .
        date('YmdHis') .
        '-' .
        bin2hex(
            random_bytes(3)
        );
}
