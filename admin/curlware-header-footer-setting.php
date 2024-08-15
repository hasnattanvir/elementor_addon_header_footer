<?php 
use Elementor\Controls_Manager;
use Elementor\Element_Base;


defined('ABSPATH') || die();

class Curlware_Header_Footer_Setting {

    public function __construct()
    {
		add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'curlware_hfe_control_sec' ], 1 );
		add_action( 'elementor/frontend/before_render', [ $this, 'curlware_before_section_render' ], 1 );
    }

    public function curlware_hfe_control_sec( Element_Base $get_element ) {
		$tabs_field = Controls_Manager::TAB_CONTENT;

		if ( 'section' === $get_element->get_name()  ) {
			$tabs_field = Controls_Manager::TAB_LAYOUT;
		}

		$get_element->start_controls_section(
			'_section_hfe_wrapper_setting',
			[
				'label' => __( 'Curlware Header Settings', 'curlware-header-footer-elementor' ),
				'tab'   => $tabs_field,
			]
		);

		$get_element->add_control(
			'position_header',
			[
				'label'     => __( 'Select Position', 'curlware-header-footer-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'no-position' 		=> __( 'Default', 'curlware-header-footer-elementor' ),
					'absolute-position'  	=> __( 'Transparent', 'curlware-header-footer-elementor' ),
				],
				'default'   => 'no-position',
			]
		);

		$get_element->add_control(
			'curlware_sitcky_on_off',
			[
				'label' => esc_html__( 'Sticky Header', 'curlware-header-footer-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default_header',
				'options' => [
					'default_header'  => esc_html__( 'Sticky Disable', 'curlware-header-footer-elementor' ),
					'sticky_header' => esc_html__( 'Sticky Enable', 'curlware-header-footer-elementor' ),
				],
			]
		);

		$get_element->add_control(
			'curlware_sitcky_positon',
			[
				'label' => esc_html__( 'Sticky Top', 'curlware-header-footer-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default_top',
				'options' => [
					'default_top'  => esc_html__( 'Default Top', 'curlware-header-footer-elementor' ),
					'sticky_top' => esc_html__( 'Sticky Top', 'curlware-header-footer-elementor' ),
				],
			]
		);
		$get_element->add_control(
			'sticky_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} header.sticky' => 'background-color: {{VALUE}};',
				],
			]
		);

		$get_element->add_control(
			'content_padding_top',
			[
				'label' => esc_html__( 'Padding Top', 'rsaddon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
			]
		);

		$get_element->add_control(
			'content_padding_bottom',
			[
				'label' => esc_html__( 'Padding Bottom', 'rsaddon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
			]
		);

		$get_element->end_controls_section();
	}

	public  function curlware_before_section_render( Element_Base $get_element ) {
		$curlware_sitcky_on_off = $get_element->get_settings_for_display( 'curlware_sitcky_on_off' );
		$position_header = $get_element->get_settings_for_display( 'position_header' );
		$curlware_sitcky_positon = $get_element->get_settings_for_display( 'curlware_sitcky_positon' );
		$sticky_bg_color = $get_element->get_settings_for_display( 'sticky_bg_color' );
		$content_padding_top = $get_element->get_settings_for_display( 'content_padding_top' );
		$content_padding_bottom = $get_element->get_settings_for_display( 'content_padding_bottom' );

		if ( $curlware_sitcky_on_off && ! empty( $curlware_sitcky_on_off )  || $position_header && ! empty( $position_header ) || $curlware_sitcky_positon && ! empty( $curlware_sitcky_positon ) ) {
			$get_element->add_render_attribute(
				'_wrapper',
				[
					'class' => [ $curlware_sitcky_on_off, $position_header, $curlware_sitcky_positon ],
				]
			);
		}


		if ( $sticky_bg_color && ! empty( $sticky_bg_color )) { ?>
			<style type="text/css">
				.sticky-wrapper .sc-header-content.sticky header.sticky_header,
				.spria_sticky .sc-menu-sticky.sticky .sticky_header.elementor-section  {
					background:<?php echo esc_attr($sticky_bg_color) ?>!important;
				}			
			</style>
		<?php
		}

		if ( !empty( $content_padding_top['size']) || ! empty( $content_padding_bottom['size'] )) { ?>
			<style type="text/css">
				.sticky-wrapper .sc-header-content.sticky header.sticky_header,.spria_sticky .sc-menu-sticky.sticky .sticky_header.elementor-section  {
					padding-top: <?php echo $content_padding_top['size'];?>px;
					padding-bottom: <?php echo $content_padding_bottom['size'];?>px;
				}	
						
			</style>
		<?php
		}
	}
}

new Curlware_Header_Footer_Setting();
