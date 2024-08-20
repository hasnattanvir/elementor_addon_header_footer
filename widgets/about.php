

<?php
/**
 * @author  UiGigs
 * @since   1.0
 * @version 1.0
 */

class About_Widget extends \WP_Widget {
	public function __construct() {
		$id = curlwareelements_PREFIX . '_about';
		parent::__construct(
            $id, // Base ID
            esc_html__( 'A1: About', 'curlware-header-footer-elementor' ), // Name
            array( 'description' => esc_html__( 'CW: About Widget', 'curlware-header-footer-elementor' )
        ) );
	}

	public function widget( $args, $instance ){

		echo wp_kses_post( $args['before_widget'] );

		$title = $instance['title'];
		$logo  = wp_get_attachment_image( $instance['logo'], 'full' );
		$desc  = $instance['desc'];
		?>
		
		<?php if (!empty($logo)) { ?>
			<a href="<?php echo esc_url( home_url('/') ); ?>" class="footer-logo img-logo">
				<?php echo wp_kses_post( $logo ) ; ?>

			</a>
		<?php } elseif (!empty($title)) { ?>
			<a href="<?php echo esc_url( home_url('/') ); ?>" class="footer-logo text-logo">
				<?php echo esc_html($title); ?>
			</a>
		<?php } if (!empty($desc)) { ?>
			<div class="description"><?php echo wp_kses_post($desc); ?></div>
		<?php } ?>

		<?php 
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ){
		$instance          = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['logo']  = ( ! empty( $new_instance['logo'] ) ) ? sanitize_text_field( $new_instance['logo'] ) : '';
		$instance['desc'] = ( ! empty( $new_instance['desc'] ) ) ? sanitize_text_field( $new_instance['desc'] ) : '';

		return $instance;
	}

	public function form( $instance ){
		$defaults = array(
			'title' => '',
			'logo'  => '',
			'desc'  => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = array(
			'title'       => array(
				'label'   => esc_html__( 'Title', 'curlware-header-footer-elementor' ),
				'type'    => 'text',
			),
			'logo'       => array(
				'label'   => esc_html__( 'Logo Image', 'curlware-header-footer-elementor' ),
				'type'    => 'image',
			),
			'desc'        => array(
				'label'   => esc_html__( 'Description', 'curlware-header-footer-elementor' ),
				'type'    => 'textarea',
			),
		);

		Curlware_Widget_Fields::display( $fields, $instance, $this );
	}
}
