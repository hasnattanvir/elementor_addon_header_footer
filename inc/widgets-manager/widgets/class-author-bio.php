<?php
namespace curlwareelements\WidgetsManager\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use curlwareelements\WidgetsManager\Widgets_Loader;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

class Author_Bio extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'author-bio';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'CW NEW Author Bio', 'curlware-header-footer-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-elementor-circle';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'sce-widgets' ];
	}

	/**
	 * Register Page Title controls.
	 */
	protected function register_controls() {
		$this->register_content_page_title_controls();
		$this->register_page_title_style_controls();
	}

	/**
	 * Register Page Title General Controls.
	 */
	protected function register_content_page_title_controls() {
		$this->start_controls_section(
			'section_general_fields',
			[
				'label' => __( 'Title', 'curlware-header-footer-elementor' ),
			]
		);

		$this->add_control(
			'archive_title_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				/* translators: %1$s doc link */
				'raw'             => sprintf( __( '<b>Note:</b> Archive page title will be visible on frontend.', 'curlware-header-footer-elementor' ) ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);

		//
		$this->add_control(
			'custom_page',
			[
				'label' => esc_html__( 'Custom Page Title', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
			]
		);
		$this->add_control(
			'custom_page_title',
			[
				'label' => esc_html__( 'Title', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Default title', 'curlware-header-footer-elementor' ),
				'condition' => [
					'custom_page' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => __( 'HTML Tag', 'curlware-header-footer-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'curlware-header-footer-elementor' ),
					'h2' => __( 'H2', 'curlware-header-footer-elementor' ),
					'h3' => __( 'H3', 'curlware-header-footer-elementor' ),
					'h4' => __( 'H4', 'curlware-header-footer-elementor' ),
					'h5' => __( 'H5', 'curlware-header-footer-elementor' ),
					'h6' => __( 'H6', 'curlware-header-footer-elementor' ),
				],
				'default' => 'h2',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'              => __( 'Alignment', 'curlware-header-footer-elementor' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => [
					'left'    => [
						'title' => __( 'Left', 'curlware-header-footer-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'curlware-header-footer-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'curlware-header-footer-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'curlware-header-footer-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'            => '',
				'selectors'          => [
					'{{WRAPPER}} .sce-page-title-wrapper' => 'text-align: {{VALUE}};',
				],
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();
	}
	/**
	 * Register Page Title Style Controls.
	 */
	protected function register_page_title_style_controls() {
		$this->start_controls_section(
			'section____general',
			[
				'label' => __( 'General', 'curlware-header-footer-elementor' ),
			]
		);
		$this->add_control(
            'field____color',
            [
                'label' => esc_html__( 'Text Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_section();
	}

	/**
	 * Render page title widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		?>
		<h1>Hello World</h1>
		<?php

	}
}
