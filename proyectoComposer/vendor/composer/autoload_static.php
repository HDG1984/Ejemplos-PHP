<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit458fd56ef92d72ce960bfb1bcba553c6
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
        'H' => 
        array (
            'Hdg61\\ProyectoComposer\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
        'Hdg61\\ProyectoComposer\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit458fd56ef92d72ce960bfb1bcba553c6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit458fd56ef92d72ce960bfb1bcba553c6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit458fd56ef92d72ce960bfb1bcba553c6::$classMap;

        }, null, ClassLoader::class);
    }
}
