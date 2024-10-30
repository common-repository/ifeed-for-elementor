<?php
namespace iFeedForElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Color;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Ifeed_For_Elementor_Widget extends Widget_Base {

	public function get_name() {
		return 'ifeed-for-elementor';
	}

	public function get_title() {
		return __( 'Instagram Feed', 'ifeed-for-elementor' );
	}

	public function get_icon() {
		return 'fa fa-instagram';
	}

	public function get_categories() {
		return [ 'iffe-items' ];
	}

	protected function _register_controls() {

		$this->iffe_content_layout_options();

		$this->iffe_style_layout_options();
		$this->iffe_style_image_options();
		$this->iffe_style_meta_options();
		
	}

	/**
	 * Content Layout Options.
	 */
	private function iffe_content_layout_options() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'ifeed-for-elementor' ),
			]
		);

		$options 		= get_option( 'iffe_options' ); 
		$access_token 	= $options['access_token'];

		if( !empty( $access_token ) ){

			$this->add_control(
				'access_token',
				[
					'label' => __( 'Access Token', 'ifeed-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html( $access_token ),
				]
			);

		}else{

			$this->add_control(
				'access_token',
				[
					'label' => __( 'Access Token', 'ifeed-for-elementor' ),
					'description' => sprintf( __( 'You have not set Access Token. Please click here to %s', 'ifeed-for-elementor' ), '<a target="_self" href="'.admin_url('admin.php?page=ifeed-for-elementor').'">' . __( 'Set Access Token', 'ifeed-for-elementor' ) . '</a>' ),
					'type' => Controls_Manager::TEXT,
					'default' => '',
				]
			);

		}
		
		$this->add_control(
			'feed_columns',
			[
				'label' => __( 'Columns', 'ifeed-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7' => '7',
					'8' => '8',
				],
				'prefix_class' => 'elementor-grid-',
				'frontend_available' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'number_of_images',
			[
				'label' => __( 'Number of Images', 'ifeed-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 9,
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => __( 'Image Size', 'ifeed-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'standard_resolution',
				'options' => [
					'standard_resolution' => esc_html__( 'Standard', 'ifeed-for-elementor' ),
					'low_resolution' => esc_html__( 'Medium', 'ifeed-for-elementor' ),
					'thumbnail' => esc_html__( 'Small', 'ifeed-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'show_likes',
			[
				'label' => __( 'Likes', 'ifeed-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ifeed-for-elementor' ),
				'label_off' => __( 'Hide', 'ifeed-for-elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_comments',
			[
				'label' => __( 'Comments', 'ifeed-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'ifeed-for-elementor' ),
				'label_off' => __( 'Hide', 'ifeed-for-elementor' ),
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Style Layout Options.
	 */
	private function iffe_style_layout_options() {

		// Layout.
		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => __( 'Layout', 'ifeed-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Columns margin.
		$this->add_control(
			'feed_columns_margin',
			[
				'label'     => __( 'Columns margin', 'ifeed-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iffe-grid-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
					
				],
			]
		);

		// Row margin.
		$this->add_control(
			'grid_style_rows_margin',
			[
				'label'     => __( 'Rows margin', 'ifeed-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .iffe-grid-container' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Style Image Options.
	 */
	private function iffe_style_image_options() {

		// Box.
		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'ifeed-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Image border radius.
		$this->add_control(
			'feed_image_border_width',
			[
				'label'      => __( 'Border Width', 'ifeed-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .iffe-feed-main .iffe-feed-item img' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],				
			]
		);

		// Image border radius.
		$this->add_control(
			'feed_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ifeed-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iffe-feed-main .iffe-feed-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .iffe-feed-main .iffe-feed-item a:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'feed_image_style' );

		// Normal tab.
		$this->start_controls_tab(
			'feed_image_style_normal',
			[
				'label'     => __( 'Normal', 'ifeed-for-elementor' ),
			]
		);

		// Normal border color.
		$this->add_control(
			'feed_image_style_normal_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'ifeed-for-elementor' ),
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .iffe-feed-main .iffe-feed-item img' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'feed_image_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .iffe-feed-main .iffe-feed-item img',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'feed_image_style_hover',
			[
				'label'     => __( 'Hover', 'ifeed-for-elementor' ),
			]
		);

		// Hover background color.
		$this->add_control(
			'feed_image_style_hover_overlay_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Overlay Color', 'ifeed-for-elementor' ),
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default' => 'rgba(0,0,0,0.5)',
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .iffe-feed-main .iffe-feed-item a:before' => 'background: {{VALUE}};',
				],
			]
		);

		// Hover border color.
		$this->add_control(
			'feed_image_style_hover_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'ifeed-for-elementor' ),
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .iffe-feed-main .iffe-feed-item:hover img' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Hover box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'feed_image_style_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .iffe-feed-main .iffe-feed-item:hover img',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Style > Meta.
	 */
	private function iffe_style_meta_options() {
		// Tab.
		$this->start_controls_section(
			'section_feed_meta_style',
			[
				'label'     => __( 'Meta', 'ifeed-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		// Meta color.
		$this->add_control(
			'feed_meta_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'ifeed-for-elementor' ),
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .iffe-feed-main .iffe-feed-item .iffe-feed-likes-comments span'      => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'feed_meta_style_size',
			[
				'label' => __( 'Size', 'ifeed-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '16',
				'selectors' => [
					'{{WRAPPER}} .iffe-feed-main .iffe-feed-item a .iffe-feed-likes-comments span'      => 'font-size: {{VALUE}}px;',
				],
			]
		);

		$this->end_controls_section();
	}

	private function ifeed_for_elementor_feeds( $access_token, $image_num, $image_resolution ) {    
	    $url = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=' . trim( $access_token ). '&count=' . trim( $image_num );

	    $feeds_json = wp_remote_fopen( $url );

	    $feeds_obj 	= json_decode( $feeds_json, true ); 

	    $feeds_images_array = array();

	    if ( 200 == $feeds_obj['meta']['code'] ) {

	        if ( ! empty( $feeds_obj['data'] ) ) {

	            foreach ( $feeds_obj['data'] as $data ) { 
	                array_push( $feeds_images_array, array( $data['images'][$image_resolution]['url'], $data['link'], $data['likes'], $data['comments'], $data['type'] ) );
	            }

	            $ending_array = array(
	                'images' => $feeds_images_array,
	            );

	            return $ending_array;
	        }
	    }
	}

	protected function render( $instance = [] ) {

		// Get settings.
		$settings = $this->get_settings();

		?>
		<div class="iffe-feed-main">

			<div class="iffe-feed-inner">

				<?php

				$access_token = $settings['access_token'];

				$number_of_images = $settings['number_of_images'];

				$image_size = $settings['image_size'];

				$show_likes = $settings['show_likes'];

				$show_comments = $settings['show_comments'];

				$insta_feeds = $this->ifeed_for_elementor_feeds( esc_html( $access_token ), absint( $number_of_images ), esc_html( $image_size ) );

				$count 	= count( $insta_feeds['images'] );

			    ?>

				<div class="iffe-feed-items iffe-grid-container elementor-grid">
					<?php
				        for ( $i = 0; $i < $count; $i ++ ) {
				            if ( $insta_feeds['images'][ $i ] ) { ?>

				            	<div class="iffe-feed-item feed-type-<?php echo esc_attr( $insta_feeds['images'][ $i ][4] ); ?>">

				            		<a href="<?php echo esc_url( $insta_feeds['images'][ $i ][1]); ?>" target="_blank">

				            			<img src="<?php echo esc_url( $insta_feeds['images'][ $i ][0] ); ?>" alt="">

				            			<?php if ( 'yes' === $show_likes || 'yes' === $show_comments ) { ?>
					            			<div class="iffe-feed-likes-comments">
					            				<?php if ( 'yes' === $show_likes ) { ?>
					            					<span class="iffe-feed-likes"><i class="fa fa-heart-o" aria-hidden="true"></i> <?php echo absint( $insta_feeds['images'][ $i ][2]['count']); ?></span>
					            				<?php } ?>
					            				<?php if ( 'yes' === $show_comments ) { ?>
					            					<span class="iffe-feed-comments"><i class="fa fa-comment-o" aria-hidden="true"></i> <?php echo absint( $insta_feeds['images'][ $i ][3]['count']); ?></span>
					            				<?php } ?>
					            			</div>	
					            		<?php } ?>			            			
				            		</a>
				            	</div>
				                <?php
				            }
				        } ?>
				</div>

			</div>			      						               
		</div>
		<?php

	}
}