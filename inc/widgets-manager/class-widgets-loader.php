<?php
/**
 * Widgets loader for Header Footer Elementor.
 */

namespace curlwareelements\WidgetsManager;
use Elementor\Plugin;
use Elementor\Utils;

defined( 'ABSPATH' ) or exit;

/**
 * Set up Widgets Loader class
 */
class Widgets_Loader {

	/**
	 * Instance of Widgets_Loader.
	 *
	 * @since  1.2.0
	 * @var null
	 */
	private static $_instance = null;

	/**
	 * Get instance of Widgets_Loader
	 *
	 * @since  1.2.0
	 * @return Widgets_Loader
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Setup actions and filters.
	 *
	 * @since  1.2.0
	 */
	private function __construct() {
		// Register category.
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_widget_category' ] );

		// Register widgets.
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Add svg support.
		add_filter( 'upload_mimes', [ $this, 'socoders_elements_svg_mime_types' ] );

		// Refresh the cart fragments.
		if ( class_exists( 'woocommerce' ) ) {

			add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'wc_refresh_mini_cart_count' ] );
		}
	}

	/**
	 * Returns Script array.
	 *
	 * @return array()
	 * @since 1.3.0
	 */
	public static function get_widget_script() {
		$js_files = [
			'sce-frontend-js' => [
				'path'      => 'inc/js/frontend.js',
				'dep'       => [ 'jquery' ],
				'in_footer' => true,
			],
		];

		return $js_files;
	}

	/**
	 * Returns Script array.
	 *
	 * @return array()
	 * @since 1.3.0
	 */
	public static function get_widget_list() {
		$widget_list = [
			'author-bio',
            'copyright',
            'accordion',
			'pricing-switcher',
            'newsletter',
            'video',
            'image',
            'heading',
			'navigation-menu',
			'menu-walker',
			'site-title',
			'page-title',
			'site-logo',
			'search-button',
			'header-button',
			'servicegrid',
			'counter',
			'feature-list',
			'team-slider',
			'teamgrid',
			'blog-slider',
			'project-slider',
			'project-grid',
			'blog-grid',
			'testimonial-slider',
			'brand-slider',
			'hero-slider',
			'price-table',
			'contact-form',
			'service-slider',
			'working-process',
			'offcanvas',
			'breadcrumb',
		];

		return $widget_list;
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function include_widgets_files() {
		$js_files    = $this->get_widget_script();
		$widget_list = $this->get_widget_list();

		if ( ! empty( $widget_list ) ) {
			foreach ( $widget_list as $handle => $data ) {
				require_once curlwareelements_DIR . '/inc/widgets-manager/widgets/class-' . $data . '.php';
			}
		}

		if ( ! empty( $js_files ) ) {
			foreach ( $js_files as $handle => $data ) {
				wp_register_script( $handle, curlwareelements_URL . $data['path'], $data['dep'], curlwareelements_VER, $data['in_footer'] );
			}
		}

		$tag_validation = [ 'article', 'aside', 'div', 'footer', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'header', 'main', 'nav', 'p', 'section', 'span' ];

		wp_localize_script(
			'elementor-editor',
			'HfeWidgetsData',
			[
				'allowed_tags' => $tag_validation,
			]
		);

		// Emqueue the widgets style.
		wp_enqueue_style( 'sce-widgets-style', curlwareelements_URL . 'inc/widgets-css/frontend.css', [], curlwareelements_VER );
	}

	/**
	 * Provide the SVG support for Retina Logo widget.
	 *
	 * @param array $mimes which return mime type.
	 *
	 * @since  1.2.0
	 * @return $mimes.
	 */
	public function socoders_elements_svg_mime_types( $mimes ) {
		// New allowed mime types.
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/**
	 * Register Category
	 *
	 * @since 1.2.0
	 * @param object $this_cat class.
	 */
	public function register_widget_category( $this_cat ) {
		$category = __( 'CurlWare Addons', 'CurlWare-header-footer-elementor' );

		$this_cat->add_category(
			'sce-widgets',
			[
				'title' => $category,
				'icon'  => 'eicon-font',
			]
		);

		return $this_cat;
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files.
		$this->include_widgets_files();
		// Register Widgets.
		$curlwareelements_addon_setting = get_option( 'curlwareelements_addon_option' );
		
		// My New One Authorbio
		if( isset( $curlwareelements_addon_setting['curlwareelements_SC_AuthorBiopic'] ) == 'curlwareelements_SC_AuthorBiopic' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\Author_Bio() );
		}

		if( isset( $curlwareelements_addon_setting['curlwareelements_copyright'] ) == 'curlwareelements_copyright' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\Copyright() );
		}
        if( isset( $curlwareelements_addon_setting['curlwareelements_video'] ) == 'curlwareelements_video' ) {
            Plugin::instance()->widgets_manager->register( new Widgets\Video() );
        }
        if( isset( $curlwareelements_addon_setting['curlwareelements_accordion'] ) == 'curlwareelements_accordion' ) {
            Plugin::instance()->widgets_manager->register( new Widgets\Accordion() );
        }
        if( isset( $curlwareelements_addon_setting['curlwareelements_pricing_switcher'] ) == 'curlwareelements_pricing_switcher' ) {
            Plugin::instance()->widgets_manager->register( new Widgets\Pricing_Switcher() );
        }
        if( isset( $curlwareelements_addon_setting['curlwareelements_newsletter'] ) == 'curlwareelements_newsletter' ) {
            Plugin::instance()->widgets_manager->register( new Widgets\Newsletter() );
        }
        if( isset( $curlwareelements_addon_setting['curlwareelements_image'] ) == 'curlwareelements_image' ) {
            Plugin::instance()->widgets_manager->register( new Widgets\Image() );
        }
        if( isset( $curlwareelements_addon_setting['curlwareelements_heading'] ) == 'curlwareelements_heading' ) {
            Plugin::instance()->widgets_manager->register( new Widgets\Heading() );
        }
		if( isset( $curlwareelements_addon_setting['curlwareelements_header_button'] ) == 'curlwareelements_header_button' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\Header_Button() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_navigation_menu'] ) == 'curlwareelements_navigation_menu' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\Navigation_Menu() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_site_logo'] ) == 'curlwareelements_site_logo' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\Page_Title() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_page_title'] ) == 'curlwareelements_page_title' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\Site_Logo() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_search'] ) == 'curlwareelements_search' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\Search_Button() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_service_grid'] ) == 'curlwareelements_service_grid' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\ServiceGrid() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_counter'] ) == 'curlwareelements_counter' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\scCounter() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_feature_list'] ) == 'curlwareelements_feature_list' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\FeatureList() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_teamslider'] ) == 'curlwareelements_teamslider' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\TeamSlider() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_teamslider'] ) == 'curlwareelements_teamslider' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\TeamSlider() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_contactform'] ) == 'curlwareelements_contactform' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\scContacForm() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_blogslider'] ) == 'curlwareelements_blogslider' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\BlogSlider() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_BlogGrid'] ) == 'curlwareelements_BlogGrid' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\BlogGrid() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_projectslider'] ) == 'curlwareelements_projectslider' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\ProjectSlider() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_testimonial'] ) == 'curlwareelements_testimonial' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\TestimonialSlider() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_brandslider'] ) == 'curlwareelements_brandslider' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\BrandSlider() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_pricetable'] ) == 'curlwareelements_pricetable' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\SC_PriceTable() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_heroslider'] ) == 'curlwareelements_pricetable' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\HeroSlider() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_service_slider'] ) == 'curlwareelements_service_slider' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\ServiceSlider() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_working_process'] ) == 'curlwareelements_working_process' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\WorkingProcess() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_sc_breadcrumb'] ) == 'curlwareelements_sc_breadcrumb' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\SC_Breadcrumb() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_ProjectGrid'] ) == 'curlwareelements_ProjectGrid' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\ProjectGrid() );
		}
		
		if( isset( $curlwareelements_addon_setting['curlwareelements_SCoffcanvas'] ) == 'curlwareelements_SCoffcanvas' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\SCoffcanvas() );
		}
		if( isset( $curlwareelements_addon_setting['curlwareelements_TeamGrid'] ) == 'curlwareelements_TeamGrid' ) {
			Plugin::instance()->widgets_manager->register( new Widgets\TeamGrid() );
		}
		

	}

	/**
	 * Cart Fragments.
	 *
	 * Refresh the cart fragments.
	 *
	 * @since 1.5.0
	 * @param array $fragments Array of fragments.
	 * @access public
	 */
	public function wc_refresh_mini_cart_count( $fragments ) {

		$has_cart = is_a( WC()->cart, 'WC_Cart' );

		if ( ! $has_cart ) {
			return $fragments;
		}

		$cart_badge_count = ( null !== WC()->cart ) ? WC()->cart->get_cart_contents_count() : '';

		if ( null !== WC()->cart ) {

			$fragments['span.sce-cart-count'] = '<span class="sce-cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';

			$fragments['span.elementor-button-text.sce-subtotal'] = '<span class="elementor-button-text sce-subtotal">' . WC()->cart->get_cart_subtotal() . '</span>';
		}

		$fragments['span.elementor-button-icon[data-counter]'] = '<span class="elementor-button-icon" data-counter="' . $cart_badge_count . '"><i class="eicon" aria-hidden="true"></i><span class="elementor-screen-only">' . __( 'Cart', 'CurlWare-header-footer-elementor' ) . '</span></span>';

		return $fragments;
	}

	/**
	 * Validate an HTML tag against a safe allowed list.
	 *
	 * @since 1.5.8
	 * @param string $tag specifies the HTML Tag.
	 * @access public
	 */
	public static function validate_html_tag( $tag ) {

		// Check if Elementor method exists, else we will run custom validation code.
		if ( method_exists( 'Elementor\Utils', 'validate_html_tag' ) ) {
			return Utils::validate_html_tag( $tag );
		} else {
			$allowed_tags = [ 'article', 'aside', 'div', 'footer', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'header', 'main', 'nav', 'p', 'section', 'span' ];
			return in_array( strtolower( $tag ), $allowed_tags ) ? $tag : 'div';
		}
	}
}

/**
 * Initiate the class.
 */
Widgets_Loader::instance();
