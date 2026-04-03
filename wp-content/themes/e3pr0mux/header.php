<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="cursor"></div>

<nav class="e3-nav" id="e3-nav">
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="e3-nav__logo">
    E<span>3</span>pr<span>0</span>mUX
  </a>

  <button class="e3-nav__burger" id="e3-burger" aria-label="Menu" aria-expanded="false">
    <span></span><span></span>
  </button>

  <?php
  wp_nav_menu( [
    'theme_location' => 'primary',
    'container'      => 'div',
    'container_class'=> 'e3-nav__menu',
    'menu_class'     => 'e3-nav__list',
    'fallback_cb'    => function () {
        echo '<div class="e3-nav__menu"><ul class="e3-nav__list">';
        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
        echo '<li><a href="' . esc_url( home_url( '/portfolio' ) ) . '">Portfolio</a></li>';
        echo '<li><a href="' . esc_url( home_url( '/blog' ) ) . '">Blog</a></li>';
        echo '</ul></div>';
    },
  ] );
  ?>

  <a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="e3-nav__cta">Inizia un progetto</a>
</nav>

<main class="e3-main" id="e3-main">
