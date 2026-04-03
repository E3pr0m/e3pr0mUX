<?php get_header(); ?>

<section class="e3-archive-header">
  <p class="section-label">
    <?php
    if ( is_category() )      echo 'Categoria';
    elseif ( is_tag() )       echo 'Tag';
    elseif ( is_author() )    echo 'Autore';
    elseif ( is_date() )      echo 'Archivio';
    else                      echo 'Blog';
    ?>
  </p>
  <h1 class="e3-archive-title">
    <?php
    if ( is_category() || is_tag() || is_author() ) echo single_term_title( '', false ) . '<span class="red">.</span>';
    elseif ( is_month() )  echo get_the_date( 'F Y' ) . '<span class="red">.</span>';
    else                   echo 'Archivio<span class="red">.</span>';
    ?>
  </h1>
</section>

<div class="e3-blog-layout">
  <div class="e3-posts-grid">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <?php get_template_part( 'template-parts/content', 'post' ); ?>
    <?php endwhile;
    else : ?>
      <p class="e3-empty">Nessun articolo trovato.</p>
    <?php endif; ?>
  </div>
  <aside class="e3-sidebar">
    <?php if ( is_active_sidebar( 'blog-sidebar' ) ) dynamic_sidebar( 'blog-sidebar' ); ?>
  </aside>
</div>

<div class="e3-pagination">
  <?php the_posts_pagination( [ 'prev_text' => '← Precedenti', 'next_text' => 'Successivi →' ] ); ?>
</div>

<?php get_footer(); ?>
