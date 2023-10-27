<?php get_template_part('includes/header'); ?>

<?php if ( have_posts() ) : ?>
    <section class="blog-archive">
        <?php while ( have_posts() ) : the_post(); ?>
            <?
            if ( get_field('image') ) {
                $image = get_field('image')['sizes']['blog-post'];


            } else {
                $image = get_field('default_blog_post_image', 'options')['sizes']['blog-post'];
            }
            ?>
            <div class="row blog-post" data-aos="fade-up">

                <div class="small-12 medium-6 columns image" style="background-image:url('<?= $image; ?>');" onclick="document.location='<?= get_the_permalink(); ?>';">

                </div>

                <div class="small-12 medium-6 columns info align-middle" >
                    <div class="hold-me">
                        <a href="<? the_permalink(); ?>">
                            <h5><? the_title(); ?></h5>
                        </a>
                        <h6><?= get_the_date('l, F j, Y'); ?></h6>
                        <p>
                            <?= wp_trim_words($post->post_content, 40, '...') ?>
                        </p>
                        <a href="<? the_permalink(); ?>" class="button tertiary">Read More &raquo;</a>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>

        <div class="row pagination">
            <div class="small-12 columns">
                <? aor_archive_pagination(); ?>
            </div>
        </div>

    </section>

<?php endif; ?>

<?php get_template_part('includes/footer'); ?>

  <script type="text/javascript">
    jQuery(document).ready(function($){
      
        //Set link to entire project block, since wrapping in an <a> tag isn't accessible.
        $(".blog-post").click(function() {
          window.location = $(this).find("a").attr("href"); 
          return false;
        });
    });
  
</script>
