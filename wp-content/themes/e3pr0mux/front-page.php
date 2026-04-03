<?php get_header(); ?>

<!-- HERO -->
<section class="hero" id="hero">
  <canvas id="e3-shader-canvas" aria-hidden="true"></canvas>
  <div class="hero-accent-line"></div>
  <p class="hero-tag">// UX Engineering Studio — EST. <?php echo date('Y'); ?></p>
  <h1 class="hero-title">
    <span class="line" id="hero-word"><?php bloginfo( 'name' ); ?></span>
  </h1>
  <div class="hero-bottom">
    <p class="hero-desc">
      <strong>Interfacce che non si dimenticano.</strong><br>
      Design brutale. Codice pulito.<br>
      Esperienza ingegnerizzata al millimetro.
    </p>
    <div class="scroll-hint">scroll</div>
  </div>
</section>

<!-- MARQUEE -->
<div class="marquee-wrap">
  <div class="marquee-track">
    <span>UX Design</span><span class="dot">✦</span>
    <span>UI Engineering</span><span class="dot">✦</span>
    <span>Interaction Design</span><span class="dot">✦</span>
    <span>Prototyping</span><span class="dot">✦</span>
    <span>Frontend Dev</span><span class="dot">✦</span>
    <span>Design Systems</span><span class="dot">✦</span>
    <span>User Research</span><span class="dot">✦</span>
    <span>Motion Design</span><span class="dot">✦</span>
    <span>UX Design</span><span class="dot">✦</span>
    <span>UI Engineering</span><span class="dot">✦</span>
    <span>Interaction Design</span><span class="dot">✦</span>
    <span>Prototyping</span><span class="dot">✦</span>
    <span>Frontend Dev</span><span class="dot">✦</span>
    <span>Design Systems</span><span class="dot">✦</span>
    <span>User Research</span><span class="dot">✦</span>
    <span>Motion Design</span><span class="dot">✦</span>
  </div>
</div>

<!-- MANIFESTO -->
<section class="e3-manifesto" id="manifesto">
  <p class="section-label">01 / Manifesto</p>
  <div class="manifesto-stack">
    <div class="manifesto-line"><span class="inner">Non<span class="red"> design</span>iamo.</span></div>
    <div class="manifesto-line"><span class="inner">Ingegner<span class="red">izziamo</span></span></div>
    <div class="manifesto-line"><span class="inner">Esperienza<span class="red">.</span></span></div>
  </div>
</section>

<!-- SERVICES (CPT) -->
<?php
$services = new WP_Query( [
    'post_type'      => 'servizio',
    'posts_per_page' => -1,
    'orderby'        => 'meta_value_num',
    'meta_key'       => '_e3_service_order',
    'order'          => 'ASC',
] );
if ( $services->have_posts() ) : ?>
<section class="e3-services" id="services">
  <p class="section-label">02 / Servizi</p>
  <div class="services-grid">
    <?php while ( $services->have_posts() ) : $services->the_post();
      $num = get_post_meta( get_the_ID(), '_e3_service_number', true ) ?: '0' . $services->current_post + 1;
    ?>
    <div class="service-item">
      <p class="service-num">— <?php echo esc_html( $num ); ?></p>
      <h3 class="service-name"><?php the_title(); ?></h3>
      <div class="service-desc"><?php echo wp_kses_post( get_the_content() ); ?></div>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>
</section>
<?php endif; ?>

<!-- PORTFOLIO (CPT) -->
<?php
$portfolio = new WP_Query( [
    'post_type'      => 'portfolio',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC',
] );
if ( $portfolio->have_posts() ) : ?>
<section class="e3-work" id="work">
  <p class="section-label">03 / Lavori</p>
  <div class="work-grid">
    <?php $idx = 1; while ( $portfolio->have_posts() ) : $portfolio->the_post();
      $img = get_the_post_thumbnail_url( get_the_ID(), 'portfolio-thumb' );
      $cat = wp_get_post_terms( get_the_ID(), 'tipo_progetto' );
      $cat_label = ! empty( $cat ) ? esc_html( $cat[0]->name ) : 'Progetto';
      $bg_style  = $img ? 'background-image:url(' . esc_url( $img ) . ')' : '';
    ?>
    <article class="work-item" style="<?php echo $bg_style; ?>">
      <div class="work-placeholder">
        <p class="work-placeholder-text"><?php printf( '%02d', $idx ); ?></p>
      </div>
      <a href="<?php the_permalink(); ?>" class="work-overlay">
        <div class="work-info">
          <p class="work-cat"><?php echo $cat_label; ?></p>
          <p class="work-title-card"><?php the_title(); ?></p>
        </div>
      </a>
    </article>
    <?php $idx++; endwhile; wp_reset_postdata(); ?>
  </div>
  <div class="e3-work__cta">
    <a href="<?php echo esc_url( home_url( '/portfolio' ) ); ?>" class="e3-btn-outline">Tutti i progetti →</a>
  </div>
</section>
<?php endif; ?>

<!-- ABOUT -->
<section class="e3-about" id="about">
  <div class="about-statement">
    <div>NOI</div>
    <div class="outline">PENSIAMO</div>
    <div>IN<span class="red"> UX</span></div>
  </div>
  <div class="about-text">
    <?php
    $about_page = get_page_by_path( 'about' );
    if ( $about_page ) {
        echo '<p>' . wp_kses_post( $about_page->post_content ) . '</p>';
    } else { ?>
    <p>
      <strong>E3pr0mUX è uno studio ibrido</strong> tra design e ingegneria.
      Progettiamo interfacce digitali che funzionano — non solo visivamente,
      ma nei flussi, nelle emozioni, nella logica.
    </p>
    <p>
      Ogni pixel ha un perché. Ogni interazione ha una ragione.
      Lavoriamo su prodotti che devono <strong>durare e scalare</strong>.
    </p>
    <?php } ?>
    <div class="about-stats">
      <div>
        <div class="stat-num">100%</div>
        <div class="stat-label">Custom — niente template</div>
      </div>
      <div>
        <div class="stat-num">0px</div>
        <div class="stat-label">Di padding sprecato</div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section class="e3-contact-section" id="contact">
  <div class="bg-text">TALK</div>
  <p class="contact-eyebrow">// Hai un progetto?</p>
  <h2 class="contact-headline">
    <span class="outline">Costruiamo</span><br>
    Insieme<span class="red">.</span>
  </h2>
  <?php
  $contact_page = get_page_by_path( 'contatti' );
  if ( $contact_page ) {
      echo '<a href="' . esc_url( get_permalink( $contact_page ) ) . '" class="contact-cta">Scrivici ora</a>';
  } else {
      echo '<a href="mailto:' . antispambot( get_option( 'admin_email' ) ) . '" class="contact-cta">Scrivici ora</a>';
  }
  ?>
</section>

<?php get_footer(); ?>
