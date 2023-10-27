<?php
/* Template Name: Stla Preview Template */ 
$form_id = sanitize_text_field( $_GET['stla_form_id'] );
?>
<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<link rel="profile" href="https://gmpg.org/xfn/11">
		<?php gravity_form_enqueue_scripts( $form_id, false ); ?>
		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<?php
		wp_body_open();
		?>
<div class="stla-gravity-preview" id="stla-gravity-preview" style="width:80%; margin:auto; margin-top: 80px;">
    <?php echo do_shortcode('[gravityform id="'.$form_id.'" title="true" description="true"  ]'); ?>
</div>

<?php wp_footer(); ?>

	</body>
</html>