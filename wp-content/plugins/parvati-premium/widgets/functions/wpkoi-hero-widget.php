<?php
/**
 * WPKoi Hero Widget
 *
 */
class WPKoi_Hero_Widget extends WP_Widget {

	protected $defaults = array(
		'title'             => '',
		'subtitle'          => '',
		'button_text'       => '',
		'button_url'        => '',
	);

	function __construct() {
		parent::__construct(
			'WPKoi_Hero_Widget', // Base ID
			__('WPKoi Hero', 'parvati-premium'), // Name
			array( 'description' => __( 'A Call to Action widget.', 'parvati-premium' ), ) // Args
		);
	}


	function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$id            = isset( $args['id'] ) ? $args['id'] : '';
		$before_widget = $args['before_widget'];
		$after_widget  = $args['after_widget'];

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$subtitle    = $instance['subtitle'];
		$button_text = $instance['button_text'];
		$button_url  = $instance['button_url'];

		echo $before_widget;

		?><div class="widget-hero"><?php

		if ( $title || $subtitle ) {
			?>
			<div class="widget-hero-heading"><?php

			if ( $title ) {
				echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
			}

			if ( $subtitle ) {
				?><p class="widget-hero-subtitle"><?php echo esc_html( $subtitle ); ?></p><?php
			}

			?></div><?php
		}

		if ( ! empty( $button_text ) && ! empty( $button_url ) ) {
			?><a href="<?php echo esc_url( $button_url ); ?>" class="button"><?php echo esc_html( $button_text ); ?></a><?php
		}

		?></div><?php

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']       = sanitize_text_field( $new_instance['title'] );
		$instance['subtitle']    = sanitize_text_field( $new_instance['subtitle'] );
		$instance['button_text'] = sanitize_text_field( $new_instance['button_text'] );
		$instance['button_url']  = esc_url_raw( $new_instance['button_url'] );

		return $instance;
	} // save

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title       = $instance['title'];
		$subtitle    = $instance['subtitle'];
		$button_text = $instance['button_text'];
		$button_url  = $instance['button_url'];
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'parvati-premium' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat"/></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"><?php esc_html_e( 'Subtitle:', 'parvati-premium' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>" class="widefat"/></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Button Text:', 'parvati-premium' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" class="widefat" /></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"><?php esc_html_e( 'Button URL:', 'parvati-premium' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_url' ) ); ?>" type="text" value="<?php echo esc_attr( $button_url ); ?>" class="widefat" /></p>
		<?php

	} // form

}

// register widget
function wpkoi_hero_widget_register() {
    register_widget( 'WPKoi_Hero_Widget' );
}
add_action( 'widgets_init', 'wpkoi_hero_widget_register' );