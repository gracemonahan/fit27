<?php
/**
 * Admin View: Notice - Theme supported
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$dismiss_url = add_query_arg( 'notice', 'wc-gzd-hide-theme-notice', add_query_arg( 'nonce', wp_create_nonce( 'wc-gzd-hide-theme-notice' ) ) );
?>

<div class="error fade">
    <h3><?php printf( __( 'Enable full %s support', 'woocommerce-germanized' ), $current_theme->get( 'Name' ) ); ?></h3>
    <p><?php printf( __( 'Your current theme %s needs some adaptions to seamlessly integrate with Germanized. Our Pro Version will <strong>enable support for %s</strong> and makes sure Germanized settings are shown and styled within frontend for a better user experience. A better user experience will help you selling more products.', 'woocommerce-germanized' ), $current_theme->get( 'Name' ), $current_theme->get( 'Name' ) ); ?></p>
    <p class="alignleft wc-gzd-button-wrapper">
        <a class="button button-primary" href="https://vendidero.de/woocommerce-germanized#upgrade"
           target="_blank"><?php printf( __( 'Enable support for %s', 'woocommerce-germanized' ), $current_theme->get( 'Name' ) ); ?></a>
    </p>
    <p class="alignright">
        <a href="<?php echo esc_url( $dismiss_url ); ?>"><?php _e( 'Hide this notice', 'woocommerce-germanized' ); ?></a>
    </p>
    <div class="clear"></div>
</div>