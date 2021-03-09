<?php
/**
 * WPKoi Contact Widget
 *
 */
class WPKoi_Contact_Widget extends WP_Widget {

	protected $defaults = array(
		'title'          => '',
		'contact_desc'       => '',
		'contact_title'  => '',
		'contact_fields' => array(),
	);

	function __construct() {
		parent::__construct(
			'WPKoi_Contact_Widget', // Base ID
			__('WPKoi Contact', 'parvati-premium'), // Name
			array( 'description' => __( 'Add Your contact info to a widget.', 'parvati-premium' ), ) // Args
		);
	}

	function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$id            = isset( $args['id'] ) ? $args['id'] : '';
		$before_widget = $args['before_widget'];
		$after_widget  = $args['after_widget'];

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$contact_desc  = $instance['contact_desc'];
		$contact_title = $instance['contact_title'];
		$fields        = $instance['contact_fields'];

		echo $before_widget;

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if ( $contact_title ) {
			echo '<p class="contact-widget-title">' . esc_html( $contact_title ) . '</p>';
		}

		if ( $contact_desc ) {
			echo '<p class="contact-widget-desc">' . esc_html( $contact_desc ) . '</p>';
		}

		if ( $fields ) {
			echo '<ul class="contact-widget-items">';
			foreach ( $fields as $field ) {
				echo sprintf( '<li class="contact-widget-item"><i class="fa %1$s"></i> %2$s</li>', $field['icon'], $field['title'] );
			}
			echo '</ul>';
		}

		echo $after_widget;

	} // widget

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['contact_desc'] = sanitize_text_field( $new_instance['contact_desc'] );
		$instance['contact_title']  = sanitize_text_field( $new_instance['contact_title'] );
		$instance['contact_fields'] = $this->sanitize_contact_fields( $new_instance );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title         = $instance['title'];
		$contact_desc  = $instance['contact_desc'];
		$contact_title = $instance['contact_title'];
		$fields        = $instance['contact_fields'];

		$field_title_name = $this->get_field_name( 'contact_field_title' ) . '[]';
		$field_icon_name  = $this->get_field_name( 'contact_field_icon' ) . '[]';
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'parvati-premium' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" /></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'contact_title' ) ); ?>"><?php esc_html_e( 'Contact title:', 'parvati-premium' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'contact_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'contact_title' ) ); ?>" type="text" value="<?php echo esc_attr( $contact_title ); ?>" class="widefat" /></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'contact_desc' ) ); ?>"><?php esc_html_e( 'Contact description:', 'parvati-premium' ); ?></label><textarea id="<?php echo esc_attr( $this->get_field_id( 'contact_desc' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'contact_desc' ) ); ?>" class="widefat"><?php echo esc_textarea( $contact_desc ); ?></textarea></p>

		<p><?php esc_html_e( 'Add Your infos one by one with pressing the "Add Item" button.', 'parvati-premium' ); ?></p>
		<fieldset class="wpkoi-repeating-fields">
			<div class="inner">
				<?php
					if ( ! empty( $fields ) ) {
						$count = count( $fields );
						for ( $i = 0; $i < $count; $i++ ) {
							?>
							<div class="post-field">
								<label class="post-field-item"><?php _e( 'You can add icon code for Your button.<br>Example: <code>fa-file-pdf-o</code>.<br>Use the codes from <a href="https://fontawesome.com/icons?from=io" target="_blank">Font Awesome</a>', 'parvati-premium' ); ?>
									<input type="text" name="<?php echo esc_attr( $field_icon_name ); ?>" value="<?php echo esc_attr( $fields[ $i ]['icon'] ); ?>" class="widefat" />
								</label>

								<label class="post-field-item"><?php esc_html_e( 'Title:', 'parvati-premium' ); ?>
									<input type="text" name="<?php echo esc_attr( $field_title_name ); ?>" value="<?php echo esc_attr( $fields[ $i ]['title'] ); ?>" class="widefat" />
								</label>

								<p class="wpkoi-repeating-remove-action"><a href="#" class="button wpkoi-repeating-remove-field"><?php esc_html_e( 'Remove Item', 'parvati-premium' ); ?></a></p>
							</div>
							<?php
						}
					}
				?>
				<?php
				//
				// Add an empty and hidden set for jQuery
				//
				?>
				<div class="post-field field-prototype" style="display: none;">
					<label class="post-field-item"><?php echo wp_kses( sprintf( __( 'Icon (e.g. <code>fa-check</code> <a href="%s" target="_blank">Reference</a>):', 'parvati-premium' ), 'http://fontawesome.io/icons/' ), array( 'code' => array(), 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?>
						<input type="text" name="<?php echo esc_attr( $field_icon_name ); ?>" value="" class="widefat" />
					</label>

					<label class="post-field-item"><?php esc_html_e( 'Title:', 'parvati-premium' ); ?>
						<input type="text" name="<?php echo esc_attr( $field_title_name ); ?>" value="" class="widefat" />
					</label>

					<p class="wpkoi-repeating-remove-action"><a href="#" class="button wpkoi-repeating-remove-field"><?php esc_html_e( 'Remove Item', 'parvati-premium' ); ?></a></p>
				</div>
			</div>
			<a href="#" class="wpkoi-repeating-add-field button"><?php esc_html_e( 'Add Item', 'parvati-premium' ); ?></a>
		</fieldset>

		<?php
	} // form

	protected function sanitize_contact_fields( $instance ) {
		if ( empty( $instance ) || ! is_array( $instance ) ) {
			return array();
		}

		$icons  = $instance['contact_field_icon'];
		$titles = $instance['contact_field_title'];

		$count = max( count( $icons ), count( $titles ) );

		$new_fields = array();

		$records_count = 0;

		for ( $i = 0; $i < $count; $i++ ) {
			if ( empty( $titles[ $i ] ) && empty( $icons[ $i ] ) ) {
				continue;
			}

			$new_fields[ $records_count ]['icon']  = sanitize_key( $icons[ $i ] );
			$new_fields[ $records_count ]['title'] = sanitize_text_field( $titles[ $i ] );

			$records_count++;
		}
		return $new_fields;
	}
} // class

// register widget
function wpkoi_contact_widget_register() {
    register_widget( 'WPKoi_Contact_Widget' );
}
add_action( 'widgets_init', 'wpkoi_contact_widget_register' );