<?php get_header(); while ( have_posts() ) : the_post();
  $client = get_post_meta( get_the_ID(), '_e3_client',       true );
  $year   = get_post_meta( get_the_ID(), '_e3_year',         true );
  $url    = get_post_meta( get_the_ID(), '_e3_url',          true );
  $techs  = get_post_meta( get_the_ID(), '_e3_technologies', true );
  $role   = get_post_meta( get_the_ID(), '_e3_role',         true );
  $cats   = wp_get_post_terms( get_the_ID(), 'tipo_progetto' );
  $label  = ! empty( $cats ) ? esc_html( $cats[0]->name ) : 'Progetto';
?>

<article class="e3-single-portfolio">

  <!-- HERO del progetto -->
  <header class="e3-portfolio-hero" <?php if ( has_post_thumbnail() ) echo 'style="background-image:url(' . esc_url( get_the_post_thumbnail_url( get_the_ID(), 'portfolio-full' ) ) . ')"'; ?>>
    <div class="e3-portfolio-hero__overlay"></div>
    <div class="e3-portfolio-hero__content">
      <p class="e3-portfolio-hero__cat"><?php echo $label; ?></p>
      <h1 class="e3-portfolio-hero__title"><?php the_title(); ?></h1>
    </div>
  </header>

  <!-- Meta sidebar + content -->
  <div class="e3-portfolio-body">

    <aside class="e3-portfolio-meta">
      <?php if ( $client ) : ?>
      <div class="e3-portfolio-meta__item">
        <span class="e3-portfolio-meta__label">Cliente</span>
        <span class="e3-portfolio-meta__value"><?php echo esc_html( $client ); ?></span>
      </div>
      <?php endif; ?>
      <?php if ( $year ) : ?>
      <div class="e3-portfolio-meta__item">
        <span class="e3-portfolio-meta__label">Anno</span>
        <span class="e3-portfolio-meta__value"><?php echo esc_html( $year ); ?></span>
      </div>
      <?php endif; ?>
      <?php if ( $role ) : ?>
      <div class="e3-portfolio-meta__item">
        <span class="e3-portfolio-meta__label">Ruolo</span>
        <span class="e3-portfolio-meta__value"><?php echo esc_html( $role ); ?></span>
      </div>
      <?php endif; ?>
      <?php if ( $techs ) : ?>
      <div class="e3-portfolio-meta__item">
        <span class="e3-portfolio-meta__label">Tecnologie</span>
        <div class="e3-tech-tags">
          <?php foreach ( explode( ',', $techs ) as $t ) : ?>
          <span class="e3-tag"><?php echo esc_html( trim( $t ) ); ?></span>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
      <?php if ( $url ) : ?>
      <div class="e3-portfolio-meta__item">
        <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" class="e3-btn-outline e3-portfolio-meta__cta">
          Vedi progetto →
        </a>
      </div>
      <?php endif; ?>
    </aside>

    <div class="e3-portfolio-content e3-prose">
      <?php the_content(); ?>
    </div>

  </div><!-- .e3-portfolio-body -->

  <!-- Navigazione tra progetti -->
  <nav class="e3-portfolio-nav">
    <?php
    $prev = get_previous_post( false, '', 'tipo_progetto' );
    $next = get_next_post( false, '', 'tipo_progetto' );
    if ( $prev ) : ?>
    <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="e3-portfolio-nav__link e3-portfolio-nav__link--prev">
      <span class="e3-portfolio-nav__dir">← Precedente</span>
      <span class="e3-portfolio-nav__name"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
    </a>
    <?php endif; ?>
    <a href="<?php echo esc_url( home_url( '/portfolio' ) ); ?>" class="e3-portfolio-nav__all">Tutti i lavori</a>
    <?php if ( $next ) : ?>
    <a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="e3-portfolio-nav__link e3-portfolio-nav__link--next">
      <span class="e3-portfolio-nav__dir">Successivo →</span>
      <span class="e3-portfolio-nav__name"><?php echo esc_html( get_the_title( $next ) ); ?></span>
    </a>
    <?php endif; ?>
  </nav>

</article>

<?php endwhile; get_footer(); ?>
