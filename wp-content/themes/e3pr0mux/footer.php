</main><!-- #e3-main -->

<footer class="e3-footer">
  <div class="e3-footer__inner">
    <div class="e3-footer__brand">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="e3-nav__logo">
        E<span>3</span>pr<span>0</span>mUX
      </a>
      <p class="e3-footer__tagline">We Engineer Experience.</p>
    </div>

    <div class="e3-footer__nav">
      <?php
      wp_nav_menu( [
        'theme_location' => 'footer',
        'container'      => false,
        'menu_class'     => 'e3-footer__list',
        'fallback_cb'    => function () {
            echo '<ul class="e3-footer__list">';
            echo '<li><a href="' . esc_url( home_url( '/portfolio' ) ) . '">Portfolio</a></li>';
            echo '<li><a href="' . esc_url( home_url( '/blog' ) ) . '">Blog</a></li>';
            echo '<li><a href="' . esc_url( home_url( '/#contact' ) ) . '">Contatti</a></li>';
            echo '</ul>';
        },
      ] );
      ?>
    </div>

    <div class="e3-footer__contact">
      <a href="mailto:<?php echo antispambot( get_option( 'admin_email' ) ); ?>" class="e3-footer__email">
        <?php echo antispambot( get_option( 'admin_email' ) ); ?>
      </a>
    </div>
  </div>

  <div class="e3-footer__bottom">
    <span>© <?php echo date( 'Y' ); ?> E<span class="red">3</span>pr<span class="red">0</span>mUX</span>
    <span>Made with <span class="red">✦</span> brutalism &amp; precision</span>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
