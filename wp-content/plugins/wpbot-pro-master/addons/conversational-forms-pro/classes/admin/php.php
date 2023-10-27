<?php

/**
 * Utility functions for determining if a PHP version is supported or not
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2018 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Admin_PHP{

    /**
     * Minimum supported version of Chatbot Form Builder
     *
     * When this changed, update Test_PHP_Version_Check::test_not_supported()
     *
     * @since 1.6.0
     *
     * @var string
     */
    private static $min_supported_version = '5.2.4';

    /**
     * Minimum version of Chatbot Form Builder that is tested
     *
     * When this changed, update Test_PHP_Version_Check::test_not_tested()
     *
     * @since 1.6.0
     *
     * @var string
     */
    private static $min_tested_version = '5.6';

    /**
     * Is a version of PHP supported by Chatbot Form Builder?
     *
     * @since 1.6.0
     *
     * @param string|null $version Optional. PHP version to test. Default is current version of PHP.
     *
     * @return bool
     */
    public static function is_version_supported( $version = null ){
            return self::greater_than( self::$min_supported_version, $version );
    }

    /**
     * Is a version of PHP tested with Chatbot Form Builder?
     *
     * @since 1.6.0
     *
     * @param string|null $version Optional. PHP version to test. Default is current version of PHP.
     *
     * @return bool
     */
    public static  function is_version_tested( $version = null ){
        return self::greater_than( self::$min_tested_version, $version );
    }

    /**
     * Is a version of PHP's supported deprecated by Chatbot Form Builder?
     *
     * @since 1.6.0
     *
     * @param string|null $version Optional. PHP version to test. Default is current version of PHP.
     *
     * @return bool
     */
    public static function is_version_deprecated( $version = null ){
        //This may, in the future, need it's own comparison.
        return ! self::is_version_tested( $version );
    }

    /**
     * Check if a PHP version is greater than minimum version
     *
     * @since 1.6.0
     *
     * @param string $min_version Minimum version to allow.
     * @param string|null $compare_version Optional. PHP version to test. Default is current version of PHP.
     *
     * @return bool
     */
    public static function greater_than( $min_version, $compare_version = null ){
        $compare_version = !is_null($compare_version) ? $compare_version : PHP_VERSION;
        return version_compare($compare_version, $min_version ) >= 0;
    }

    /**
     * Get the minimum supported version
     *
     * @since 1.6.0
     *
     * @return string
     */
    public static function get_minimum_supported_version(){
        return self::$min_supported_version;
    }

    /**
     * Get the minimum tested version
     *
     * @since 1.6.0
     *
     * @return string
     */
    public static function get_minimum_tested_version(){
        return self::$min_tested_version;
    }

    /**
     * Get the deprecation notice
     *
     * @since 1.6.0
     *
     * @return string Output is escaped
     */
    public static function get_deprecated_notice(){
        return sprintf('%s %s',
            esc_html__( sprintf('You are using a VERY out of date version of PHP: %s. Chatbot Form Builder 1.7 will require PHP Version %s or later.',
                PHP_VERSION, self::get_minimum_tested_version()
            ), 'qcformbuilder-forms'),
            sprintf('<a style="color:#fff;" href="https://quantumcloud.com/php?utm_source=wp-admin&utm_campaign=php_deprecated" target="__blank">%s</a>',
                esc_html__('Learn More', 'qcformbuilder-forms' )
            )
        );

    }

}
