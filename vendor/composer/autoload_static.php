<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8ccb454dbdc716b2713a7cb1e3acfc7d
{
    public static $files = array (
        '253c157292f75eb38082b5acb06f3f01' => __DIR__ . '/..' . '/nikic/fast-route/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Slim\\' => 5,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Container\\' => 14,
        ),
        'I' => 
        array (
            'Interop\\Container\\' => 18,
        ),
        'F' => 
        array (
            'FastRoute\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Slim\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/slim/Slim',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Interop\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/container-interop/container-interop/src/Interop/Container',
        ),
        'FastRoute\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/fast-route/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
        ),
    );

    public static $classMap = array (
        'App\\Controllers\\BaseController' => __DIR__ . '/../..' . '/App/Controllers/BaseController.php',
        'App\\Controllers\\NormalController' => __DIR__ . '/../..' . '/App/Controllers/NormalController.php',
        'App\\Controllers\\RoleController' => __DIR__ . '/../..' . '/App/Controllers/RoleController.php',
        'App\\Controllers\\UserController' => __DIR__ . '/../..' . '/App/Controllers/UserController.php',
        'App\\Middlewares\\AuthMiddleware' => __DIR__ . '/../..' . '/App/Middlewares/AuthMiddleware.php',
        'App\\Middlewares\\BaseMiddleware' => __DIR__ . '/../..' . '/App/Middlewares/BaseMiddleware.php',
        'App\\Middlewares\\RoleMiddleware' => __DIR__ . '/../..' . '/App/Middlewares/RoleMiddleware.php',
        'App\\Middlewares\\TrailingSlashMiddleware' => __DIR__ . '/../..' . '/App/Middlewares/TrailingSlashMiddleware.php',
        'App\\Models\\BaseModel' => __DIR__ . '/../..' . '/App/Models/BaseModel.php',
        'App\\Models\\RoleModel' => __DIR__ . '/../..' . '/App/Models/RoleModel.php',
        'App\\Models\\SqlHelper' => __DIR__ . '/../..' . '/App/Models/SqlHelper.php',
        'App\\Models\\UserModel' => __DIR__ . '/../..' . '/App/Models/UserModel.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8ccb454dbdc716b2713a7cb1e3acfc7d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8ccb454dbdc716b2713a7cb1e3acfc7d::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit8ccb454dbdc716b2713a7cb1e3acfc7d::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit8ccb454dbdc716b2713a7cb1e3acfc7d::$classMap;

        }, null, ClassLoader::class);
    }
}
