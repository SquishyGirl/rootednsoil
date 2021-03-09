<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WPKoi_Elements_Data_Table extends Widget_Base {
	public $unique_id = null;
	public function get_name() {
		return 'wpkoi-elements-data-table';
	}

	public function get_title() {
		return esc_html__( 'Data Table', 'wpkoi-elements' );
	}

	public function get_icon() {
		return 'eicon-table';
	}

   public function get_categories() {
		return [ 'wpkoi-addons-for-elementor' ];
	}

	protected function register_controls() {

  		/**
  		 * Data Table Header
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_data_table_header',
  			[
  				'label' => esc_html__( 'Header', 'wpkoi-elements' )
  			]
  		);
		
		$table_head_repeater = new Repeater();

		$table_head_repeater->add_control(
			'wpkoi_elements_data_table_header_col',
			array(
				'label' => esc_html__( 'Column Name', 'wpkoi-elements' ),
				'default' => 'Table Header',
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
			)
		);

		$table_head_repeater->add_control(
			'wpkoi_elements_data_table_header_col_icon_enabled',
			array(
				'label' => esc_html__( 'Enable Header Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'yes', 'wpkoi-elements' ),
				'label_off' => __( 'no', 'wpkoi-elements' ),
				'default' => 'false',
				'return_value' => 'true',
			)
		);

		$table_head_repeater->add_control(
			'wpkoi_elements_data_table_header_col_icon_new',
			array(
				'label' => esc_html__( 'Icon', 'wpkoi-elements' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'wpkoi_elements_data_table_header_col_icon',
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'fa-solid',
				],
				'condition' => [
					'wpkoi_elements_data_table_header_col_icon_enabled' => 'true'
				]
			)
		);

		$table_head_repeater->add_control(
			'wpkoi_elements_data_table_header_col_img_enabled',
			array(
				'label' => esc_html__( 'Enable Header Image', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'yes', 'wpkoi-elements' ),
				'label_off' => __( 'no', 'wpkoi-elements' ),
				'default' => 'false',
				'return_value' => 'true',
			)
		);

		$table_head_repeater->add_control(
			'wpkoi_elements_data_table_header_col_img',
			array(
				'label' => esc_html__( 'Image', 'wpkoi-elements' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'wpkoi_elements_data_table_header_col_img_enabled' => 'true',
				]
			)
		);

		$table_head_repeater->add_control(
			'wpkoi_elements_data_table_header_col_img_size',
			array(
				'label' => esc_html__( 'Image Size(px)', 'wpkoi-elements' ),
				'default' => '25',
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'condition' => [
					'wpkoi_elements_data_table_header_col_img_enabled' => 'true',
				]
			)
		);
		
		$this->add_control(
			'wpkoi_elements_data_table_header_cols_data',
			array(
				'type'    => Controls_Manager::REPEATER,
				'label'   => esc_html__( 'Header content', 'wpkoi-elements' ),
				'fields'  => $table_head_repeater->get_controls(),
				'seperator' => 'before',
				'default' => [
					[ 'wpkoi_elements_data_table_header_col' => 'Table Header' ],
					[ 'wpkoi_elements_data_table_header_col' => 'Table Header' ],
					[ 'wpkoi_elements_data_table_header_col' => 'Table Header' ],
					[ 'wpkoi_elements_data_table_header_col' => 'Table Header' ],
				],
				'title_field' => '{{wpkoi_elements_data_table_header_col}}',
			)
		);

  		$this->end_controls_section();

  		/**
  		 * Data Table Content
  		 */
  		$this->start_controls_section(
  			'wpkoi_elements_section_data_table_cotnent',
  			[
  				'label' => esc_html__( 'Content', 'wpkoi-elements' )
  			]
  		);

  		$table_body_repeater = new Repeater();

		$table_body_repeater->add_control(
			'wpkoi_elements_data_table_content_row_type',
			array(
				'label' => esc_html__( 'Row Type', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'row',
				'label_block' => false,
				'options' => [
					'row' => esc_html__( 'Row', 'wpkoi-elements' ),
					'col' => esc_html__( 'Column', 'wpkoi-elements' ),
				]
			)
		);

		$table_body_repeater->add_control(
			'wpkoi_elements_data_table_content_row_title',
			array(
				'label' => esc_html__( 'Cell Text', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => false,
				'default' => esc_html__( 'Content', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_data_table_content_row_type' => 'col'
				]
			)
		);

		$table_body_repeater->add_control(
			'wpkoi_elements_data_table_content_row_title_link',
			array(
				'label' => esc_html__( 'Link', 'wpkoi-elements' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'default' => [
						'url' => '',
						'is_external' => '',
					],
					'show_external' => true,
					'separator' => 'before',
					'condition' => [
					'wpkoi_elements_data_table_content_row_type' => 'col'
				]
			)
		);

		$table_body_repeater->add_control(
			'wpkoi_elements_data_table_content_row_colspan',
			array(
				'label' => esc_html__( 'Colspan', 'wpkoi-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'condition' => [
					'wpkoi_elements_data_table_content_row_type' => 'col'
				]
			)
		);
		
		$this->add_control(
			'wpkoi_elements_data_table_content_rows',
			array(
				'type'    => Controls_Manager::REPEATER,
				'label'   => esc_html__( 'Body content', 'wpkoi-elements' ),
				'fields'  => $table_body_repeater->get_controls(),
				'seperator' => 'before',
				'default' => [
					[ 'wpkoi_elements_data_table_content_row_type' => 'row' ],
					[ 'wpkoi_elements_data_table_content_row_type' => 'col' ],
					[ 'wpkoi_elements_data_table_content_row_type' => 'col' ],
					[ 'wpkoi_elements_data_table_content_row_type' => 'col' ],
					[ 'wpkoi_elements_data_table_content_row_type' => 'col' ],
				],
				'title_field' => '{{wpkoi_elements_data_table_content_row_type}}::{{wpkoi_elements_data_table_content_row_title}}',
			)
		);
		
  		$this->end_controls_section();

  		/**
		 * -------------------------------------------
		 * Tab Style (Data Table Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_data_table_style_settings',
			[
				'label' => esc_html__( 'General Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_data_table_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-data-table-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_data_table_container_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-data-table-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_data_table_container_margin',
			[
				'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-data-table-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
				[
					'name' => 'wpkoi_elements_data_table_border',
					'label' => esc_html__( 'Border', 'wpkoi-elements' ),
					'selector' => '{{WRAPPER}} .wpkoi-elements-data-table-wrap',
				]
		);

		$this->add_control(
			'wpkoi_elements_data_table_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-data-table-wrap' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_data_table_th_padding',
			[
				'label' => esc_html__( 'Table Header Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-data-table thead tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_data_table_td_padding',
			[
				'label' => esc_html__( 'Table Data Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
	 					'{{WRAPPER}} .wpkoi-elements-data-table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	 			],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wpkoi_elements_data_table_shadow',
				'selector' => '{{WRAPPER}} .wpkoi-elements-data-table-wrap',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Data Table Header Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_data_table_title_style_settings',
			[
				'label' => esc_html__( 'Header Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);


		$this->add_control(
			'wpkoi_elements_section_data_table_header_radius',
			[
				'label' => esc_html__( 'Header Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 7,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-data-table thead tr th:first-child' => 'border-radius: {{SIZE}}px 0px 0px 0px;',
					'{{WRAPPER}} .wpkoi-elements-data-table thead tr th:last-child' => 'border-radius: 0px {{SIZE}}px 0px 0px;',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_data_table_header_title_color',
			[
				'label' => esc_html__( 'Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-data-table thead tr th' => 'color: {{VALUE}};',
					'{{WRAPPER}} table.dataTable thead .sorting:after' => 'color: {{VALUE}};',
					'{{WRAPPER}} table.dataTable thead .sorting_asc:after' => 'color: {{VALUE}};',
					'{{WRAPPER}} table.dataTable thead .sorting_desc:after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_data_table_header_title_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#4a4893',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-data-table thead tr th' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             	'name' => 'wpkoi_elements_data_table_header_title_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-data-table thead tr th',
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_data_table_header_title_alignment',
			[
				'label' => esc_html__( 'Title Alignment', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left',
				'prefix_class' => 'wpkoi-elements-dt-th-align-',
			]
		);

		$this->end_controls_section();

		/**
		 * -------------------------------------------
		 * Tab Style (Data Table Content Style)
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'wpkoi_elements_section_data_table_content_style_settings',
			[
				'label' => esc_html__( 'Content Style', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_data_table_content_color_odd',
			[
				'label' => esc_html__( 'Color ( Odd Row )', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6d7882',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-data-table tbody > tr:nth-child(2n) td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_data_table_content_bg_odd_color',
			[
				'label' => esc_html__( 'Background Color (Odd Row)', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-data-table tbody > tr:nth-child(2n) td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_data_table_content_color_even',
			[
				'label' => esc_html__( 'Color ( Even Row )', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6d7882',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-data-table tbody > tr:nth-child(2n+1) td' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_data_table_content_bg_even_color',
			[
				'label' => esc_html__( 'Background Color (Even Row)', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-data-table tbody > tr:nth-child(2n+1) td' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             	'name' => 'wpkoi_elements_data_table_content_typography',
				'selector' => '{{WRAPPER}} .wpkoi-elements-data-table tbody tr td',
			]
		);

		$this->add_control(
			'wpkoi_elements_data_table_content_link_typo',
			[
				'label' => esc_html__( 'Link Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		/* Table Content Link */
		$this->start_controls_tabs( 'wpkoi_elements_data_table_link_tabs' );

			// Normal State Tab
			$this->start_controls_tab( 'wpkoi_elements_data_table_link_normal', [ 'label' => esc_html__( 'Normal', 'wpkoi-elements' ) ] );

			$this->add_control(
				'wpkoi_elements_data_table_link_normal_text_color',
				[
					'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#c15959',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-data-table-wrap table td a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			// Hover State Tab
			$this->start_controls_tab( 'wpkoi_elements_data_table_link_hover', [ 'label' => esc_html__( 'Hover', 'wpkoi-elements' ) ] );

			$this->add_control(
				'wpkoi_elements_data_table_link_hover_text_color',
				[
					'label' => esc_html__( 'Text Color', 'wpkoi-elements' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#6d7882',
					'selectors' => [
						'{{WRAPPER}} .wpkoi-elements-data-table-wrap table td a:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'wpkoi_elements_data_table_content_alignment',
			[
				'label' => esc_html__( 'Content Alignment', 'wpkoi-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'wpkoi-elements' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left',
				'prefix_class' => 'wpkoi-elements-dt-td-align-',
			]
		);

		$this->end_controls_section();

	}


	protected function render( ) {

   		$settings = $this->get_settings();

	  	$table_tr = [];
		$table_td = [];

	  	// Storing Data table content values
	  	foreach( $settings['wpkoi_elements_data_table_content_rows'] as $content_row ) {

	  		$row_id = rand(10, 1000);
	  		if( $content_row['wpkoi_elements_data_table_content_row_type'] == 'row' ) {
	  			$table_tr[] = [
	  				'id' => $row_id,
	  				'type' => $content_row['wpkoi_elements_data_table_content_row_type'],
	  			];

	  		}
	  		if( $content_row['wpkoi_elements_data_table_content_row_type'] == 'col' ) {
	  			$target = $content_row['wpkoi_elements_data_table_content_row_title_link']['is_external'] ? 'target="_blank"' : '';
	  			$nofollow = $content_row['wpkoi_elements_data_table_content_row_title_link']['nofollow'] ? 'rel="nofollow"' : '';

	  			$table_tr_keys = array_keys( $table_tr );
	  			$last_key = end( $table_tr_keys );

	  			$table_td[] = [
	  				'row_id' => $table_tr[$last_key]['id'],
	  				'type' => $content_row['wpkoi_elements_data_table_content_row_type'],
	  				'title' => $content_row['wpkoi_elements_data_table_content_row_title'],
	  				'link_url' => $content_row['wpkoi_elements_data_table_content_row_title_link']['url'],
	  				'link_target' => $target,
	  				'nofollow' => $nofollow,
					'colspan' => $content_row['wpkoi_elements_data_table_content_row_colspan']
	  			];
	  		}
	  	}

	  	$table_th_count = count($settings['wpkoi_elements_data_table_header_cols_data']);
	  	?>
		<div class="wpkoi-elements-data-table-wrap">
			<table id="wpkoi-elements-data-table-<?php echo $this->get_id(); ?>" class="tablesorter wpkoi-elements-data-table">
			    <thead>
			        <tr class="table-header">
			        	<?php foreach( $settings['wpkoi_elements_data_table_header_cols_data'] as $header_title ) : ?>
			            <th class="sorting">
			            	<?php if( $header_title['wpkoi_elements_data_table_header_col_icon_enabled'] == 'true' ) : ?>
			            		<?php   
								$migrated = isset( $header_title['__fa4_migrated']['wpkoi_elements_data_table_header_col_icon_new'] );
								$is_new = empty( $header_title['wpkoi_elements_data_table_header_col_icon'] );
								if ( $is_new || $migrated ) :
									Icons_Manager::render_icon( $header_title['wpkoi_elements_data_table_header_col_icon_new'], [ 'aria-hidden' => 'true' ] );
								else : ?>
									<i class="data-header-icon <?php echo $header_title['wpkoi_elements_data_table_header_col_icon']; ?>" aria-hidden="true"></i>
								<?php endif; ?>
			            	<?php endif; ?>
			            	<?php if( $header_title['wpkoi_elements_data_table_header_col_img_enabled'] == 'true' ) : ?>
			            		<img src="<?php echo esc_url( $header_title['wpkoi_elements_data_table_header_col_img']['url'] ) ?>" class="wpkoi-elements-data-table-th-img" style="width:<?php echo $header_title['wpkoi_elements_data_table_header_col_img_size'] ?>px" alt="<?php echo esc_attr( $header_title['wpkoi_elements_data_table_header_col'] ); ?>">
			            	<?php endif; ?>
			            	<?php echo esc_html( $header_title['wpkoi_elements_data_table_header_col'] ); ?>
			            </th>
			        	<?php endforeach; ?>
			        </tr>
			    </thead>
			  	<tbody>
					<?php for( $i = 0; $i < count( $table_tr ); $i++ ) : ?>
						<tr>
							<?php
								for( $j = 0; $j < count( $table_td ); $j++ ) {
									if( $table_tr[$i]['id'] == $table_td[$j]['row_id'] ) {
										?>
										<?php if( !empty( $table_td[$j]['link_url'] ) ) : ?>
											<td<?php echo $table_td[$j]['colspan'] > 1 ? ' colspan="'.$table_td[$j]['colspan'].'"' : ''; ?>>
												<a href="<?php echo esc_attr( $table_td[$j]['link_url'] ); ?>" <?php echo $table_td[$j]['link_target'] ?> <?php echo $table_td[$j]['nofollow'] ?>><?php echo $table_td[$j]['title']; ?></a>
											</td>
										<?php else: ?>
											<td<?php echo $table_td[$j]['colspan'] > 1 ? ' colspan="'.$table_td[$j]['colspan'].'"' : ''; ?>><?php echo $table_td[$j]['title']; ?></td>
										<?php endif; ?>
										<?php
									}
								}
							?>
						</tr>
			        <?php endfor; ?>
			    </tbody>
			</table>
		</div>
	  	<?php
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_Data_Table() );
