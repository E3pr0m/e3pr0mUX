<?php get_header(); ?>

<section class="e3-archive-header">
  <p class="section-label">03 / Portfolio</p>
  <h1 class="e3-archive-title">Lavori<span class="red">.</span></h1>

  <?php
  /* Filtro per tipo_progetto */
  $types = get_terms( [ 'taxonomy' => 'tipo_progetto', 'hide_empty' => true ] );
  if ( ! empty( $types ) && ! is_wp_error( $types ) ) :
  ?>
  <div class="e3-portfolio-filters">
    <button class="e3-filter-btn is-active" data-filter="*">Tutti</button>
    <?php foreach ( $types as $type ) : ?>
    <button class="e3-filter-btn" data-filter="<?php echo esc_attr( $type->slug ); ?>">
      <?php echo esc_html( $type->name ); ?>
    </button>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>

<div class="e3-portfolio-archive-grid" id="e3-portfolio-grid">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
    $img   = get_the_post_thumbnail_url( get_the_ID(), 'portfolio-thumb' );
    $cats  = wp_get_post_terms( get_the_ID(), 'tipo_progetto' );
    $slugs = ! empty( $cats ) ? implode( ' ', array_column( $cats, 'slug' ) ) : '';
    $label = ! empty( $cats ) ? esc_html( $cats[0]->name ) : 'Progetto';
    $year  = get_post_meta( get_the_ID(), '_e3_year', true );
  ?>
  <article class="e3-portfolio-archive-item <?php echo esc_attr( $slugs ); ?>"
           data-cats="<?php echo esc_attr( $slugs ); ?>">
    <a href="<?php the_permalink(); ?>" class="e3-portfolio-archive-item__inner">
      <div class="e3-portfolio-archive-item__img"
           style="<?php echo $img ? 'background-image:url(' . esc_url( $img ) . ')' : ''; ?>">
        <span class="e3-portfolio-archive-item__num">
          <?php printf( '%02d', $wp_query->current_post + 1 ); ?>
        </span>
      </div>
      <div class="e3-portfolio-archive-item__info">
        <span class="e3-portfolio-archive-item__cat"><?php echo $label; ?></span>
        <h2 class="e3-portfolio-archive-item__title"><?php the_title(); ?></h2>
        <?php if ( $year ) echo '<span class="e3-portfolio-archive-item__year">' . esc_html( $year ) . '</span>'; ?>
      </div>
    </a>
  </article>
  <?php endwhile;
  else : ?>
    <p class="e3-empty">Nessun progetto disponibile.</p>
  <?php endif; ?>
</div>

<div class="e3-pagination">
  <?php the_posts_pagination( [ 'prev_text' => '← Precedenti', 'next_text' => 'Successivi →' ] ); ?>
</div>

<?php get_footer(); ?>
