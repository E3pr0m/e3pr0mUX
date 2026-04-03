<?php
/**
 * Template Name: Contatti
 */
get_header();
?>

<section class="e3-contact-page">
  <div class="e3-contact-page__bg-text">TALK</div>

  <div class="e3-contact-page__header">
    <p class="contact-eyebrow">// Hai un progetto?</p>
    <h1 class="contact-headline">
      <span class="outline">Costruiamo</span><br>
      Insieme<span class="red">.</span>
    </h1>
  </div>

  <div class="e3-contact-page__body">
    <div class="e3-contact-page__info">
      <?php the_content(); ?>
      <div class="e3-contact-links">
        <a href="mailto:<?php echo antispambot( get_option( 'admin_email' ) ); ?>" class="e3-contact-link">
          <span class="e3-contact-link__label">Email</span>
          <span class="e3-contact-link__value"><?php echo antispambot( get_option( 'admin_email' ) ); ?></span>
        </a>
      </div>
    </div>

    <div class="e3-contact-page__form">
      <?php echo do_shortcode( '[e3_contact_form]' ); ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
