<?php

namespace DeliciousBrains\WP_Offload_Media\Gcp;

// autoload_real.php @generated by Composer
class ComposerAutoloaderInita2bfe7ba53e4edfe8b3eb3024fac12d4
{
    private static $loader;
    public static function loadClassLoader($class)
    {
        if ('DeliciousBrains\\WP_Offload_Media\\Gcp\\Composer\\Autoload\\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }
    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }
        require __DIR__ . '/platform_check.php';
        \spl_autoload_register(array('DeliciousBrains\\WP_Offload_Media\\Gcp\\ComposerAutoloaderInita2bfe7ba53e4edfe8b3eb3024fac12d4', 'loadClassLoader'), \true, \true);
        self::$loader = $loader = new \DeliciousBrains\WP_Offload_Media\Gcp\Composer\Autoload\ClassLoader(\dirname(__DIR__));
        \spl_autoload_unregister(array('DeliciousBrains\\WP_Offload_Media\\Gcp\\ComposerAutoloaderInita2bfe7ba53e4edfe8b3eb3024fac12d4', 'loadClassLoader'));
        require __DIR__ . '/autoload_static.php';
        \call_user_func(\DeliciousBrains\WP_Offload_Media\Gcp\Composer\Autoload\ComposerStaticInita2bfe7ba53e4edfe8b3eb3024fac12d4::getInitializer($loader));
        $loader->setClassMapAuthoritative(\true);
        $loader->register(\true);
        $filesToLoad = \DeliciousBrains\WP_Offload_Media\Gcp\Composer\Autoload\ComposerStaticInita2bfe7ba53e4edfe8b3eb3024fac12d4::$files;
        $requireFile = \Closure::bind(static function ($fileIdentifier, $file) {
            if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
                $GLOBALS['__composer_autoload_files'][$fileIdentifier] = \true;
                require $file;
            }
        }, null, null);
        foreach ($filesToLoad as $fileIdentifier => $file) {
            $requireFile($fileIdentifier, $file);
        }
        return $loader;
    }
}
