<?php
/**
 * WPKoi Posts Widget
 *
 */

class WPKoi_Posts_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'WPKoi_Posts_Widget', // Base ID
			__('WPKoi Advanced Posts', 'parvati-premium'), // Name
			array( 'description' => __( 'Posts or Events display.', 'parvati-premium' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$params = array();

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$title = '';
		if ( ! empty( $instance['title'] ) ) {
			$title = $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title;
		}

		unset( $params['title'] );
		
		if ( ! empty( $instance ) ) :
			$items = 5;
			if(isset($instance['posts_number']) && $instance['posts_number'] != ''){
				$items = (int)$instance['posts_number'];
			}
		
			if ( $instance['type'] == 'recent' ) {
				$query = array(
					'post_type'      => 'post',
					'posts_per_page' => $items
				);
				$posts = new WP_Query( $query );
			} elseif ( $instance['type'] == 'events' ) {
				$query = array(
					'post_type'      => 'wpkoi-events',
					'posts_per_page' => $items
				);
				$posts = new WP_Query( $query );
			} 
		
			echo $before_widget;
			echo $title;
			?>
			<ul class="wpkoi-posts-widget">
				<?php while ( $posts->have_posts() ) : $posts->the_post();  ?>
					<li>
                    	<?php if($instance['show_images']): ?>
                        <div class="post-image-thumb">
                        	<a href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
                        </div>
                        <?php endif; ?>
						<div class="post-content">
							<a href="<?php echo get_permalink(); ?>" class="post-title"><?php the_title(); ?></a>
							<?php if($instance['display_date']): 
									$date = get_the_date();
									if ( $instance['type'] == 'events' ) {
										$wpkoi_events_metabox_date     = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_date', true );
										$wpkoi_events_metabox_format   = get_post_meta( get_the_ID(), 'wpkoi_events_metabox_format', true );
										$wpkoi_display_date = date_create($wpkoi_events_metabox_date);
										$date = date_format( $wpkoi_display_date, $wpkoi_events_metabox_format );
									}
							?>
								<br /><span class="post-date"><?php echo esc_html( $date ); ?></span>
							<?php endif; ?>
						</div>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php
			echo $after_widget;
		endif; 
	}

	/**
	 * Back-end widget form.
	 */
        
	public function form( $instance ) {
		$instance   = wp_parse_args( (array) $instance, array(
			'title'        => '',
			'posts_number' => 5,
			'type'         => 'recent',
		) );
                
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'parvati-premium' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>"><?php esc_html_e( 'Number of Posts to Show:', 'parvati-premium' ); ?></label>
			<input size="3" style="width: 45px;" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_number' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['posts_number'] ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html_e( 'Select Type:', 'parvati-premium' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" class="widefat">
				<option value="recent" <?php selected( $instance['type'], 'recent' ); ?>><?php esc_html_e( 'Recent Posts', 'parvati-premium' ); ?></option>
                <?php if ( function_exists('wpkoi_events') ) { ?>
				<option value="events" <?php selected( $instance['type'], 'events' ); ?>><?php esc_html_e( 'WPKoi Events', 'parvati-premium' ); ?></option>
                <?php } ?>
			</select>
		</p>
		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'show_images' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_images' ) ); ?>" type="checkbox" <?php checked( isset( $instance['show_images'] ) ? $instance['show_images'] : 0 ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_images' ) ); ?>"><?php esc_html_e( 'Display Images?', 'parvati-premium' ); ?></label>
		</p>
		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'display_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_date' ) ); ?>" type="checkbox" <?php checked( isset( $instance['display_date'] ) ? $instance['display_date'] : 0 ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'display_date' ) ); ?>"><?php esc_html_e( 'Display Date?', 'parvati-premium' ); ?></label>
		</p>               
		
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                 = wp_parse_args( (array) $new_instance, $old_instance );
		$instance['title']        = $new_instance['title'];
		$instance['posts_number'] = $new_instance['posts_number'];
		$instance['show_images']  = isset( $new_instance['show_images'] );
		$instance['display_date'] = isset( $new_instance['display_date'] );

		return $instance;
	}

}

// register event widget
function wpkoi_posts_widget_register() {
    register_widget( 'WPKoi_Posts_Widget' );
}
add_action( 'widgets_init', 'wpkoi_posts_widget_register' );