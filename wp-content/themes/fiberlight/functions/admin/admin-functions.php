<?php
// Custom Backend Footer
function aor_custom_admin_footer() {
  _e('<span id="footer-thankyou">Developed by <a href="http://www.thinkaor.com" target="_blank">AOR</a></span>.', 'aor');
}
add_filter('admin_footer_text', 'aor_custom_admin_footer');

// Login css
function aor_login_css() {
  wp_enqueue_style( 'aor_login_css', get_template_directory_uri() . '/styles/login.css', false );
}
add_action( 'login_enqueue_scripts', 'aor_login_css', 10 );

// changing the logo link from wordpress.org to your site
function aor_login_url() {  return home_url(); }
add_filter('login_headerurl', 'aor_login_url');

// changing the alt text on the logo to show your site name
function aor_login_title() { return get_option('blogname'); }
add_filter('login_headertitle', 'aor_login_title');

// remove the default option in the page template selector
function aor_remove_default_template_option() {
    global $pagenow;
    if ( in_array( $pagenow, array( 'post-new.php', 'post.php') ) && get_post_type() == 'page' ) { ?>
        <script type="text/javascript">
            (function($){
                $(document).ready(function(){
                    $('#page_template option[value="default"]').remove();
                })
            })(jQuery)
        </script>
    <?php
    }
}
add_action('admin_footer', 'aor_remove_default_template_option', 10);

//allow extra file types in uploader
function aor_allow_extra_file_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'aor_allow_extra_file_types');

//add meta box to expand and contract the acf fields
function aor_expand_acf_box() {
  ?>
  <a class="button button-primary button-large expand-acf" style="
    background-color: #8c45b1;
    border-color: #66357f;
    text-shadow: none;
    margin-bottom: 10px;
    box-shadow: none;
    ">[+] Expand ACF Fields</a><br>
  <a class="button button-primary button-large contract-acf" style="
    background-color: #de0f4c;
    border-color: #ac1642;
    text-shadow: none;
    box-shadow: none;
    ">[-] Contract ACF Fields</a>
    <script type="text/javascript">
      jQuery(document).ready(function($){


        $('.expand-acf').click(function() {

          $('.acf-field-object').each(function() {
            if ( !$(this).hasClass('open') ) {
              $(this).find('a.edit-field').click();
            }
          });

        });

        $('.contract-acf').click(function() {

          $('.acf-field-object').each(function() {
            if ( $(this).hasClass('open') ) {
              $(this).find('a.edit-field').click();
            }
          });

        });


      });
    </script>
  <?php
}

function aor_expand_pb_box() {
  ?>
  <a class="button button-primary button-large expand-pb" style="
    background-color: #8c45b1;
    border-color: #66357f;
    text-shadow: none;
    margin-bottom: 10px;
    box-shadow: none;
    ">[+] Expand Page Builder Modules</a><br>
  <a class="button button-primary button-large contract-pb" style="
    background-color: #de0f4c;
    border-color: #ac1642;
    text-shadow: none;
    box-shadow: none;
    ">[-] Contract Page Builder Modules</a>
    <script type="text/javascript">
      jQuery(document).ready(function($){


        $('.expand-pb').click(function() {

          $('.layout').each(function() {
            if ( $(this).hasClass('-collapsed') ) {
              $(this).find('.acf-fc-layout-handle').click();
            }
          });

        });

        $('.contract-pb').click(function() {

          $('.layout').each(function() {
            if ( !$(this).hasClass('collapsed') ) {
              $(this).find('.acf-fc-layout-handle').click();
            }
          });

        });


      });
    </script>
  <?php
}

function aor_add_custom_meta_boxes() {
    add_meta_box("expand_acf_box", "Expand & Contract ACF Fields", "aor_expand_acf_box", "acf-field-group", "side", "high", null);
    add_meta_box("expand_pb_box", "Expand & Contract Page Builder", "aor_expand_pb_box", "page", "side", "high", null);
}
add_action("add_meta_boxes", "aor_add_custom_meta_boxes");

// // default permalink structure
// function aor_set_permalinks() {
//     global $wp_rewrite;
//     $wp_rewrite->set_permalink_structure( '/%postname%/' );
// }
// add_action( 'init', 'aor_set_permalinks' );

// duplicate post plugin option set
update_option( 'duplicate_post_copystatus', '1' );


function aor_edit_per_page( $result, $option, $user ) {
    if ( (int)$result < 1 )
        return 200;
}
// automatically set the default posts per page for every custom post
function aor_set_default_per_page() {
  $postTypes = get_post_types( array('public' => 'true', '_builtin' => 'false'), 'names','or');
  foreach ( $postTypes as $postType ) {
    add_filter( 'get_user_option_edit_' . $postType . '_per_page', 'aor_edit_per_page', 10, 3 );
  }
}
add_action( 'admin_head', 'aor_set_default_per_page', 10 );

// shortcut to save page
add_action( 'admin_footer', function() {?>
  <script>
    ( function ( $ ) {
        'use strict';
        $( window ).load( function () {
            wpse.init();
        });
        var wpse = {
            keydown : function (e) {
                if ( e.ctrlKey && 83 === e.which ) {
                    // ctrl+p for "Publish" or "Update"
                    e.preventDefault();
                    $( '#publish' ).trigger( 'click' );
                }
            },
            set_keydown_for_document : function() {
                $(document).on( 'keydown', wpse.keydown );
            },
            set_keydown_for_tinymce : function() {
               if( typeof tinymce == 'undefined' )
                   return;
               for (var i = 0; i < tinymce.editors.length; i++)
                   tinymce.editors[i].on( 'keydown', wpse.keydown );
           },
           init : function() {
               wpse.set_keydown_for_document();
               wpse.set_keydown_for_tinymce();
           }
       }
    } ( jQuery ) );
    </script>
<?php });




