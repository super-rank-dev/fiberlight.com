<?
add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar){
    $admin_bar->add_menu( array(
        'id'    => 'dev-links',
        'title' => 'Dev Links',
        'href'  => '#',
        'meta'  => array(
            'title' => __('Dev Links'),
            'class' => 'dev-links'
        ),
    ));
    
    if (get_field('dev_quick_links', 'options')):
        $counter = 1;
	    while(has_sub_field('dev_quick_links', 'options')): 
            
            $admin_bar->add_menu( array(
                'id'    => 'my-sub-item-' . $counter,
                'parent' => 'dev-links',
                'title' => get_sub_field('link_title'),
                'href'  => get_sub_field('relative_link_url'),
                'meta'  => array(
                    'title' => __(get_sub_field('link_title')),
                    'target' => '_blank'
                ),
            ));
            
            $counter++;

	    endwhile; 

    endif; 
    
}
?>