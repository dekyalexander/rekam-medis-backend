<?php

use Illuminate\Support\Str;

return [

  /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

  'default' => env('DB_CONNECTION', 'rekammedis'),

  /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

  'connections' => [

    // LOCAL

    'rekammedis' => [
      'driver' => 'mysql',
      'url' => env('DATABASE_URL'),
      'host' => env('DB_HOST', '127.0.0.1'),
      'port' => env('DB_PORT', '3306'),
      'database' => env('DB_DATABASE', 'rekammedisdb'),
      'username' => env('DB_USERNAME', 'root'),
      'password' => env('DB_PASSWORD', 'deky17'),
      'unix_socket' => env('DB_SOCKET', ''),
      'charset' => 'utf8mb4',
      'collation' => 'utf8mb4_unicode_ci',
      'prefix' => '',
      'prefix_indexes' => true,
      'strict' => true,
      'engine' => null,
      'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
      ]) : [],
    ],

    'pusat' => [
      'driver' => 'mysql',
      'url' => env('DATABASE_URL'),
      'host' => env('DB_HOST', '127.0.0.1'),
      'port' => env('DB_PORT', '3306'),
      'database' => env('DB_DATABASE_PUSAT', 'pusatdb'),
      'username' => env('DB_USERNAME', 'root'),
      'password' => env('DB_PASSWORD', 'deky17'),
      'unix_socket' => env('DB_SOCKET', ''),
      'charset' => 'utf8mb4',
      'collation' => 'utf8mb4_unicode_ci',
      'prefix' => '',
      'prefix_indexes' => true,
      'strict' => true,
      'engine' => null,
      'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
      ]) : [],
    ],


    'hris' => [
      'driver' => 'mysql',
      'host' => env('DB_HOST', '127.0.0.1'),
      'port' => env('DB_PORT', '3308'),
      'database' => env('DB_DATABASE_HRIS', 'hris'),
      'username' => env('DB_USERNAME_HRIS', 'root'),
      'password' => env('DB_PASSWORD_HRIS', 'deky17'),
      'unix_socket' => env('DB_SOCKET', ''),
      'charset' => 'utf8mb4',
      'collation' => 'utf8mb4_unicode_ci',
      'prefix' => '',
      'prefix_indexes' => true,
      'strict' => false,
      'engine' => null,
    ],

   // SERVER

    // 'rekammedis' => [
    //   'driver' => 'mysql',
    //   'url' => env('DATABASE_URL'),
    //   'host' => env('DB_HOST', '127.0.0.1'),
    //   'port' => env('DB_PORT', '3306'),
    //   'database' => env('DB_DATABASE', 'rekammedisdb'),
    //   'username' => env('DB_USERNAME', 'root'),
    //   'password' => env('DB_PASSWORD', 'pahoagodigital*300112'),
    //   'unix_socket' => env('DB_SOCKET', ''),
    //   'charset' => 'utf8mb4',
    //   'collation' => 'utf8mb4_unicode_ci',
    //   'prefix' => '',
    //   'prefix_indexes' => true,
    //   'strict' => true,
    //   'engine' => null,
    //   'options' => extension_loaded('pdo_mysql') ? array_filter([
    //     PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    //   ]) : [],
    // ],

    // 'pusat' => [
    //   'driver' => 'mysql',
    //   'url' => env('DATABASE_URL'),
    //   'host' => env('DB_HOST', '127.0.0.1'),
    //   'port' => env('DB_PORT', '3306'),
    //   'database' => env('DB_DATABASE_PUSAT', 'pusatdb'),
    //   'username' => env('DB_USERNAME', 'root'),
    //   'password' => env('DB_PASSWORD', 'pahoagodigital*300112'),
    //   'unix_socket' => env('DB_SOCKET', ''),
    //   'charset' => 'utf8mb4',
    //   'collation' => 'utf8mb4_unicode_ci',
    //   'prefix' => '',
    //   'prefix_indexes' => true,
    //   'strict' => true,
    //   'engine' => null,
    //   'options' => extension_loaded('pdo_mysql') ? array_filter([
    //     PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    //   ]) : [],
    // ],


    // 'hris' => [
    //   'driver' => 'mysql',
    //   'host' => env('DB_HOST', '127.0.0.1'),
    //   'port' => env('DB_PORT', '3308'),
    //   'database' => env('DB_DATABASE_HRIS', 'hris'),
    //   'username' => env('DB_USERNAME_HRIS', 'root'),
    //   'password' => env('DB_PASSWORD_HRIS', 'pahoagodigital*300112'),
    //   'unix_socket' => env('DB_SOCKET', ''),
    //   'charset' => 'utf8mb4',
    //   'collation' => 'utf8mb4_unicode_ci',
    //   'prefix' => '',
    //   'prefix_indexes' => true,
    //   'strict' => false,
    //   'engine' => null,
    // ],

  //   'dbtk' => [
  //     'driver' => 'mysql',
  //     'host' => env('DB_HOST', '127.0.0.1'),
  //     'port' => env('DB_PORT', '3308'),
  //     'database' => env('DB_DATABASE_TK', 'dbtk'),
  //     'username' => env('DB_USERNAME_TK', 'root'),
  //     'password' => env('DB_PASSWORD_TK', ''),
  //     'unix_socket' => env('DB_SOCKET', ''),
  //     'charset' => 'utf8mb4',
  //     'collation' => 'utf8mb4_unicode_ci',
  //     'prefix' => '',
  //     'prefix_indexes' => true,
  //     'strict' => false,
  //     'engine' => null,
  // ],

  //   'nilai_sdk13' => [
  //     'driver' => 'mysql',
  //     'host' => env('DB_HOST', '127.0.0.1'),
  //     'port' => env('DB_PORT', '3308'),
  //     'database' => env('DB_DATABASE_SD', 'nilai_sdk13'),
  //     'username' => env('DB_USERNAME_SD', 'root'),
  //     'password' => env('DB_PASSWORD_SD', ''),
  //     'unix_socket' => env('DB_SOCKET', ''),
  //     'charset' => 'utf8mb4',
  //     'collation' => 'utf8mb4_unicode_ci',
  //     'prefix' => '',
  //     'prefix_indexes' => true,
  //     'strict' => false,
  //     'engine' => null,
  // ],

  // 'nilai_smp' => [
  //     'driver' => 'mysql',
  //     'host' => env('DB_HOST', '127.0.0.1'),
  //     'port' => env('DB_PORT', '3308'),
  //     'database' => env('DB_DATABASE_SMP', 'nilai_smp'),
  //     'username' => env('DB_USERNAME_SMP', 'root'),
  //     'password' => env('DB_PASSWORD_SMP', ''),
  //     'unix_socket' => env('DB_SOCKET', ''),
  //     'charset' => 'utf8mb4',
  //     'collation' => 'utf8mb4_unicode_ci',
  //     'prefix' => '',
  //     'prefix_indexes' => true,
  //     'strict' => false,
  //     'engine' => null,
  // ],

  // 'nilai_sma_2017' => [
  //     'driver' => 'mysql',
  //     'host' => env('DB_HOST', '127.0.0.1'),
  //     'port' => env('DB_PORT', '3308'),
  //     'database' => env('DB_DATABASE_SMA', 'nilai_sma_2017'),
  //     'username' => env('DB_USERNAME_SMA', 'root'),
  //     'password' => env('DB_PASSWORD_SMA', ''),
  //     'unix_socket' => env('DB_SOCKET', ''),
  //     'charset' => 'utf8mb4',
  //     'collation' => 'utf8mb4_unicode_ci',
  //     'prefix' => '',
  //     'prefix_indexes' => true,
  //     'strict' => false,
  //     'engine' => null,
  // ],

  ],

  /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

  'migrations' => 'migrations',

  /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

  'redis' => [

    'client' => env('REDIS_CLIENT', 'phpredis'),

    'options' => [
      'cluster' => env('REDIS_CLUSTER', 'redis'),
      'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
    ],

    'default' => [
      'url' => env('REDIS_URL'),
      'host' => env('REDIS_HOST', '127.0.0.1:8080'),
      'password' => env('REDIS_PASSWORD', null),
      'port' => env('REDIS_PORT', '6379'),
      'database' => env('REDIS_DB', '0'),
    ],

    'cache' => [
      'url' => env('REDIS_URL'),
      'host' => env('REDIS_HOST', '127.0.0.1:8080'),
      'password' => env('REDIS_PASSWORD', null),
      'port' => env('REDIS_PORT', '6379'),
      'database' => env('REDIS_CACHE_DB', '1'),
    ],

  ],

];
