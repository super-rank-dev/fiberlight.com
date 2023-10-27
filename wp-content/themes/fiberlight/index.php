<?php

if ( is_singular() ):

    $postType = get_post_type();

    get_template_part( 'post-templates/' . $postType . '_single' );

elseif ( is_home() || is_category() ):

    get_template_part( 'post-templates/post_archive' );

elseif ( is_post_type_archive() ) :

    $postType = $wp_query->query['post_type'];
    
    $postArchive = 1;
    
    if ( $postType == "news" ) :
        
        get_template_part( 'post-templates/post_archive' );
        
    else :
        
        get_template_part( 'post-templates/' . $postType . '_archive' );
    
    endif;

elseif ( is_search() ):

    get_template_part( 'includes/search' );

elseif ( is_404() ):

    get_template_part( 'includes/404' );

elseif ( is_page() ) :

    get_template_part( 'page-templates/page-builder' );

elseif ( ( is_front_page() ) && ( !get_option( 'page_on_front' ) ) ) :

    echo "<a href='/wp-admin/options-reading.php'>Set a front page.</a>";

else :
    echo "Blank";

endif;

?>


