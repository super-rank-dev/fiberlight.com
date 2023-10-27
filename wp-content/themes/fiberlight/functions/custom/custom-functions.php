<?
// gets ubermenu code from acf and parses it
function aor_display_ubermenu() {
    $menuCode = str_replace(array("<?php","?>"), "", get_field('main_navigation_code','options'));
    eval($menuCode);
}
/*
@description
Finds all of the values that are used for a certain checkbox field group and displays them as links in a row.

@param $categoryField
The name of the checkbox field ACF group

@param $postType
The post type we are working with
*/
function aor_display_isotope_categories( $categoryField, $postType ) {
    $categoryList = [];

    $loop = new WP_Query( array( 'post_type' => $postType, 'posts_per_page' => '-1' ) );
    if ( $loop->have_posts() ) :
        while ( $loop->have_posts() ) : $loop->the_post();

            $categories = get_field($categoryField);

            if ( is_array($categories) ) {
                foreach ( $categories as $category ) {

                    if ( !in_array($category, $categoryList) ) {

                        $categoryList[] = $category;

                    }

                }
            }

        endwhile;

    endif;
    wp_reset_postdata();
    ?>
    <li data-filter="*" class="active">All</li>
    <?

    foreach ( $categoryList as $category ) {

        ?>
        <li data-filter=".<?= onlyLetters($category); ?>"><?= $category; ?></li>
        <?
    }
}
function aor_archive_pagination() {
    global $wp_query;

    $big = 999999999; // This needs to be an unlikely integer

    $paginate_links = paginate_links( array(
        'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'mid_size' => 5,
        'prev_next' => True,
        'prev_text' => __('&laquo;'),
        'next_text' => __('&raquo;'),
        'type' => 'list'
    ) );

    // Display the pagination if more than one page is found
    if ( $paginate_links ) {
        echo $paginate_links;
    }
}
function aor_print_r($val){
        echo '<pre>';
        print_r($val);
        echo  '</pre>';
}
//this function will output an image field as a bg image at a given size
function aor_bg_image($field, $size = "medium", $sub = 0, $options = 0) {
    if ( $sub && $options ) :
        echo "Please do not choose $sub and $options";
    elseif ( $sub ) :
        echo "style='background-image:url(" . get_sub_field($field)['sizes'][$size] . ");'";
    elseif ( $options ) :
        echo "style='background-image:url(" . get_field($field, 'options')['sizes'][$size] . ");'";
    else :
        echo "style='background-image:url(" . get_field($field)['sizes'][$size] . ");'";
    endif;
    
    return;
}
// redirect attachments to the homepage
function aor_attachment_redirect(){
    global $post;
    if ( is_attachment() ) :
        wp_redirect( '/', 301 );
        exit();
        wp_reset_postdata();
    endif;
}
add_action( 'template_redirect', 'aor_attachment_redirect' );


// The following snippet will update the database's sitename if it's on c9 and if it's incorrect
$url = $_SERVER['SERVER_NAME'] . dirname(__FILE__);
$domain = explode('/',$url);
$domain = $domain[0];
$domain = explode('.',$domain);
$siteName = $domain[0];
if ( $domain[1] == "c9users") :
    if ( get_option('siteurl') !== 'http://'. $siteName .'.c9users.io') :
        update_option( 'siteurl', 'http://'. $siteName .'.c9users.io' );
        update_option( 'home', 'http://'. $siteName .'.c9users.io' );
    endif;
endif;

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
function aor_excerpt_filter( $more ) {
    return '...';
}
add_filter('excerpt_more', 'aor_excerpt_filter');

/* Changed excerpt length to 150 words*/
function aor_excerpt_length($length) {
return 30;
}
add_filter('excerpt_length', 'aor_excerpt_length');


