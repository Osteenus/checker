<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitdbe5f2ac6d20e8a771043032d1ed87dd
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
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

        spl_autoload_register(array('ComposerAutoloaderInitdbe5f2ac6d20e8a771043032d1ed87dd', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitdbe5f2ac6d20e8a771043032d1ed87dd', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitdbe5f2ac6d20e8a771043032d1ed87dd::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
