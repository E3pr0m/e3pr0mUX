<?php
/**
 * Plugin Name:  E3pr0mUX Core
 * Plugin URI:   https://e3pr0mux.local
 * Description:  Custom Post Types (Portfolio, Servizi) e shortcode per il tema E3pr0mUX.
 * Version:      1.0.0
 * Author:       E3pr0mUX
 * Text Domain:  e3pr0mux
 */

defined( 'ABSPATH' ) || exit;

define( 'E3_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'E3_CORE_URL',  plugin_dir_url( __FILE__ ) );

require_once E3_CORE_PATH . 'includes/cpt-portfolio.php';
require_once E3_CORE_PATH . 'includes/cpt-services.php';
require_once E3_CORE_PATH . 'includes/shortcodes.php';

/* Admin styles for meta boxes */
add_action( 'admin_head', function () {
    echo '<style>
        .e3-meta-table { width:100%; border-collapse:collapse; }
        .e3-meta-table th { text-align:left; padding:8px 12px 4px; font-size:12px; color:#646970; font-weight:600; text-transform:uppercase; letter-spacing:.08em; }
        .e3-meta-table td { padding:4px 12px 10px; }
        .e3-meta-table input[type=text], .e3-meta-table textarea { width:100%; border:1px solid #ddd; border-radius:3px; padding:6px 8px; font-size:13px; }
        .e3-meta-table textarea { min-height:80px; resize:vertical; }
    </style>';
} );
