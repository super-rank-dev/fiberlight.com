<?php
get_header();
?>
<div id="wp-chatbot-app-checkout-container">
<?php
wp_enqueue_script( 'wc-checkout');
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
echo do_shortcode('[woocommerce_checkout]');
?>

</div>
<?php
get_footer();
?>
