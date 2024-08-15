<?php
/**
 * @author  UiGigs
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'curlware_Postmeta' ) ) {
	return;
}

$Postmeta = \curlware_Postmeta::getInstance();

$prefix = curlwareelements_PREFIX;
$ctp_socials = array(
	'facebook' => array(
		'label' => __( 'Facebook', 'curlware-core' ),
		'type'  => 'text',
		'icon'  => 'fab fa-facebook-f',
		'color' => '#3b5998',
	),
	'twitter' => array(
		'label' => __( 'Twitter', 'curlware-core' ),
		'type'  => 'text',
		'icon'  => 'fab fa-twitter',
		'color' => '#1da1f2',
	),
	'linkedin' => array(
		'label' => __( 'Linkedin', 'curlware-core' ),
		'type'  => 'text',
		'icon'  => 'fab fa-linkedin-in',
		'color' => '#0077b5',
	),
	'instagram' => array(
		'label' => __( 'Instagram', 'curlware-core' ),
		'type'  => 'text',
		'icon'  => 'fab fa-instagram',
		'color' => '#AA3DB2',
	),
	'pinterest' => array(
		'label' => __( 'Pinterest', 'curlware-core' ),
		'type'  => 'text',
		'icon'  => 'fab fa-pinterest-p',
		'color' => '#E60023',
	),
);
$curlware_ctp_socials = apply_filters( 'ctp_socials', $ctp_socials );

/*---------------------------------------------------------------------
#. = Layout Settings
-----------------------------------------------------------------------*/
$nav_menus = wp_get_nav_menus( array( 'fields' => 'id=>name' ) );
$nav_menus = array( 'default' => __( 'Default', 'curlware-core' ) ) + $nav_menus;

$Postmeta->add_meta_box( "{$prefix}_page_settings", __( 'Page Settings', 'curlware-core' ), array( 'page', 'post', 'artex_team' ), '', '', 'high', array(
	'fields' => array(
	
		"{$prefix}_layout_settings" => array(
			'label'   => __( 'Layouts', 'curlware-core' ),
			'type'    => 'group',
			'value'  => array(	
			
				"{$prefix}_layout" => array(
					'label'   => __( 'Page Sidebar Settings', 'curlware-core' ),
					'type'    => 'select',
					'options' => array(
						'default'       => __( 'Default', 'curlware-core' ),
						'full-width'    => __( 'Full Width', 'curlware-core' ),
						'left-sidebar'  => __( 'Left Sidebar', 'curlware-core' ),
						'right-sidebar' => __( 'Right Sidebar', 'curlware-core' ),
					),
					'default'  => 'default',
				),	
				"{$prefix}_page_top_padding" => array(
					'label'   => __( 'Page Top Padding', 'curlware-core' ),
					'type'    => 'number',
					'default'  => '100',
				),
				"{$prefix}_page_bottom_padding" => array(
					'label'   => __( 'Page Bottom Padding ', 'curlware-core' ),
					'type'    => 'number',
					'default'  => '100',
				),	
				"{$prefix}_banner" => array(
					'label'   => __( 'Banner Show/Hide', 'curlware-core' ),
					'type'    => 'select',
					'options' => array(
						'default' => __( 'Default', 'curlware-core' ),
						'on'	  => __( 'Show', 'curlware-core' ),
						'off'	  => __( 'Hide', 'curlware-core' ),
					),
					'default'  => 'default',
				),
				"{$prefix}_breadcrumb" => array(
					'label'   => __( 'Breadcrumb Show/Hide', 'curlware-core' ),
					'type'    => 'select',
					'options' => array(
						'default' => __( 'Default', 'curlware-core' ),
						'on'      => __( 'Show', 'curlware-core' ),
						'off'	  => __( 'Hide', 'curlware-core' ),
					),
					'default'  => 'default',
				),
				"{$prefix}_banner_type" => array(
					'label'   => __( 'Banner Background Type', 'curlware-core' ),
					'type'    => 'select',
					'options' => array(
						'default' => __( 'Default', 'curlware-core' ),
						'bgimg'   => __( 'Background Image', 'curlware-core' ),
						'bgcolor' => __( 'Background Color', 'curlware-core' ),
					),
					'default' => 'default',
				),
				"{$prefix}_banner_bgimg" => array(
					'label' => __( 'Banner Background Image', 'curlware-core' ),
					'type'  => 'image',
					'desc'  => __( 'Please select your background type', 'curlware-core' ),
				),
				"{$prefix}_banner_bgcolor" => array(
					'label' => __( 'Banner Background Color', 'curlware-core' ),
					'type'  => 'color_picker',
					'desc'  => __( 'Please select your background type', 'curlware-core' ),
				),
				"{$prefix}_top_padding" => array(
					'label'   => __( 'Banner Top Padding', 'curlware-core' ),
					'type'    => 'number',
					'default'  => '100',
				),
				"{$prefix}_bottom_padding" => array(
					'label'   => __( 'Banner Bottom Padding ', 'curlware-core' ),
					'type'    => 'number',
					'default'  => '100',
				),
			)
		)
	),
) );

/*---------------------------------------------------------------------
#. = Speaker
-----------------------------------------------------------------------*/
$Postmeta->add_meta_box( $prefix.'_speaker_info', __( 'Speaker Information', 'curlware-core' ), array( $prefix.'_speaker' ), '', '', 'high', array(
	'fields' => array(
		"{$prefix}_speaker_desigantion" => array(
			'label' => esc_html__( 'Designation', 'curlware-core' ),
			'type'  => 'text',
		),
		"{$prefix}_speaker_socials" => array(
			'type'  => 'group',
			'label' => esc_html__( 'Speaker Socials', 'artex-core' ),
			'value'  => $curlware_ctp_socials
		),
	)
) );