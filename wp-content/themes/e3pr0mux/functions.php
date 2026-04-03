<?php
/**
 * E3pr0mUX — functions.php
 */
defined( 'ABSPATH' ) || exit;

define( 'E3_THEME_VER', '1.0.0' );
define( 'E3_THEME_URI', get_template_directory_uri() );

/* ── Theme setup ── */
add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ] );

    register_nav_menus( [
        'primary' => 'Menu principale',
        'footer'  => 'Menu footer',
    ] );

    /* Thumbnail sizes */
    add_image_size( 'portfolio-thumb', 800, 600, true );
    add_image_size( 'portfolio-full',  1600, 1000, true );
} );

/* ── Enqueue ── */
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'e3-fonts',
        'https://fonts.googleapis.com/css2?family=Unbounded:wght@900&family=Syne+Mono&family=Syne:wght@400;700;800&display=swap',
        [],
        null
    );
    wp_enqueue_style( 'e3-main', E3_THEME_URI . '/assets/css/main.css', [ 'e3-fonts' ], E3_THEME_VER );
    wp_enqueue_script( 'e3-main',   E3_THEME_URI . '/assets/js/main.js',         [], E3_THEME_VER, true );
    wp_enqueue_script( 'e3-shader', E3_THEME_URI . '/assets/js/hero-shader.js', [], E3_THEME_VER, true );

    if ( is_singular() && comments_open() ) {
        wp_enqueue_script( 'comment-reply' );
    }
} );

/* ── Remove WP bloat ── */
add_action( 'init', function () {
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
} );

/* ── Sidebar ── */
add_action( 'widgets_init', function () {
    register_sidebar( [
        'name'          => 'Sidebar Blog',
        'id'            => 'blog-sidebar',
        'before_widget' => '<div class="e3-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="e3-widget-title">',
        'after_title'   => '</h4>',
    ] );
} );

/* ── Excerpt length ── */
add_filter( 'excerpt_length', fn() => 20 );
add_filter( 'excerpt_more',   fn() => '...' );

/* ── Custom page title ── */
add_filter( 'document_title_separator', fn() => '—' );

/* ── Helpers ── */
function e3_posted_on() {
    printf(
        '<span class="e3-post-date">%s</span>',
        esc_html( get_the_date( 'd.m.Y' ) )
    );
}

function e3_reading_time( $post_id = null ) {
    $content = get_post_field( 'post_content', $post_id ?? get_the_ID() );
    $words   = str_word_count( strip_tags( $content ) );
    return max( 1, round( $words / 200 ) );
}
