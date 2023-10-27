<?php

/**
 * Handles asset loading for admin
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 QcformbuilderWP LLC
 */
class Qcformbuilder_Forms_Admin_Assets
{

    /**
     * Enqueue scripts and styles used in the post editor
     *
     * @since 1.5.0
     */
    public static function post_editor()
    {
        if (static::is_woocommerce_page()) {
            return;
        }
        self::maybe_register_all_admin();
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');

        self::admin_common();
        self::enqueue_script('shortcode-insert');
    }

    /**
     * Enqueue scripts and styles used in the form editor
     *
     * @since 1.5.0
     */
    public static function form_editor()
    {
        self::maybe_register_all_admin();
        wp_enqueue_style('wp-color-picker');
        self::enqueue_script('edit-fields');
        self::enqueue_script('editor');
        self::enqueue_style('editor-grid');

        wp_enqueue_script('jquery-ui-users');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-droppable');
    }

    /**
     * Enqueue scripts and styles used in main admin and in form editor
     *
     * @since 1.5.0
     */
    public static function admin_common()
    {
        self::maybe_register_all_admin();
        Qcformbuilder_Forms_Render_Assets::maybe_register();
        Qcformbuilder_Forms_Render_Assets::enqueue_script('validator');
        $locale = get_locale();
        if ($locale !== 'en_US') {
            Qcformbuilder_Forms_Render_Assets::enqueue_validator_i18n();
        }

        Qcformbuilder_Forms_Render_Assets::enqueue_style('grid');
        self::enqueue_style('admin');
        $slug = self::slug('admin');
        self::set_wfb_admin($slug);

        self::enqueue_style('modal');
        self::enqueue_script('admin');
        Qcformbuilder_Forms_Render_Assets::enqueue_style('front');
        Qcformbuilder_Forms_Render_Assets::enqueue_style('field');

        self::enqueue_script('baldrick');

        if( Qcformbuilder_Forms_Admin::is_main_page() ){
            wp_enqueue_script( Qcformbuilder_Forms_Render_Assets::make_slug('admin-client') );
        }

    }

    /**
     * Register all scripts for Chatbot Form Builder admin
     *
     * @since 1.5.0
     */
    public static function register_scripts()
    {
        $version = Qcformbuilder_Forms::VERSION;
        Qcformbuilder_Forms_Render_Assets::maybe_validator_i18n(true);

        wp_register_script(self::slug('shortcode-insert'), Qcformbuilder_Forms_Render_Assets::make_url('shortcode-insert'), array('jquery', 'wp-color-picker'), $version);

        wp_register_script(self::slug('baldrick'), Qcformbuilder_Forms_Render_Assets::make_url('wp-baldrick-full'), array('jquery'), $version);


        $admin_client_dependencies = [
            'wp-element',
            'wp-components'
        ];
        global $wp_version;
        if (!version_compare($wp_version, '5.0.0', '>=')) {
            $admin_client_dependencies[] = Qcformbuilder_Forms_Render_Assets::make_slug('legacy-bundle');
        }
        wp_register_script(Qcformbuilder_Forms_Render_Assets::make_slug('admin-client'), Qcformbuilder_Forms_Render_Assets::make_url('admin-client'), $admin_client_dependencies, $version);

        wp_register_script(self::slug('admin'), Qcformbuilder_Forms_Render_Assets::make_url('admin'), array(
            self::slug('baldrick'),
            Qcformbuilder_Forms_Render_Assets::make_slug('conditionals'),
            'wp-pointer',
            'password-strength-meter',
        ), $version);



        wp_register_script(self::slug('edit-fields'), Qcformbuilder_Forms_Render_Assets::make_url('fields'), array(
            'jquery',
            'wp-color-picker',
        ), $version);

        wp_register_script(self::slug('support-page'), Qcformbuilder_Forms_Render_Assets::make_url('support-page'), array('jquery'), $version);

        wp_localize_script(self::slug('editor'), 'CF_ADMIN_TOOLTIPS', self::get_tooltips());
        /**
         * Runs after scripts are registered for Chatbot Form Builder admin
         *
         * @since 1.5.0
         */
        do_action('qcformbuilder_forms_admin_assets_scripts_registered');
    }


    /**
     * Checks if current page is a WooCommerce admin page
     *
     * Will return false if WooCommerce is not active
     *
     * @return bool
     * @since 1.7.0
     *
     */
    public static function is_woocommerce_page()
    {
        if (!function_exists('wc_get_screen_ids')) {
            return false;
        }
        $current_screen = get_current_screen();
        return is_object($current_screen) && in_array($current_screen->id, wc_get_screen_ids());
    }

    /**
     * Register all styles for Chatbot Form Builder admin
     *
     * @since 1.5.0
     */
    public static function register_styles()
    {
        $version = Qcformbuilder_Forms::VERSION;
        wp_register_style(self::slug('modals', false), Qcformbuilder_Forms_Render_Assets::make_url('modals', false), array('wp-color-picker'), $version);
        self::enqueue_style('editor-grid');
        wp_register_style(
            Qcformbuilder_Forms_Render_Assets::make_slug('admin-client'),
            Qcformbuilder_Forms_Render_Assets::make_url('admin-client',
                false),
            [
                'wp-components',
                self::slug('editor-grid',false )
            ],
            $version);

        wp_register_style(self::slug('admin', false), Qcformbuilder_Forms_Render_Assets::make_url('admin', false), array(
            self::slug('modals', false),
            'wp-color-picker',
            'wp-pointer',
            Qcformbuilder_Forms_Render_Assets::make_slug('admin-client', false)
        ), $version);

        wp_register_style(self::slug('processors', false), Qcformbuilder_Forms_Render_Assets::make_url('processors-edit', false), array(), $version);
        wp_register_style(self::slug('editor-grid', false), Qcformbuilder_Forms_Render_Assets::make_url('editor-grid', false), array(
            self::slug('processors', false)
        ), $version);

        /**
         * Runs after styles are registered for Chatbot Form Builder admin
         *
         * @since 1.5.0
         */
        do_action('qcformbuilder_forms_admin_assets_styles_registered');

    }

    /**
     * Enqueue a style for Chatbot Form Builder admin
     *
     * @param string $slug Style slug
     * @since 1.5.0
     *
     */
    public static function enqueue_style($slug)
    {
        if (1 !== strpos($slug, Qcformbuilder_Forms::PLUGIN_SLUG)) {
            $slug = self::slug($slug, false);
        }
		
        wp_enqueue_style($slug);
    }

    /**
     * Enqueue a script for Chatbot Form Builder admin
     *
     * @param string $slug Script slug
     * @since 1.5.0
     *
     */
    public static function enqueue_script($slug)
    {
        if (1 !== strpos($slug, Qcformbuilder_Forms::PLUGIN_SLUG)) {
            $slug = self::slug($slug, true);
        }
        if(isset( $_GET['page'] )){
           if( is_admin() &&   $_GET['page'] == 'qcformbuilder-forms' && ! isset( $_GET['edit'] ) ){
               wp_enqueue_script( "jqueryOneTwelve",  WFBCORE_URL . "/assets/build/js/jquery-12-4.min.js");
           }
        }
		
        wp_enqueue_script($slug);
    }

    /**
     * Create a script/style slug for Chatbot Form Builder admin
     *
     * @param string $slug Short slug
     * @param bool|string $script Optional. True, the default append -scripts, false appends -style. A string appends that string.
     *
     * @return string
     * @since 1.5.0
     *
     */
    public static function slug($slug, $script = true)
    {
        if ('edit-editor' === $slug || 'editor' === $slug) {
            return Qcformbuilder_Forms_Render_Assets::make_slug('editor');
        }

        if ('baldrick' == $slug) {
            $slug = Qcformbuilder_Forms::PLUGIN_SLUG . '-' . $slug;
            return $slug;
        }
        $slug = Qcformbuilder_Forms::PLUGIN_SLUG . '-' . $slug;
        if (is_string($script)) {
            $slug .= $script;
        } elseif (true === $script) {
            $slug .= '-scripts';
        } elseif (false === $script) {
            $slug .= '-styles';
        }

        return $slug;
    }

    /**
     * Load scripts for form editor panels
     *
     * @since 1.5.0
     */
    public static function panels()
    {
        $panels = Qcformbuilder_Forms_Admin_Panel::get_panels();
        if (!empty($panels)) {
            foreach ($panels as $panel) {
                if (!empty($panel['setup']['scripts'])) {
                    foreach ($panel['setup']['scripts'] as $script) {
                        if (filter_var($script, FILTER_VALIDATE_URL)) {
                            self::enqueue_script($script);
                        } else {
                            wp_enqueue_script($script);
                        }
                    }

                    foreach ($panel['setup']['styles'] as $style) {
                        if (filter_var($style, FILTER_VALIDATE_URL)) {
                            self::enqueue_style($style);
                        } else {
                            wp_enqueue_style($style);
                        }
                    }
                }
            }
        }
    }

    /**
     * Registers all scripts needed if not registered yet
     *
     * @since 1.5.0
     */
    public static function maybe_register_all_admin()
    {
        $front = false;
        if (!did_action('qcformbuilder_forms_admin_assets_styles_registered')) {
            Qcformbuilder_Forms_Render_Assets::register();
            Qcformbuilder_Forms_Render_Assets::enqueue_all_fields();
            $front = true;
            self::register_styles();
        }

        if (!did_action('qcformbuilder_forms_admin_assets_scripts_registered')) {
            if (false === $front) {
                Qcformbuilder_Forms_Render_Assets::register();
                Qcformbuilder_Forms_Render_Assets::enqueue_all_fields();
            }
            self::register_scripts();
        }
    }

    /**
     * Get strings for admin tooltips
     *
     * @return array
     * @since 1.5.0.7
     *
     */
    public static function get_tooltips()
    {
        $tooltips = array(
            'add_field_row' => esc_html__('Add field to row', 'qcformbuilder-forms'),
            'split_row' => esc_html__('Split row.', 'qcformbuilder-forms'),
            'delete_row' => esc_html__('Delete row.', 'qcformbuilder-forms'),
        );

        /**
         * Filter admin tooltips
         *
         * @since 1.5.0.7
         */
        return apply_filters('qcformbuilder_forms_admin_tooltip_strings', $tooltips);
    }

    /**
     * Prepare data to pass to wp_localize_script in CF_ADMIN
     *
     * @return array
     * @since 1.6.2
     *
     */
    protected static function data_to_localize()
    {
        $data = array(
            'adminAjax' => esc_url_raw(admin_url('admin-ajax.php')),
            'rest' => array(
                'root' => esc_url_raw(untrailingslashit(Qcformbuilder_Forms_API_Util::url())),
                'nonce' => Qcformbuilder_Forms_API_Util::get_core_nonce()
            ),
            'isProConnected' => (bool) qcformbuilder_forms_pro_is_active(),
        );
        $api_config = new Qcformbuilder_Forms_API_JsConfig;
        $data = array_merge($data, $api_config->toArray());

        if (Qcformbuilder_Forms_Admin::is_edit()) {
            $form_id = trim($_GET[Qcformbuilder_Forms_Admin::EDIT_KEY]);
            $data['rest']['form'] = esc_url_raw(Qcformbuilder_Forms_API_Util::url('forms/' . $form_id, true));
            $data['rest']['revisions'] = esc_url_raw(Qcformbuilder_Forms_API_Util::url('forms/' . $form_id . '/revisions', true));
            $data['rest']['delete_entries'] = esc_url_raw(Qcformbuilder_Forms_API_Util::url('entries/' . $form_id . '/delete', true));
        }
        return $data;
    }

    /**
     * Sets up CF_ADMIN variable in JS land via wp_localize_script
     *
     * @param $slug
     * @since 1.6.2
     *
     */
    public static function set_wfb_admin($slug)
    {
        $data = self::data_to_localize();
        wp_localize_script($slug, 'CF_ADMIN', $data);
    }

}