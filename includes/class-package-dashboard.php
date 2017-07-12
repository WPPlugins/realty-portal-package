<?php
/**
 * RP_Package_Config_Dashboard_Setting Class
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'RP_Package_Config_Dashboard_Setting' ) ) :

	class RP_Package_Config_Dashboard_Setting {

		/**
		 *    Initialize class
		 */
		public function __construct() {
			add_filter( 'RP_Tab_Setting/Config', 'RP_Package_Config_Dashboard_Setting::setting_agent', 15 );
			add_action( 'RP_Tab_Setting_Content/Config_After', 'RP_Package_Config_Dashboard_Setting::form_setting', 25 );
			add_filter( 'rp_agent_form_setting', 'RP_Package_Config_Dashboard_Setting::form_setting_agent' );
		}

		/**
		 * Show html setting agent
		 *
		 * @param $list_tab
		 *
		 * @return array
		 */
		public static function setting_agent( $list_tab ) {

			$list_tab[] = array(
				'name'     => esc_html__( 'Payment', 'realty-portal-package' ),
				'id'       => 'tab-setting-payment',
				'position' => 30,
			);

			return $list_tab;
		}

		/**
		 * Show form setting
		 */
		public static function form_setting() {
			$field = array();
			if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

				$field[] = array(
					'title'   => esc_html__( 'Select type of payment', 'realty-portal-package' ),
					'name'    => 'payment_type',
					'type'    => 'radio',
					'std'     => 'paypal',
					'options' => array(
						'paypal'      => esc_html__( 'PayPal', 'realty-portal-package' ),
						'woocommerce' => esc_html__( 'WooCommerce', 'realty-portal-package' ),
					),
					'class'   => 'box-payment-type',
				);
			}

			$field[] = array(
				'title' => esc_html__( 'PayPal Merchant Account (ID or Email)', 'realty-portal-package' ),
				'name'  => 'merchant_account',
				'type'  => 'text',
				'class' => 'payment_type type_paypal',
			);

			$field[] = array(
				'title' => esc_html__( 'Enable PayPal Sandbox Testing', 'realty-portal-package' ),
				'name'  => 'enable_sandbox',
				'type'  => 'checkbox',
				'std'   => '1',
				'class' => 'payment_type type_paypal',
			);

			$field[] = array(
				'title' => esc_html__( 'Disable SSL secure connection (Not recommended)', 'realty-portal-package' ),
				'name'  => 'disable_ssl',
				'type'  => 'checkbox',
				'class' => 'payment_type type_paypal',
			);

			$field[] = array(
				'title' => esc_html__( 'Email for sending payment notification', 'realty-portal-package' ),
				'name'  => 'notify_email',
				'type'  => 'text',
				'class' => 'payment_type type_paypal',
			);

			rp_render_form_setting( array(
				'title'   => esc_html__( 'Payment Setting', 'realty-portal-package' ),
				'name'    => 'payment_setting',
				'id_form' => 'tab-setting-payment',
				'fields'  => $field,
			) );
		}

		public static function form_setting_agent( $list_form ) {
			$list_form_new = array(
				array(
					'name' => 'agent_linebreak',
					'type' => 'line',
				),
				array(
					'title'   => esc_html__( 'Membership Type', 'addon-agent' ),
					'name'    => 'membership_type',
					'type'    => 'radio',
					'std'     => 'free',
					'options' => array(
						'none'       => esc_html__( 'No Membership (Agents created by Admin can still submit Property)', 'addon-agent' ),
						'free'       => esc_html__( 'Free for all Users', 'addon-agent' ),
						'membership' => esc_html__( 'Membership Packages', 'addon-agent' ),
						'submission' => esc_html__( 'Pay per Submission', 'addon-agent' ),
					),
					'class'   => 'box-membership-type',
				),
				array(
					'title'  => esc_html__( 'Number of Expire Days', 'addon-agent' ),
					'name'   => 'per_listing_expire',
					'type'   => 'text',
					'std'    => 30,
					'notice' => esc_html__( 'No of days until a listings will expire. Starts from the moment the property is published on the website', 'addon-agent' ),
				),
				array(
					'title' => esc_html__( 'Enable Freemium Membership', 'addon-agent' ),
					'name'  => 'membership_free',
					'type'  => 'checkbox',
					'class' => ' type_membership box-free-membership',
				),
				array(
					'title' => esc_html__( 'Number of Free Properties', 'addon-agent' ),
					'name'  => 'membership_freemium_properties_num',
					'type'  => 'text',
					'class' => 'membership_type membership_free',
					'std'   => '6',
				),
				array(
					'title' => esc_html__( 'Number of Free Featured Properties', 'addon-agent' ),
					'name'  => 'membership_freemium_featured_num',
					'type'  => 'text',
					'class' => 'membership_type membership_free',
					'std'   => '0',
				),
				array(
					'title' => esc_html__( 'Price per Submission', 'addon-agent' ),
					'name'  => 'membership_submission_listing_price',
					'type'  => 'text',
					'class' => 'membership_type type_submission',
				),
				array(
					'title' => esc_html__( 'Price for Featured Property', 'addon-agent' ),
					'name'  => 'membership_submission_featured_price',
					'type'  => 'text',
					'class' => 'membership_type type_submission',
				),
				array(
					'title' => esc_html__( 'Membership listing page (Page with pricing table)', 'addon-agent' ),
					'name'  => 'membership_page',
					'type'  => 'pages',
					'class' => 'membership_type type_membership',
				),
				array(
					'title'   => esc_html__( 'Submitted Properties need approve from admin?', 'addon-agent' ),
					'name'    => 'admin_approve',
					'type'    => 'radio',
					'std'     => 'add',
					'options' => array(
						'all'  => esc_html__( 'Yes, all newly added and edited properties', 'addon-agent' ),
						'add'  => esc_html__( 'Yes, but only newly submitted properties', 'addon-agent' ),
						'none' => esc_html__( 'Don\'t need Admin approval', 'addon-agent' ),
					),
					'class'   => 'membership_type type_free type_membership type_submission',
				),
			);

			return array_merge( $list_form, $list_form_new );
		}

	}

	new RP_Package_Config_Dashboard_Setting();

endif;