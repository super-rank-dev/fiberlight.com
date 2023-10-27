<?php


add_action('acf/init', 'my_acf_blocks_init');
function my_acf_blocks_init() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

			// Register Full Page Block
			add_acf_block("full_page_hero", "Full Page - Hero", "Full Page - Hero", true, false, "preview");
			add_acf_block("full_page_custom", "Full Page - Custom", "Full Page - Custom", true, false, "preview");
			add_acf_block("full_page_stats", "Full Page - Stats", "Full Page - Stats", true, false, "preview");
			add_acf_block("full_page_slider", "Full Page - Slider", "Full Page - Slider", true, true, "preview");
			add_acf_block("page_hero", "Page - Hero", "Page - Hero", true, false, "preview");
			add_acf_block("page_hero_2", "Page - Hero 2", "Page - Hero 2", true, false, "preview");
			add_acf_block("page_hero_3", "Page - Hero 3", "Page - Hero 3", true, false, "preview");
			add_acf_block("page_slider", "Page - Slider", "Page - Slider", true, true, "preview");
			add_acf_block("content_custom", "Content - Custom", "Content - Custom", true, false, "preview");
			add_acf_block("content_split", "Content - Split Col", "Content - Split Col", true, false, "preview");
			add_acf_block("content_snapshot", "Content - Snapshot", "Content - Snapshot", true, false, "preview");
			add_acf_block("content_layout_1", "Content - Layout 1", "Content - Layout 1", true, false, "preview");
			add_acf_block("content_layout_2", "Content - Layout 2", "Content - Layout 2", true, false, "preview");
			add_acf_block("content_layout_3", "Content - Layout 3", "Content - Layout 3", true, false, "auto");
			add_acf_block("content_layout_4", "Content - Layout 4", "Content - Layout 4", true, false, "auto");
			add_acf_block("content_layout_5", "Content - Layout 5", "Content - Layout 5", true, false, "preview");
			add_acf_block("content_layout_6", "Content - Layout 6", "Content - Layout 6", true, false, "auto",);
			add_acf_block("content_layout_7", "Content - Layout 7", "Content - Layout 7", true, false, "preview",);
			add_acf_block("content_layout_8", "Content - Layout 8", "Content - Layout 8", true, false, "preview",);
			add_acf_block("content_layout_9", "Content - Layout 9", "Content - Layout 9", true, false, "preview",);
			add_acf_block("content_layout_10", "Content - Layout 10", "Content - Layout 10", true, false, "preview");
			add_acf_block("file_download", "File Download", "File Download", true, false, "preview");
			add_acf_block("file_download_list", "File Download List", "File Download List", true, false, "auto");
			add_acf_block("quote", "Testimonial", "Testimonial", true, false, "preview");
			add_acf_block("service_list", "Service List", "Service List", true, false, "preview");
			add_acf_block("service_list_custom", "Service List Custom", "Service List Custom", true, false, "auto");
			add_acf_block("team_member_single", "Team Member - Single", "Single Team Member Item", true, false, "preview");
			add_acf_block("team_member_list", "Team Member - List", "Team Member List", true, false, "preview");
			add_acf_block("stat_list", "Stats - List", "Stats List", true, false, "preview");
			add_acf_block("video", "Video - Layout 1", "Video - Layout 1", true, false, "preview");
			add_acf_block("breadcrumb", "Breadcrumbs", "Custom breadcrumb style title", true, false, "preview");
			add_acf_block("image", "Image", "Image", true, false, "preview");
			add_acf_block("savings_calculator", "Savings Calculator", "Savings Calculator", true, false, "preview");
    }
}

function add_acf_block($name, $title, $description, $css, $scripts, $mode) {

	if ($scripts){
		$theScripts = get_template_directory_uri() . '/dist/js/'. $name .'.min.js';
	}
	else{
		$theScripts = '';
	}

	acf_register_block_type(array(
		'name'						=> $name,
		'title'						=> $title,
		'description'			=> $description,
		'category'				=> 'fiberlight',
		'mode'						=> $mode,
		'enqueue_style'  => get_template_directory_uri() . '/dist/css/acf/blocks/'. $name .'.min.css',
		'enqueue_script'  => $theScripts,
		'supports'				=> array(
			'align' 				=> false,
			'mode' 					=> false,
			'jsx' 					=> true,
		'color'           => [
				'background' 	=> true,
				'gradients'  	=> true,
				'text'       	=> false,
			],
		),
		'render_template' => 'dist/template-parts/acf/blocks/'. $name .'.php',
	));

}