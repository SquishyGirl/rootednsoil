<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Widget_WPKoi_Elements_Image_Accordion extends Widget_Base {

  public function get_name() {
    return 'wpkoi-elements-image-accordion';
  }

  public function get_title() {
    return esc_html__( 'Image Accordion', 'wpkoi-elements' );
  }

  public function get_icon() {
    return 'eicon-call-to-action';
  }

   public function get_categories() {
    return [ 'wpkoi-addons-for-elementor' ];
  }

  protected function register_controls() {
      /**
      * Image accordion Content Settings
      */
	$this->start_controls_section(
        'wpkoi_elements_section_img_accordion_settings',
        [
          'label' => esc_html__( 'Image Accordion Settings', 'wpkoi-elements' )
        ]
      );

      $this->add_control(
      'wpkoi_elements_img_accordion_type',
        [
        'label'         => esc_html__( 'Accordion Style', 'wpkoi-elements' ),
          'type'      => Controls_Manager::SELECT,
          'default'     => 'on-hover',
          'label_block'   => false,
          'options'     => [
            'on-hover'   => esc_html__( 'On Hover', 'wpkoi-elements' ),
            'on-click'   => esc_html__( 'On Click', 'wpkoi-elements' ),
          ],
        ]
    );
	
	$repeater = new Repeater();

	$repeater->add_control(
		'wpkoi_elements_accordion_bg',
		array(
		  'label' => esc_html__( 'Background Image', 'wpkoi-elements' ),
		  'type' => Controls_Manager::MEDIA,
		  'label_block' => true,
		  'default' => [
			  'url' => WPKOI_ELEMENTS_URL . 'elements/image-accordion/assets/accordion.png',
			],
		)
	);

	$repeater->add_control(
		'wpkoi_elements_accordion_tittle',
		array(
		  'label' => esc_html__( 'Title', 'wpkoi-elements' ),
		  'type' => Controls_Manager::TEXT,
		  'label_block' => true,
		  'default' => esc_html__( 'Accordion item title', 'wpkoi-elements' ),
		  'dynamic' => [ 'active' => true ]
		)
	);

	$repeater->add_control(
		'wpkoi_elements_accordion_content',
		array(
		  'label' => esc_html__( 'Content', 'wpkoi-elements' ),
		  'type' => Controls_Manager::WYSIWYG,
		  'label_block' => true,
		  'default' => esc_html__( 'Accordion content goes here!', 'wpkoi-elements' )
		)
	);

	$repeater->add_control(
		'wpkoi_elements_accordion_title_link',
		array(
		  'label' => esc_html__( 'Title Link', 'wpkoi-elements' ),
		  'type' => Controls_Manager::URL,
		  'label_block' => true,
		  'default' => [
				'url' => '#',
				'is_external' => '',
			],
			'show_external' => true,
		)
	);
	
	$this->add_control(
		'wpkoi_elements_img_accordions',
		array(
			'type'    => Controls_Manager::REPEATER,
			'label'   => esc_html__( 'Gallery items', 'wpkoi-elements' ),
			'fields'  => $repeater->get_controls(),
			'seperator' => 'before',
			'default' => [
				[ 'wpkoi_elements_accordion_bg' => WPKOI_ELEMENTS_URL . 'elements/image-accordion/assets/accordion.png' ],
				[ 'wpkoi_elements_accordion_bg' => WPKOI_ELEMENTS_URL . 'elements/image-accordion/assets/accordion.png' ],
				[ 'wpkoi_elements_accordion_bg' => WPKOI_ELEMENTS_URL . 'elements/image-accordion/assets/accordion.png' ],
				[ 'wpkoi_elements_accordion_bg' => WPKOI_ELEMENTS_URL . 'elements/image-accordion/assets/accordion.png' ],
			],
			'title_field' => '{{wpkoi_elements_accordion_tittle}}',
		)
	);

      $this->end_controls_section();


      /**
       * -------------------------------------------
       * Tab Style (Image accordion)
       * -------------------------------------------
       */
      $this->start_controls_section(
        'wpkoi_elements_section_img_accordion_style_settings',
        [
          'label' => esc_html__( 'Image Accordion Style', 'wpkoi-elements' ),
          'tab' => Controls_Manager::TAB_STYLE
        ]
      );

      $this->add_control(
        'wpkoi_elements_accordion_height',
        [
          'label' => esc_html__( 'Height', 'wpkoi-elements' ),
          'type' => Controls_Manager::TEXT,
          'default' => '400',
          'description' => 'Unit in px',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-img-accordion ' => 'height: {{VALUE}}px;',
          ],
        ]
      );

      $this->add_control(
        'wpkoi_elements_accordion_bg_color',
        [
          'label' => esc_html__( 'Background Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => '',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-img-accordion' => 'background-color: {{VALUE}};',
          ],
        ]
      );

      $this->add_responsive_control(
        'wpkoi_elements_accordion_container_padding',
        [
          'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
          'type' => Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', 'em', '%' ],
          'selectors' => [
              '{{WRAPPER}} .wpkoi-elements-img-accordion' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );

      $this->add_responsive_control(
        'wpkoi_elements_accordion_container_margin',
        [
          'label' => esc_html__( 'Margin', 'wpkoi-elements' ),
          'type' => Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', 'em', '%' ],
          'selectors' => [
              '{{WRAPPER}} .wpkoi-elements-img-accordion' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
      );

      $this->add_group_control(
        Group_Control_Border::get_type(),
        [
          'name' => 'wpkoi_elements_accordion_border',
          'label' => esc_html__( 'Border', 'wpkoi-elements' ),
          'selector' => '{{WRAPPER}} .wpkoi-elements-img-accordion',
        ]
      );

      $this->add_control(
        'wpkoi_elements_accordion_border_radius',
        [
          'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
          'type' => Controls_Manager::SLIDER,
          'default' => [
            'size' => 4,
          ],
          'range' => [
            'px' => [
              'max' => 500,
            ],
          ],
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-img-accordion' => 'border-radius: {{SIZE}}px;',
          ],
        ]
      );

      $this->add_group_control(
        Group_Control_Box_Shadow::get_type(),
        [
          'name' => 'wpkoi_elements_accordion_shadow',
          'selector' => '{{WRAPPER}} .wpkoi-elements-img-accordion',
        ]
      );

      $this->add_control(
        'wpkoi_elements_accordion_img_overlay_color',
        [
          'label' => esc_html__( 'Overlay Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => 'rgba(0, 0, 0, .3)',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-img-accordion a:after' => 'background-color: {{VALUE}};',
          ],
        ]
      );

      $this->add_control(
        'wpkoi_elements_accordion_img_hover_color',
        [
          'label' => esc_html__( 'Hover Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => 'rgba(0, 0, 0, .5)',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-img-accordion a:hover .overlay' => 'background-color: {{VALUE}};',
          ],
        ]
      );

      $this->end_controls_section();

      /**
       * -------------------------------------------
       * Tab Style (Image accordion Content Style)
       * -------------------------------------------
       */
      $this->start_controls_section(
        'wpkoi_elements_section_img_accordion_typography_settings',
        [
          'label' => esc_html__( 'Color &amp; Typography', 'wpkoi-elements' ),
          'tab' => Controls_Manager::TAB_STYLE
        ]
      );

      $this->add_control(
        'wpkoi_elements_accordion_title_text',
        [
          'label' => esc_html__( 'Title', 'wpkoi-elements' ),
          'type' => Controls_Manager::HEADING,
          'separator' => 'before'
        ]
      );

      $this->add_control(
        'wpkoi_elements_accordion_title_color',
        [
          'label' => esc_html__( 'Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#fff',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-img-accordion .overlay h2' => 'color: {{VALUE}};',
          ],
        ]
      );

      $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
          'name' => 'wpkoi_elements_accordion_title_typography',
          'selector' => '{{WRAPPER}} .wpkoi-elements-img-accordion .overlay h2',
        ]
      );

      $this->add_control(
        'wpkoi_elements_accordion_content_text',
        [
          'label' => esc_html__( 'Content', 'wpkoi-elements' ),
          'type' => Controls_Manager::HEADING,
          'separator' => 'before'
        ]
      );

      $this->add_control(
        'wpkoi_elements_accordion_content_color',
        [
          'label' => esc_html__( 'Color', 'wpkoi-elements' ),
          'type' => Controls_Manager::COLOR,
          'default' => '#fff',
          'selectors' => [
            '{{WRAPPER}} .wpkoi-elements-img-accordion .overlay p' => 'color: {{VALUE}};',
          ],
        ]
      );

      $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
          'name' => 'wpkoi_elements_accordion_content_typography',
          'selector' => '{{WRAPPER}} .wpkoi-elements-img-accordion .overlay p',
        ]
      );

      $this->end_controls_section();

  }


  protected function render( ) {

      $settings = $this->get_settings_for_display();

      if( !empty($settings['wpkoi_elements_img_accordions']) ) :
      ?>
      <div class="wpkoi-elements-img-accordion" id="wpkoi-elements-img-accordion-<?php echo $this->get_id(); ?>">
        <?php foreach( $settings['wpkoi_elements_img_accordions'] as $img_accordion ) :
            $wpkoi_elements_accordion_link = $img_accordion['wpkoi_elements_accordion_title_link']['url'];
            $target = $img_accordion['wpkoi_elements_accordion_title_link']['is_external'] ? 'target="_blank"' : '';
            $nofollow = $img_accordion['wpkoi_elements_accordion_title_link']['nofollow'] ? 'rel="nofollow"' : '';
        ?>
          <a href="<?php echo esc_url($wpkoi_elements_accordion_link); ?>" <?php echo $target; ?> <?php echo $nofollow; ?> style="background-image: url(<?php echo esc_url($img_accordion['wpkoi_elements_accordion_bg']['url']); ?>);">
            <div class="overlay">
              <div class="overlay-inner">
                <h2><?php echo $img_accordion['wpkoi_elements_accordion_tittle']; ?></h2>
                <p><?php echo $img_accordion['wpkoi_elements_accordion_content']; ?></p>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
        <?php if( 'on-hover' === $settings['wpkoi_elements_img_accordion_type'] ) : ?>
        <style>
          #wpkoi-elements-img-accordion-<?php echo $this->get_id(); ?> a:hover {
            flex: 3;
          }
          #wpkoi-elements-img-accordion-<?php echo $this->get_id(); ?> a:hover .overlay-inner * {
            opacity: 1;
            visibility: visible;
            transform: none;
            transition: all .3s .3s;
          }
        </style>
        <?php endif; ?>
        <?php if( 'on-click' === $settings['wpkoi_elements_img_accordion_type'] ) : ?>
        <script>
          jQuery(document).ready(function($) {
            $('#wpkoi-elements-img-accordion-<?php echo $this->get_id(); ?> a').on('click', function(e) {
              e.preventDefault();
              $('#wpkoi-elements-img-accordion-<?php echo $this->get_id(); ?> a').css('flex', '1');
              $('#wpkoi-elements-img-accordion-<?php echo $this->get_id(); ?> a').find('.overlay-inner').removeClass('overlay-inner-show');
              $(this).find('.overlay-inner').addClass('overlay-inner-show');
              $(this).css('flex', '3');
            });
            $('#wpkoi-elements-img-accordion-<?php echo $this->get_id(); ?> a').on('blur', function(e) {
              $('#wpkoi-elements-img-accordion-<?php echo $this->get_id(); ?> a').css('flex', '1');
              $('#wpkoi-elements-img-accordion-<?php echo $this->get_id(); ?> a').find('.overlay-inner').removeClass('overlay-inner-show');
            });
          });
        </script>
        <?php endif; ?>
      <?php endif; ?>
      <?php

    }

  protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_WPKoi_Elements_Image_Accordion() );