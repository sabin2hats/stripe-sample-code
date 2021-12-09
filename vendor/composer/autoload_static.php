<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit30d3b2f8cb8f607c7d06d3ebd17a4394
{
    public static $files = array (
        'e56a195bef55b4a2a801e17f0f0c0b67' => __DIR__ . '/../..' . '/actions/session.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit30d3b2f8cb8f607c7d06d3ebd17a4394::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit30d3b2f8cb8f607c7d06d3ebd17a4394::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit30d3b2f8cb8f607c7d06d3ebd17a4394::$classMap;

        }, null, ClassLoader::class);
    }
}
