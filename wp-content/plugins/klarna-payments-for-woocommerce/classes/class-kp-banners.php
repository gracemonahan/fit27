<?php
/**
 * Adds the Klarna banner to WordPress Admin
 *
 * @package WC_Klarna_Payments/Classes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'KP_Banners' ) ) {
	/**
	 * Displays merchant information in the backend.
	 */
	class KP_Banners {
		/**
		 * WC_Klarna_Banners_KP constructor.
		 */
		public function __construct() {
			add_action( 'in_admin_header', array( $this, 'klarna_banner' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_css' ) );
			add_action( 'wp_ajax_hide_klarna_kp_banner', array( $this, 'hide_klarna_kp_banner' ) );
			add_action( 'wp_ajax_nopriv_hide_klarna_kp_banner', array( $this, 'hide_klarna_kp_banner' ) );
		}

		/**
		 * Loads admin CSS file, has to be done here instead of gateway class, because
		 * it is required in all admin pages.
		 */
		public function load_admin_css() {
			wp_enqueue_style(
				'klarna_payments_admin',
				plugins_url( 'assets/css/klarna-payments-admin.css?v=120320182111', WC_KLARNA_PAYMENTS_MAIN_FILE )
			);
		}

		/**
		 * Loads Klarna banner in admin pages.
		 */
		public function klarna_banner() {
			$kp_settings = get_option( 'woocommerce_klarna_payments_settings' );
			$show_banner = false;

			// Always show banner in testmode.
			if ( isset( $kp_settings['testmode'] ) && 'yes' === $kp_settings['testmode'] ) {
				$show_banner = true;
			}

			// Go through countries and check if at least one has credentials configured.
			$countries   = array( 'at', 'dk', 'fi', 'de', 'nl', 'no', 'se', 'gb', 'us' );
			$country_set = false;
			foreach ( $countries as $country ) {
				if ( '' !== $kp_settings[ 'merchant_id_' . $country ] && '' !== $kp_settings[ 'shared_secret_' . $country ] ) {
					$country_set = true;
				}
			}

			// Set args for the URL.
			$country        = wc_get_base_location()['country'];
			$plugin         = 'klarna-payments-for-woocommerce';
			$plugin_version = WC_KLARNA_PAYMENTS_VERSION;
			$wc_version     = defined( 'WC_VERSION' ) && WC_VERSION ? WC_VERSION : null;
			$url_queries    = '?country=' . $country . '&products=kp&plugin=' . $plugin . '&pluginVersion=' . $plugin_version . '&platform=woocommerce&platformVersion=' . $wc_version;

			if ( 'US' !== $country ) {
				$url_base = 'https://eu.portal.klarna.com/signup/';
			} else {
				$url_base = 'https://us.portal.klarna.com/signup/';
			}

			$url = $url_base . $url_queries;

			if ( ! $country_set ) {
				$show_banner = true;
			}

			if ( $show_banner && false === get_transient( 'klarna_kp_hide_banner' ) ) {
				?>
				<div id="kb-spacer"></div>
				<div id="klarna-kp-banner">
					<div id="kb-left">
						<h1>Go live</h1>
						<p>Before you can start to sell with Klarna you need your store to be approved by Klarna. When the installation is done and you are ready to go live, Klarna will need to verify the integration. Then you can go live with your store! If you wish to switch Klarna products then you’ll need the Klarna team to approve your store again.</p>
						<a class="kb-button"
						href="<?php echo esc_html( self::get_go_live_url() ); ?>"
						target="_blank">Go live with Klarna</a>
					</div>
					<div id="kb-right">
						<h1>Currently using Klarna?</h1>
						<p>Pay now, Pay later and Slice it. Klarna is entering a new world of smoooth. We would love for you to join us on the ride and to do so, you will need to upgrade your Klarna products to a new integration. You will then always get the latest features that Klarna develops and you’ll keep your current agreement along with your price settings.</p>
						<a class="kb-button"
						href="https://hello.klarna.com/product-upgrade?utm_source=woo-backend&utm_medium=referral&utm_campaign=woo&utm_content=banner"
						target="_blank">Upgrade your contract with Klarna</a>
					</div>
					<img id="kb-image"
						src="<?php echo esc_url( WC_KLARNA_PAYMENTS_PLUGIN_URL ); ?>/assets/img/klarna_logo_white.png"
						alt="Klarna logo" width="110"/>
						<span class="kb-kp-dismiss dashicons dashicons-dismiss"></span>
				</div>

				<script type="text/javascript">
					jQuery(document).ready(function($){

						jQuery('.kb-kp-dismiss').click(function(){
							jQuery('#klarna-kp-banner').slideUp();
							jQuery.post(
								ajaxurl,
								{
									action		: 'hide_klarna_kp_banner',
									_wpnonce	: '<?php echo wp_create_nonce( 'hide-klarna-kp-banner' ); // phpcs:ignore ?>',
								},
								function(response){
									console.log('Success hide kp banner');
								}
							);
						});
					});
					</script>
				<?php
			}
		}

		/**
		 * Adds sidebar to setting page settings.
		 *
		 * @param string $parent_options The parent options.
		 */
		public static function settings_sidebar( $parent_options ) {
			?>
			<img id="klarna-settings-logo" src="<?php echo esc_url( WC_KLARNA_PAYMENTS_PLUGIN_URL ); ?>/assets/img/klarna_logo_black.png" width="200" />

			<div id="klarna-wrapper">
				<div id="klarna-main">
					<?php echo $parent_options; // phpcs:ignore ?>
				</div>
				<div id="klarna-sidebar">
					<div class="kb-sidebar-section">
						<img src="<?php echo esc_url( WC_KLARNA_PAYMENTS_PLUGIN_URL ); ?>/assets/img/icon_reminder.png" width="64" />
						<h3>Go live</h3>
						<p>Before you can start to sell with Klarna you need your store to be approved by Klarna. When the installation is done and you are ready to go live, Klarna will need to verify the integration. Then you can go live with your store! If you wish to switch Klarna products then you’ll need the Klarna team to approve your store again.</p>
						<a class="kb-button" href="<?php echo esc_html( self::get_go_live_url() ); ?>" target="_blank">Go live with Klarna</a>
					</div>

					<div class="kb-sidebar-section">
						<div>
							<img src="<?php echo esc_url( WC_KLARNA_PAYMENTS_PLUGIN_URL ); ?>/assets/img/klarna_icons.png" width="192" />
						</div>
						<h3>Currently using Klarna?</h3>
						<p>Pay now, Pay later and Slice it. Klarna is entering a new world of smoooth. We would love for you to join us on the ride and to do so, you will need to upgrade your Klarna products to a new integration. You will then always get the latest features that Klarna develops and you’ll keep your current agreement along with your price settings.</p>
						<a class="kb-button" href="https://hello.klarna.com/product-upgrade?utm_source=woo-backend&utm_medium=referral&utm_campaign=woo&utm_content=kp" target="_blank">Upgrade you contract with Klarna</a>
					</div>
				</div>
			</div>

			<?php
		}

		/**
		 * Hide Klarna banner in admin pages for.
		 */
		public function hide_klarna_kp_banner() {
			set_transient( 'klarna_kp_hide_banner', '1', 6 * DAY_IN_SECONDS );
			wp_send_json_success( 'Hide Klarna Payment banner.' );
			wp_die();
		}

		/**
		 * Return correct Go live url depending on the store country.
		 */
		public static function get_go_live_url() {
			// Set args for the URL.
			$country        = wc_get_base_location()['country'];
			$plugin         = 'klarna-payments-for-woocommerce';
			$plugin_version = WC_KLARNA_PAYMENTS_VERSION;
			$wc_version     = defined( 'WC_VERSION' ) && WC_VERSION ? WC_VERSION : null;
			$url_queries    = '?country=' . $country . '&products=kp&plugin=' . $plugin . '&pluginVersion=' . $plugin_version . '&platform=woocommerce&platformVersion=' . $wc_version;

			if ( 'US' !== $country ) {
				$url_base = 'https://eu.portal.klarna.com/signup/';
				$url      = $url_base . $url_queries;
			} else {
				// $url_base = 'https://us.portal.klarna.com/signup/';
				$url = 'https://www.klarna.com/international/business/woocommerce/?utm_source=woo-backend&utm_medium=referral&utm_campaign=woo&utm_content=kp';
			}
			return $url;
		}
	}
}

new KP_Banners();
