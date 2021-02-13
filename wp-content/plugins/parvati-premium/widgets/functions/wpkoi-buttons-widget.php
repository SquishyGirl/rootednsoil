<?php
/**
 * WPKoi Buttons Widget
 *
 */

class WPKoi_Buttons_Widget extends WP_Widget {

	protected $defaults = array(
		'title' => '',
		'rows'  => array(),
	);

	function __construct() {
		parent::__construct(
			'WPKoi_Buttons_Widget', // Base ID
			__('WPKoi Buttons', 'parvati-premium'), // Name
			array( 'description' => __( 'A list of buttons.', 'parvati-premium' ), ) // Args
		);
	}

	function widget( $args, $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$id            = isset( $args['id'] ) ? $args['id'] : '';
			$before_widget = $args['before_widget'];
			$after_widget  = $args['after_widget'];

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$rows = $instance['rows'];

			echo $before_widget;

			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if ( ! empty( $rows ) ) {
				?><div class="wpkoi-button-widget"><?php
					foreach ( $rows as $row ) {
						?>
						<a href="<?php echo esc_url( $row['url'] ); ?>" class="button">
							<?php if ( ! empty( $row['icon'] ) ) : ?>
								<i class="fa <?php echo esc_attr( $row['icon'] ); ?>"></i>
							<?php endif; ?>
							<?php if ( ! empty( $row['title'] ) ) : ?>
                                <?php echo esc_html( $row['title'] ); ?>
                            <?php endif; ?>
						</a>
						<?php
					}
				?></div><?php
			}

			echo $after_widget;

	} // widget

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title = $instance['title'];
		$rows  = $instance['rows'];

		$row_title_name    = $this->get_field_name( 'row_title' ) . '[]';
		$row_icon_name     = $this->get_field_name( 'row_icon' ) . '[]';
		$row_url_name      = $this->get_field_name( 'row_url' ) . '[]';
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'parvati-premium' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" /></p>

		<p><?php _e( 'Add or remove Your buttons. In the icon code field, You can add icon code for Your button.<br>Example: <code>fa-file-pdf-o</code>.<br>Use the codes from <a href="https://fontawesome.com/icons?from=io" target="_blank">Font Awesome</a>', 'parvati-premium' ); ?></p>
		<fieldset class="wpkoi-repeating-fields">
			<div class="inner">
				<?php
					if ( ! empty( $rows ) ) {
						$count = count( $rows );
						for ( $i = 0; $i < $count; $i ++ ) {
							?>
							<div class="post-field">
								<label class="post-field-item"><?php esc_html_e( 'Title:', 'parvati-premium' ); ?>
									<input type="text" name="<?php echo esc_attr( $row_title_name ); ?>" value="<?php echo esc_attr( $rows[ $i ]['title'] ); ?>" class="widefat" />
								</label>

								<label class="post-field-item"><?php esc_html_e( 'Icon code:', 'parvati-premium' ); ?>
									<input type="text" name="<?php echo esc_attr( $row_icon_name ); ?>" value="<?php echo esc_attr( $rows[ $i ]['icon'] ); ?>" class="widefat" />
								</label>

								<label class="post-field-item"><?php esc_html_e( 'Link URL:', 'parvati-premium' ); ?>
									<input type="text" name="<?php echo esc_attr( $row_url_name ); ?>" value="<?php echo esc_attr( $rows[ $i ]['url'] ); ?>" class="widefat" />
								</label>

								<p class="wpkoi-repeating-remove-action"><a href="#" class="button wpkoi-repeating-remove-field"><?php esc_html_e( 'Remove button', 'parvati-premium' ); ?></a></p>
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
					<label class="post-field-item"><?php esc_html_e( 'Title:', 'parvati-premium' ); ?>
						<input type="text" name="<?php echo esc_attr( $row_title_name ); ?>" value="" class="widefat" />
					</label>

					<label class="post-field-item"><?php esc_html_e( 'Icon code:', 'parvati-premium' ); ?>
						<input type="text" name="<?php echo esc_attr( $row_icon_name ); ?>" value="" class="widefat" />
					</label>

					<label class="post-field-item"><?php esc_html_e( 'Link URL:', 'parvati-premium' ); ?>
						<input type="text" name="<?php echo esc_attr( $row_url_name ); ?>" value="" class="widefat" />
					</label>

					<p class="wpkoi-repeating-remove-action"><a href="#" class="button wpkoi-repeating-remove-field"><?php esc_html_e( 'Remove button', 'parvati-premium' ); ?></a></p>
				</div>
			</div>
			<a href="#" class="wpkoi-repeating-add-field button"><?php esc_html_e( 'Add Button', 'parvati-premium' ); ?></a>
		</fieldset>
		<?php
	} // form

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['rows']  = $this->sanitize_instance_rows( $new_instance );

		return $instance;
	}

	protected function sanitize_instance_rows( $instance ) {
		if ( empty( $instance ) || ! is_array( $instance ) ) {
			return array();
		}

		$titles    = $instance['row_title'];
		$icons     = $instance['row_icon'];
		$urls      = $instance['row_url'];

		$count = max(
			count( $titles ),
			count( $subtitles ),
			count( $icons ),
			count( $urls )
		);

		$new_fields = array();

		$records_count = 0;

		for ( $i = 0; $i < $count; $i++ ) {
			if ( empty( $titles[ $i ] )
				 && empty( $icons[ $i ] )
				 && empty( $urls[ $i ] )
			) {
				continue;
			}

			$new_fields[ $records_count ]['title']    = sanitize_text_field( $titles[ $i ] );
			$new_fields[ $records_count ]['icon']     = sanitize_html_class( $icons[ $i ] );
			$new_fields[ $records_count ]['url']      = esc_url_raw( $urls[ $i ] );

			$records_count++;
		}
		return $new_fields;
	}

} // class

// register widget
function wpkoi_buttons_widget_register() {
    register_widget( 'WPKoi_Buttons_Widget' );
}
add_action( 'widgets_init', 'wpkoi_buttons_widget_register' );