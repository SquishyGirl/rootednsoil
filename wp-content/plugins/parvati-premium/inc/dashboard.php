<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'parvati_dashboard_inside_container', 'parvati_do_dashboard_tabs', 5 );
/**
 * Adds our tabs to the Parvati dashboard.
 *
 */
function parvati_do_dashboard_tabs() {
	$tabs = apply_filters( 'parvati_dashboard_tabs', array(
		'Modules' => array(
			'name' => __( 'Modules', 'parvati-premium' ),
			'url' => admin_url( 'themes.php?page=parvati-options' ),
			'class' => isset( $_GET['page'] ) && 'parvati-options' == $_GET['page'] && ! isset( $_GET['area'] ) ? 'active' : '',
		)
	) );

	// Don't print any markup if we only have one tab.
	if ( count( $tabs ) === 1 ) {
		return;
	}
	?>
	<div class="parvati-dashboard-tabs">
		<?php
		foreach ( $tabs as $tab ) {
			printf( '<a href="%1$s" class="%2$s">%3$s</a>',
				esc_url( $tab['url'] ),
				esc_attr( $tab['class'] ),
				esc_html( $tab['name'] )
			);
		}
		?>
	</div>
	<?php
}
