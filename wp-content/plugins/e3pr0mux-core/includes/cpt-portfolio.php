<?php
defined( 'ABSPATH' ) || exit;

/* ── Register CPT: portfolio ── */
add_action( 'init', function () {
    register_post_type( 'portfolio', [
        'labels' => [
            'name'               => 'Portfolio',
            'singular_name'      => 'Progetto',
            'add_new'            => 'Aggiungi progetto',
            'add_new_item'       => 'Nuovo progetto',
            'edit_item'          => 'Modifica progetto',
            'new_item'           => 'Nuovo progetto',
            'view_item'          => 'Vedi progetto',
            'search_items'       => 'Cerca progetti',
            'not_found'          => 'Nessun progetto trovato',
            'not_found_in_trash' => 'Nessun progetto nel cestino',
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => [ 'slug' => 'portfolio' ],
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'menu_icon'          => 'dashicons-portfolio',
        'show_in_rest'       => true,
    ] );

    /* Taxonomy: tipo di progetto */
    register_taxonomy( 'tipo_progetto', 'portfolio', [
        'labels' => [
            'name'          => 'Tipologie',
            'singular_name' => 'Tipologia',
            'add_new_item'  => 'Nuova tipologia',
        ],
        'hierarchical'  => true,
        'public'        => true,
        'rewrite'       => [ 'slug' => 'tipo-progetto' ],
        'show_in_rest'  => true,
    ] );
} );

/* ── Meta box ── */
add_action( 'add_meta_boxes', function () {
    add_meta_box(
        'e3_portfolio_details',
        'Dettagli Progetto',
        'e3_portfolio_meta_cb',
        'portfolio',
        'normal',
        'high'
    );
} );

function e3_portfolio_meta_cb( $post ) {
    wp_nonce_field( 'e3_portfolio_save', 'e3_portfolio_nonce' );
    $fields = [
        '_e3_client'       => 'Cliente',
        '_e3_year'         => 'Anno',
        '_e3_url'          => 'URL progetto',
        '_e3_technologies' => 'Tecnologie (virgola separata)',
        '_e3_role'         => 'Ruolo',
    ];
    echo '<table class="e3-meta-table">';
    foreach ( $fields as $key => $label ) {
        $val = get_post_meta( $post->ID, $key, true );
        echo '<tr>';
        echo '<th><label for="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label></th>';
        echo '<td><input type="text" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '"></td>';
        echo '</tr>';
    }
    echo '</table>';
}

add_action( 'save_post_portfolio', function ( $post_id ) {
    if (
        ! isset( $_POST['e3_portfolio_nonce'] ) ||
        ! wp_verify_nonce( $_POST['e3_portfolio_nonce'], 'e3_portfolio_save' ) ||
        defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE
    ) return;

    $fields = [ '_e3_client', '_e3_year', '_e3_url', '_e3_technologies', '_e3_role' ];
    foreach ( $fields as $key ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_post_meta( $post_id, $key, sanitize_text_field( $_POST[ $key ] ) );
        }
    }
} );

/* ── Helper: get portfolio meta ── */
function e3_portfolio_meta( $post_id, $key ) {
    return get_post_meta( $post_id, $key, true );
}
