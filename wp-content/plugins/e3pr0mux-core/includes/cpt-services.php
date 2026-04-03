<?php
defined( 'ABSPATH' ) || exit;

/* ── Register CPT: servizio ── */
add_action( 'init', function () {
    register_post_type( 'servizio', [
        'labels' => [
            'name'               => 'Servizi',
            'singular_name'      => 'Servizio',
            'add_new'            => 'Aggiungi servizio',
            'add_new_item'       => 'Nuovo servizio',
            'edit_item'          => 'Modifica servizio',
            'not_found'          => 'Nessun servizio trovato',
            'not_found_in_trash' => 'Nessun servizio nel cestino',
        ],
        'public'         => false,
        'show_ui'        => true,
        'show_in_menu'   => true,
        'has_archive'    => false,
        'supports'       => [ 'title', 'editor' ],
        'menu_icon'      => 'dashicons-admin-tools',
        'show_in_rest'   => true,
    ] );
} );

/* ── Meta box ── */
add_action( 'add_meta_boxes', function () {
    add_meta_box(
        'e3_service_details',
        'Dettagli Servizio',
        'e3_service_meta_cb',
        'servizio',
        'normal',
        'high'
    );
} );

function e3_service_meta_cb( $post ) {
    wp_nonce_field( 'e3_service_save', 'e3_service_nonce' );
    $num   = get_post_meta( $post->ID, '_e3_service_number', true );
    $order = get_post_meta( $post->ID, '_e3_service_order',  true );
    echo '<table class="e3-meta-table">';
    echo '<tr><th><label for="_e3_service_number">Numero display (es. 001)</label></th>';
    echo '<td><input type="text" id="_e3_service_number" name="_e3_service_number" value="' . esc_attr( $num ) . '"></td></tr>';
    echo '<tr><th><label for="_e3_service_order">Ordinamento</label></th>';
    echo '<td><input type="text" id="_e3_service_order" name="_e3_service_order" value="' . esc_attr( $order ) . '"></td></tr>';
    echo '</table>';
}

add_action( 'save_post_servizio', function ( $post_id ) {
    if (
        ! isset( $_POST['e3_service_nonce'] ) ||
        ! wp_verify_nonce( $_POST['e3_service_nonce'], 'e3_service_save' ) ||
        defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE
    ) return;

    foreach ( [ '_e3_service_number', '_e3_service_order' ] as $key ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_post_meta( $post_id, $key, sanitize_text_field( $_POST[ $key ] ) );
        }
    }
} );
