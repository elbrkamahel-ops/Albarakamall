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
| PUT / PATCH Only
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
| Input
|--------------------------------------------------------------------------
*/

$id = cleanInt(
    $data['id'] ?? $_GET['id'] ?? 0
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

$categoryId = cleanInt(
    $data['category_id'] ?? 0
);

$sku = cleanString(
    $data['sku'] ?? ''
);

$price = cleanFloat(
    $data['price'] ?? 0
);

$oldPrice = cleanFloat(
    $data['old_price'] ?? 0
);

$stock = cleanFloat(
    $data['stock'] ?? 0
);

$unit = cleanString(
    $data['unit'] ?? 'piece'
);

$image = cleanString(
    $data['image'] ?? ''
);

$status = cleanString(
    $data['status'] ?? 'active'
);

$featured = cleanInt(
    $data['featured'] ?? 0
);

$sortOrder = cleanInt(
    $data['sort_order'] ?? 0
);


/*
|--------------------------------------------------------------------------
| Validate ID
|--------------------------------------------------------------------------
*/

if ($id <= 0) {

    errorResponse(
        'رقم المنتج غير صحيح.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Validate Name
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


/*
|--------------------------------------------------------------------------
| Validate Category
|--------------------------------------------------------------------------
*/

if ($categoryId <= 0) {

    errorResponse(
        'القسم مطلوب.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Validate Price
|--------------------------------------------------------------------------
*/

if ($price < 0) {

    errorResponse(
        'سعر المنتج غير صحيح.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Validate Old Price
|--------------------------------------------------------------------------
*/

if (
    $oldPrice > 0 &&
    $oldPrice < $price
) {

    errorResponse(
        'السعر القديم يجب أن يكون أكبر من أو يساوي السعر الحالي.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Validate Stock
|--------------------------------------------------------------------------
*/

if ($stock < 0) {

    errorResponse(
        'كمية المخزون غير صحيحة.',
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
        'حالة المنتج غير صحيحة.',
        422
    );

}


/*
|--------------------------------------------------------------------------
| Featured
|--------------------------------------------------------------------------
*/

$featured =
    $featured === 1
        ? 1
        : 0;


/*
|--------------------------------------------------------------------------
| Generate Slug
|--------------------------------------------------------------------------
*/

if ($slug === '') {

    $slug =
        generateProductSlug(
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
        'معرف المنتج غير صالح.',
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
    | Check Product
    |--------------------------------------------------------------------------
    */

    $productStmt =
        $db->prepare(
            "
            SELECT

                id,
                stock

            FROM products

            WHERE id = :id

            LIMIT 1
            "
        );


    $productStmt->execute([
        ':id' => $id
    ]);


    $existingProduct =
        $productStmt->fetch();


    if (!$existingProduct) {

        errorResponse(
            'المنتج غير موجود.',
            404
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Check Category
    |--------------------------------------------------------------------------
    */

    $categoryStmt =
        $db->prepare(
            "
            SELECT

                id,
                status

            FROM categories

            WHERE id = :id

            LIMIT 1
            "
        );


    $categoryStmt->execute([
        ':id' => $categoryId
    ]);


    $category =
        $categoryStmt->fetch();


    if (!$category) {

        errorResponse(
            'القسم غير موجود.',
            404
        );

    }


    if (
        $category['status'] !== 'active'
    ) {

        errorResponse(
            'لا يمكن وضع المنتج داخل قسم غير نشط.',
            409
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Check SKU
    |--------------------------------------------------------------------------
    */

    if ($sku !== '') {

        $skuStmt =
            $db->prepare(
                "
                SELECT id

                FROM products

                WHERE sku = :sku

                AND id != :id

                LIMIT 1
                "
            );


        $skuStmt->execute([

            ':sku' =>
                $sku,

            ':id' =>
                $id

        ]);


        if (
            $skuStmt->fetch()
        ) {

            errorResponse(
                'رمز المنتج SKU مستخدم بالفعل.',
                409
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Check Slug
    |--------------------------------------------------------------------------
    */

    $slugStmt =
        $db->prepare(
            "
            SELECT id

            FROM products

            WHERE slug = :slug

            AND id != :id

            LIMIT 1
            "
        );


    $slugStmt->execute([

        ':slug' =>
            $slug,

        ':id' =>
            $id

    ]);


    if (
        $slugStmt->fetch()
    ) {

        errorResponse(
            'معرف المنتج مستخدم بالفعل.',
            409
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Update Product
    |--------------------------------------------------------------------------
    */

    $updateStmt =
        $db->prepare(
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


    $updateStmt->execute([

        ':category_id' =>
            $categoryId,

        ':name' =>
            $name,

        ':slug' =>
            $slug,

        ':description' =>
            $description ?: null,

        ':sku' =>
            $sku ?: null,

        ':price' =>
            $price,

        ':old_price' =>
            $oldPrice > 0
                ? $oldPrice
                : null,

        ':stock' =>
            $stock,

        ':unit' =>
            $unit,

        ':image' =>
            $image ?: null,

        ':status' =>
            $status,

        ':featured' =>
            $featured,

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

    $resultStmt =
        $db->prepare(
            "
            SELECT

                p.id,

                p.category_id,

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

                p.updated_at,

                c.name AS category_name

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

            'product' => [

                'id' =>
                    (int)
                    $product['id'],

                'category' => [

                    'id' =>
                        (int)
                        $product['category_id'],

                    'name' =>
                        $product['category_name']

                ],

                'name' =>
                    $product['name'],

                'slug' =>
                    $product['slug'],

                'description' =>
                    $product['description'],

                'sku' =>
                    $product['sku'],

                'price' =>
                    (float)
                    $product['price'],

                'old_price' =>
                    $product['old_price']
                        !== null
                        ? (float)
                            $product['old_price']
                        : null,

                'stock' =>
                    (float)
                    $product['stock'],

                'unit' =>
                    $product['unit'],

                'image' =>
                    $product['image'],

                'status' =>
                    $product['status'],

                'featured' =>
                    (int)
                    $product['featured'],

                'sort_order' =>
                    (int)
                    $product['sort_order'],

                'created_at' =>
                    $product['created_at'],

                'updated_at' =>
                    $product['updated_at']

            ]

        ],

        'تم تعديل المنتج بنجاح.'
    );


} catch (PDOException $e) {

    error_log(
        'Update Product PDO Error: ' .
        $e->getMessage()
    );


    if (
        $e->getCode() === '23000'
    ) {

        errorResponse(
            'لا يمكن تعديل المنتج بسبب تعارض في البيانات.',
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


    return 'product-' .
        date('YmdHis') .
        '-' .
        bin2hex(
            random_bytes(3)
        );
}
