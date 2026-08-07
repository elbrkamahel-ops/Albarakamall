<?php

/*
|--------------------------------------------------------------------------
| Al Baraka Mall
| Database Configuration
|--------------------------------------------------------------------------
| File:
| api/config/database.php
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Database Settings
|--------------------------------------------------------------------------
|
| غيّر هذه القيم حسب بيانات قاعدة البيانات الموجودة على الاستضافة.
|
*/

define('DB_HOST', 'localhost');

define('DB_NAME', 'albaraka_db');

define('DB_USER', 'albaraka_user');

define('DB_PASS', 'CHANGE_THIS_PASSWORD');

define('DB_CHARSET', 'utf8mb4');



/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
*/

function getDatabaseConnection(): PDO
{
    static $connection = null;


    /*
    | منع إنشاء اتصال جديد في كل استدعاء
    */

    if ($connection instanceof PDO) {

        return $connection;

    }


    /*
    | DSN
    */

    $dsn =
        'mysql:host=' . DB_HOST .
        ';dbname=' . DB_NAME .
        ';charset=' . DB_CHARSET;


    /*
    | PDO Options
    */

    $options = [

        PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION,

        PDO::ATTR_DEFAULT_FETCH_MODE =>
            PDO::FETCH_ASSOC,

        PDO::ATTR_EMULATE_PREPARES =>
            false,

    ];


    /*
    | إنشاء الاتصال
    */

    try {

        $connection =
            new PDO(
                $dsn,
                DB_USER,
                DB_PASS,
                $options
            );


        return $connection;


    } catch (PDOException $e) {

        /*
        | لا نعرض بيانات الاتصال للمستخدم.
        */

        error_log(
            'Al Baraka Database Error: ' .
            $e->getMessage()
        );


        http_response_code(500);


        die(
            'تعذر الاتصال بقاعدة البيانات.'
        );

    }

}



/*
|--------------------------------------------------------------------------
| Test Connection
|--------------------------------------------------------------------------
| يمكن استخدام هذه الدالة أثناء إعداد المشروع.
|--------------------------------------------------------------------------
*/

function testDatabaseConnection(): bool
{
    try {

        getDatabaseConnection();

        return true;

    } catch (Throwable $e) {

        return false;

    }
}



/*
|--------------------------------------------------------------------------
| Close Connection
|--------------------------------------------------------------------------
*/

function closeDatabaseConnection(): void
{
    /*
    | PDO يغلق الاتصال تلقائيًا عند انتهاء الطلب.
    | لذلك لا نحتاج إلى تنفيذ شيء هنا.
    */
}
