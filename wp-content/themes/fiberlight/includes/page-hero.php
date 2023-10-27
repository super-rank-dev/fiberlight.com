<?php
if ( !get_field('hide_hero') ) :
    //is home page
    if(is_front_page()) :
        $col = "medium-7 large-5";
        $description = get_field('description');
        $image = get_field('background_image');
        if (get_field('page_title_override')) :
            $title  = get_field('page_title_override');
          else:
            $title  = get_the_title();
          endif;
    // if is defualt blog page
    elseif (is_home()) :
      $title    = get_the_title( get_option('page_for_posts', true) );
      $image = get_field('background_image', get_option('page_for_posts'));
      $description = get_field('description', get_option('page_for_posts'));
      $col = "medium-7 large-5";

    //if is custom post archive
    elseif ( is_post_type_archive() ) :
      $title    = post_type_archive_title('', false );
      $image = get_field('default_cpt_banner', 'options');

    // if is archive
    elseif (is_archive()) :
      $title    = get_the_archive_title();
      $image = get_field('default_page_banner', 'options');
      $col = "medium-6 large-5";

// if is single post
    elseif (is_singular('post') || is_singular('news')) :
        $title    = get_the_title();
        $col = "medium-7 large-5";
        if ( get_field('header_image')) :
            $image = get_field('header_image');
        elseif ( get_field('image') ):
            $image = get_field('image');
        else :
            $image = get_field('default_blog_post_image' ,'options');
        endif;
        

    // if is single post
    elseif (is_singular('success-story')) :
        $title    = get_the_title();
        $image = get_field('image');
        $col = "medium-7 large-5";
        $story = 1;

    // if is 404 page
    elseif (is_404()) :
        $title    = get_field('404_page_title', 'option');
        $image = get_field('default_404_page_banner', 'options');
        $col = "medium-7 large-5";
    elseif (is_search()) :
        $title    = 'Search results for </br>"' . get_search_query() .'"';
        $image = get_field('default_404_page_banner', 'options');
        $col = "medium-6 large-5";
    //else
    else :
      // if page title override
      if (get_field('page_title_override')) :
        $title  = get_field('page_title_override');
      else:
        $title  = get_the_title();
      endif;
    //endif
    if (get_field('background_image')) :
        $image = get_field('background_image');
    else:
        $image = get_field('default_page_banner', 'options');
    endif;
    $description = get_field('description');
    $col = "medium-7 large-5";
    endif;

$video = false;
if ( get_field('layout') == "video" ) {
    $video = true;
    $video_url = get_field('video_url');
    if(strpos($video_url, 'vimeo') !== false) {
        $video_url = rtrim(get_field('video_url'),"/");
        $vim_imgid = substr(strrchr(rtrim($video_url, '/'), '/'), 1);
    }
    if(strpos($video_url, 'youtube') !== false) {
        $video_url = rtrim(get_field('video_url'),"/");
        $data = "$video_url";
        $yt_imgid = substr($data, strpos($data, "=") + 1);
    }
    if(!get_field('video_thumbnail_override')) {
        if(strpos($video_url, 'vimeo') !== false) {
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$vim_imgid.php"));
            $image['sizes']['mainstage-image'] = $hash[0]['thumbnail_large'];
        }
        if(strpos($video_url, 'youtube') !== false) {
            $image['sizes']['mainstage-image'] = "https://img.youtube.com/vi/$yt_imgid/maxresdefault.jpg";
        }
    } else {
        $image = get_field('video_thumbnail_override');
    }
}
$rand = rand(10000,99999);
$trigger_video_from_button = get_field('trigger_video_from_button');
?>

<section class="hero <?php if ( get_field('simple_hero') ) : ?>simple-hero<?php endif; ?> <?= get_field('layout') == "video" ? "video" : ''; ?>" <?php if ( !get_field('simple_hero') ) : ?> style="background-image: url('<?php echo $image['sizes']['mainstage-image']; ?>');<?php endif; ?>">
    <div class="row">
        <div class="small-12 columns content <?php if ( !get_field('simple_hero') ) : ?><?php echo $col; ?><?php endif; ?>">
            <div class="hold-me">
                <a class="parent-title" href="<?php $parent_title = get_permalink($post->post_parent); echo $parent_title; ?>">
                <?php
                    if($post->post_parent) {
                        $parent_title = get_the_title($post->post_parent);
                        echo $parent_title;
                    }
                    elseif ( is_home() || is_single() || is_post_type_archive() ) {

                    }
                    else {

                        echo get_the_title($post->ID);
                    }
                ?>
                </a>
                <h1><?php echo $title; ?></h1>
                <?php if ( $description ) : ?>
                    <p><?php echo $description; ?></p>
                <?php endif; ?>
                <?php if (get_field('buttons')): ?>
                    <?php while(has_sub_field('buttons')): ?>
                        <? aor_button($trigger_video_from_button, $rand, $video_url); ?>
                    <?php endwhile; ?>
                <?php endif; ?>
                <? if ( $story ) : ?>
                    <p><?= get_field('client_name'); ?></p>
                <? endif; ?>
            </div>

        </div>
    </div>
    <div class="pattern" data-scroll-speed='9'></div>
    <? if ( get_field('layout') == "video" ) : ?>
        <div class='inner'>
            <a href="<? echo $video_url; ?>" class='video_popup video_popup_<?= $rand; ?>'>
                <img src="<? echo get_template_directory_uri(); ?>/img/play_button.png" alt="play video"/>
            </a>
        </div>
    <? endif; ?>
</section>
<? if($video) : ?>
    <script>
        $(document).ready(function() {
            $('.video_popup_<?= $rand; ?>').magnificPopup({
                type: 'iframe',
                iframe: {
                    patterns: {
                        vimeo: {
                            index: 'vimeo.com/',
                            src: '//player.vimeo.com/video/<?= $vim_imgid; ?>'
                        },
                    }
                }
            });
        })
    </script>
<? endif; ?>
<?php endif; ?>
