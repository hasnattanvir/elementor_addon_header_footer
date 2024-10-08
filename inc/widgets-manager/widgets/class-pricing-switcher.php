<?php
/**
 * Pricing table widget class
 *
 */
namespace curlwareelements\WidgetsManager\Widgets;

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Pricing_Switcher extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve rsgallery widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */

    public function get_name() {
        return 'pricing-switcher';
    }   


    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Pricing Switcher', 'curlware-header-footer-elementor' );
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-elementor-circle';
    }


    public function get_categories() {
        return [ 'sce-widgets' ];
    }



	protected function register_controls() {



        $this->start_controls_section(
            '_section_price',
            [
                'label' => esc_html__( 'Pricing Table', 'curlware-header-footer-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        
        $this->add_control(
            'price_showhide',
            [
                'label' => esc_html__( 'Price Show/Hide', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'curlware-header-footer-elementor' ),
                    'no' => esc_html__( 'No', 'curlware-header-footer-elementor' ),
                ],                
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'monthly_title',
            [
                'label' => esc_html__( 'Monthly Text', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Monthly',
                'condition' => [
					'price_showhide' => 'yes',
				],
            ]
        );

        $this->add_control(
            'yearly_title',
            [
                'label' => esc_html__( 'Yearly Text', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Yearly',
                'condition' => [
					'price_showhide' => 'yes',
				],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'monthly_options',
            [
                'label' => esc_html__( 'Monthly Pricing Here', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => esc_html__( 'Basic', 'curlware-header-footer-elementor' ),
            ]
        );
        $repeater->add_control(
            'first_image',
            [
                'label' => esc_html__( 'Choose Image', 'curlware-header-footer-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'price',
            [
                'label' => esc_html__( 'Price', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( '$29.00', 'curlware-header-footer-elementor' ),
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__( 'Monthly', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Monthly Text', 'curlware-header-footer-elementor' ),
            ]
        );
        
        $repeater->add_control(
            'badge',
            [
                'label' => esc_html__( 'Badge Text', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'features',
            [
                'label'   => esc_html__( 'Features (Use List Style)', 'curlware-header-footer-elementor' ),
                'type'    => Controls_Manager::WYSIWYG,
                'rows'    => 10, 
                'default' => esc_html__( '1 Users', 'curlware-header-footer-elementor' ),
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Button Text', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Get Started', 'curlware-header-footer-elementor' ),
                'placeholder' => esc_html__( 'Type button text here', 'curlware-header-footer-elementor' ),
                'label_block' => false,
            ]
        );

        $repeater->add_control(
            'button_link',
            [
                'label' => esc_html__( 'Link', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'https://example.com/', 'curlware-header-footer-elementor' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        //Yearly Content
        $repeater->add_control(
            'yearly_options',
            [
                'label' => esc_html__( 'Yearly Pricing Here', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'title_yearly',
            [
                'label' => esc_html__( 'Title', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => esc_html__( 'Basic', 'curlware-header-footer-elementor' ),
            ]
        );
        $repeater->add_control(
            'second_image',
            [
                'label' => esc_html__( 'Choose Image', 'curlware-header-footer-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'price_yearly',
            [
                'label' => esc_html__( 'Price', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( '$59.00', 'curlware-header-footer-elementor' ),
            ]
        );

        $repeater->add_control(
            'description_yearly',
            [
                'label' => esc_html__( 'Yearly', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Yearly Text', 'curlware-header-footer-elementor' ),
            ]
        );

        $repeater->add_control(
            'badge_yearly',
            [
                'label' => esc_html__( 'Badge Text', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'features_yearly',
            [
                'label'   => esc_html__( 'Features (Use List Style)', 'curlware-header-footer-elementor' ),
                'type'    => Controls_Manager::WYSIWYG,
                'rows'    => 10,
                'default' => esc_html__( '1 Users', 'curlware-header-footer-elementor' ),
            ]
        );

        $repeater->add_control(
            'button_text_yearly',
            [
                'label' => esc_html__( 'Button Text', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Get Started', 'curlware-header-footer-elementor' ),
                'placeholder' => esc_html__( 'Type button text here', 'curlware-header-footer-elementor' ),
                'label_block' => false,
            ]
        );

        $repeater->add_control(
            'button_link_yearly',
            [
                'label' => esc_html__( 'Link', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => esc_html__( 'https://example.com/', 'curlware-header-footer-elementor' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'price_list',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'show_content_icon',
            [
                'label' => esc_html__( 'Show Content List Icon', 'curlware-header-footer-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'Default', 'curlware-header-footer-elementor' ),
                    'none' => esc_html__( 'Hide', 'curlware-header-footer-elementor' ),
                    'inline-block' => esc_html__( 'Show', 'curlware-header-footer-elementor' ),

                ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-body .features ul li:before' => 'display: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'show_header_image',
            [
                'label' => esc_html__( 'Show Header Image', 'curlware-header-footer-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    '' => esc_html__( 'Default', 'curlware-header-footer-elementor' ),
                    'none' => esc_html__( 'Hide', 'curlware-header-footer-elementor' ),
                    'flex' => esc_html__( 'Show', 'curlware-header-footer-elementor' ),

                ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container ul.pricing-list li.exclusive ul.pricing-wrapper li .pricing-header .sc-price-image' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_months',
            [
                'label' => esc_html__( 'Monthly & Yearly Style', 'curlware-header-footer-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'pricing_align_style',
            [
                'label' => esc_html__( 'Pricing Alignment', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justify', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}  .sc-pricing-container .pricing-switcher' => 'text-align: {{VALUE}}'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_colors_fie',
                'label' => esc_html__( 'Background', 'curlware-header-footer-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .pricing-switcher .fieldset',
            ]
        );

        $this->add_control(
			'pricing_switcher_position_heading',
			[
				'label' => esc_html__( 'Pricing Switcher Position', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
			'pricing_switcher_position_y_top',
			[
				'label' => esc_html__( 'Top', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricing-switcher .fieldset' => 'top: {{SIZE}}{{UNIT}}; position: absolute;',
				],
			]
		);
        $this->add_responsive_control(
			'pricing_switcher_position_x_right',
			[
				'label' => esc_html__( 'Right', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricing-switcher .fieldset' => 'right: {{SIZE}}{{UNIT}}; position: absolute;',
				],
			]
		);
        $this->add_responsive_control(
			'pricing_switcher_position_y_bottom',
			[
				'label' => esc_html__( 'Bottom', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricing-switcher .fieldset' => 'bottom: {{SIZE}}{{UNIT}}; position: absolute;',
				],
			]
		);
        $this->add_responsive_control(
			'pricing_switcher_position_x_left',
			[
				'label' => esc_html__( 'Left', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricing-switcher .fieldset' => 'left: {{SIZE}}{{UNIT}}; position: absolute;',
				],
			]
		);

        $this->add_control(
            'switcher_bg_heading',
            [
                'label' => esc_html__( 'Switcher Color (Normal)', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'switcher_bg_color',
                'label' => esc_html__( 'Background', 'curlware-header-footer-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .pricing-switcher .switch',
            ]
        );

        $this->add_control(
            'switcher_normal_color',
            [
                'label' => esc_html__( 'Switcher Color (Normal)', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pricing-switcher label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'switcher_active_color',
            [
                'label' => esc_html__( 'Switcher Color (Active)', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pricing-switcher .fieldset.mnt-ac .rs-mnt, .pricing-switcher .fieldset.mnt-acs .rs-yrs' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
			'fieldset_max_width',
			[
				'label' => esc_html__( 'Fieldset Width', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pricing-switcher .fieldset' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->add_control(
			'yearly_position',
			[
				'label' => esc_html__( 'Yearly Left Position', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pricing-switcher input[type=radio]:checked + label + .switch, .pricing-switcher input[type=radio]:checked + label:nth-of-type(n) + .switch' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'switcher_typography',
                'label' => esc_html__( 'Typography', 'curlware-header-footer-elementor' ),
                'selector' => '{{WRAPPER}} .pricing-switcher label',
            ]
        );

        $this->add_responsive_control(
            'year_padding',
            [
                'label' => esc_html__( 'Padding', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing-switcher .fieldset' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'year_margin',
            [
                'label' => esc_html__( 'Margin', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing-switcher .fieldset' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'price_menu_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .pricing-switcher .fieldset',
            ]
        );

        

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_style_general',
            [
                'label' => esc_html__( 'Item Style', 'curlware-header-footer-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'gradient_color_showhide',
            [
                'label'   => esc_html__( 'Gradient Color', 'curlware-header-footer-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'gradient_disable',
                'options' => [                  
                    'gradient_enable' => esc_html__( 'Enable', 'curlware-header-footer-elementor'),
                    'gradient_disable' => esc_html__( 'Disable', 'curlware-header-footer-elementor'),
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justify', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}}  .sc-pricing-container' => 'text-align: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_color',
                'label' => esc_html__( 'Background', 'curlware-header-footer-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .pricing-wrapper > li',
            ]
        );

        

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing-wrapper > li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__( 'Padding', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing-wrapper > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_style_margin',
            [
                'label' => esc_html__( 'Margin', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing-list .pricing-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'general_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .pricing-wrapper > li',
            ]
        );

        $this->add_control(
            'box_shadow_hover_title',
            [
                'label' => esc_html__( 'Hover Box-show', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'general_box_shadow_hover',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .pricing-wrapper > li:hover',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            '_section_style_header',
            [
                'label' => esc_html__( 'Header Style', 'curlware-header-footer-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'headtitle_color',
            [
                'label' => esc_html__( 'Title Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [   
                'label' => esc_html__( 'Title Typography', 'curlware-header-footer-elementor' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .sc-pricing-container .pricing-header h3',
            ]
        );
        $this->add_responsive_control(
            'title_margin__',
            [
                'label' => esc_html__( 'Title Margin', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'main_header_style',
            [
                'label' => esc_html__( 'Main Header Box Style', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'box_horizontal_align',
            [
                'label' => esc_html__( 'Box Style (Inline / Block)', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex' => [
                        'title' => esc_html__( 'Inline', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-post-list',
                    ],
                    'block' => [
                        'title' => esc_html__( 'Block', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-posts-grid',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header' => 'display: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'box_vertical_align',
            [
                'label' => esc_html__( 'Vertical Align', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Top', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Middle', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Bottom', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-end-v',
                    ],
                ],
                'condition' => [
                    'box_horizontal_align' => 'flex',
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header' => 'align-items: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'flex_box_h_align',
            [
                'label' => esc_html__( 'Horizontal Align', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-justify-space-between-h',
                    ],

                ],
                'condition' => [
                    'box_horizontal_align' => 'flex',
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'pricing_header_style',
            [
                'label' => esc_html__( 'Pricing Box Style', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'box_p_horizontal_align',
            [
                'label' => esc_html__( 'Box Style (Inline / Block)', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex' => [
                        'title' => esc_html__( 'Inline', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-post-list',
                    ],
                    'block' => [
                        'title' => esc_html__( 'Block', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-posts-grid',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header .price' => 'display: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'box_p_vertical_align',
            [
                'label' => esc_html__( 'Vertical Align', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Top', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Middle', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Bottom', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-end-v',
                    ],
                ],
                'condition' => [
                    'box_p_horizontal_align' => 'flex',
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header .price' => 'align-items: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'flex_box_p_h_align',
            [
                'label' => esc_html__( 'Horizontal Align', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-justify-space-between-h',
                    ],

                ],
                'condition' => [
                    'box_p_horizontal_align' => 'flex',
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header .price' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'flex_box_p_h_direction',
            [
                'label' => esc_html__( 'Flex Direction', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'column' => [
                        'title' => esc_html__( 'Column', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-start-h',
                    ],
                    'column-reverse' => [
                        'title' => esc_html__( 'Column Reverse', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-center-h',
                    ],
                    'row' => [
                        'title' => esc_html__( 'Row', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-align-end-h',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__( 'Row Reverse', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-justify-space-between-h',
                    ],

                ],
                'condition' => [
                    'box_p_horizontal_align' => 'flex',
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header .price' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'price_color',
            [
                'label' => esc_html__( 'Price Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header .price' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'gradient_color' => 'gradient_disable',
                ], 
            ]
        );

        $this->add_control(
            'btn_border_gradient_heading_price',
            [
                'label' => esc_html__( 'Price Gradient Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'gradient_color' => 'gradient_enable',
                ], 
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'price_gradient_color',
                'label' => __( 'Background Color', 'curlware-header-footer-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .gradient_enable .pricing-header .price',
                'condition' => [
                    'gradient_color' => 'gradient_enable',
                ], 
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [   
                'label' => esc_html__( 'Price Typography', 'curlware-header-footer-elementor' ),
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .sc-pricing-container .pricing-header .price',
            ]
        );

        $this->add_responsive_control(
            'title_paddings',
            [
                'label' => esc_html__( 'Padding', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'des_list_color',
            [
                'label' => esc_html__( 'Description Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header .price-item .price span' => 'color: {{VALUE}}; opacity:1;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [   
                'label' => esc_html__( 'Description Typography', 'curlware-header-footer-elementor' ),
                'name' => 'des_typography',
                'selector' => '{{WRAPPER}} .sc-pricing-container .pricing-header .price-item .price span',
            ]
        );
        $this->add_control(
            'short_desc_margin',
            [
                'label' => esc_html__( ' Description Margin', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header .price-item .price span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_area_margin',
            [
                'label' => esc_html__( 'Area Margin', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_border',
            [
                'label' => esc_html__( 'Border Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header:after' => 'background: {{VALUE}}; opacity:1;',
                ],
            ]
        );

        $this->add_control(
            'header_buttom_bg',
            [
                'label' => esc_html__( 'Header Bottom Border Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'header_buttom_grdient_bg',
                'label' => __( 'Background Color', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .sc-pricing-container .pricing-header:after',
            ]
        );

        $this->add_control(
            'heading_icon_img_style',
            [
                'label' => esc_html__( 'Header Icon Style   ', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::HEADING,
                'condition'=>[
                    'show_header_image'=>'flex'
                ],
            ]
        );
        $this->add_control(
            'heading_icon_margin_',
            [
                'label' => esc_html__( 'Margin', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-header .sc-price-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'=>[
                    'show_header_image'=>'flex'
                ],
            ]
        );
        $this->add_control(
            'heading_icon_bg_color',
            [
                'label' => esc_html__( 'Background', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container ul.pricing-list li.exclusive ul.pricing-wrapper li .pricing-header .sc-price-image' => 'background: {{VALUE}}; opacity:1;',
                ],
                'condition'=>[
                    'show_header_image'=>'flex'
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_icon_b_r',
            [
                'label' => esc_html__( 'Border Radius', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container ul.pricing-list li.exclusive ul.pricing-wrapper li .pricing-header .sc-price-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'=>[
                    'show_header_image'=>'flex'
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_icon_width_wrapper',
            [
                'label' => esc_html__( 'Wrapper Width', 'curlware-header-footer-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container ul.pricing-list li.exclusive ul.pricing-wrapper li .pricing-header .sc-price-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'=>[
                    'show_header_image'=>'flex'
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_icon_height_wrapper',
            [
                'label' => esc_html__( 'Wrapper Height', 'curlware-header-footer-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container ul.pricing-list li.exclusive ul.pricing-wrapper li .pricing-header .sc-price-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'=>[
                    'show_header_image'=>'flex'
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_icon_width_',
            [
                'label' => esc_html__( 'Width', 'curlware-header-footer-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container ul.pricing-list li.exclusive ul.pricing-wrapper li .pricing-header .sc-price-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'=>[
                    'show_header_image'=>'flex'
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_icon_height_',
            [
                'label' => esc_html__( 'Height', 'curlware-header-footer-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container ul.pricing-list li.exclusive ul.pricing-wrapper li .pricing-header .sc-price-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'=>[
                    'show_header_image'=>'flex'
                ],
            ]
        );

        $this->end_controls_section();

        // Badge Style Start
        $this->start_controls_section(
            '_section_style_badge',
            [
                'label' => esc_html__( 'Badge Style', 'curlware-header-footer-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'badge_align',
            [
                'label' => esc_html__( 'Alignment', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
             
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .pricebadge' => 'text-align: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'badge_typography',
		        'label' => esc_html__( 'Typography', 'curlware-header-footer-elementor' ),
				'selector' => '{{WRAPPER}} .pricebadge',
		        
		    ]
		);
        $this->add_control(
            'badge_color',
            [
                'label' => esc_html__( 'Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pricebadge' => 'color: {{VALUE}};',                   
                ],
            ]
        );
        $this->add_responsive_control(
		    'badge_padding',
		    [
		        'label' => esc_html__( 'Padding', 'curlware-header-footer-elementor' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .pricebadge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
        $this->add_responsive_control(
		    'badge_margin',
		    [
		        'label' => esc_html__( 'Margin', 'curlware-header-footer-elementor' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .pricebadge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
        $this->add_responsive_control(
		    'badge_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'curlware-header-footer-elementor' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .pricebadge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'badge_background',
                'label' => esc_html__( 'Background', 'curlware-header-footer-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .pricebadge',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'badge_border',
                'selector' => '{{WRAPPER}} .pricebadge',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'badge_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .pricebadge'
            ]
        );
        $this->add_control(
			'badge_width',
			[
				'label' => esc_html__( 'Width', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricebadge' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_responsive_control(
            'badge_align_width_base',
            [
                'label' => esc_html__( 'Alignment (If Given Width)', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => '',
                'options' => [
                    '' => [
                        'title' => esc_html__( 'Left', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    '0 auto' => [
                        'title' => esc_html__( 'Center', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    '0 0 0 auto' => [
                        'title' => esc_html__( 'Right', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
             
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .pricebadge' => 'margin: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
			'badge_position_heading',
			[
				'label' => esc_html__( 'Badge Position', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'badge_position_y_top',
			[
				'label' => esc_html__( 'Top', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricebadge' => 'top: {{SIZE}}{{UNIT}}; position: absolute;',
				],
			]
		);
        $this->add_control(
			'badge_position_x_right',
			[
				'label' => esc_html__( 'Right', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricebadge' => 'right: {{SIZE}}{{UNIT}}; position: absolute;',
				],
			]
		);
        $this->add_control(
			'badge_position_y_bottom',
			[
				'label' => esc_html__( 'Bottom', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricebadge' => 'bottom: {{SIZE}}{{UNIT}}; position: absolute;',
				],
			]
		);
        $this->add_control(
			'badge_position_x_left',
			[
				'label' => esc_html__( 'Left', 'curlware-header-footer-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .pricebadge' => 'left: {{SIZE}}{{UNIT}}; position: absolute;',
				],
			]
		);

        $this->end_controls_section();
        // Badge Style End

        $this->start_controls_section(
            '_section_style_body',
            [
                'label' => esc_html__( 'Pricing Body Style', 'curlware-header-footer-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'align_body',
            [
                'label' => esc_html__( 'Alignment', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justify', 'curlware-header-footer-elementor' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}}  .pricing-body' => 'text-align: {{VALUE}}'
                ]
            ]
        );



        $this->add_control(
            'des_features_color',
            [
                'label' => esc_html__( 'Features Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-body .features ul li' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'des_close_features_color',
            [
                'label' => esc_html__( 'Close Features Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-body .features ul li.active' => 'color: {{VALUE}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'icon_features_color',
            [
                'label' => esc_html__( 'Check Icon Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pricing-body .features ul li:before' => 'color: {{VALUE}};',
                    'condition' => [
                        'gradient_color' => 'gradient_disable',
                    ],
                ],
            ]
        );

        $this->add_control(
            'icon_gradient',
            [
                'label' => esc_html__( 'Check Icon Gradient Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'gradient_color' => 'gradient_enable',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'check_icon_gradient',
                'label' => __( 'Background Color', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .pricing-body .features ul li:before',
                'condition' => [
                    'gradient_color' => 'gradient_enable',
                ],
            ]
        );



        $this->add_control(
            'icon_border_features_color',
            [
                'label' => esc_html__( 'Close Icon Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pricing-body .features ul li.close-icon:before, {{WRAPPER}} .sc-pricing-container .pricing-body .features ul li.active:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [   
                'label' => esc_html__( 'Features Typography', 'curlware-header-footer-elementor' ),
                'name' => 'features_typography',
                'selector' => '{{WRAPPER}} .sc-pricing-container .pricing-body .features ul li',
            ]
        );
        $this->add_control(
            'item_fea_desc_margin',
            [
                'label' => esc_html__( 'Margin (Per Item)', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-body .features ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'item_fea_desc_padding',
            [
                'label' => esc_html__( 'Padding (Per Item)', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-body .features ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'body_padding',
            [
                'label' => esc_html__( 'List Area Padding', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'body_margin',
            [
                'label' => esc_html__( 'List Area Margin', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
            '_section_style_button',
            [
                'label' => esc_html__( 'Button Style', 'curlware-header-footer-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'button_area__padding',
            [
                'label' => esc_html__( ' Area Padding', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
			'button_max_width',
			[
				'label' => esc_html__( 'Button Max Width', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
				'selectors' => [
					'{{WRAPPER}} .sc-pricing-container .pricing-footer a' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->start_controls_tabs( '_tabs_button' );

        $this->start_controls_tab(
            '_tab_button_normal',
            [
                'label' => esc_html__( 'Normal', 'curlware-header-footer-elementor' ),
            ]
        );
        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Text Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-footer a, {{WRAPPER}} .sc-pricing-container .pricing-wrapper li footer.pricing-footer a span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background__sd',
                'label' => __( 'Background Color', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .sc-pricing-container.gradient_enable .pricing-footer a:before, {{WRAPPER}} .sc-pricing-container .pricing-footer a',
            ]
        );
        $this->add_control(
            'btn_border_gradient_heading',
            [
                'label' => esc_html__( 'Button Border Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'gradient_color' => 'gradient_enable',
                ], 
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'btn_gradient_bg',
                'label' => __( 'Background Color', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .sc-pricing-container.gradient_enable .pricing-footer a',
                'condition' => [
                    'gradient_color' => 'gradient_enable',
                ], 
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .sc-pricing-container .pricing-footer a',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .sc-pricing-container .pricing-footer a',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-footer a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .sc-pricing-container .pricing-footer a',
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__( 'Area Margin', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing-footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__( 'Padding', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-footer a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );  

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_button_hover',
            [
                'label' => esc_html__( 'Hover', 'curlware-header-footer-elementor' ),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => esc_html__( 'Text Color', 'curlware-header-footer-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .sc-pricing-container .pricing-wrapper > li:hover .pricing-footer a, {{WRAPPER}} .sc-pricing-container .pricing-wrapper li footer.pricing-footer a:hover span' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_hover_border',
                'selector' => '{{WRAPPER}} .sc-pricing-container .pricing-wrapper > li:hover .pricing-footer a',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} .sc-pricing-container .pricing-wrapper > li:hover .pricing-footer a',
            ]
        );

        $this->add_control(
            'gradient_color',
            [
                'label'   => esc_html__( 'Gradient Color', 'curlware-header-footer-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'gradient_disable',
                'options' => [                  
                    'gradient_enable' => esc_html__( 'Enable', 'curlware-header-footer-elementor'),
                    'gradient_disable' => esc_html__( 'Disable', 'curlware-header-footer-elementor'),
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background_btn_hover',
                'label' => __( 'Background Color', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .price-btn:hover::after, {{WRAPPER}} .price-btn:hover::before',
                'condition' => [
                    'gradient_color' => 'gradient_disable',
                ], 
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background_btn_hover_gradientds',
                'label' => __( 'Background Color', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .sc-pricing-container.gradient_enable .pricing-wrapper > li:hover .pricing-footer a:before',
                'condition' => [
                    'gradient_color' => 'gradient_enable',
                ], 
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        

        <div class="pricing-container sc-pricing-container <?php echo esc_attr( $settings['gradient_color'] ); ?>">
             <?php if(($settings['price_showhide'] == 'yes') ){ ?>
                <div class="pricing-switcher">
                    <p class="fieldset mnt-ac" style="text-align:
                    center;">
                        <input type="radio" name="duration-1" value="monthly" id="monthly-1" checked>
                        <label for="monthly-1" id ="rsmnt" class="rs-mnt"><?php echo wp_kses_post($settings['monthly_title']);?>  </label>
                        <input type="radio" name="duration-1" value="yearly" id="yearly-1">
                        <label for="yearly-1" id ="rsyrs" class="rs-yrs"><?php echo wp_kses_post($settings['yearly_title']);?>  </label>
                        <span class="switch"></span>
                    </p>
                </div>
            <?php } ?>

            <ul class="pricing-list bounce-invert">
                <?php foreach ( $settings['price_list'] as $items => $item ) { ?>
                    <?php 
                        $title                  = !empty($item['title']) ? $item['title'] : '';                            
                        $price                  = !empty($item['price']) ? $item['price'] : '';                            
                        $description            = !empty($item['description']) ? $item['description'] : '';                            
                        $badge                  = !empty($item['badge']) ? $item['badge'] : '';                           
                        $features               = !empty($item['features']) ? $item['features'] : '';                            
                        $button_text            = !empty($item['button_text']) ? $item['button_text'] : '';                            
                        $target                 = !empty($item['button_link']['is_external']) ? 'target=_blank' : '';  
                        $button_link            = !empty($item['button_link']['url']) ? $item['button_link']['url'] : '';

                        $title_yearly           = !empty($item['title_yearly']) ? $item['title_yearly'] : '';                            
                        $price_yearly           = !empty($item['price_yearly']) ? $item['price_yearly'] : '';                            
                        $description_yearly     = !empty($item['description_yearly']) ? $item['description_yearly'] : '';
                        $badge_yearly           = !empty($item['badge_yearly']) ? $item['badge_yearly'] : ''; 
                        $features_yearly        = !empty($item['features_yearly']) ? $item['features_yearly'] : '';                            
                        $button_text_yearly     = !empty($item['button_text_yearly']) ? $item['button_text_yearly'] : '';       
                        $target                 = !empty($item['button_link_yearly']['is_external']) ? 'target=_blank' : '';  
                        $button_link_yearly     = !empty($item['button_link_yearly']['url']) ? $item['button_link_yearly']['url'] : '';

                    ?>
                    <li class="exclusive">
                        <ul class="pricing-wrapper"> 

                            <!-- Monthly -->
                            <li data-type="monthly" class="is-visible">
                                <?php if(!empty($badge)){ ?>
                                    <div class="pricebadge"><?php echo esc_attr ($badge);?></div>
                                <?php } ?>
                                <header class="pricing-header">
                                    <div class="sc-price-image">
                                        <?php if(!empty($item['first_image']['url'])) : ?>
                                            <img src="<?php echo esc_url($item['first_image']['url']);?>" alt="Images">
                                        <?php endif; ?>
                                    </div>
                                    <div class="price-item">
                                        <h3><?php echo esc_attr ($title);?></h3>
                                        <div class="price"><?php echo esc_attr ($price);?>
                                            <?php if(!empty($description)){ ?>
                                            <span><?php echo esc_attr ($description);?></span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </header>

                                <div class="pricing-body">  
                                    <?php if(!empty($features)){ ?>
                                        <div class="features"><?php echo wp_kses_post ($features);?></div>
                                    <?php } ?>
                                </div>

                                <?php if(!empty($button_text)){ ?> 
                                <footer class="pricing-footer">
                                    <a class="price-btn" href="<?php echo esc_url($button_link);?>" <?php echo wp_kses_post($target);?>><span><?php echo esc_attr ($button_text);?></span></a>
                                </footer>
                                <?php } ?>

                            </li>
                            <!-- End Monthly -->
                            
                            <!-- Yearly -->
                            <li data-type="yearly" class="is-hidden">
                                <?php if(!empty($badge_yearly)){ ?>
                                    <div class="pricebadge"><?php echo esc_attr ($badge_yearly);?></div>
                                <?php } ?>
                                <header class="pricing-header">
                                    <div class="sc-price-image">
                                        <?php if(!empty($item['second_image']['url'])) : ?>
                                            <img src="<?php echo esc_url($item['second_image']['url']);?>" alt="Images">
                                        <?php endif; ?>
                                    </div>
                                    <div class="price-item">
                                        <h3><?php echo esc_attr ($title_yearly);?></h3>
                                        <div class="price"><?php echo esc_attr ($price_yearly);?>
                                            <?php if(!empty($description)){ ?>
                                            <span><?php echo esc_attr ($description_yearly);?></span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </header>
                                <div class="pricing-body">                                    
                                    <div class="features"><?php echo wp_kses_post ($features_yearly);?></div>
                                </div>
                                <footer class="pricing-footer">
                                    <a class="price-btn" href="<?php echo esc_url($button_link_yearly);?>" <?php echo wp_kses_post($target);?>><span><?php echo esc_attr ($button_text_yearly);?></span></a>
                                </footer>
                            </li>
                            <!-- End Yearly -->

                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <?php
    }
}