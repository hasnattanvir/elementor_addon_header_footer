<?php
namespace curlwareelements\WidgetsManager\Widgets;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

class Header_Button extends Widget_Base {

	public function get_name() {
		return 'header_button';
	}

	public function get_title() {
		return __( 'CurlWare Button', 'curlware-header-footer-elementor' );
	}

	public function get_icon() {
		return 'eicon-elementor-circle';
	}

	public function get_categories() {
		return [ 'sce-widgets' ];
	}


	protected function register_controls() {
		$this->register_content_general_controls();
		$this->register_content_style_controls();
	}

	/**
	 * Undocumented function
	 *
	 * @return 
	 */
	protected function register_content_general_controls() {
		$this->start_controls_section(
			'header_btn_section',
			[
				'label' => __( 'Header Button', 'curlware-header-footer-elementor' ),
			]
		);

		$this->add_control(
			'header_btn_text',
			[
				'label'   => __( 'Button Text', 'curlware-header-footer-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Simple', 'curlware-header-footer-elementor' ),
				'placeholder' => __( 'Button', 'curlware-header-footer-elementor' ),
				'separator'   => 'before',
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_width',
			[
				'label'       => __( 'Button Width', 'curlware-header-footer-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'inline',
				'options'     => [
					'inline' => __( 'Inline', 'curlware-header-footer-elementor' ),
					'fullwidth'   => __( 'Full width (100%)', 'curlware-header-footer-elementor' ),
				],
			]
		);

		$this->add_control(
			'icon_postion',
			[
				'label'       => __( 'Icon Position', 'curlware-header-footer-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'right_icon',
				'options'     => [
					'left_icon' => __( 'Left Icon', 'curlware-header-footer-elementor' ),
					'right_icon'   => __( 'Right Icon', 'curlware-header-footer-elementor' ),
				],
			]
		);

		$this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'curlware-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .primary-btn2 i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn2 svg path' => 'fill: {{VALUE}};',
                ],                
            ]
        );
		$this->add_control(
            'icon_hover_color',
            [
                'label' => esc_html__( 'Icon Hover Color', 'curlware-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                     '{{WRAPPER}} a.primary-btn2:hover i' => 'color: {{VALUE}};',
                     '{{WRAPPER}} a.primary-btn2:hover svg path' => 'fill: {{VALUE}};',
                ],                
            ]
        );
        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Icon Margin', 'rsaddon'),
                'type' => Controls_Manager::DIMENSIONS,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .primary-btn2 i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__('Icon Padding', 'rsaddon'),
                'type' => Controls_Manager::DIMENSIONS,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .primary-btn2 i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->add_control(
			'header_btn_link',
			[
				'label' => esc_html__( 'Link', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'curlware-header-footer-elementor' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'label_block' => true,
			]
		);

		$this->add_responsive_control(
			'header_btn_align',
			[
				'label'              => __( 'Alignment', 'curlware-header-footer-elementor' ),
				'type'               => Controls_Manager::CHOOSE,
				'options'            => [
					'left'   => [
						'title' => __( 'Left', 'curlware-header-footer-elementor' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'curlware-header-footer-elementor' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'curlware-header-footer-elementor' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors'          => [
					'{{WRAPPER}} .btn-signin' => 'text-align: {{VALUE}};',
				],
				'frontend_available' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'header_btn_icon',
			[
				'label' => esc_html__( 'Icon', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
				'separator'   => 'before',
			]
		);

            $this->add_group_control(
                        \Elementor\Group_Control_Typography::get_type(),
                        [
                            'name' => 'icon__typography',
                            'selector' => '{{WRAPPER}} a i:before',
                        ]
                    );

		$this->add_control(
			'header_btn_icon_spacing',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Icon Spacing', 'curlware-header-footer-elementor' ),
				'separator'   => 'before',
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .header-btn-iocn' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
		    'svg__width',
		    [
		        'label' => esc_html__( 'Width', 'curlware-header-footer-elementor' ),
		        'type' => Controls_Manager::SLIDER,
		        'separator'   => 'before',
		        'size_units' => [ 'px' ],
		        'selectors' => [
		            '{{WRAPPER}} .header-btn-wrapper span svg' => 'width: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_responsive_control(
		    'svg__height',
		    [
		        'label' => esc_html__( 'Height', 'curlware-header-footer-elementor' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px' ],
		        'separator'   => 'before',
		        'selectors' => [
		            '{{WRAPPER}} .header-btn-wrapper span svg' => 'height: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_section();
	}

	protected function register_content_style_controls(){
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style', 'curlware-header-footer-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'style_tabs'
		);

		/**
		 * General style Tab
		 */
		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'curlware-header-footer-elementor' ),
			]
		);

		$this->add_control(
			'header_btn_text_color',
			[
				'label' => esc_html__( 'Color', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .primary-btn2 span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .header-btn-wrapper span svg path' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .sc-primary-btn' => 'color: {{VALUE}}',
				],
				'separator'     => 'after',
			]
		);
		$this->add_control(
			'header_btn_text_bg_color',
			[
				'label' => esc_html__( 'After Background Color', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sc-primary-btn:before' => 'background-color: {{VALUE}}',
				],
				'separator'     => 'after',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'header_btn_background',
				'label' => esc_html__( 'Background', 'curlware-header-footer-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .primary-btn2',
			]
		);
		$this->end_controls_tab();
		
		/**
		 * Style hover tab
		 */
		$this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'curlware-header-footer-elementor' ),
			]
		);

		$this->add_control(
			'header_btn_text_hover_color',
			[
				'label' => esc_html__( 'Color', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .primary-btn2:hover span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .primary-btn2:hover span svg path' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'header_btn_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .primary-btn2:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'header_btn_hover_background',
				'label' => esc_html__( 'Background', 'curlware-header-footer-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .primary-btn2::before, {{WRAPPER}} .primary-btn2::after',
			]
		);

		$this->add_control(
			'header_btn_hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'header_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .primary-btn2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_btn_margin',
			[
				'label' => esc_html__( 'Margin', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .primary-btn2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'header_btn_typography',
				'selector' => '{{WRAPPER}} .primary-btn2',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'header_btn_border',
				'label' => esc_html__( 'Border', 'curlware-header-footer-elementor' ),
				'selector' => '{{WRAPPER}} .primary-btn2',
			]
		);

		$this->add_responsive_control(
			'btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .primary-btn2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}


	/**
	 * Undocumented function
	 *
	 * @return HTML view
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( ! empty( $settings['header_btn_link']['url'] ) ) {
			$this->add_link_attributes( 'header_btn_link', $settings['header_btn_link'] );
		}

		$elementClass = 'btn-signin';
		if ( $settings['header_btn_hover_animation'] ) {
			$elementClass .= ' elementor-animation-' . $settings['header_btn_hover_animation'];
		}
		$this->add_render_attribute( 'wrapper', 'class', $elementClass );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a class="primary-btn2 sc_btn_<?php echo $settings['button_width']?>" <?php echo $this->get_render_attribute_string( 'header_btn_link' ); ?>>

				
				<?php if ('left_icon' == $settings['icon_postion']) {  ?>
				<?php Icons_Manager::render_icon( $settings['header_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?> 
				<?php } ?>

				<span class="header-btn-text">
					<?php echo esc_html( $settings['header_btn_text'] ); ?> 
				</span>

				<?php if ('right_icon' == $settings['icon_postion']) {  ?>
				<?php Icons_Manager::render_icon( $settings['header_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?> 
				<?php } ?>
			</a>
		</div>
		<?php
	}
}