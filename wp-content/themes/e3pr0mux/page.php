<?php get_header(); while ( have_posts() ) : the_post(); ?>

<article class="e3-page" id="post-<?php the_ID(); ?>">
  <header class="e3-page__header">
    <p class="section-label">Pagina</p>
    <h1 class="e3-page__title"><?php the_title(); ?><span class="red">.</span></h1>
  </header>
  <div class="e3-page__content e3-prose">
    <?php the_content(); ?>
  </div>
</article>

<?php endwhile; get_footer(); ?>
