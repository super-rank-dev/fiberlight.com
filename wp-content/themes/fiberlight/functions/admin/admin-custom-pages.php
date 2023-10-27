<?
/*add_action( 'admin_menu', 'aor_add_menu_pages' );

function aor_add_menu_pages() {
  //add_menu_page( 'AOR SEO', 'AOR SEO', 'manage_options', 'aor_admin_seo', 'aor_admin_seo_page', 'dashicons-tickets', 6  );
}

function aor_save_by_ajax() {
  https://support.advancedcustomfields.com/forums/topic/use-update_field-with-ajax/
}

function aor_admin_seo_page() {

  wp_deregister_script('foundation');
    wp_register_script('foundation', ("//cdnjs.cloudflare.com/ajax/libs/foundation/6.2.3/foundation.min.js"), array(), '6.2.3', true);
    wp_enqueue_script('foundation');
    wp_enqueue_style( 'stylesheet', get_template_directory_uri() . '/assets/styles/admin-foundation.min.css' );

  $loop = new WP_Query( array( 'post_type' => 'page', 'posts_per_page' => '3' ) );

  if ( $loop->have_posts() ) :

    while ( $loop->have_posts() ) : $loop->the_post();

      ?>
      <div class="row">
        <div class="small-12 columns">
          ad
        </div>
      </div>
      <?

    endwhile;

  endif;

  wp_reset_postdata();

}
*/
?>
