<?php

/** Register QuantumCloud Custom Autoloader. */
spl_autoload_register( function ( $class ) {
	$namespace = 'QuantumCloud\\';
	/** Bail if the class is not in our namespace. */
	if ( 0 !== strpos( $class, $namespace ) ) {
		return;
	}
	/** Build the filename. */
	$file = realpath( __DIR__ );
	$file = $file . DIRECTORY_SEPARATOR . str_replace( '\\', DIRECTORY_SEPARATOR, $class ) . '.php';
	/** If the file exists for the class name, load it. */
	if ( file_exists( $file ) ) {
		/** @noinspection PhpIncludeInspection */
		include( $file );
	}
} );

