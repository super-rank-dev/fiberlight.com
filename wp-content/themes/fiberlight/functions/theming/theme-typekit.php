<?php
$typekit = get_field('typekit_id', 'options');

if ( $typekit ) {
  function aor_typekit() {
    $typekit_code = get_field('typekit_id', 'options');
    wp_enqueue_script( 'aor_typekit', '//use.typekit.net/'.$typekit_code.'.js');
  }
  add_action( 'wp_enqueue_scripts', 'aor_typekit' );

  function aor_typekit_inline() {
    if ( wp_script_is( 'aor_typekit', 'done' ) ) { ?>
      <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
  <?php }
  }
  add_action( 'wp_head', 'aor_typekit_inline' );
}
