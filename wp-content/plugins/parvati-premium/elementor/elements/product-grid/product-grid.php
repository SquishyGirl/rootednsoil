<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_WPKoi_Elements_Product_Grid extends Widget_Base {
	

	public function get_name() {
		return 'eicon-woocommerce';
	}

	public function get_title() {
		return esc_html__( 'Product Grid', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

   public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}


	protected function register_controls() {

		// Content Controls
  		$this->start_controls_section(
  			'wpkoi_elements_section_product_grid_settings',
  			[
  				'label' => esc_html__( 'Product Settings', 'wpkoi-elements' )
  			]
  		);

		$this->add_control(
			'wpkoi_elements_product_grid_product_filter',
			[
				'label' => esc_html__( 'Filter By', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'recent-products',
				'options' => [
					'recent-products' => esc_html__( 'Recent Products', 'wpkoi-elements' ),
					'featured-products' => esc_html__( 'Featured Products', 'wpkoi-elements' ),
					'best-selling-products' => esc_html__( 'Best Selling Products', 'wpkoi-elements' ),
					'sale-products' => esc_html__( 'Sale Products', 'wpkoi-elements' ),
					'top-products' => esc_html__( 'Top Rated Products', 'wpkoi-elements' ),
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_product_grid_column',
			[
				'label' => esc_html__( 'Columns', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'1' => esc_html__( '1', 'wpkoi-elements' ),
					'2' => esc_html__( '2', 'wpkoi-elements' ),
					'3' => esc_html__( '3', 'wpkoi-elements' ),
					'4' => esc_html__( '4', 'wpkoi-elements' ),
					'5' => esc_html__( '5', 'wpkoi-elements' ),
					'6' => esc_html__( '6', 'wpkoi-elements' ),
				],
			]
		);

		$this->add_control(
		  'wpkoi_elements_product_grid_products_count',
		  [
		     'label'   => __( 'Products Count', 'wpkoi-elements' ),
		     'type'    => Controls_Manager::NUMBER,
		     'default' => 4,
		     'min'     => 1,
		     'max'     => 1000,
		     'step'    => 1,
		  ]
		);


		$this->add_control(
			'wpkoi_elements_product_grid_categories',
			[
				'label' => esc_html__( 'Product Categories', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => wpkoi_elements_woocommerce_product_categories(),
			]
		);

		// $this->add_control(
		// 	'wpkoi_elements_product_grid_style_preset',
		// 	[
		// 		'label' => esc_html__( 'Style Preset', 'wpkoi-elements' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'default' => 'wpkoi-elements-product-simple',
		// 		'options' => [
		// 			'wpkoi-elements-product-simple' => esc_html__( 'Simple Style', 'wpkoi-elements' ),
		// 			'wpkoi-elements-product-reveal' => esc_html__( 'Reveal Style', 'wpkoi-elements' ),
		// 			'wpkoi-elements-product-overlay' => esc_html__( 'Overlay Style', 'wpkoi-elements' ),
		// 			'eacs-product-default' => esc_html__( 'None (Use Theme Style)', 'wpkoi-elements' ),
		// 		],
		// 	]
		// );

		$this->add_control(
			'wpkoi_elements_product_grid_rating',
			[
				'label' => esc_html__( 'Show Product Rating?', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'wpkoi_elements_product_grid_styles',
			[
				'label' => esc_html__( 'Products Styles', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_product_grid_background_color',
			[
				'label' => esc_html__( 'Content Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce ul.products li.product' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_peoduct_grid_border',
				'selector' => '{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce ul.products li.product',
			]
		);
		
		$this->add_control(
			'wpkoi_elements_peoduct_grid_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce ul.products li.product' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
				
		
		$this->end_controls_section();


		$this->start_controls_section(
			'wpkoi_elements_section_product_grid_typography',
			[
				'label' => esc_html__( 'Color &amp; Typography', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_product_grid_product_title_heading',
			[
				'label' => __( 'Product Title', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_product_grid_product_title_color',
			[
				'label' => esc_html__( 'Product Title Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce ul.products li.product .woocommerce-loop-product__title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_product_grid_product_title_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce ul.products li.product .woocommerce-loop-product__title',
			]
		);

		$this->add_control(
			'wpkoi_elements_product_grid_product_price_heading',
			[
				'label' => __( 'Product Price', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);


		$this->add_control(
			'wpkoi_elements_product_grid_product_price_color',
			[
				'label' => esc_html__( 'Product Price Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#272727',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce ul.products li.product .price' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_product_grid_product_price_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce ul.products li.product .price',
			]
		);

		$this->add_control(
			'wpkoi_elements_product_grid_product_rating_heading',
			[
				'label' => __( 'Star Rating', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_product_grid_product_rating_color',
			[
				'label' => esc_html__( 'Rating Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f2b01e',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce .star-rating::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce .star-rating span::before' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_product_grid_product_rating_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce ul.products li.product .star-rating',
			]
		);


		$this->end_controls_section();

		
		$this->start_controls_section(
			'wpkoi_elements_section_product_grid_add_to_cart_styles',
			[
				'label' => esc_html__( 'Add to Cart Button Styles', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);


		$this->start_controls_tabs( 'wpkoi_elements_product_grid_add_to_cart_style_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'wpkoi-elements' ) ] );

		$this->add_control(
			'wpkoi_elements_product_grid_add_to_cart_color',
			[
				'label' => esc_html__( 'Button Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce li.product .button.add_to_cart_button' => 'color: {{VALUE}};',
				],
			]
		);
				
		$this->add_control(
			'wpkoi_elements_product_grid_add_to_cart_background',
			[
				'label' => esc_html__( 'Button Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce li.product .button.add_to_cart_button' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_product_grid_add_to_cart_border',
				'selector' => '{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce li.product .button.add_to_cart_button',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_product_grid_add_to_cart_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce li.product .button.add_to_cart_button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'wpkoi_elements_product_grid_add_to_cart_hover_styles', [ 'label' => esc_html__( 'Hover', 'wpkoi-elements' ) ] );

		$this->add_control(
			'wpkoi_elements_product_grid_add_to_cart_hover_color',
			[
				'label' => esc_html__( 'Button Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce li.product .button.add_to_cart_button:hover' => 'color: {{VALUE}};',
				],
			]
		);
				
		$this->add_control(
			'wpkoi_elements_product_grid_add_to_cart_hover_background',
			[
				'label' => esc_html__( 'Button Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f9f9f9',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce li.product .button.add_to_cart_button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
				
		$this->add_control(
			'wpkoi_elements_product_grid_add_to_cart_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-product-grid .woocommerce li.product .button.add_to_cart_button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();
		
		$this->end_controls_tabs();


		$this->end_controls_section();
		
		
	}


	protected function render( ) {
		
			
		$settings = $this->get_settings();
			
		$product_count = $this->get_settings( 'wpkoi_elements_product_grid_products_count' );
		$columns = $this->get_settings( 'wpkoi_elements_product_grid_column' );
		$show_rating = ( ($settings['wpkoi_elements_product_grid_rating'] 	== 'yes') ? "show_rating" : "hide_rating" );
		$product_grid_classes = $show_rating;

		$get_product_categories = $settings['wpkoi_elements_product_grid_categories']; // get custom field value
		if($get_product_categories >= 1 ) { 
			$category_ids = implode(', ', $get_product_categories); 
		} else {
			$category_ids = '';
		}

	?>

<div id="wpkoi-elements-product-grid-<?php echo esc_attr($this->get_id()); ?>" class="wpkoi-elements-product-carousel wpkoi-elements-product-grid <?php echo $product_grid_classes; ?>">

	<?php if ( ($settings['wpkoi_elements_product_grid_product_filter']) == 'recent-products' ) : ?>

		<?php echo do_shortcode("[recent_products per_page=\"$product_count\" columns=\"$columns\" category=\"$category_ids\"]") ?>

	<?php elseif ( ($settings['wpkoi_elements_product_grid_product_filter']) == 'featured-products' ) : ?>

		<?php echo do_shortcode("[featured_products per_page=\"$product_count\" columns=\"$columns\" category=\"$category_ids\"]") ?>

	<?php elseif ( ($settings['wpkoi_elements_product_grid_product_filter']) == 'best-selling-products' ) : ?>

		<?php echo do_shortcode("[best_selling_products per_page=\"$product_count\" columns=\"$columns\" category=\"$category_ids\"]") ?>

	<?php elseif ( ($settings['wpkoi_elements_product_grid_product_filter']) == 'sale-products' ) : ?>

		<?php echo do_shortcode("[sale_products per_page=\"$product_count\" columns=\"$columns\" category=\"$category_ids\"]") ?>

	<?php else: ?>

		<?php echo do_shortcode("[top_rated_products per_page=\"$product_count\" columns=\"$columns\" category=\"$category_ids\"]") ?>

	<?php endif; ?>

    <div class="clearfix"></div>
</div>

	
	<?php
	
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_Product_Grid() );