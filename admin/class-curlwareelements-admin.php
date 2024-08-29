<?php
use HFE\Lib\curlwareelements_Target_Rules_Fields;

defined( 'ABSPATH' ) or exit;

/**
 * socoders_elements_Admin setup
 *
 * @since 1.0.0
 */
class socoders_elements_Admin {

	/**
	 * Instance of socoders_elements_Admin
	 */
	private static $_instance = null;

    /**
	 * Declare the property
	 */
    public $curlwareelements_options;

	/**
	 * Instance of socoders_elements_Admin
	 */
	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		add_action( 'elementor/init', __CLASS__ . '::load_admin', 0 );

		return self::$_instance;
	}

	/**
	 * Load the icons style in editor.
	 *
	 * @since 1.3.0
	 */
	public static function load_admin() {
		add_action( 'elementor/editor/after_enqueue_styles', __CLASS__ . '::socoders_elements_admin_enqueue_scripts' );
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @since 1.3.0
	 * @param string $hook Current page hook.
	 * @access public
	 */
	public static function socoders_elements_admin_enqueue_scripts( $hook ) {

		// Register the icons styles.
		wp_register_style(
			'sce-style',
			curlwareelements_URL . 'assets/css/style.css',
			[],
			curlwareelements_VER
		);

		wp_enqueue_style( 'sce-style' );
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'init', [ $this, 'header_footer_posttype' ] );
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ], 50 );
		add_action( 'admin_enqueue_scripts', array( $this, 'curlwareelements_admin_scripts' ) );
		add_action( 'add_meta_boxes', [ $this, 'ehf_register_metabox' ] );
		add_action( 'save_post', [ $this, 'ehf_save_meta' ] );
		add_action( 'admin_notices', [ $this, 'location_notice' ] );
		add_action( 'template_redirect', [ $this, 'block_template_frontend' ] );
		add_filter( 'single_template', [ $this, 'load_canvas_template' ] );
		add_filter( 'manage_elementor-hf_posts_columns', [ $this, 'set_shortcode_columns' ] );
		add_action( 'manage_elementor-hf_posts_custom_column', [ $this, 'render_shortcode_column' ], 10, 2 );

		if ( is_admin() ) {
			add_action( 'manage_elementor-hf_posts_custom_column', [ $this, 'column_content' ], 10, 2 );
			add_filter( 'manage_elementor-hf_posts_columns', [ $this, 'column_headings' ] );
			require_once curlwareelements_DIR . 'admin/class-sce-addons-actions.php';
		}

		add_action( 'admin_init', array( $this, 'curlwareelements_page_init' ) );
	}

	/**
	 * Admin Style
	 */
	public function curlwareelements_admin_scripts(){
        wp_register_style('curlwareelements-admin-styles', curlwareelements_ASSETS_ADMIN . 'admin/assets/css/ehf-admin.css', array(), null );
        wp_enqueue_style('curlwareelements-admin-styles');
    }

	/**
	 * Adds or removes list table column headings.
	 *
	 * @param array $columns Array of columns.
	 * @return array
	 */
	public function column_headings( $columns ) {
		unset( $columns['date'] );

		$columns['elementor_hf_display_rules'] = __( 'Display Rules', 'curlware-elements' );
		$columns['date']                       = __( 'Date', 'curlware-elements' );

		return $columns;
	}

	/**
	 * Adds the custom list table column content.
	 *
	 * @param array $column Name of column.
	 * @param int   $post_id Post id.
	 * @return void
	 */
	public function column_content( $column, $post_id ) {

		if ( 'elementor_hf_display_rules' == $column ) {

			$locations = get_post_meta( $post_id, 'ehf_target_include_locations', true );
			if ( ! empty( $locations ) ) {
				echo '<div class="ast-advanced-headeCurlWare-location-wrap" style="margin-bottom: 5px;">';
				echo '<strong>Display: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			}

			$locations = get_post_meta( $post_id, 'ehf_target_exclude_locations', true );
			if ( ! empty( $locations ) ) {
				echo '<div class="ast-advanced-headeCurlWare-exclusion-wrap" style="margin-bottom: 5px;">';
				echo '<strong>Exclusion: </strong>';
				$this->column_display_location_rules( $locations );
				echo '</div>';
			}

			$users = get_post_meta( $post_id, 'ehf_target_user_roles', true );
			if ( isset( $users ) && is_array( $users ) ) {
				if ( isset( $users[0] ) && ! empty( $users[0] ) ) {
					$user_label = [];
					foreach ( $users as $user ) {
						$user_label[] = curlwareelements_Target_Rules_Fields::get_user_by_key( $user );
					}
					echo '<div class="ast-advanced-headeCurlWare-useCurlWare-wrap">';
					echo '<strong>Users: </strong>';
					echo join( ', ', $user_label );
					echo '</div>';
				}
			}
		}
	}

	/**
	 * Get Markup of Location rules for Display rule column.
	 *
	 * @param array $locations Array of locations.
	 * @return void
	 */
	public function column_display_location_rules( $locations ) {

		$location_label = [];
		$index          = array_search( 'specifics', $locations['rule'] );
		if ( false !== $index && ! empty( $index ) ) {
			unset( $locations['rule'][ $index ] );
		}

		if ( isset( $locations['rule'] ) && is_array( $locations['rule'] ) ) {
			foreach ( $locations['rule'] as $location ) {
				$location_label[] = curlwareelements_Target_Rules_Fields::get_location_by_key( $location );
			}
		}
		if ( isset( $locations['specific'] ) && is_array( $locations['specific'] ) ) {
			foreach ( $locations['specific'] as $location ) {
				$location_label[] = curlwareelements_Target_Rules_Fields::get_location_by_key( $location );
			}
		}

		echo join( ', ', $location_label );
	}


	/**
	 * Register Post type for Elementor Header & Footer Builder templates
	 */
	public function header_footer_posttype() {
		$labels = [
			'name'               => __( 'CurlWare Header & Footer Builder', 'curlware-elements' ),
			'singular_name'      => __( 'CurlWare Header & Footer Builder', 'curlware-elements' ),
			'menu_name'          => __( 'CurlWare Header & Footer Builder', 'curlware-elements' ),
			'name_admin_bar'     => __( 'CurlWare Header & Footer Builder', 'curlware-elements' ),
			'add_new'            => __( 'Add New', 'curlware-elements' ),
			'add_new_item'       => __( 'Add New Header or Footer', 'curlware-elements' ),
			'new_item'           => __( 'New Template', 'curlware-elements' ),
			'edit_item'          => __( 'Edit Template', 'curlware-elements' ),
			'view_item'          => __( 'View Template', 'curlware-elements' ),
			'all_items'          => __( 'All Templates', 'curlware-elements' ),
			'search_items'       => __( 'Search Templates', 'curlware-elements' ),
			'parent_item_colon'  => __( 'Parent Templates:', 'curlware-elements' ),
			'not_found'          => __( 'No Templates found.', 'curlware-elements' ),
			'not_found_in_trash' => __( 'No Templates found in Trash.', 'curlware-elements' ),
		];

		$args = [
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-editor-kitchensink',
			'supports'            => [ 'title', 'elementor' ],
		];
		register_post_type( 'elementor-hf', $args );
	}

	/**
	 * Register the admin menu
	 *
	 * @since  1.0.0
	 */
	public function register_admin_menu() {
		$parent_slug = 'elementor-hf';
        add_menu_page( 
            __( 'Custom Menu Title', 'curlware-elements' ),
            'CW Header Footer',
            'manage_options',
            $parent_slug,
            [$this, 'curlwareelements_addon_switcher'],
            'dashicons-welcome-widgets-menus',
            6
        );

		add_submenu_page(
			$parent_slug,
			__( 'CurlWare Header & Footer Builder', 'curlware-elements' ),
			__( 'All Header Footer', 'curlware-elements' ),
			// 'manage_options',
			'edit_pages',
			// $parent_slug,
			'edit.php?post_type=elementor-hf'
		);
	}

	function curlwareelements_addon_switcher(){
		$this->curlwareelements_options = get_option( 'curlwareelements_addon_option' );
        ?>
        <div class="wrap">
            <form class="cwelements-form" method="post" action="options.php">
                <?php
                settings_fields( 'curlwareelements_addon_group' );
                do_settings_sections( 'curlwareelements-addon-field' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
	}

	/**
	 * 
	 */
	public function curlwareelements_page_init(){
        register_setting(
            'curlwareelements_addon_group',
            'curlwareelements_addon_option',
            array( $this, 'CurlWareelements_sanitize' )
        );

        add_settings_section(
            'curlwareelements_section_field_id',
            esc_html__( 'Deactivate elements for better performance', 'curlware-elements' ),
            array( $this, 'CurlWareelements_section_info' ),
            'curlwareelements-addon-field',
        );
        /**
         * Author Bio Pic
         */
        add_settings_field(
            'curlwareelements_SC_AuthorBiopic',
            esc_html__( 'CurlWare Author Biopic', 'curlware-elements' ),
            array( $this, 'curlwareelements_SC_AuthorBiopic_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

        /**
         * Copyright
         */
        add_settings_field(
            'curlwareelements_copyright',
            esc_html__( 'CurlWare Copyright', 'curlware-elements' ),
            array( $this, 'curlwareelements_copyright_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );
        /**
         * Video
         */
        add_settings_field(
            'curlwareelements_video',
            esc_html__( 'CurlWare Video', 'curlware-elements' ),
            array( $this, 'curlwareelements_video_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );
        /**
         * Accordion
         */
        add_settings_field(
            'curlwareelements_accordion',
            esc_html__( 'CurlWare Accordion', 'curlware-elements' ),
            array( $this, 'curlwareelements_accordion_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

        /**
         * Pricing Switcher
         */
        add_settings_field(
            'curlwareelements_pricing_switcher',
            esc_html__( 'CurlWare Pricing Switcher', 'curlware-elements' ),
            array( $this, 'curlwareelements_pricing_switcher_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

        /**
         * Newsletter
         */
        add_settings_field(
            'curlwareelements_newsletter',
            esc_html__( 'CurlWare Newsletter', 'curlware-elements' ),
            array( $this, 'curlwareelements_newsletter_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

        /**
         * Image
         */
        add_settings_field(
            'curlwareelements_image',
            esc_html__( 'CurlWare Image', 'curlware-elements' ),
            array( $this, 'curlwareelements_image_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

        /**
         * Heading
         */
        add_settings_field(
            'curlwareelements_heading',
            esc_html__( 'CurlWare Heading', 'curlware-elements' ),
            array( $this, 'curlwareelements_heading_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Header Button
         */
        add_settings_field(
            'curlwareelements_header_button',
            esc_html__( 'CurlWare Header Button', 'curlware-elements' ),
            array( $this, 'curlwareelements_header_button_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Navigation Menu
         */
        add_settings_field(
            'curlwareelements_navigation_menu',
            esc_html__( 'CurlWare Navigation Menu', 'curlware-elements' ),
            array( $this, 'curlwareelements_navigation_menu_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Site Logo
         */
        add_settings_field(
            'curlwareelements_site_logo',
            esc_html__( 'CurlWare Site Logo', 'curlware-elements' ),
            array( $this, 'curlwareelements_site_logo_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Page Title
         */
        add_settings_field(
            'curlwareelements_page_title',
            esc_html__( 'CurlWare Page Title', 'curlware-elements' ),
            array( $this, 'curlwareelements_page_title_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Search
         */

        add_settings_field(
            'curlwareelements_search',
            esc_html__( 'CurlWare Search', 'curlware-elements' ),
            array( $this, 'curlwareelements_search_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Service Grid
         */

        add_settings_field(
            'curlwareelements_service_grid',
            esc_html__( 'CurlWare Service Grid', 'curlware-elements' ),
            array( $this, 'curlwareelements_service_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );


		/**
         * CurlWare Counter
         */

        add_settings_field(
            'curlwareelements_counter',
            esc_html__( 'CurlWare Counter', 'curlware-elements' ),
            array( $this, 'curlwareelements_counter_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		
		/**
         * Feature List
         */
        add_settings_field(
            'curlwareelements_feature_list',
            esc_html__( 'CurlWare Feature List', 'curlware-elements' ),
            array( $this, 'curlwareelements_feature_list_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Team Slider
         */

        add_settings_field(
            'curlwareelements_teamslider',
            esc_html__( 'CurlWare Team Slider', 'curlware-elements' ),
            array( $this, 'curlwareelements_teamslider_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Team Slider
         */

        add_settings_field(
            'curlwareelements_TeamGrid',
            esc_html__( 'CurlWare Team Grid', 'curlware-elements' ),
            array( $this, 'curlwareelements_TeamGrid_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Blog Slider
         */

        add_settings_field(
            'curlwareelements_blogslider',
            esc_html__( 'CurlWare Blog Slider', 'curlware-elements' ),
            array( $this, 'curlwareelements_blogslider_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Blog Grid
         */

        add_settings_field(
            'curlwareelements_BlogGrid',
            esc_html__( 'CurlWare Blog Grid', 'curlware-elements' ),
            array( $this, 'curlwareelements_BlogGrid_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );


		/**
         * CurlWare Contact Form
         */
        add_settings_field(
            'curlwareelements_contactform',
            esc_html__( 'CurlWare Contact Form', 'curlware-elements' ),
            array( $this, 'curlwareelements_contactform_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Project Slider
         */
        add_settings_field(
            'curlwareelements_projectslider',
            esc_html__( 'CurlWare Project Slider', 'curlware-elements' ),
            array( $this, 'curlwareelements_projectslider_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Project Slider
         */
        add_settings_field(
            'curlwareelements_testimonial',
            esc_html__( 'CurlWare Testimonials', 'curlware-elements' ),
            array( $this, 'curlwareelements_testimonial_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Project Slider
         */
        add_settings_field(
            'curlwareelements_brandslider',
            esc_html__( 'CurlWare Brand Slider', 'curlware-elements' ),
            array( $this, 'curlwareelements_brandslider_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );
		
		/**
         * CurlWare Price Table
         */
        add_settings_field(
            'curlwareelements_pricetable',
            esc_html__( 'CurlWare Price Table', 'curlware-elements' ),
            array( $this, 'curlwareelements_pricetable_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Price Table
         */
        add_settings_field(
            'curlwareelements_heroslider',
            esc_html__( 'CurlWare Hero Slider', 'curlware-elements' ),
            array( $this, 'curlwareelements_heroslider_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );
		
		/**
         * CurlWare Price Table
         */
        add_settings_field(
            'curlwareelements_SC_Accordion',
            esc_html__( 'CurlWare Accordion', 'curlware-elements' ),
            array( $this, 'curlwareelements_sc_accordion_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Price Table
         */
        add_settings_field(
            'curlwareelements_service_slider',
            esc_html__( 'CurlWare Service Slider', 'curlware-elements' ),
            array( $this, 'curlwareelements_service_slider_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Price Table
         */
        add_settings_field(
            'curlwareelements_working_process',
            esc_html__( 'CurlWare Working Process', 'curlware-elements' ),
            array( $this, 'curlwareelements_working_process_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Breadcrumb
         */
        add_settings_field(
            'curlwareelements_sc_breadcrumb',
            esc_html__( 'CurlWare Breadcrumb', 'curlware-elements' ),
            array( $this, 'curlwareelements_sc_breadcrumb_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Breadcrumb
         */
        add_settings_field(
            'curlwareelements_ProjectGrid',
            esc_html__( 'CurlWare Project Grid', 'curlware-elements' ),
            array( $this, 'curlwareelements_ProjectGrid_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );

		/**
         * CurlWare Breadcrumb
         */
        add_settings_field(
            'curlwareelements_SCoffcanvas',
            esc_html__( 'CurlWare Offcanvas Icon', 'curlware-elements' ),
            array( $this, 'curlwareelements_SCoffcanvas_block' ),
            'curlwareelements-addon-field',
            'curlwareelements_section_field_id',
            array( 'class' => 'CurlWareelements_addon_field' )
        );


	}
// -------- Register Function -----------
	/**
     * Print the Section text
     */
    public function CurlWareelements_section_info() {
        //print 'Enter your settings below:';
    }

    /**
     * Author Bio Pic
     */

    public function curlwareelements_SC_AuthorBiopic_block() {
        ?><div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_SC_AuthorBiopic]" id="curlwareelements_SC_AuthorBiopic" value="curlwareelements_SC_AuthorBiopic" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_SC_AuthorBiopic']) && $this->curlwareelements_options['curlwareelements_SC_AuthorBiopic'] ) == 'curlwareelements_SC_AuthorBiopic' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_SC_AuthorBiopic"></label>
        </div>
        <?php
    }

	/**
     * Copyright
     */
    public function curlwareelements_copyright_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_copyright]" id="curlwareelements_copyright" value="curlwareelements_copyright" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_copyright']) && $this->curlwareelements_options['curlwareelements_copyright'] ) == 'curlwareelements_copyright' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_copyright"></label>
        </div>
        <?php
    }

    /**
     * Pricing Switcher
     */
    public function curlwareelements_pricing_switcher_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_pricing_switcher]" id="curlwareelements_pricing_switcher" value="curlwareelements_pricing_switcher" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_pricing_switcher']) && $this->curlwareelements_options['curlwareelements_pricing_switcher'] ) == 'curlwareelements_pricing_switcher' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_pricing_switcher"></label>
        </div>
        <?php
    }

    /**
     * Video
     */
    public function curlwareelements_video_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_video]" id="curlwareelements_video" value="curlwareelements_video" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_video']) && $this->curlwareelements_options['curlwareelements_video'] ) == 'curlwareelements_video' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_video"></label>
        </div>
        <?php
    }

    /**
     * Accordion
    */
    public function curlwareelements_accordion_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_accordion]" id="curlwareelements_accordion" value="curlwareelements_accordion" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_accordion']) && $this->curlwareelements_options['curlwareelements_accordion'] ) == 'curlwareelements_accordion' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_accordion"></label>
        </div>
        <?php
    }


    /**
     * Newsletter
     */
    public function curlwareelements_newsletter_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_newsletter]" id="curlwareelements_newsletter" value="curlwareelements_newsletter" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_newsletter']) && $this->curlwareelements_options['curlwareelements_newsletter'] ) == 'curlwareelements_newsletter' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_newsletter"></label>
        </div>
        <?php
    }
    /**
     * Image
     */
    public function curlwareelements_image_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_image]" id="curlwareelements_image" value="curlwareelements_image" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_image']) && $this->curlwareelements_options['curlwareelements_image'] ) == 'curlwareelements_image' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_image"></label>
        </div>
        <?php
    }
    /**
     * Heading
     */
    public function curlwareelements_heading_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_heading]" id="curlwareelements_heading" value="curlwareelements_heading" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_heading']) && $this->curlwareelements_options['curlwareelements_heading'] ) == 'curlwareelements_heading' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_heading"></label>
        </div>
        <?php
    }

	/**
     * Header Button
     */
    public function curlwareelements_header_button_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_header_button]" id="curlwareelements_header_button" value="curlwareelements_header_button" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_header_button']) && $this->curlwareelements_options['curlwareelements_header_button'] ) == 'curlwareelements_header_button' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_header_button"></label>
        </div>
        <?php
    }

	/**
     * Navigation Menu
     */
    public function curlwareelements_navigation_menu_block() {
        ?>
        <div class="checkbox">
            <?php
			$this->curlwareelements_options = get_option('curlwareelements_addon_option');
			
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_navigation_menu]" id="curlwareelements_navigation_menu" value="curlwareelements_navigation_menu" %s/>',
			(isset( $this->curlwareelements_options['curlwareelements_site_logo']) && $this->curlwareelements_options['curlwareelements_navigation_menu'] ) == 'curlwareelements_navigation_menu' ? 'checked' : ''
		);
            ?>
            <label for="curlwareelements_navigation_menu"></label>
        </div>
        <?php
    }

	/**
     * Site Logo
     */
    public function curlwareelements_site_logo_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_site_logo]" id="curlwareelements_site_logo" value="curlwareelements_site_logo" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_site_logo']) && $this->curlwareelements_options['curlwareelements_site_logo'] ) == 'curlwareelements_site_logo' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_site_logo"></label>
        </div>
        <?php
    }

	/**
     * Page Title
     */
    public function curlwareelements_page_title_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_page_title]" id="curlwareelements_page_title" value="curlwareelements_page_title" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_page_title']) && $this->curlwareelements_options['curlwareelements_page_title'] ) == 'curlwareelements_page_title' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_page_title"></label>
        </div>
        <?php
    }

	/**
     * Search
     */
    public function curlwareelements_search_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_search]" id="curlwareelements_search" value="curlwareelements_search" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_search']) && $this->curlwareelements_options['curlwareelements_search'] ) == 'curlwareelements_search' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_search"></label>
        </div>
        <?php
    }

	/**
     * Service Grid
     */
    public function curlwareelements_service_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_service_grid]" id="curlwareelements_service_grid" value="curlwareelements_service_grid" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_service_grid']) && $this->curlwareelements_options['curlwareelements_service_grid'] ) == 'curlwareelements_service_grid' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_service_grid"></label>
        </div>
        <?php
    }

	/**
     * Curlware Counter
     */
    public function curlwareelements_counter_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_counter]" id="curlwareelements_counter" value="curlwareelements_counter" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_counter']) && $this->curlwareelements_options['curlwareelements_counter'] ) == 'curlwareelements_counter' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_counter"></label>
        </div>
        <?php
    }

	/**
     * Feature List
     */
    public function curlwareelements_feature_list_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_feature_list]" id="curlwareelements_feature_list" value="curlwareelements_feature_list" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_feature_list']) && $this->curlwareelements_options['curlwareelements_feature_list'] ) == 'curlwareelements_feature_list' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_feature_list"></label>
        </div>
        <?php
    }

	/**
     * Curlware Team Slider
     */
    public function curlwareelements_teamslider_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_teamslider]" id="curlwareelements_teamslider" value="curlwareelements_teamslider" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_teamslider']) && $this->curlwareelements_options['curlwareelements_teamslider'] ) == 'curlwareelements_teamslider' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_teamslider"></label>
        </div>
        <?php
    }

	/**
     * Curlware Team Slider
     */
    public function curlwareelements_TeamGrid_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_TeamGrid]" id="curlwareelements_TeamGrid" value="curlwareelements_TeamGrid" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_TeamGrid']) && $this->curlwareelements_options['curlwareelements_TeamGrid'] ) == 'curlwareelements_TeamGrid' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_TeamGrid"></label>
        </div>
        <?php
    }

	/**
     * Curlware Blog Slider
     */
    public function curlwareelements_blogslider_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_blogslider]" id="curlwareelements_blogslider" value="curlwareelements_blogslider" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_blogslider']) && $this->curlwareelements_options['curlwareelements_blogslider'] ) == 'curlwareelements_blogslider' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_blogslider"></label>
        </div>
        <?php
    }

	/**
     * Curlware Blog Grid
     */
    public function curlwareelements_BlogGrid_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_BlogGrid]" id="curlwareelements_BlogGrid" value="curlwareelements_BlogGrid" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_BlogGrid']) && $this->curlwareelements_options['curlwareelements_BlogGrid'] ) == 'curlwareelements_BlogGrid' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_BlogGrid"></label>
        </div>
        <?php
    }

	/**
     * Curlware Counter
     */
    public function curlwareelements_contactform_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_contactform]" id="curlwareelements_contactform" value="curlwareelements_contactform" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_contactform']) && $this->curlwareelements_options['curlwareelements_contactform'] ) == 'curlwareelements_teamslider' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_contactform"></label>
        </div>
        <?php
    }

	/**
     * Curlware Project Slider
     */
    public function curlwareelements_projectslider_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_projectslider]" id="curlwareelements_projectslider" value="curlwareelements_projectslider" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_projectslider']) && $this->curlwareelements_options['curlwareelements_projectslider'] ) == 'curlwareelements_teamslider' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_projectslider"></label>
        </div>
        <?php
    }
	
	/**
     * Curlware Testimonils
     */
    public function curlwareelements_testimonial_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_testimonial]" id="curlwareelements_testimonial" value="curlwareelements_testimonial" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_testimonial']) && $this->curlwareelements_options['curlwareelements_testimonial'] ) == 'curlwareelements_teamslider' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_testimonial"></label>
        </div>
        <?php
    }
	
	/**
     * Curlware Testimonils
     */
    public function curlwareelements_brandslider_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_brandslider]" id="curlwareelements_brandslider" value="curlwareelements_brandslider" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_brandslider']) && $this->curlwareelements_options['curlwareelements_brandslider'] ) == 'curlwareelements_teamslider' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_brandslider"></label>
        </div>
        <?php
    }
	
	/**
     * Curlware Price Table
     */
    public function curlwareelements_heroslider_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_heroslider]" id="curlwareelements_heroslider" value="curlwareelements_heroslider" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_heroslider']) && $this->curlwareelements_options['curlwareelements_heroslider'] ) == 'curlwareelements_teamslider' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_heroslider"></label>
        </div>
        <?php
    }

	/**
     * Curlware Price Table
     */
    public function curlwareelements_pricetable_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_pricetable]" id="curlwareelements_pricetable" value="curlwareelements_pricetable" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_pricetable']) && $this->curlwareelements_options['curlwareelements_pricetable'] ) == 'curlwareelements_teamslider' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_pricetable"></label>
        </div>
        <?php
    }

	/**
     * Curlware Price Table
     */
    public function curlwareelements_sc_accordion_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_SC_Accordion]" id="curlwareelements_SC_Accordion" value="curlwareelements_SC_Accordion" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_SC_Accordion']) && $this->curlwareelements_options['curlwareelements_SC_Accordion'] ) == 'curlwareelements_SC_Accordion' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_SC_Accordion"></label>
        </div>
        <?php
    }

	/**
     * Curlware Service Slider
     */
    public function curlwareelements_service_slider_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_service_slider]" id="curlwareelements_service_slider" value="curlwareelements_service_slider" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_service_slider']) && $this->curlwareelements_options['curlwareelements_service_slider'] ) == 'curlwareelements_service_slider' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_service_slider"></label>
        </div>
        <?php
    }

	

	/**
     * Curlware Service Slider
     */
    public function curlwareelements_working_process_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_working_process]" id="curlwareelements_working_process" value="curlwareelements_working_process" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_working_process']) && $this->curlwareelements_options['curlwareelements_working_process'] ) == 'curlwareelements_working_process' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_working_process"></label>
        </div>
        <?php
    }
	
	/**
     * Curlware Service Slider
     */
    public function curlwareelements_sc_breadcrumb_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_sc_breadcrumb]" id="curlwareelements_sc_breadcrumb" value="curlwareelements_sc_breadcrumb" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_sc_breadcrumb']) && $this->curlwareelements_options['curlwareelements_sc_breadcrumb'] ) == 'curlwareelements_sc_breadcrumb' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_sc_breadcrumb"></label>
        </div>
        <?php
    }
	
	/**
     * Curlware Project Grid
     */
    public function curlwareelements_ProjectGrid_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_ProjectGrid]" id="curlwareelements_ProjectGrid" value="curlwareelements_ProjectGrid" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_ProjectGrid']) && $this->curlwareelements_options['curlwareelements_ProjectGrid'] ) == 'curlwareelements_ProjectGrid' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_ProjectGrid"></label>
        </div>
        <?php
    }
	
	/**
     * Curlware Project Grid
     */
    public function curlwareelements_SCoffcanvas_block() {
        ?>
        <div class="checkbox">
            <?php
            printf('<input type="checkbox" name="curlwareelements_addon_option[curlwareelements_SCoffcanvas]" id="curlwareelements_SCoffcanvas" value="curlwareelements_SCoffcanvas" %s/>',
                (isset( $this->curlwareelements_options['curlwareelements_SCoffcanvas']) && $this->curlwareelements_options['curlwareelements_SCoffcanvas'] ) == 'curlwareelements_SCoffcanvas' ? 'checked' : ''
            );
            ?>
            <label for="curlwareelements_SCoffcanvas"></label>
        </div>
        <?php
    }




	/**
	 * Register meta box(es).
	 */
	function ehf_register_metabox() {
		add_meta_box(
			'ehf-meta-box',
			__( 'CurlWare Header & Footer Builder Options', 'curlware-elements' ),
			[
				$this,
				'efh_metabox_render',
			],
			'elementor-hf',
			'normal',
			'high'
		);
	}

	/**
	 * Render Meta field.
	 *
	 * @param  POST $post Currennt post object which is being displayed.
	 */
	function efh_metabox_render( $post ) {
		$values            = get_post_custom( $post->ID );
		$template_type     = isset( $values['ehf_template_type'] ) ? esc_attr( $values['ehf_template_type'][0] ) : '';
		$display_on_canvas = isset( $values['display-on-canvas-template'] ) ? true : false;

		// We'll use this nonce field later on when saving.
		wp_nonce_field( 'ehf_meta_nounce', 'ehf_meta_nounce' );
		?>
		<table class="sce-options-table widefat">
			<tbody>
				<tr class="sce-options-row type-of-template">
					<td class="sce-options-row-heading">
						<label for="ehf_template_type"><?php _e( 'Type of Template', 'curlware-elements' ); ?></label>
					</td>
					<td class="sce-options-row-content">
						<select name="ehf_template_type" id="ehf_template_type">
							<option value="" <?php selected( $template_type, '' ); ?>><?php _e( 'Select Option', 'curlware-elements' ); ?></option>
							<option value="type_header" <?php selected( $template_type, 'type_header' ); ?>><?php _e( 'Header', 'curlware-elements' ); ?></option>
							<option value="type_before_footer" <?php selected( $template_type, 'type_before_footer' ); ?>><?php _e( 'Before Footer', 'curlware-elements' ); ?></option>
							<option value="type_footer" <?php selected( $template_type, 'type_footer' ); ?>><?php _e( 'Footer', 'curlware-elements' ); ?></option>
                            <option value="type_sidebar_canvas" <?php selected( $template_type, 'type_sidebar_canvas' ); ?>><?php _e( 'Sidebar Offcanvas', 'curlware-elements' ); ?></option>
						</select>
					</td>
				</tr>

				<?php $this->display_rules_tab(); ?>
				<tr class="sce-options-row sce-shortcode">
					<td class="sce-options-row-heading">
						<label for="ehf_template_type"><?php _e( 'Shortcode', 'curlware-elements' ); ?></label>
						<i class="sce-options-row-heading-help dashicons dashicons-editor-help" title="<?php _e( 'Copy this shortcode and paste it into your post, page, or text widget content.', 'curlware-elements' ); ?>">
						</i>
					</td>
					<td class="sce-options-row-content">
						<span class="sce-shortcode-col-wrap">
							<input type="text" onfocus="this.select();" readonly="readonly" value="[curlwareelements_template id='<?php echo esc_attr( $post->ID ); ?>']" class="sce-large-text code">
						</span>
					</td>
				</tr>
				<tr class="sce-options-row enable-for-canvas">
					<td class="sce-options-row-heading">
						<label for="display-on-canvas-template">
							<?php _e( 'Enable Layout for Elementor Canvas Template?', 'curlware-elements' ); ?>
						</label>
						<i class="sce-options-row-heading-help dashicons dashicons-editor-help" title="<?php _e( 'Enabling this option will display this layout on pages using Elementor Canvas Template.', 'curlware-elements' ); ?>"></i>
					</td>
					<td class="sce-options-row-content">
						<input type="checkbox" id="display-on-canvas-template" name="display-on-canvas-template" value="1" <?php checked( $display_on_canvas, true ); ?> />
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Markup for Display Rules Tabs.
	 *
	 * @since  1.0.0
	 */
	public function display_rules_tab() {
		// Load Target Rule assets.
		curlwareelements_Target_Rules_Fields::get_instance()->admin_styles();

		$include_locations = get_post_meta( get_the_id(), 'ehf_target_include_locations', true );
		$exclude_locations = get_post_meta( get_the_id(), 'ehf_target_exclude_locations', true );
		$users             = get_post_meta( get_the_id(), 'ehf_target_user_roles', true );
		?>
		<tr class="bsf-target-rules-row sce-options-row">
			<td class="bsf-target-rules-row-heading sce-options-row-heading">
				<label><?php esc_html_e( 'Display On', 'curlware-elements' ); ?></label>
				<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help"
					title="<?php echo esc_attr__( 'Add locations for where this template should appear.', 'curlware-elements' ); ?>"></i>
			</td>
			<td class="bsf-target-rules-row-content sce-options-row-content">
				<?php
				curlwareelements_Target_Rules_Fields::target_rule_settings_field(
					'bsf-target-rules-location',
					[
						'title'          => __( 'Display Rules', 'curlware-elements' ),
						'value'          => '[{"type":"basic-global","specific":null}]',
						'tags'           => 'site,enable,target,pages',
						'rule_type'      => 'display',
						'add_rule_label' => __( 'Add Display Rule', 'curlware-elements' ),
					],
					$include_locations
				);
				?>
			</td>
		</tr>
		<tr class="bsf-target-rules-row sce-options-row">
			<td class="bsf-target-rules-row-heading sce-options-row-heading">
				<label><?php esc_html_e( 'Do Not Display On', 'curlware-elements' ); ?></label>
				<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help"
					title="<?php echo esc_attr__( 'Add locations for where this template should not appear.', 'curlware-elements' ); ?>"></i>
			</td>
			<td class="bsf-target-rules-row-content sce-options-row-content">
				<?php
				curlwareelements_Target_Rules_Fields::target_rule_settings_field(
					'bsf-target-rules-exclusion',
					[
						'title'          => __( 'Exclude On', 'curlware-elements' ),
						'value'          => '[]',
						'tags'           => 'site,enable,target,pages',
						'add_rule_label' => __( 'Add Exclusion Rule', 'curlware-elements' ),
						'rule_type'      => 'exclude',
					],
					$exclude_locations
				);
				?>
			</td>
		</tr>
		<tr class="bsf-target-rules-row sce-options-row">
			<td class="bsf-target-rules-row-heading sce-options-row-heading">
				<label><?php esc_html_e( 'User Roles', 'curlware-elements' ); ?></label>
				<i class="bsf-target-rules-heading-help dashicons dashicons-editor-help" title="<?php echo esc_attr__( 'Display custom template based on user role.', 'curlware-elements' ); ?>"></i>
			</td>
			<td class="bsf-target-rules-row-content sce-options-row-content">
				<?php
				curlwareelements_Target_Rules_Fields::target_user_role_settings_field(
					'bsf-target-rules-users',
					[
						'title'          => __( 'Users', 'curlware-elements' ),
						'value'          => '[]',
						'tags'           => 'site,enable,target,pages',
						'add_rule_label' => __( 'Add User Rule', 'curlware-elements' ),
					],
					$users
				);
				?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Save meta field.
	 *
	 * @param  POST $post_id Currennt post object which is being displayed.
	 *
	 * @return Void
	 */
	public function ehf_save_meta( $post_id ) {

		// Bail if we're doing an auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// if our nonce isn't there, or we can't verify it, bail.
		if ( ! isset( $_POST['ehf_meta_nounce'] ) || ! wp_verify_nonce( $_POST['ehf_meta_nounce'], 'ehf_meta_nounce' ) ) {
			return;
		}

		// if our current user can't edit this post, bail.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$target_locations = curlwareelements_Target_Rules_Fields::get_format_rule_value( $_POST, 'bsf-target-rules-location' );
		$target_exclusion = curlwareelements_Target_Rules_Fields::get_format_rule_value( $_POST, 'bsf-target-rules-exclusion' );
		$target_users     = [];

		if ( isset( $_POST['bsf-target-rules-users'] ) ) {
			$target_users = array_map( 'sanitize_text_field', $_POST['bsf-target-rules-users'] );
		}

		update_post_meta( $post_id, 'ehf_target_include_locations', $target_locations );
		update_post_meta( $post_id, 'ehf_target_exclude_locations', $target_exclusion );
		update_post_meta( $post_id, 'ehf_target_user_roles', $target_users );

		if ( isset( $_POST['ehf_template_type'] ) ) {
			update_post_meta( $post_id, 'ehf_template_type', esc_attr( $_POST['ehf_template_type'] ) );
		}

		if ( isset( $_POST['display-on-canvas-template'] ) ) {
			update_post_meta( $post_id, 'display-on-canvas-template', esc_attr( $_POST['display-on-canvas-template'] ) );
		} else {
			delete_post_meta( $post_id, 'display-on-canvas-template' );
		}
	}

	/**
	 * Display notice when editing the header or footer when there is one more of similar layout is active on the site.
	 *
	 * @since 1.0.0
	 */
	public function location_notice() {
		global $pagenow;
		global $post;

		if ( 'post.php' != $pagenow || ! is_object( $post ) || 'elementor-hf' != $post->post_type ) {
			return;
		}

		$template_type = get_post_meta( $post->ID, 'ehf_template_type', true );

		if ( '' !== $template_type ) {
			$templates = Header_Footer_Elementor::get_template_id( $template_type );

			// Check if more than one template is selected for current template type.
			if ( is_array( $templates ) && isset( $templates[1] ) && $post->ID != $templates[0] ) {
				$post_title        = '<strong>' . get_the_title( $templates[0] ) . '</strong>';
				$template_location = '<strong>' . $this->template_location( $template_type ) . '</strong>';
				/* Translators: Post title, Template Location */
				$message = sprintf( __( 'Template %1$s is already assigned to the location %2$s', 'curlware-elements' ), $post_title, $template_location );

				echo '<div class="error"><p>';
				echo $message;
				echo '</p></div>';
			}
		}
	}

	/**
	 * Convert the Template name to be added in the notice.
	 *
	 * @since  1.0.0
	 *
	 * @param  String $template_type Template type name.
	 *
	 * @return String $template_type Template type name.
	 */
	public function template_location( $template_type ) {
		$template_type = ucfirst( str_replace( 'type_', '', $template_type ) );

		return $template_type;
	}

	/**
	 * Don't display the elementor Elementor Header & Footer Builder templates on the frontend for non edit_posts capable users.
	 *
	 * @since  1.0.0
	 */
	public function block_template_frontend() {
		if ( is_singular( 'elementor-hf' ) && ! current_user_can( 'edit_posts' ) ) {
			wp_redirect( site_url(), 301 );
			die;
		}
	}

	/**
	 * Single template function which will choose our template
	 *
	 * @since  1.0.1
	 *
	 * @param  String $single_template Single template.
	 */
	function load_canvas_template( $single_template ) {
		global $post;

		if ( 'elementor-hf' == $post->post_type ) {
			$elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

			if ( file_exists( $elementor_2_0_canvas ) ) {
				return $elementor_2_0_canvas;
			} else {
				return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
			}
		}

		return $single_template;
	}

	/**
	 * Set shortcode column for template list.
	 *
	 * @param array $columns template list columns.
	 */
	function set_shortcode_columns( $columns ) {
		$date_column = $columns['date'];

		unset( $columns['date'] );

		$columns['shortcode'] = __( 'Shortcode', 'curlware-elements' );
		$columns['date']      = $date_column;

		return $columns;
	}

	/**
	 * Display shortcode in template list column.
	 *
	 * @param array $column template list column.
	 * @param int   $post_id post id.
	 */
	function render_shortcode_column( $column, $post_id ) {
		switch ( $column ) {
			case 'shortcode':
				ob_start();
				?>
				<span class="sce-shortcode-col-wrap">
					<input type="text" onfocus="this.select();" readonly="readonly" value="[curlwareelements_template id='<?php echo esc_attr( $post_id ); ?>']" class="sce-large-text code">
				</span>

				<?php

				ob_get_contents();
				break;
		}
	}
}

socoders_elements_Admin::instance();
