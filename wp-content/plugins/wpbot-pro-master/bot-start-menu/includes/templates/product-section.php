<?php

$perpage = get_option( 'startmenu_number_of_product', 4 );
//Latest product
$args_latest = array(
    'post_type' => 'product',
    'posts_per_page' => $perpage,
    'orderby' =>'date',
    'order' => 'DESC' 
);

//featured product query
$args_featured = array('post_status' => 'publish',
    'posts_per_page' => $perpage,
    'post_type' => 'product',
    'post_status' => 'publish',
    'tax_query' => array(array('taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => 'featured'))
);

//on sale product query
$args_sale = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => $perpage,
    'meta_query' => array(
        'relation' => 'OR',
        array( // Simple products type
            'key' => '_sale_price',
            'value' => 0,
            'compare' => '>',
            'type' => 'numeric'
        ),
        array( // Variable products type
            'key' => '_min_variation_sale_price',
            'value' => 0,
            'compare' => '>',
            'type' => 'numeric'
        )
    )
);

$product_type = get_option( 'startmenu_product_type', 'latest' );
if( $product_type == 'latest' ){
    $product_query = new WP_Query($args_latest);
    $title = esc_html__('Latest Products', 'botstartmenu');
}elseif( $product_type == 'featured' ){
    $product_query = new WP_Query($args_featured);
    $title = esc_html__('Featured Products', 'botstartmenu');
}elseif( $product_type == 'sale' ){ 
    $product_query = new WP_Query($args_sale);
    $title = esc_html__('On Sale Products', 'botstartmenu');
 }


$product_num = $product_query->post_count;

$total_product_num = $product_num;

$html = '<div class="wp-chatbot-start-content-single"><div class="start-single-header"><p><b>'.$title.'</b></p></div><div class="wp-chatbot-products-area">';
$_pf = new WC_Product_Factory();
//repeating the products
if ($product_num > 0) {
    
    $html .= '<ul class="wp-chatbot-products">';
    while ($product_query->have_posts()) : $product_query->the_post();
        $product = $_pf->get_product(get_the_ID());
        $html .= '<li class="wp-chatbot-product">';
        $html .= '<a class="wp-chatbot-product-url" wp-chatbot-pid= "' . get_the_ID() . '" target="_blank" href="' . get_permalink(get_the_ID()) . '" title="' . esc_attr($product->get_title() ? $product->get_title() : get_the_ID()) . '">';
        $html .= get_the_post_thumbnail(get_the_ID(), 'shop_catalog') . '
            <div class="wp-chatbot-product-summary">
            <div class="wp-chatbot-product-table">
            <div class="wp-chatbot-product-table-cell">
            <h3 class="wp-chatbot-product-title">' . esc_html($product->get_title()) . '</h3>
            <div class="price">' . ($product->get_price_html()) . '</div>';
        $html .= ' </div>
            </div>
            </div></a>
            </li>';
    endwhile;
    wp_reset_postdata();
    $html .= '</ul>';
}
$html .= '</div></div>';

echo $html;
