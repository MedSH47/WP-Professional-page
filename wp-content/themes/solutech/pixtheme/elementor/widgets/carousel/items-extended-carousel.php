<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Items_Extended_Carousel extends Base_Posts_Carousel {

    public function get_name() {
        return 'pixtheme-items-extended-carousel';
    }

    public function get_title() {
        return esc_html__( 'Items Carousel with Filter', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_keywords() {
        return [ 'services', 'projects', 'team', 'post', 'product', 'carousel' ];
    }

    public function get_script_depends() {
        return [
            'pixtheme-widgets-carousel',
            'pixtheme-widgets-projects-filter'
        ];
    }
    
    protected function get_post_type() {
        return 'post';
    }

    protected function get_taxonomy() {
        return 'category';
    }

    protected function register_controls() {
        $this->add_section_content();
        //$this->add_image_size_section();
        parent::register_controls();
        $this->update_controls();
    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        
		$this->add_control(
			'style',
			[
				'label' => esc_html__( 'Style', 'solutech' ),
				'type' => 'radio_images',
                'default' => 'bottom-info',
				'options' => [
                    'hover-info' => 'isotop_hover-info.png;Hover Info',
                    'bottom-info' => 'isotop_bottom-info.png;Bottom Info',
                    'bottom-info boxed' => 'isotop_bottom-info.png;Bottom Boxed',
                    'bottom-desc' => 'isotop_bottom-desc.png;Bottom Description',
				]
			]
		);

        $this->add_control(
            'title',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__( 'Heading', 'solutech' ),
                'default' => esc_html__( 'Projects', 'solutech' ),
            ]
        );

        $this->add_control(
            'show_filter',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Show filter', 'solutech' ),
                'default' => 'yes',
                'label_off' => esc_html__( 'Hide', 'solutech' ),
                'label_on' => esc_html__( 'Show', 'solutech' ),
            ]
        );

        $this->add_control(
            'cols',
            [
                'label' => esc_html__( 'Items per row', 'solutech' ),
                'description' => esc_html__( 'How many items should be shown per row?', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '2' => esc_html__( '2 columns', 'solutech' ),
                    '3' => esc_html__( '3 columns', 'solutech' ),
                    '4' => esc_html__( '4 columns', 'solutech' ),
                ),
                'default' => '3',
            ]
        );

        $this->add_control(
            'image_proportions',
            [
                'label' => esc_html__( 'Image proportions', 'solutech' ),
                'description' => esc_html__( 'The width of the loaded portfolio preview must be at least the base width of the image (see Appearance->Customize->Portfolio->Image Size)', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'square' => esc_html__( 'Square', 'solutech' ),
                    'landscape' => esc_html__( 'Landscape', 'solutech' ),
                    'portrait' => esc_html__( 'Portrait', 'solutech' ),
                    'original' => esc_html__( 'Original', 'solutech' ),
                ),
                'default' => 'square',
            ]
        );

        $this->end_controls_section();
    }

    protected function add_image_size_section() {
        $this->start_controls_section(
            'image_size_section',
            [
                'label' => esc_html__( 'Image Size', 'solutech' ),
            ]
        );

        $this->add_control(
            'image_size_default',
            [
                'label'        => esc_html__( 'Use Default Thumbnail Size', 'solutech' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '1',
                'return_value' => '1',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image_size',
                'default'   => 'full',
                'condition' => [
                    'image_size_default!' => '1',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function update_controls() {

        $this->update_responsive_control(
            'slides_per_view',
            [
                'default'        => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
            ]
        );

        $this->update_responsive_control(
            'slides_per_group',
            [
                'default'        => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
            ]
        );

        $this->update_responsive_control(
            'slides_per_column',
            [
                'default'        => '2',
                'tablet_default' => '2',
                'mobile_default' => '1',
            ]
        );

        $this->update_control(
            'show_dots',
            [
                'default' => 'no',
            ]
        );

        $this->update_control(
            'query_type',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => 'custom_query',
            ]
        );

        $this->update_control(
            'product_type',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => 'all',
            ]
        );
    }

    protected function print_slider( array $settings = null ) {
        if ( null === $settings ) {
            $settings = $this->get_settings_for_display();
        }
        
        $arr_taxonomies = [
            'post' => [
                'category',
                'include_post_slugs'
            ],
            'pix-service' => [
                'pix-service-cat',
                'include_service_slugs'
            ],
            'pix-portfolio' => [
                'pix-portfolio-cat',
                'include_portfolio_slugs'
            ],
            'pix-team' => [
                'pix-team-cat',
                'include_team_slugs'
            ],
            'product' => [
                'product_cat',
                'include_product_slugs'
            ],
        ];
        
        $style = $settings['style'] != '' ? $settings['style'] : 'hover-info';
        $col = $settings['col'] != '' ? $settings['col'] : '3';
        $image_size = $settings['img_proportions'];
        if($col == 3){
            $image_size .= '-col-3';
        } elseif($col > 3) {
            $image_size .= '-col-4';
        }
        $image_size .= pixtheme_retina() ? '-retina' : '';
        
        $post_type = $settings['post_type'];
        
        $slider_settings = $this->get_slider_settings( $settings );
        
        $default_settings = [
		    'class' => ['pix-extended-carousel-container', 'pix-carousel', 'pix-gallery', $post_type, 'pix-' . esc_attr($style) . '-container']
		];

		$slider_settings = array_merge_recursive( $default_settings, $slider_settings );

        $this->add_render_attribute( 'slider', $slider_settings );
        
        $terms = [];
        if ( 'yes' === $settings['show_filter'] ){
            $attributes = [
                'taxonomy' => $arr_taxonomies[$post_type][0],
            ];
            $term_ids = [];
            if ( ! empty( $term_slugs = $settings[$arr_taxonomies[$post_type][1]] ) ) :
                foreach( $term_slugs as $slug ) {
                    $term = get_term_by( 'slug', $slug, $arr_taxonomies[$post_type][0] );
                    if ( isset( $term->term_id ) ) {
                        $term_ids[] = $term->term_id;
                    }
                }
                $attributes['include'] = $term_ids;
            endif;
            $terms = get_terms( $attributes );
        }
        
        
        ?>

        <div <?php $this->print_render_attribute_string( 'slider' ); ?>>
            <?php if ( ! empty( $title = $settings['title'] ) || 'yes' === $settings['show_filter'] ) : ?>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="pix-section-top-line">
                            <?php if ( ! empty( $title = $settings['title'] ) ) : ?>
                            <div class="pix-section-title text-left section__title">
                                <h2 class="pix-title-h2"><?php echo wp_kses($title, 'post'); ?></h2>
                            </div>
                            <?php endif; ?>
                            <?php if ( 'yes' === $settings['show_filter'] ) : ?>
                            <div class="pix-gallery-cats pix-project-categories-container section__titleFilter">
                                <a class="active" data-project-type="all" href="#"><?php echo esc_html__( 'All', 'solutech' ); ?></a>
                                <?php
                                foreach ( $terms as $term ) :
                                    $term_name = $term->name;
                                    $term_id = $term->term_id;
                                    echo '<a data-term-id="' . esc_attr( $term_id ) . '" href="#">' . esc_attr( $term_name ) . '</a>';
                                endforeach;
                                ?>
                            </div>
                            <?php endif; ?>
                            <div class="arrows"></div>
                            <div class="pix-gallery-slider-controls">
                                <div class="pix-slider-prev"></div>
                                <div class="pix-slider-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="row overflow-hidden">
                <div class="col-12">
                    <?php
                    $this->query_posts_multi($post_type, $arr_taxonomies[$post_type][0], $arr_taxonomies[$post_type][1]);

                    $posts_query = $this->get_query();

	                $pixtheme_extended_items_query_vars = htmlspecialchars( wp_json_encode( $this->get_query_args() ) );
	                ?>

                    <div class="swiper-container topproducts" data-query="<?php echo esc_attr( $pixtheme_extended_items_query_vars ); ?>" data-taxonomy="<?php echo esc_attr( $arr_taxonomies[$post_type][0] ); ?>">
                        <div class="swiper-wrapper">
                            <?php if ( $posts_query->have_posts() ) : ?>
                                <?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
                                    
                                    <?php
                                    $cats = wp_get_object_terms(get_the_ID(), $arr_taxonomies[$post_type][0]);
                                    $cat_titles = $cat_titles_span = '';
                                    $cat_slugs = array();
                                    if ( ! empty($cats) ) {
                                        foreach ( $cats as $cat ) {
                                            $cat_titles .= '<a href="'.get_term_link($cat).'" class="pix-button pix-round pix-h-s pix-v-xs pix-font-s">'.$cat->name.'</a>';
                                            $cat_titles_span .= '<span>'.$cat->name.'</span>';
    
                                            $cat_slugs[] = $cat->slug;
    
                                            if($cat->parent > 0){
                                                $cat_parent = get_term($cat->parent, $arr_taxonomies[$post_type][0]);
                                                if(!in_array($cat_parent->slug, $cat_slugs)){
                                                    $cat_slugs[] = $cat_parent->slug;
                                                }
                                            }
                                        }
                                    }
                                    $thumbnail = '<div class="pix-img-wrapper">'.get_the_post_thumbnail(get_the_ID(), $image_size, array('class' => 'img-responsive')).'</div>';
                                    ?>
                                    <div class="swiper-slide">
                                        <div class="pix-gallery-item pix-<?php echo esc_attr($style) ?> <?php echo esc_attr($post_type) ?> pix-overlay-container <?php echo esc_attr(esc_attr(implode(' ', $cat_slugs))) ?>">
                                        
                                        </div>
                                        <?php $this->print_slide( $settings ); ?>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                        <div class="topproductsLoader">
                            <div></div>
                        </div>
                        <?php if ( ! empty( $settings['show_dots'] ) && 'yes' === $settings['show_dots']  ) : ?>
                            <div class="swiper-pagination-wrap"></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php wp_reset_postdata(); ?>
        <?php
    }

    protected function print_slide( array $settings ) {
        set_query_var( 'settings', $settings );
        
        if($settings['post_type'] == 'pix-service'){
            get_template_part( 'template-parts/service/content' );
        } elseif($settings['post_type'] == 'pix-portfolio'){
            get_template_part( 'template-parts/portfolio/content' );
        } elseif($settings['post_type'] == 'pix-team'){
            get_template_part( 'template-parts/service/content' );
        } elseif($settings['post_type'] == 'product'){
            get_template_part( 'template-parts/woocommerce/content-product-icons-center' );
        } else {
            get_template_part( 'template-parts/post/content' );
        }
        
    }

}
