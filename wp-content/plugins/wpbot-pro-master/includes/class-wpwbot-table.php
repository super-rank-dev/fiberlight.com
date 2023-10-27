<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
define('QCLD_wpCHATBOT_ACTION', 'https://www.quantumcloud.com/custom-chatbot-services/');
define('QCLD_theme_BANNER_LANDING', 'https://www.quantumcloud.com/products/themes/chatbot-theme/');
define('QCLD_wpCHATBOT_ACTION_hook','wpqcld_chk_seft');
if ( ! class_exists( 'wpwBot_Table' ) ) :
    /**
     * Class for plugin index table
     */
    
    class wpwBot_Table {
        /**
         * @var wpwBot_Table Index table name
         */
        private $table_name;
        /**
         * Constructor
         */
        public function __construct() {
            global $wpdb;
            $this->table_name = $wpdb->prefix . QCLD_wpCHATBOT_INDEX_TABLE;
            //add_action( 'wp_insert_post', array( $this, 'update_table' ), 10, 3 );
           
            if ( defined('wpCOMMERCE_VERSION') ) {              
                if ( version_compare( wpCOMMERCE_VERSION, '3.0', ">=" ) ) {
                    add_action( 'woocommerce_variable_product_sync_data', array( $this, 'variable_product_changed' ) );
                } else {
                    add_action( 'woocommerce_variable_product_sync', array( $this, 'variable_product_changed' ), 10, 2 );  
                }
            }
            
            add_action( 'wp_ajax_qcld-wp-chabot-reindex', array( $this, 'reindex_table' ) );
            add_action( 'wp_ajax_qcld-wp-chabot-cancel-index', array( $this, 'cancel_reindex' ) );
        }
        /*
         * Reindex plugin table
         */
        public function reindex_table( $return = false ) {
            global $wpdb;
            $index_meta = get_option( 'wp_chatbot_index_meta', false );
            $status = false;
            // No current index going on. Let's start over
            if ( false === $index_meta ) {
                $status = 'start';
                $index_meta = array(
                    'offset' => 0,
                    'start' => true,
                );
                $wpdb->query("DROP TABLE IF EXISTS {$this->table_name}");
                $this->create_table();
                $index_meta['found_posts'] = $this->get_number_of_products();
            } else if ( ! empty( $index_meta['site_stack'] ) && $index_meta['offset'] >= $index_meta['found_posts'] ) {
                $status = 'start';
                $index_meta['start'] = true;
                $index_meta['offset'] = 0;
                $index_meta['current_site'] = array_shift( $index_meta['site_stack'] );
            } else {
                $index_meta['start'] = false;
            }
            $index_meta = apply_filters( 'wp_chatbot_index_meta', $index_meta );
            $posts_per_page = apply_filters( 'wp_chatbot_index_posts_per_page', 30 );
            $args = array(
                'posts_per_page'      => $posts_per_page,
                'fields'              => 'ids',
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'offset'              => $index_meta['offset'],
                'ignore_sticky_posts' => true,
                'suppress_filters'    => true,
                'no_found_rows'       => 1,
                'orderby'             => 'ID',
                'order'               => 'DESC',
            );
            $posts = get_posts( $args );
            if ( $status !== 'start' ) {
                if ( $posts && count( $posts ) > 0 ) {
                    $queued_posts = array();
                    foreach( $posts as $post_id ) {
                        $queued_posts[] = absint( $post_id );
                    }
                    $this->fill_table( $queued_posts );
                    $index_meta['offset'] = absint( $index_meta['offset'] + $posts_per_page );
                    if ( $index_meta['offset'] >= $index_meta['found_posts'] ) {
                        $index_meta['offset'] = $index_meta['found_posts'];
                    }
                    update_option( 'wp_chatbot_index_meta', $index_meta );
                } else {
                    // We are done (with this site)
                    $index_meta['offset'] = (int) count( $posts );
                    delete_option( 'wp_chatbot_index_meta' );
                    update_option( 'wp_chatbot_index_count', 1 );
                }
            } else {
                update_option( 'wp_chatbot_index_meta', $index_meta );
            }
            if ( $return ) {
                return $index_meta;
            } else {
                wp_send_json_success( $index_meta );
            }
        }
        /*
         * Get total number of products
         */
        private function get_number_of_products() {
            $args = array(
                'posts_per_page'      => -1,
                'fields'              => 'ids',
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'suppress_filters'    => true,
                'no_found_rows'       => 1,
                'orderby'             => 'ID',
                'order'               => 'DESC',
            );
            $posts = get_posts( $args );
            if ( $posts && count( $posts ) > 0 ) {
                $count = count( $posts );
            } else {
                $count = 0;
            }
            return $count;
        }
        /*
         * Check if index table exist
         */
        private function is_table_not_exist() {
            global $wpdb;
            return ( $wpdb->get_var( "SHOW TABLES LIKE '{$this->table_name}'" ) != $this->table_name );
        }
        /*
         * Create index table
         */
        private function create_table() {
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE {$this->table_name} (
                      id BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
                      term VARCHAR(50) NOT NULL DEFAULT 0,
                      term_source VARCHAR(20) NOT NULL DEFAULT 0,
                      type VARCHAR(50) NOT NULL DEFAULT 0,
                      count BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
                      in_stock INT(11) NOT NULL DEFAULT 0,
                      visibility VARCHAR(20) NOT NULL DEFAULT 0,
                      lang VARCHAR(20) NOT NULL DEFAULT 0
                ) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
        /*
         * Insert data into the index table
         */
        private function fill_table( $posts ) {
            foreach ( $posts as $found_post_id ) {
                $data = array();
                $data['terms'] = array();
                $data['id'] = $found_post_id;
                $product = wc_get_product( $data['id'] );
                if( ! is_a( $product, 'WC_Product' ) ) {
                    continue;
                }
                $data['in_stock'] = method_exists( $product, 'get_stock_status' ) ? ( ( $product->get_stock_status() === 'outofstock' ) ? 0 : 1 ) : ( method_exists( $product, 'is_in_stock' ) ? $product->is_in_stock() : 1 );
                $data['visibility'] = method_exists( $product, 'get_catalog_visibility' ) ? $product->get_catalog_visibility() : ( method_exists( $product, 'get_visibility' ) ? $product->get_visibility() : 'visible' );
                $data['lang'] = '';
                $sku = $product->get_sku();
                $title = apply_filters( 'the_title', get_the_title( $data['id'] ) );
                $content = apply_filters( 'the_content', get_post_field( 'post_content', $data['id'] ) );
                $excerpt = get_post_field( 'post_excerpt', $data['id'] );
                $cat_names = $this->get_terms_names_list( $data['id'], 'product_cat' );
                $tag_names = $this->get_terms_names_list( $data['id'], 'product_tag' );
                // Get all child products if exists
                if ( $product->is_type( 'variable' ) && class_exists( 'WC_Product_Variation' ) ) {
                    if ( sizeof( $product->get_children() ) > 0 ) {
                        foreach ( $product->get_children() as $child_id ) {
                            $variation_product = new WC_Product_Variation( $child_id );
                            $variation_sku = $variation_product->get_sku();
                            $variation_desc = '';
                            if ( method_exists( $variation_product, 'get_description' ) ) {
                                $variation_desc = $variation_product->get_description();
                            }
                            if ( $variation_sku ) {
                                $sku = $sku . ' ' . $variation_sku;
                            }
                            if ( $variation_desc ) {
                                $content = $content . ' ' . $variation_desc;
                            }
                        }
                    }
                }
                // WP 4.2 emoji strip
                if ( function_exists( 'wp_encode_emoji' ) ) {
                    $content = wp_encode_emoji( $content );
                }
                $content = $this->strip_shortcodes( $content );
                $excerpt = $this->strip_shortcodes( $excerpt );
                $data['terms']['title']    = $this->extract_terms( $title );
                $data['terms']['content']  = $this->extract_terms( $content );
                $data['terms']['excerpt']  = $this->extract_terms( $excerpt );
                $data['terms']['sku']      = $this->extract_terms( $sku );
                $data['terms']['category'] = $this->extract_terms( $cat_names );
                $data['terms']['tag']      = $this->extract_terms( $tag_names );
                //Insert data into table
                $this->insert_into_table( $data );
            }
        }
        /*
         * Scrap all product data and insert to table
         */
        private function insert_into_table( $data ) {
            global $wpdb;
            $values = array();
            foreach( $data['terms'] as $source => $all_terms ) {
                foreach ( $all_terms as $term => $count ) {
                    if ( ! $term ) {
                        continue;
                    }
                    $value = $wpdb->prepare(
                        "(%d, %s, %s, %s, %d, %d, %s, %s)",
                        $data['id'], $term, $source, 'product', $count, $data['in_stock'], $data['visibility'], $data['lang']
                    );
                    $values[] = $value;
                }
            }
            if ( count( $values ) > 0 ) {
                $values = implode( ', ', $values );
                $query  = "INSERT IGNORE INTO {$this->table_name}
				              (`id`, `term`, `term_source`, `type`, `count`, `in_stock`, `visibility`, `lang`)
				              VALUES $values
                    ";
                $wpdb->query( $query );
            }
        }
        /*
         * Update index table
         */
        public function update_table( $post_id, $post, $update ) {
            global $wpdb;
            if ( $this->is_table_not_exist() ) {
                $this->create_table();
            }
            $slug = 'product';
            if ( $slug != $post->post_type ) {
                return;
            }
            $wpdb->delete( $this->table_name, array( 'id' => $post_id ) );
            $posts = get_posts( array(
                'posts_per_page'   => -1,
                'fields'           => 'ids',
                'post_type'        => 'product',
                'post_status'      => 'publish',
                'suppress_filters' => false,
                'no_found_rows'    => 1,
                'include'          => $post_id
            ) );
            $this->fill_table( $posts );
        }
        /*
         * Fires when products terms are changed
         */
        public function term_changed( $term_id, $tt_id, $taxonomy ) {
            if ( $taxonomy === 'product_cat' || $taxonomy === 'product_tag' ) {
            }
        }
        /*
         * Fires when products variations are changed
         */
        public function variable_product_changed( $product, $children = null ) {
            global $wpdb;
            $product_id = '';
                    
            if ( $this->is_table_not_exist() ) {
                $this->create_table();
            }
            
            if ( is_object( $product ) ) {
                $product_id = $product->get_id();
            } else {
                $product_id = $product;
            }
            $wpdb->delete( $this->table_name, array( 'id' => $product_id ) );
            $posts = get_posts( array(
                'posts_per_page'   => -1,
                'fields'           => 'ids',
                'post_type'        => 'product',
                'post_status'      => 'publish',
                'suppress_filters' => false,
                'no_found_rows'    => 1,
                'include'          => $product_id
            ) );
            $this->fill_table( $posts );
        }
        /*
         * Cancel index
         */
        public function cancel_reindex() {
            delete_option( 'wp_chatbot_index_meta' );
            wp_send_json_success( 'Deleted!' );
        }
        /*
         * Strip shortcodes
         */
        private function strip_shortcodes( $content ) {
            $content = preg_replace( '#\[[^\]]+\]#', '', $content );
            return $content;
        }
        /*
         * Extract terms from content
         */
        private function extract_terms( $str ) {
            $stopwords = str_replace('\\', '', get_option('qlcd_wp_chatbot_stop_words'));
            $str = $this->html2txt( $str );
            // Avoid single A-Z.
            
            $special_cars = $this->get_special_chars();
            $str = str_replace( $special_cars, "", $str );
            $str = str_replace( array(
                "Ă‹â€ˇ",
                "Ă‚Â°",
                "Ă‹â€ş",
                "Ă‹ĹĄ",
                "Ă‚Â¸",
                "Ă‚Â§",
                "=",
                "Ă‚Â¨",
                "â€™",
                "â€",
                "â€ť",
                "â€ś",
                "â€ž",
                "Â´",
                "â€”",
                "â€“",
                "Ă—",
                '&#8217;',
                "&nbsp;",
                chr( 194 ) . chr( 160 )
            ), " ", $str );
            $str = str_replace( 'Ăź', 'ss', $str );
            $str = preg_replace( '/[[:space:]]+/', ' ', $str );
            // Most objects except unicode characters
            $str = preg_replace( '/[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\x9F]/u', '', $str );
            // Line feeds, carriage returns, tabs
            $str = preg_replace( '/[\x00-\x1F\x80-\x9F]/u', '', $str );
            if ( function_exists( 'mb_strtolower' ) ) {
                $str = mb_strtolower( $str );
            } else {
                $str = strtolower( $str );
            }
            $str = preg_replace( '/^[a-z]$/i', "", $str );
            $str = trim( preg_replace( '/\s+/', ' ', $str ) );
            $str_array = array_count_values( explode( ' ', $str ) );
            if ( $stopwords && $str_array && ! empty( $str_array ) ) {
                $stopwords_array = explode( ',', $stopwords );
                if ( $stopwords_array && ! empty( $stopwords_array ) ) {
                    $stopwords_array = array_map( 'trim', $stopwords_array );
                    foreach ( $str_array as $str_word => $str_count ) {
                        if ( in_array( $str_word, $stopwords_array ) ) {
                            unset( $str_array[$str_word] );
                        }
                    }
                }
            }
            return $str_array;
        }
        /*
         * Removes scripts, styles, html tags
         */
        public function html2txt( $str ) {
            $search = array(
                '@<script[^>]*?>.*?</script>@si',
                '@<[\/\!]*?[^<>]*?>@si',
                '@<style[^>]*?>.*?</style>@siU',
                '@<![\s\S]*?--[ \t\n\r]*>@'
            );
            $str = preg_replace( $search, '', $str );
            $str = esc_attr( $str );
            $str = stripslashes( $str );
            $str = str_replace( array( "\r", "\n" ), ' ', $str );
            $str = str_replace( array(
                "Â·",
                "â€¦",
                "â‚¬",
                "&shy;"
            ), "", $str );
            return $str;
        }
        /*
        * Get special characters that must be striped
        */
       public function get_special_chars() {
            $chars = array(
                '-',
                '_',
                '|',
                '+',
                '`',
                '~',
                '!',
                '@',
                '#',
                '$',
                '%',
                '^',
                '&',
                '*',
                '(',
                ')',
                '\\',
                '?',
                ';',
                ':',
                "'",
                '"',
                ".",
                ",",
                "<",
                ">",
                "{",
                "}",
                "/",
                "[",
                "]",
            );
            return apply_filters( 'wp_chatbot_special_chars', $chars );
        }
        /*
         * Get string with current product terms ids
         *
         * @return string List of terms ids
         */
        private function get_terms_list( $id, $taxonomy ) {
            $terms = get_the_terms( $id, $taxonomy );
            if ( is_wp_error( $terms ) ) {
                return '';
            }
            if ( empty( $terms ) ) {
                return '';
            }
            $cats_array_temp = array();
            foreach ( $terms as $term ) {
                $cats_array_temp[] = $term->term_id;
            }
            return implode( ', ', $cats_array_temp );
        }
        /*
         * Get string with current product terms names
         *
         * @return string List of terms names
         */
        private function get_terms_names_list( $id, $taxonomy ) {
            $terms = get_the_terms( $id, $taxonomy );
            if ( is_wp_error( $terms ) ) {
                return '';
            }
            if ( empty( $terms ) ) {
                return '';
            }
            $cats_array_temp = array();
            foreach ( $terms as $term ) {
                $cats_array_temp[] = $term->name;
            }
            return implode( ', ', $cats_array_temp );
        }
    }
endif;
//new wpwBot_Table();