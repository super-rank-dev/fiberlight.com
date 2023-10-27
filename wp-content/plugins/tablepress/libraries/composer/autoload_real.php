<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit99edf9200846366e8bbb86f47558dfa7
{
	private static $loader;

	public static function loadClassLoader($class)
	{
		if ('Composer\AutoloadTablePress\ClassLoader' === $class) {
			require __DIR__ . '/ClassLoader.php';
		}
	}

	/**
	 * @return \Composer\AutoloadTablePress\ClassLoader
	 */
	public static function getLoader()
	{
		if (null !== self::$loader) {
			return self::$loader;
		}

		require __DIR__ . '/platform_check.php';

		spl_autoload_register(array('ComposerAutoloaderInit99edf9200846366e8bbb86f47558dfa7', 'loadClassLoader'), true, true);
		self::$loader = $loader = new \Composer\AutoloadTablePress\ClassLoader(\dirname(__DIR__));
		spl_autoload_unregister(array('ComposerAutoloaderInit99edf9200846366e8bbb86f47558dfa7', 'loadClassLoader'));

		require __DIR__ . '/autoload_static.php';
		call_user_func(\Composer\Autoload\ComposerStaticInit99edf9200846366e8bbb86f47558dfa7::getInitializer($loader));

		$loader->setClassMapAuthoritative(true);
		$loader->register(true);

		return $loader;
	}
}
