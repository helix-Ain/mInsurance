<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7ce6f1daa523c529f9225e3b62d83688
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Whoops\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Whoops\\' => 
        array (
            0 => __DIR__ . '/..' . '/filp/whoops/src/Whoops',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7ce6f1daa523c529f9225e3b62d83688::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7ce6f1daa523c529f9225e3b62d83688::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
