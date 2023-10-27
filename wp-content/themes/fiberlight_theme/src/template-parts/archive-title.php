<?php

  if(is_paged()):
    $noPad = 'blog-list-title-no-pad';
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $pageNumber = '- Page '. $paged;
  else:
    $noPad = '';
    $paged = '';
  endif;

  $archivePage = 'Y';
  $blogTitle = $archiveTitle;
  $heroImage = $postHeroImage;
  $heroImageAlt = $heroImage['alt'];
  $headerColor = get_field('header_color_resources', 'option');
  if ($headerColor == 'dark') : $adjustHeader = 'makeHeaderDark'; endif;
?>

<section id="blog-list-title" class="blog-list-title <?php echo $noPad; ?> <?php echo $adjustHeader; ?>">
  <?php include(dirname(__DIR__).'/template-parts/acf/clone/hero-image.php');   ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 text-center">
        <h1><?php echo $blogTitle; ?> </h1>
      </div>
    </div>
  </div>
</section>