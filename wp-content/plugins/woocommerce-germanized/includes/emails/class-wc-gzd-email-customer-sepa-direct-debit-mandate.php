<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'WC_GZD_Email_Customer_SEPA_Direct_Debit_Mandate' ) ) :

	/**
	 * Direct debit mandate email
	 *
	 * Email is being sent directly after the order to inform the customer about the SEPA mandate.
	 *
	 * @class        WC_GZD_Email_Customer_Revocation
	 * @version        1.0.0
	 * @author        Vendidero
	 */
	class WC_GZD_Email_Customer_SEPA_Direct_Debit_Mandate extends WC_Email {

		public $gateway = null;

		/**
		 * Constructor
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
			$this->id          = 'customer_sepa_direct_debit_mandate';
			$this->title       = __( 'SEPA Direct Debit Mandate', 'woocommerce-germanized' );
			$this->description = __( 'Email contains a copy of the SEPA mandate generated by information provided by the customer.', 'woocommerce-germanized' );

			$this->template_html  = 'emails/customer-sepa-direct-debit-mandate.php';
			$this->template_plain = 'emails/plain/customer-sepa-direct-debit-mandate.php';

			if ( property_exists( $this, 'placeholders' ) ) {
				$this->placeholders = array(
					'{site_title}'   => $this->get_blogname(),
					'{order_number}' => '',
					'{order_date}'   => '',
				);
			}

			// Call parent constuctor
			parent::__construct();

			$this->customer_email = true;
		}

		/**
		 * Get email subject.
		 *
		 * @return string
		 * @since  3.1.0
		 */
		public function get_default_subject() {
			return __( 'SEPA Direct Debit Mandate', 'woocommerce-germanized' );
		}

		/**
		 * Get email heading.
		 *
		 * @return string
		 * @since  3.1.0
		 */
		public function get_default_heading() {
			return __( 'SEPA Direct Debit Mandate', 'woocommerce-germanized' );
		}

		/**
		 * trigger function.
		 *
		 * @access public
		 * @return void
		 */
		public function trigger( $order ) {
			if ( is_callable( array( $this, 'setup_locale' ) ) ) {
				$this->setup_locale();
			}

			if ( ! is_object( $order ) ) {
				$order = wc_get_order( absint( $order ) );
			}

			if ( $order ) {
				$this->object  = $order;
				$gateways      = WC()->payment_gateways()->payment_gateways();
				$this->gateway = $gateways['direct-debit'];

				$this->recipient = $this->object->get_billing_email();

				if ( property_exists( $this, 'placeholders' ) ) {
					$this->placeholders['{order_date}']   = wc_gzd_get_order_date( $this->object, wc_date_format() );
					$this->placeholders['{order_number}'] = $this->object->get_order_number();
				} else {
					$this->find['order-date']      = '{order_date}';
					$this->find['order-number']    = '{order_number}';
					$this->replace['order-date']   = wc_gzd_get_order_date( $this->object, wc_date_format() );
					$this->replace['order-number'] = $this->object->get_order_number();
				}
			}

			if ( $this->is_enabled() && $this->get_recipient() ) {
				$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
			}

			if ( is_callable( array( $this, 'restore_locale' ) ) ) {
				$this->restore_locale();
			}
		}

		/**
		 * Return content from the additional_content field.
		 *
		 * Displayed above the footer.
		 *
		 * @since 3.0.4
		 * @return string
		 */
		public function get_additional_content() {
			if ( is_callable( 'parent::get_additional_content' ) ) {
				return parent::get_additional_content();
			}

			return '';
		}

		/**
		 * get_content_html function.
		 *
		 * @access public
		 * @return string
		 */
		public function get_content_html() {
			return wc_get_template_html( $this->template_html, array(
				'order'              => $this->object,
				'gateway'            => $this->gateway,
				'email_heading'      => $this->get_heading(),
				'blogname'           => $this->get_blogname(),
				'additional_content' => $this->get_additional_content(),
				'sent_to_admin'      => false,
				'plain_text'         => false,
				'email'              => $this
			) );
		}

		/**
		 * get_content_plain function.
		 *
		 * @access public
		 * @return string
		 */
		public function get_content_plain() {
			return wc_get_template_html( $this->template_plain, array(
				'order'              => $this->object,
				'gateway'            => $this->gateway,
				'email_heading'      => $this->get_heading(),
				'blogname'           => $this->get_blogname(),
				'additional_content' => $this->get_additional_content(),
				'sent_to_admin'      => false,
				'plain_text'         => true,
				'email'              => $this
			) );
		}
	}

endif;

return new WC_GZD_Email_Customer_SEPA_Direct_Debit_Mandate();
