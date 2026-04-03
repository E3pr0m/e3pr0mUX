<?php get_header(); ?>

<section class="e3-archive-header">
  <p class="section-label">Blog</p>
  <h1 class="e3-archive-title">Articoli<span class="red">.</span></h1>
</section>

<div class="e3-blog-layout">
  <div class="e3-posts-grid">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <?php get_template_part( 'template-parts/content', 'post' ); ?>
    <?php endwhile;
    else : ?>
      <p class="e3-empty">Nessun articolo disponibile.</p>
    <?php endif; ?>
  </div>

  <aside class="e3-sidebar">
    <?php if ( is_active_sidebar( 'blog-sidebar' ) ) : ?>
      <?php dynamic_sidebar( 'blog-sidebar' ); ?>
    <?php endif; ?>
  </aside>
</div>

<div class="e3-pagination">
  <?php the_posts_pagination( [
    'prev_text' => '← Precedenti',
    'next_text' => 'Successivi →',
  ] ); ?>
</div>

<?php get_footer(); ?>
