<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Admin Products Page
|--------------------------------------------------------------------------
| File:
| admin/products.php
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/auth.php';

requireAdminLogin();

$pageTitle = 'إدارة المنتجات | مول البركة';

$adminName =
    $_SESSION['admin_name']
    ?? 'المدير';

$csrfToken =
    $_SESSION['csrf_token']
    ?? '';

?>
<!DOCTYPE html>

<html lang="ar" dir="rtl">

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

    <meta
        name="csrf-token"
        content="<?= htmlspecialchars(
            $csrfToken,
            ENT_QUOTES,
            'UTF-8'
        ) ?>"
    >

    <title>
        <?= htmlspecialchars(
            $pageTitle,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </title>

    <link
        rel="stylesheet"
        href="/admin/assets/css/dashboard.css"
    >

</head>

<body>

<div
    class="admin-layout"
    id="adminLayout"
>


    <!-- Sidebar -->

    <aside
        class="admin-sidebar"
    >

        <div class="sidebar-brand">

            <div class="brand-logo">
                البركة
            </div>

            <div class="brand-text">

                <strong>
                    مول البركة
                </strong>

                <span>
                    لوحة الإدارة
                </span>

            </div>

        </div>


        <nav class="sidebar-nav">

            <a
                href="/admin/"
                class="nav-item"
            >
                الرئيسية
            </a>

            <a
                href="/admin/orders.php"
                class="nav-item"
            >
                الطلبات
            </a>

            <a
                href="/admin/products.php"
                class="nav-item active"
            >
                المنتجات
            </a>

            <a
                href="/admin/categories.php"
                class="nav-item"
            >
                الأقسام
            </a>

            <a
                href="/admin/customers.php"
                class="nav-item"
            >
                العملاء
            </a>

            <a
                href="/admin/settings.php"
                class="nav-item"
            >
                الإعدادات
            </a>

            <div class="nav-divider"></div>

            <a
                href="/"
                class="nav-item"
                target="_blank"
                rel="noopener"
            >
                زيارة الموقع
            </a>

            <a
                href="/admin/logout.php"
                class="nav-item nav-danger"
            >
                تسجيل الخروج
            </a>

        </nav>

    </aside>


    <!-- Main -->

    <main class="admin-main">


        <!-- Header -->

        <header class="admin-header">

            <button
                type="button"
                class="menu-button"
                id="menuButton"
                aria-label="فتح القائمة"
            >
                ☰
            </button>

            <div class="header-title">

                <h1>
                    إدارة المنتجات
                </h1>

                <p>
                    إضافة وتعديل ومتابعة منتجات مول البركة
                </p>

            </div>

            <div class="header-actions">

                <span class="admin-badge">
                    <?= htmlspecialchars(
                        $adminName,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </span>

            </div>

        </header>


        <!-- Content -->

        <section class="dashboard-content">


            <!-- Error -->

            <div
                id="productsError"
                class="dashboard-error"
                hidden
            ></div>


            <!-- Toolbar -->

            <div class="section-card">

                <div
                    style="
                        padding:22px;
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                        gap:15px;
                        flex-wrap:wrap;
                    "
                >

                    <div>

                        <h2>
                            المنتجات
                        </h2>

                        <p
                            id="productsSummary"
                            style="
                                color:#6b7280;
                                font-size:13px;
                            "
                        >
                            جاري تحميل المنتجات...
                        </p>

                    </div>

                    <button
                        type="button"
                        class="btn btn-primary"
                        id="addProductButton"
                    >
                        + إضافة منتج
                    </button>

                </div>


                <!-- Filters -->

                <form
                    id="productsFilterForm"
                    style="padding:0 22px 22px;"
                >

                    <div
                        style="
                            display:grid;
                            grid-template-columns:
                                2fr 1fr 1fr auto;
                            gap:12px;
                        "
                    >

                        <input
                            type="search"
                            id="productSearch"
                            class="form-control"
                            placeholder="ابحث باسم المنتج أو SKU"
                        >


                        <select
                            id="productStatus"
                            class="form-control"
                        >

                            <option value="">
                                كل الحالات
                            </option>

                            <option value="active">
                                نشط
                            </option>

                            <option value="inactive">
                                غير نشط
                            </option>

                        </select>


                        <select
                            id="stockFilter"
                            class="form-control"
                        >

                            <option value="">
                                كل المخزون
                            </option>

                            <option value="low">
                                مخزون منخفض
                            </option>

                            <option value="out">
                                نفد المخزون
                            </option>

                        </select>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            بحث
                        </button>

                    </div>

                </form>

            </div>


            <!-- Products Table -->

            <div class="section-card">

                <div class="table-wrapper">

                    <table class="admin-table">

                        <thead>

                            <tr>

                                <th>
                                    المنتج
                                </th>

                                <th>
                                    SKU
                                </th>

                                <th>
                                    السعر
                                </th>

                                <th>
                                    المخزون
                                </th>

                                <th>
                                    الحالة
                                </th>

                                <th>
                                    مميز
                                </th>

                                <th>
                                    الإجراءات
                                </th>

                            </tr>

                        </thead>

                        <tbody
                            id="productsTable"
                        >

                            <tr>

                                <td
                                    colspan="7"
                                >
                                    جاري تحميل المنتجات...
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                <div
                    id="productsPagination"
                    style="
                        display:flex;
                        justify-content:center;
                        gap:8px;
                        padding:20px;
                        flex-wrap:wrap;
                    "
                ></div>

            </div>

        </section>

    </main>

</div>


<!-- Product Modal -->

<div
    class="modal"
    id="productModal"
    aria-hidden="true"
>

    <div class="modal-content">

        <div class="modal-header">

            <h2 id="productModalTitle">
                إضافة منتج
            </h2>

            <button
                type="button"
                class="btn btn-secondary"
                id="closeProductModal"
            >
                إغلاق
            </button>

        </div>


        <form
            id="productForm"
        >

            <div class="modal-body">


                <input
                    type="hidden"
                    id="productId"
                >


                <!-- Name -->

                <div class="form-group">

                    <label
                        class="form-label"
                        for="productName"
                    >
                        اسم المنتج *
                    </label>

                    <input
                        type="text"
                        id="productName"
                        class="form-control"
                        maxlength="255"
                        required
                    >

                </div>


                <!-- SKU -->

                <div class="form-group">

                    <label
                        class="form-label"
                        for="productSku"
                    >
                        SKU
                    </label>

                    <input
                        type="text"
                        id="productSku"
                        class="form-control"
                        maxlength="100"
                    >

                </div>


                <!-- Category -->

                <div class="form-group">

                    <label
                        class="form-label"
                        for="productCategory"
                    >
                        القسم
                    </label>

                    <select
                        id="productCategory"
                        class="form-control"
                    >

                        <option value="">
                            اختر القسم
                        </option>

                    </select>

                </div>


                <!-- Description -->

                <div class="form-group">

                    <label
                        class="form-label"
                        for="productDescription"
                    >
                        الوصف
                    </label>

                    <textarea
                        id="productDescription"
                        class="form-control"
                    ></textarea>

                </div>


                <!-- Price -->

                <div
                    style="
                        display:grid;
                        grid-template-columns:
                            1fr 1fr;
                        gap:12px;
                    "
                >

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="productPrice"
                        >
                            السعر *
                        </label>

                        <input
                            type="number"
                            id="productPrice"
                            class="form-control"
                            min="0"
                            step="0.01"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label
                            class="form-label"
                            for="productOldPrice"
                        >
                            السعر القديم
                        </label>

                        <input
                            type="number"
                            id="productOldPrice"
                            class="form-control"
                            min="0"
                            step="0.01"
                        >

                    </div>

                </div>


                <!-- Stock -->

                <div
                    style="
                        display:grid;
                        grid-template-columns:
                            1fr 1fr;
                        gap:12px;
                    "
                >

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="productStock"
                        >
                            المخزون *
                        </label>

                        <input
                            type="number"
                            id="productStock"
                            class="form-control"
                            min="0"
                            step="0.01"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label
                            class="form-label"
                            for="productUnit"
                        >
                            الوحدة
                        </label>

                        <input
                            type="text"
                            id="productUnit"
                            class="form-control"
                            maxlength="30"
                            placeholder="كيلو / قطعة / عبوة"
                        >

                    </div>

                </div>


                <!-- Status -->

                <div class="form-group">

                    <label
                        class="form-label"
                        for="productStatusForm"
                    >
                        الحالة
                    </label>

                    <select
                        id="productStatusForm"
                        class="form-control"
                    >

                        <option value="active">
                            نشط
                        </option>

                        <option value="inactive">
                            غير نشط
                        </option>

                    </select>

                </div>


                <!-- Featured -->

                <div class="form-group">

                    <label
                        style="
                            display:flex;
                            align-items:center;
                            gap:8px;
                            cursor:pointer;
                        "
                    >

                        <input
                            type="checkbox"
                            id="productFeatured"
                        >

                        <span>
                            منتج مميز
                        </span>

                    </label>

                </div>


                <!-- Image -->

                <div class="form-group">

                    <label
                        class="form-label"
                        for="productImage"
                    >
                        رابط الصورة
                    </label>

                    <input
                        type="text"
                        id="productImage"
                        class="form-control"
                        maxlength="500"
                        placeholder="/uploads/products/example.jpg"
                    >

                </div>


                <div
                    id="productFormError"
                    class="dashboard-error"
                    hidden
                ></div>

            </div>


            <div class="modal-footer">

                <button
                    type="submit"
                    class="btn btn-primary"
                    id="saveProductButton"
                >
                    حفظ المنتج
                </button>

                <button
                    type="button"
                    class="btn btn-secondary"
                    id="cancelProductButton"
                >
                    إلغاء
                </button>

            </div>

        </form>

    </div>

</div>


<script>

'use strict';


const productState = {

    page: 1,

    perPage: 20,

    search: '',

    status: '',

    stock: ''

};


const productsTable =
    document.getElementById(
        'productsTable'
    );


const productsPagination =
    document.getElementById(
        'productsPagination'
    );


const productsSummary =
    document.getElementById(
        'productsSummary'
    );


const productsError =
    document.getElementById(
        'productsError'
    );


const productModal =
    document.getElementById(
        'productModal'
    );


const productForm =
    document.getElementById(
        'productForm'
    );


/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
*/

async function apiRequest(
    url,
    options = {}
) {

    const response =
        await fetch(
            url,
            {

                credentials:
                    'same-origin',

                ...options,

                headers: {

                    'Accept':
                        'application/json',

                    ...(options.headers || {})

                }

            }
        );


    const data =
        await response
            .json()
            .catch(
                () => null
            );


    if (
        !response.ok ||
        !data ||
        data.success !== true
    ) {

        throw new Error(
            data?.message
            ||
            'حدث خطأ أثناء الاتصال بالخادم.'
        );

    }


    return data;

}


/*
|--------------------------------------------------------------------------
| Escape
|--------------------------------------------------------------------------
*/

function escapeHtml(
    value
) {

    return String(
        value ?? ''
    )

        .replace(
            /&/g,
            '&amp;'
        )

        .replace(
            /</g,
            '&lt;'
        )

        .replace(
            />/g,
            '&gt;'
        )

        .replace(
            /"/g,
            '&quot;'
        )

        .replace(
            /'/g,
            '&#039;'
        );

}


/*
|--------------------------------------------------------------------------
| Currency
|--------------------------------------------------------------------------
*/

function currency(
    value
) {

    return new Intl.NumberFormat(
        'ar-EG',
        {

            minimumFractionDigits:
                2,

            maximumFractionDigits:
                2

        }
    ).format(
        Number(
            value || 0
        )
    );

}


/*
|--------------------------------------------------------------------------
| Load Products
|--------------------------------------------------------------------------
*/

async function loadProducts() {

    try {

        productsError.hidden =
            true;


        productsTable.innerHTML = `

            <tr>

                <td colspan="7">
                    جاري تحميل المنتجات...
                </td>

            </tr>

        `;


        const params =
            new URLSearchParams({

                page:
                    productState.page,

                per_page:
                    productState.perPage,

                search:
                    productState.search,

                status:
                    productState.status,

                stock:
                    productState.stock

            });


        const data =
            await apiRequest(
                '/api/v1/products/list.php?'
                +
                params.toString()
            );


        const result =
            data.data
            ||
            {};


        const products =
            result.products
            ||
            [];


        renderProducts(
            products
        );


        renderProductPagination(
            result.pagination
            ||
            {}
        );


        productsSummary.textContent =
            `إجمالي المنتجات: ${
                Number(
                    result.pagination?.total
                    ||
                    0
                )
            }`;


    } catch (
        error
    ) {

        productsError.textContent =
            error.message;


        productsError.hidden =
            false;

    }

}


/*
|--------------------------------------------------------------------------
| Render Products
|--------------------------------------------------------------------------
*/

function renderProducts(
    products
) {

    if (
        products.length === 0
    ) {

        productsTable.innerHTML = `

            <tr>

                <td colspan="7">
                    لا توجد منتجات.
                </td>

            </tr>

        `;

        return;

    }


    productsTable.innerHTML =
        products
            .map(
                product => {

                    const stock =
                        Number(
                            product.stock
                            ||
                            0
                        );


                    return `

                        <tr>

                            <td>

                                <strong>
                                    ${escapeHtml(
                                        product.name
                                    )}
                                </strong>

                            </td>


                            <td>
                                ${escapeHtml(
                                    product.sku
                                    ||
                                    '-'
                                )}
                            </td>


                            <td>

                                ${currency(
                                    product.price
                                )}

                                جنيه

                            </td>


                            <td>

                                ${stock}

                                ${
                                    product.unit
                                        ? escapeHtml(
                                            ' ' +
                                            product.unit
                                        )
                                        : ''
                                }

                            </td>


                            <td>

                                <span
                                    class="
                                        status-badge
                                        ${
                                            product.status === 'active'
                                                ? 'status-delivered'
                                                : 'status-cancelled'
                                        }
                                    "
                                >

                                    ${
                                        product.status === 'active'
                                            ? 'نشط'
                                            : 'غير نشط'
                                    }

                                </span>

                            </td>


                            <td>

                                ${
                                    Number(
                                        product.featured
                                        ||
                                        0
                                    )
                                        ? 'نعم'
                                        : 'لا'
                                }

                            </td>


                            <td>

                                <div
                                    style="
                                        display:flex;
                                        gap:6px;
                                        flex-wrap:wrap;
                                    "
                                >

                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        onclick="editProduct(
                                            ${Number(
                                                product.id
                                            )}
                                        )"
                                    >
                                        تعديل
                                    </button>


                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        onclick="deleteProduct(
                                            ${Number(
                                                product.id
                                            )}
                                        )"
                                    >
                                        حذف
                                    </button>

                                </div>

                            </td>

                        </tr>

                    `;

                }
            )
            .join('');

}


/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

function renderProductPagination(
    info
) {

    productsPagination.innerHTML =
        '';


    const totalPages =
        Number(
            info.total_pages
            ||
            0
        );


    const current =
        Number(
            info.page
            ||
            1
        );


    if (
        totalPages <= 1
    ) {

        return;

    }


    for (
        let page = 1;
        page <= totalPages;
        page++
    ) {

        if (
            totalPages > 10 &&
            Math.abs(
                page - current
            ) > 2 &&
            page !== 1 &&
            page !== totalPages
        ) {

            continue;

        }


        const button =
            document.createElement(
                'button'
            );


        button.type =
            'button';


        button.className =
            page === current
                ? 'btn btn-primary'
                : 'btn btn-secondary';


        button.textContent =
            page;


        button.onclick =
            () => {

                productState.page =
                    page;

                loadProducts();

            };


        productsPagination.appendChild(
            button
        );

    }

}


/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/

async function loadCategories() {

    try {

        const data =
            await apiRequest(
                '/api/v1/categories/list.php'
            );


        const categories =
            data.data?.categories
            ||
            [];


        const select =
            document.getElementById(
                'productCategory'
            );


        select.innerHTML = `

            <option value="">
                اختر القسم
            </option>

        `;


        categories.forEach(
            category => {

                const option =
                    document.createElement(
                        'option'
                    );


                option.value =
                    category.id;


                option.textContent =
                    category.name;


                select.appendChild(
                    option
                );

            }
        );

    } catch (
        error
    ) {

        console.error(
            'Categories Error:',
            error
        );

    }

}


/*
|--------------------------------------------------------------------------
| Open Add Modal
|--------------------------------------------------------------------------
*/

function openAddProduct() {

    productForm.reset();


    document.getElementById(
        'productId'
    ).value =
        '';


    document.getElementById(
        'productModalTitle'
    ).textContent =
        'إضافة منتج';


    document.getElementById(
        'productFormError'
    ).hidden =
        true;


    productModal.classList.add(
        'active'
    );


    productModal.setAttribute(
        'aria-hidden',
        'false'
    );

}


/*
|--------------------------------------------------------------------------
| Edit Product
|--------------------------------------------------------------------------
*/

async function editProduct(
    productId
) {

    try {

        const data =
            await apiRequest(
                '/api/v1/products/show.php?id='
                +
                encodeURIComponent(
                    productId
                )
            );


        const product =
            data.data?.product;


        if (!product) {

            throw new Error(
                'لم يتم العثور على المنتج.'
            );

        }


        document.getElementById(
            'productId'
        ).value =
            product.id;


        document.getElementById(
            'productName'
        ).value =
            product.name
            ||
            '';


        document.getElementById(
            'productSku'
        ).value =
            product.sku
            ||
            '';


        document.getElementById(
            'productCategory'
        ).value =
            product.category?.id
            ||
            '';


        document.getElementById(
            'productDescription'
        ).value =
            product.description
            ||
            '';


        document.getElementById(
            'productPrice'
        ).value =
            product.price
            ||
            '';


        document.getElementById(
            'productOldPrice'
        ).value =
            product.old_price
            ||
            '';


        document.getElementById(
            'productStock'
        ).value =
            product.stock
            ||
            '';


        document.getElementById(
            'productUnit'
        ).value =
            product.unit
            ||
            '';


        document.getElementById(
            'productStatusForm'
        ).value =
            product.status
            ||
            'active';


        document.getElementById(
            'productFeatured'
        ).checked =
            Number(
                product.featured
                ||
                0
            ) === 1;


        document.getElementById(
            'productImage'
        ).value =
            product.image
            ||
            '';


        document.getElementById(
            'productModalTitle'
        ).textContent =
            'تعديل المنتج';


        document.getElementById(
            'productFormError'
        ).hidden =
            true;


        productModal.classList.add(
            'active'
        );


        productModal.setAttribute(
            'aria-hidden',
            'false'
        );

    } catch (
        error
    ) {

        alert(
            error.message
        );

    }

}


/*
|--------------------------------------------------------------------------
| Save Product
|--------------------------------------------------------------------------
*/

productForm.addEventListener(
    'submit',
    async event => {

        event.preventDefault();


        const productId =
            document.getElementById(
                'productId'
            ).value;


        const payload = {

            name:
                document.getElementById(
                    'productName'
                ).value.trim(),

            sku:
                document.getElementById(
                    'productSku'
                ).value.trim(),

            category_id:
                document.getElementById(
                    'productCategory'
                ).value
                || null,

            description:
                document.getElementById(
                    'productDescription'
                ).value.trim(),

            price:
                Number(
                    document.getElementById(
                        'productPrice'
                    ).value
                ),

            old_price:
                Number(
                    document.getElementById(
                        'productOldPrice'
                    ).value
                )
                || null,

            stock:
                Number(
                    document.getElementById(
                        'productStock'
                    ).value
                ),

            unit:
                document.getElementById(
                    'productUnit'
                ).value.trim(),

            status:
                document.getElementById(
                    'productStatusForm'
                ).value,

            featured:
                document.getElementById(
                    'productFeatured'
                ).checked
                    ? 1
                    : 0,

            image:
                document.getElementById(
                    'productImage'
                ).value.trim()

        };


        const csrf =
            document
                .querySelector(
                    'meta[name="csrf-token"]'
                )
                ?.getAttribute(
                    'content'
                )
                ||
                '';


        const errorBox =
            document.getElementById(
                'productFormError'
            );


        try {

            errorBox.hidden =
                true;


            await apiRequest(

                productId
                    ? '/api/v1/products/update.php'
                    : '/api/v1/products/create.php',

                {

                    method:
                        productId
                            ? 'PUT'
                            : 'POST',

                    headers: {

                        'Content-Type':
                            'application/json',

                        'X-CSRF-Token':
                            csrf

                    },

                    body:
                        JSON.stringify({

                            ...payload,

                            ...(productId
                                ? {
                                    id:
                                        Number(
                                            productId
                                        )
                                }
                                : {})

                        })

                }

            );


            alert(
                productId
                    ? 'تم تحديث المنتج بنجاح.'
                    : 'تم إضافة المنتج بنجاح.'
            );


            closeProductModal();

            loadProducts();


        } catch (
            error
        ) {

            errorBox.textContent =
                error.message;


            errorBox.hidden =
                false;

        }

    }
);


/*
|--------------------------------------------------------------------------
| Delete Product
|--------------------------------------------------------------------------
*/

async function deleteProduct(
    productId
) {

    if (
        !confirm(
            'هل أنت متأكد من حذف هذا المنتج؟'
        )
    ) {

        return;

    }


    const csrf =
        document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            ?.getAttribute(
                'content'
            )
            ||
            '';


    try {

        await apiRequest(
            '/api/v1/products/delete.php',
            {

                method:
                    'DELETE',

                headers: {

                    'Content-Type':
                        'application/json',

                    'X-CSRF-Token':
                        csrf

                },

                body:
                    JSON.stringify({

                        id:
                            productId

                    })

            }
        );


        alert(
            'تم حذف المنتج بنجاح.'
        );


        loadProducts();


    } catch (
        error
    ) {

        alert(
            error.message
        );

    }

}


/*
|--------------------------------------------------------------------------
| Close Modal
|--------------------------------------------------------------------------
*/

function closeProductModal() {

    productModal.classList.remove(
        'active'
    );


    productModal.setAttribute(
        'aria-hidden',
        'true'
    );

}


document
    .getElementById(
        'closeProductModal'
    )
    .addEventListener(
        'click',
        closeProductModal
    );


document
    .getElementById(
        'cancelProductButton'
    )
    .addEventListener(
        'click',
        closeProductModal
    );


document
    .getElementById(
        'addProductButton'
    )
    .addEventListener(
        'click',
        openAddProduct
    );


/*
|--------------------------------------------------------------------------
| Filters
|--------------------------------------------------------------------------
*/

document
    .getElementById(
        'productsFilterForm'
    )
    .addEventListener(
        'submit',
        event => {

            event.preventDefault();


            productState.page =
                1;


            productState.search =
                document
                    .getElementById(
                        'productSearch'
                    )
                    .value
                    .trim();


            productState.status =
                document
                    .getElementById(
                        'productStatus'
                    )
                    .value;


            productState.stock =
                document
                    .getElementById(
                        'stockFilter'
                    )
                    .value;


            loadProducts();

        }
    );


/*
|--------------------------------------------------------------------------
| Mobile Menu
|--------------------------------------------------------------------------
*/

document
    .getElementById(
        'menuButton'
    )
    ?.addEventListener(
        'click',
        () => {

            document
                .getElementById(
                    'adminLayout'
                )
                ?.classList.toggle(
                    'sidebar-open'
                );

        }
    );


/*
|--------------------------------------------------------------------------
| Initial Load
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    async () => {

        await loadCategories();

        await loadProducts();

    }
);

</script>

</body>

</html>
