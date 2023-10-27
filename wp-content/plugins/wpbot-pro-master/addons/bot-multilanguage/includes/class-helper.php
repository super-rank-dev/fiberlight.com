<?php

class WPBotML_Helper {
    
    public function __construct(){
        //$this->languages();
    }

    public function languages(){

        //echo get_locale();
        require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
        $language = wp_get_available_translations();;
        return $language;

    }
}
