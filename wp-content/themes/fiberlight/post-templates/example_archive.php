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
            <div class="row blog-post">

                <div class="small-12 medium-6 columns image" style="background-image:url('<?= $image; ?>');" onclick="document.location='<?= get_the_permalink(); ?>';">

                </div>

                <div class="small-12 medium-6 columns info">
                    <div class="hold-me">
                        <a href="<? the_permalink(); ?>">
                            <h4><? the_title(); ?></h4>
                        </a>
                        <p>
                            <?= wp_trim_words($post->post_content, 40, '...') ?>
                        </p>
                        <a href="<? the_permalink(); ?>" class="read-more">Read More &raquo;</a>
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
