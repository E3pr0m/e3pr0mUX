<article id="post-<?php the_ID(); ?>" <?php post_class( 'e3-post-card' ); ?>>
  <?php if ( has_post_thumbnail() ) : ?>
  <a href="<?php the_permalink(); ?>" class="e3-post-card__thumb">
    <?php the_post_thumbnail( 'large' ); ?>
  </a>
  <?php endif; ?>

  <div class="e3-post-card__body">
    <div class="e3-post-card__meta">
      <span class="e3-post-date"><?php echo get_the_date( 'd.m.Y' ); ?></span>
      <span class="e3-post-read"><?php echo e3_reading_time(); ?> min</span>
    </div>
    <h2 class="e3-post-card__title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
    <p class="e3-post-card__excerpt"><?php the_excerpt(); ?></p>
    <a href="<?php the_permalink(); ?>" class="e3-post-card__link">Leggi →</a>
  </div>
</article>
