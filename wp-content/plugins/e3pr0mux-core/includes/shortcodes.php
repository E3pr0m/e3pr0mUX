<?php
defined( 'ABSPATH' ) || exit;

/* ─────────────────────────────────────────
   [e3_portfolio limit="6" category=""]
   ───────────────────────────────────────── */
add_shortcode( 'e3_portfolio', function ( $atts ) {
    $atts = shortcode_atts( [ 'limit' => 6, 'category' => '' ], $atts );

    $args = [
        'post_type'      => 'portfolio',
        'posts_per_page' => intval( $atts['limit'] ),
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    if ( ! empty( $atts['category'] ) ) {
        $args['tax_query'] = [ [
            'taxonomy' => 'tipo_progetto',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $atts['category'] ),
        ] ];
    }

    $query = new WP_Query( $args );
    if ( ! $query->have_posts() ) return '<p class="e3-empty">Nessun progetto disponibile.</p>';

    ob_start();
    echo '<div class="e3-portfolio-grid">';
    $i = 1;
    while ( $query->have_posts() ) {
        $query->the_post();
        $cat   = wp_get_post_terms( get_the_ID(), 'tipo_progetto' );
        $label = ! empty( $cat ) ? esc_html( $cat[0]->name ) : 'Progetto';
        $img   = get_the_post_thumbnail_url( get_the_ID(), 'large' );
        $style = $img ? 'style="background-image:url(' . esc_url( $img ) . ')"' : '';
        ?>
        <article class="e3-portfolio-item e3-portfolio-item--<?php echo $i; ?>" <?php echo $style; ?>>
            <div class="e3-portfolio-overlay">
                <span class="e3-portfolio-cat"><?php echo $label; ?></span>
                <h3 class="e3-portfolio-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            </div>
        </article>
        <?php
        $i++;
    }
    echo '</div>';
    wp_reset_postdata();
    return ob_get_clean();
} );

/* ─────────────────────────────────────────
   [e3_services]
   ───────────────────────────────────────── */
add_shortcode( 'e3_services', function () {
    $query = new WP_Query( [
        'post_type'      => 'servizio',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => '_e3_service_order',
        'order'          => 'ASC',
    ] );

    if ( ! $query->have_posts() ) return '<p class="e3-empty">Nessun servizio disponibile.</p>';

    ob_start();
    echo '<div class="e3-services-grid">';
    while ( $query->have_posts() ) {
        $query->the_post();
        $num = get_post_meta( get_the_ID(), '_e3_service_number', true ) ?: '—';
        ?>
        <div class="service-item">
            <p class="service-num">— <?php echo esc_html( $num ); ?></p>
            <h3 class="service-name"><?php the_title(); ?></h3>
            <div class="service-desc"><?php echo wp_kses_post( get_the_content() ); ?></div>
        </div>
        <?php
    }
    echo '</div>';
    wp_reset_postdata();
    return ob_get_clean();
} );

/* ─────────────────────────────────────────
   [e3_contact_form]
   ───────────────────────────────────────── */
add_shortcode( 'e3_contact_form', function () {
    $sent  = false;
    $error = '';

    if ( isset( $_POST['e3_contact_submit'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'e3_contact_form' ) ) {
        $name    = sanitize_text_field( $_POST['e3_name']    ?? '' );
        $email   = sanitize_email( $_POST['e3_email']        ?? '' );
        $message = sanitize_textarea_field( $_POST['e3_message'] ?? '' );

        if ( ! $name || ! is_email( $email ) || ! $message ) {
            $error = 'Compila tutti i campi correttamente.';
        } else {
            $to      = get_option( 'admin_email' );
            $subject = '[E3pr0mUX] Nuovo messaggio da ' . $name;
            $body    = "Nome: $name\nEmail: $email\n\nMessaggio:\n$message";
            $headers = [ 'Content-Type: text/plain; charset=UTF-8', "Reply-To: $email" ];
            wp_mail( $to, $subject, $body, $headers );
            $sent = true;
        }
    }

    ob_start();
    if ( $sent ) {
        echo '<div class="e3-form-success"><span>✦</span> Messaggio ricevuto. Ti rispondo presto.</div>';
    } else {
        if ( $error ) echo '<div class="e3-form-error">' . esc_html( $error ) . '</div>';
        ?>
        <form class="e3-contact-form" method="POST">
            <?php wp_nonce_field( 'e3_contact_form' ); ?>
            <div class="e3-field">
                <label for="e3_name">Nome</label>
                <input type="text" id="e3_name" name="e3_name" placeholder="Il tuo nome" required value="<?php echo esc_attr( $_POST['e3_name'] ?? '' ); ?>">
            </div>
            <div class="e3-field">
                <label for="e3_email">Email</label>
                <input type="email" id="e3_email" name="e3_email" placeholder="tua@email.it" required value="<?php echo esc_attr( $_POST['e3_email'] ?? '' ); ?>">
            </div>
            <div class="e3-field e3-field--full">
                <label for="e3_message">Messaggio</label>
                <textarea id="e3_message" name="e3_message" placeholder="Descrivi il tuo progetto..." required><?php echo esc_textarea( $_POST['e3_message'] ?? '' ); ?></textarea>
            </div>
            <button type="submit" name="e3_contact_submit" class="e3-submit">Invia messaggio</button>
        </form>
        <?php
    }
    return ob_get_clean();
} );

/* ─────────────────────────────────────────
   [e3_marquee text="..."]
   ───────────────────────────────────────── */
add_shortcode( 'e3_marquee', function ( $atts ) {
    $atts = shortcode_atts( [ 'text' => 'E3pr0mUX ✦ UX Design ✦ Frontend Dev ✦ Interaction Design ✦' ], $atts );
    $text = esc_html( $atts['text'] );
    return '<div class="marquee-wrap"><div class="marquee-track">'
        . '<span>' . $text . '</span><span>' . $text . '</span>'
        . '</div></div>';
} );
