<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit676a80f02c3d47df778df9f01922d11f
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/src/Twilio',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit676a80f02c3d47df778df9f01922d11f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit676a80f02c3d47df778df9f01922d11f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
