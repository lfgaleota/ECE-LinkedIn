<?php

$cleardb_parameters = @parse_url(env('CLEARDB_DATABASE_URL', ''));
if (!$cleardb_parameters || strlen($cleardb_parameters['path']) == 0) {
    $cleardb_parameters = [];
}

$rediscloud_parameters = @parse_url(env('REDISCLOUD_URL', ''));
if (!$rediscloud_parameters || isset($rediscloud_parameters['path'])) {
	$rediscloud_parameters = [];
}

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

    'default' => count($cleardb_parameters) > 0 ? 'mysql' : env('DB_CONNECTION', 'mysql'),

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

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => isset($cleardb_parameters['host']) ? $cleardb_parameters['host'] : env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => isset($cleardb_parameters['path']) ? substr($cleardb_parameters['path'], 1) : env('DB_DATABASE', 'forge'),
            'username' => isset($cleardb_parameters['user']) ? $cleardb_parameters['user'] : env('DB_USERNAME', 'forge'),
            'password' => isset($cleardb_parameters['pass']) ? $cleardb_parameters['pass'] : env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],

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
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => isset($rediscloud_parameters['host']) ? $rediscloud_parameters['host'] : env('REDIS_HOST', '127.0.0.1'),
            'password' => isset($rediscloud_parameters['pass']) ? $rediscloud_parameters['pass'] : env('REDIS_PASSWORD', null),
            'port' => isset($rediscloud_parameters['port']) ? $rediscloud_parameters['port'] : env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
