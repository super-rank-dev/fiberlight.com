<?php

/**
 * @package WordPress
 * @subpackage Fiberlight Theme
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>
    <?php wp_title('&laquo;', true, 'right'); ?>
  </title>

  <link rel="apple-touch-icon" sizes="180x180" href="/wp-content/themes/fiberlight_theme/dist/images/favicon/apple-touch-icon.png?v=2">
  <link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/fiberlight_theme/dist/images/favicon/favicon-32x32.png?v=2">
  <link rel="icon" type="image/png" sizes="16x16" href="/wp-content/themes/fiberlight_theme/dist/images/favicon/favicon-16x16.png?v=2">
  <link rel="manifest" href="/wp-content/themes/fiberlight_theme/dist/images/favicon/site.webmanifest">
  <link rel="mask-icon" href="/wp-content/themes/fiberlight_theme/dist/images/favicon/safari-pinned-tab.svg?v=2" color="#5bbad5">
  <link rel="icon" type="image/x-icon" href="/wp-content/themes/fiberlight_theme/dist/images/favicon/favicon.ico">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <link rel="preconnect" href="https://www.googletagmanager.com">
  <link rel="preconnect" href="https://www.google-analytics.com">
  <link rel="preconnect" href="https://www.google.com">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700;900&display=swap" rel="stylesheet">

  
  <?php wp_head(); ?>

  <?php
  $headerScripts = get_field('header_scripts', 'option');
  echo $headerScripts;
  ?>

</head>

<body <?php body_class(); ?>>

  <?php
  $bodyScripts = get_field('body_scripts', 'option');
  echo $bodyScripts;
  ?>

  <?php
  $logo = get_field('logo', 'option');
  $logoRev = get_field('logo_rev', 'option');
  ?>

  <nav id="main-navigation" class="main-navigation">
    <div class="nav-content d-flex flex-column">
      <div class="nav-item-hamburger d-flex align-items-center justify-content-center">
        <button id="nav-hamburger" class="hamburger hamburger--collapse" type="button">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
      </div>



      <div class="d-flex flex-column pt-2">
        <!-- Solutions Navigation -->
        <div class="row d-flex h-100 ps-3 ps-md-5 pt-5 pt-md-5 g-0">
          <div class="col align-self-center">
            <?php
            $solutions = get_field('solutions_page', 'option');
            if ($solutions) :
              echo '<div class="nav-section-title">';
              echo '<a href="' . $solutions['url'] . '" target="_self">' . $solutions['title'] . ' &nbsp;</a>';
              echo '</div>';
            endif;
            if (have_rows('solutions_nav', 'option')) :
              echo '<ul class="nav-section-items d-flex flex-wrap ">';
              while (have_rows('solutions_nav', 'option')) :
                the_row();
                $link = get_sub_field('nav_item');
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                echo '<li><a href="' . $link_url . '" target="' . $link_target . '">' . $link_title . '</a></li>';
              endwhile;
              echo '</ul>';
            endif;
            ?>

          </div>
        </div>

        <!-- Network Navigation -->
        <div class="row d-flex h-100 ps-3 ps-md-5 pt-4 pt-md-5 g-0">
          <div class="col align-self-start">
            <?php
            $network = get_field('network_page', 'option');
            if ($network) :
              echo '<div class="nav-section-title">';
              echo '<a href="' . $network['url'] . '" target="_self">' . $network['title'] . ' &nbsp;</a>';
              echo '</div>';
            endif;
            ?>

            <ul class="nav-section-items d-flex flex-wrap align-items-center">
              <?php
              if (have_rows('network_nav', 'option')) :
                while (have_rows('network_nav', 'option')) :
                  the_row();
                  $link = get_sub_field('nav_item');
                  $link_url = $link['url'];
                  $link_title = $link['title'];
                  $link_target = $link['target'] ? $link['target'] : '_self';
                  echo '<li><a href="' . $link_url . '" target="' . $link_target . '">' . $link_title . '</a></li>';
                endwhile;
              endif;
              ?>
              <li class="">
                <?php
                $argsMaps = array(
                  'paged' => null,
                  'posts_per_page' => -1,
                  'offset' => 0,
                  'orderby' => 'title',
                  'order' => 'ASC',
                  'post_type' => 'coverage-map',
                  'post_status' => 'publish'
                );
                $coverageMaps = new WP_Query($argsMaps);
                ?>
                <select id="coverage-map-select" class="form-coverage-map form-control-sm coverage-map-select">
                  <option disabled selected value="">Coverage Maps</option>
                  <?php if ($coverageMaps->have_posts()) :
                    while ($coverageMaps->have_posts()) :
                      $coverageMaps->the_post(); ?>
                      <option value="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></option>
                  <?php endwhile;
                    wp_reset_postdata();
                  endif; ?>
                </select>

              </li>
            </ul>
          </div>
        </div>

        <!-- Company Navigation -->
        <div class="row d-flex h-100 ps-3 ps-md-5 pt-4 pt-md-5 g-0">
          <div class="col align-self-start">
            <?php
            $company = get_field('company_page', 'option');
            if ($company) :
              echo '<div class="nav-section-title">';
              echo '<a href="' . $company['url'] . '" target="_self">' . $company['title'] . ' &nbsp;</a>';
              echo '</div>';
            endif;
            if (have_rows('company_nav', 'option')) :
              echo '<ul class="nav-section-items d-flex flex-wrap">';
              while (have_rows('company_nav', 'option')) :
                the_row();
                $link = get_sub_field('nav_item');
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                echo '<li><a href="' . $link_url . '" target="' . $link_target . '">' . $link_title . '</a></li>';
              endwhile;
              echo '</ul>';
            endif;
            ?>

          </div>
        </div>
      </div>


    </div>
    <div id="nav-overlay" class="nav-overlay"></div>
  </nav>

  <header id="header" class="header">

    <div id="header-xd" class="container header-xd">
      <div class="row align-items-center ">
        <div class="col-6  ">
          <div class="logo-wrap">
            <a href="/">
              <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" id="logo-dark" class="logo hide" width="150" height="34" />
              <img src="<?php echo esc_url($logoRev['url']); ?>" alt="<?php echo esc_attr($logoRev['alt']); ?>" id="logo-light" class="logo show" width="150" height="34" />
            </a>
          </div>
        </div>

        <div class="col-6 text-end">

          <form role="search" method="get" id="header-search-form" action="<?php echo esc_url(home_url('/')); ?>" class="header-search-form input-group mb-3">
            <div class="input-group">
              <input type="search" class="form-control search-input" placeholder="Search" aria-label="search" name="s" id="search-input" value="<?php echo esc_attr(get_search_query()); ?>">
            </div>
          </form>

          <button id="header-search-btn" class="header-search-btn" type="button" aria-label="Search the website" role="button"></button> 

          <button id="header-hamburger" class="hamburger hamburger--collapse" type="button">
            <span class="hamburger-box">
              <span id="hamburger-inner" class="hamburger-inner"></span>
            </span>
            <div id="hamburger-title" class="hamburger-title">Menu</div>
          </button>
        </div>
      </div>
    </div>

    <div id="header-lg" class="container header-lg">
      <div class="row align-items-center ">
        <div class="col-6  ">
          <div class="logo-wrap">
            <a href="/">
              <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" id="logo-dark" class="logo hide" width="150" height="34" />
              <img src="<?php echo esc_url($logoRev['url']); ?>" alt="<?php echo esc_attr($logoRev['alt']); ?>" id="logo-light" class="logo show" width="150" height="34" />
            </a>
          </div>
        </div>

        <div class="col-6">
          <div class="action">
            <div class="menu-button-group">
              <div class="menu-button">
                <div class="hover-container"></div>
                <div class="dropdown text-22">Solutions</div>
                <div class="dropdown-content">
                  <div class="chip"></div>
                  <div class="menu-content">
                    <div class="section-container">
                      <div class="section">
                        <?php
                        $count = 0;
                        if (have_rows('solutions_nav', 'option')) :
                          while (have_rows('solutions_nav', 'option')) :
                            the_row();
                            if ($count >= 0 && $count < 3) {

                              $link = get_sub_field('nav_item');
                              $image = get_sub_field('nav_icon');
                              $description = get_sub_field('description');

                              $link_url = $link['url'];
                              $link_title = $link['title'];
                              $link_target = $link['target'] ? $link['target'] : '_self';
                              echo '<div class="item"><div class="nav-image"><img src="' . $image['url'] . '"></div><div class="description"><a href="' . $link_url . '" target="' . $link_target . '"><div class="header text-20">' . $link_title . '</div><div class="content text-14">' . $description . '</a></div></div></div>';
                            }
                            $count++;
                          endwhile;
                        endif;
                        ?>
                      </div>
                      <div class="section">
                        <?php
                        $count = 0;
                        if (have_rows('solutions_nav', 'option')) :
                          while (have_rows('solutions_nav', 'option')) :
                            the_row();
                            if ($count >= 3 && $count < 6) {

                              $link = get_sub_field('nav_item');
                              $description = get_sub_field('description');

                              $link_url = $link['url'];
                              $link_title = $link['title'];
                              $link_target = $link['target'] ? $link['target'] : '_self';
                              echo '<div class="item"><a href="' . $link_url . '" target="' . $link_target . '"><div class="header text-20">' . $link_title . '</div><div class="content text-14">' . $description . '</a></div></div>';
                            }
                            $count++;
                          endwhile;
                        endif;
                        ?>
                      </div>
                      <div class="section">
                        <?php
                        $count = 0;
                        if (have_rows('solutions_nav', 'option')) :
                          while (have_rows('solutions_nav', 'option')) :
                            the_row();
                            if ($count >= 6 && $count < 8) {

                              $link = get_sub_field('nav_item');
                              $description = get_sub_field('description');

                              $link_url = $link['url'];
                              $link_title = $link['title'];
                              $link_target = $link['target'] ? $link['target'] : '_self';
                              echo '<div class="item"><a href="' . $link_url . '" target="' . $link_target . '"><div class="header text-20">' . $link_title . '</div><div class="content text-14">' . $description . '</a></div></div>';
                            }
                            $count++;
                          endwhile;
                        endif;
                        ?>
                        <div class="item">
                          <button class="text-17" onclick="window.location.href='/contact'">Questions? Contact Us.</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="menu-button">
                <div class="hover-container"></div>
                <div class="dropdown text-22">Network</div>
                <div class="dropdown-content">
                  <div class="chip"></div>
                  <div class="menu-content">
                    <div class="section-container">
                      <div class="section">
                        <?php
                        $count = 0;
                        if (have_rows('network_nav', 'option')) :
                          while (have_rows('network_nav', 'option')) :
                            the_row();
                            if ($count >= 0 && $count < 3) {

                              $link = get_sub_field('nav_item');
                              $image = get_sub_field('nav_icon');
                              $description = get_sub_field('description');

                              $link_url = $link['url'];
                              $link_title = $link['title'];
                              $link_target = $link['target'] ? $link['target'] : '_self';
                              echo '<div class="item"><div class="nav-image"><img src="' . $image['url'] . '"></div><div class="description"><a href="' . $link_url . '" target="' . $link_target . '"><div class="header text-20">' . $link_title . '</div><div class="content text-14">' . $description . '</a></div></div></div>';
                            }
                            $count++;
                          endwhile;
                        endif;
                        ?>
                      </div>
                      <div class="section">
                        <?php
                        $count = 0;
                        if (have_rows('network_nav', 'option')) :
                          while (have_rows('network_nav', 'option')) :
                            the_row();
                            if ($count >= 3 && $count < 6) {

                              $link = get_sub_field('nav_item');
                              $description = get_sub_field('description');

                              $link_url = $link['url'];
                              $link_title = $link['title'];
                              $link_target = $link['target'] ? $link['target'] : '_self';
                              echo '<div class="item"><a href="' . $link_url . '" target="' . $link_target . '"><div class="header text-20">' . $link_title . '</div><div class="content text-14">' . $description . '</a></div></div>';
                            }
                            $count++;
                          endwhile;
                        endif;
                        ?>
                      </div>
                      <div class="section">
                        <?php
                        $count = 0;
                        if (have_rows('network_nav', 'option')) :
                          while (have_rows('network_nav', 'option')) :
                            the_row();
                            if ($count >= 6 && $count < 7) {

                              $link = get_sub_field('nav_item');
                              $description = get_sub_field('description');

                              $link_url = $link['url'];
                              $link_title = $link['title'];
                              $link_target = $link['target'] ? $link['target'] : '_self';
                              echo '<div class="item"><a href="' . $link_url . '" target="' . $link_target . '"><div class="header text-20">' . $link_title . '</div><div class="content text-14">' . $description . '</a></div></div>';
                            }
                            $count++;
                          endwhile;
                        endif;
                        ?>
                        <div class="item">
                          <div class="header text-20">Regional Coverage Maps</div>
                          <select id="coverage-map-select" class="text-15 coverage-map-select">
                            <option disabled selected value="">Select a Region</option>
                            <?php if ($coverageMaps->have_posts()) :
                              while ($coverageMaps->have_posts()) :
                                $coverageMaps->the_post(); ?>
                                <option value="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></option>
                            <?php endwhile;
                              wp_reset_postdata();
                            endif; ?>
                          </select>
                        </div>
                        <div class="item">
                          <button class="text-17" onclick="window.location.href='/contact'">Questions? Contact Us.</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="menu-button">
                <div class="hover-container"></div>
                <div class="dropdown text-22">Company</div>
                <div class="dropdown-content">
                  <div class="chip"></div>
                  <div class="menu-content">
                    <div class="section-container">
                      <div class="section">
                        <?php
                        $count = 0;
                        if (have_rows('company_nav', 'option')) :
                          while (have_rows('company_nav', 'option')) :
                            the_row();
                            if ($count >= 0 && $count < 3) {

                              $link = get_sub_field('nav_item');
                              $image = get_sub_field('nav_icon');
                              $description = get_sub_field('description');

                              $link_url = $link['url'];
                              $link_title = $link['title'];
                              $link_target = $link['target'] ? $link['target'] : '_self';
                              echo '<div class="item"><div class="nav-image"><img src="' . $image['url'] . '"></div><div class="description"><a href="' . $link_url . '" target="' . $link_target . '"><div class="header text-20">' . $link_title . '</div><div class="content text-14">' . $description . '</a></div></div></div>';
                            }
                            $count++;
                          endwhile;
                        endif;
                        ?>
                      </div>
                      <div class="section">
                        <?php
                        $count = 0;
                        if (have_rows('company_nav', 'option')) :
                          while (have_rows('company_nav', 'option')) :
                            the_row();
                            if ($count >= 3 && $count < 6) {

                              $link = get_sub_field('nav_item');
                              $description = get_sub_field('description');

                              $link_url = $link['url'];
                              $link_title = $link['title'];
                              $link_target = $link['target'] ? $link['target'] : '_self';
                              echo '<div class="item"><a href="' . $link_url . '" target="' . $link_target . '"><div class="header text-20">' . $link_title . '</div><div class="content text-14">' . $description . '</a></div></div>';
                            }
                            $count++;
                          endwhile;
                        endif;
                        ?>
                      </div>
                      <div class="section">
                        <?php
                        $count = 0;
                        if (have_rows('company_nav', 'option')) :
                          while (have_rows('company_nav', 'option')) :
                            the_row();
                            if ($count >= 6 && $count < 8) {

                              $link = get_sub_field('nav_item');
                              $description = get_sub_field('description');

                              $link_url = $link['url'];
                              $link_title = $link['title'];
                              $link_target = $link['target'] ? $link['target'] : '_self';
                              echo '<div class="item"><a href="' . $link_url . '" target="' . $link_target . '"><div class="header text-20">' . $link_title . '</div><div class="content text-14">' . $description . '</a></div></div>';
                            }
                            $count++;
                          endwhile;
                        endif;
                        ?>
                        <div class="item">
                          <button class="text-17" onclick="window.location.href='/contact'">Questions? Contact Us.</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="action-button-group">
              <div class="action-button">
                <form role="search" method="get" id="header-search-form" action="<?php echo esc_url(home_url('/')); ?>" class="header-search-form input-group mb-3">
                  <div class="input-group">
                    <input type="search" class="form-control search-input" placeholder="Search" aria-label="search" name="s" id="search-input" value="<?php echo esc_attr(get_search_query()); ?>">
                  </div>
                </form>
                <button id="header-search-btn" class="header-search-btn" type="button" aria-label="Search the website" role="button"></button>
              </div>
              <div class="action-button">
                <a class="header-calc-btn" href="/savings-calculator">
                  <img src="/wp-content/themes/fiberlight_theme/dist/images/savings-calculator.svg" width="24px">
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </header>