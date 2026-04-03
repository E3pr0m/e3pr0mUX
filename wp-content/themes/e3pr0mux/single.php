<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'e3-single-post' ); ?>>

  <header class="e3-single-post__header">
    <div class="e3-single-post__meta">
      <span class="e3-post-date"><?php echo get_the_date( 'd.m.Y' ); ?></span>
      <span class="e3-post-read"><?php echo e3_reading_time(); ?> min read</span>
      <?php
      $cats = get_the_category();
      if ( $cats ) echo '<span class="e3-post-cat">' . esc_html( $cats[0]->name ) . '</span>';
      ?>
    </div>
    <h1 class="e3-single-post__title"><?php the_title(); ?></h1>
  </header>

  <?php if ( has_post_thumbnail() ) : ?>
  <div class="e3-single-post__cover">
    <?php the_post_thumbnail( 'portfolio-full' ); ?>
  </div>
  <?php endif; ?>

  <div class="e3-single-post__content e3-prose">
    <?php the_content(); ?>
  </div>

  <footer class="e3-single-post__footer">
    <?php
    $tags = get_the_tags();
    if ( $tags ) {
        echo '<div class="e3-post-tags">';
        foreach ( $tags as $tag ) {
            echo '<a href="' . esc_url( get_tag_link( $tag ) ) . '" class="e3-tag">' . esc_html( $tag->name ) . '</a>';
        }
        echo '</div>';
    }
    ?>
    <nav class="e3-post-nav">
      <?php
      $prev = get_previous_post();
      $next = get_next_post();
      if ( $prev ) echo '<a href="' . esc_url( get_permalink( $prev ) ) . '" class="e3-post-nav__link e3-post-nav__link--prev">← ' . esc_html( get_the_title( $prev ) ) . '</a>';
      if ( $next ) echo '<a href="' . esc_url( get_permalink( $next ) ) . '" class="e3-post-nav__link e3-post-nav__link--next">' . esc_html( get_the_title( $next ) ) . ' →</a>';
      ?>
    </nav>
  </footer>

</article>

<?php endwhile; ?>

<?php get_footer(); ?>
