<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

abstract class Base_Posts extends Base {

    private $query = null;
    private $query_args = null;

    abstract protected function get_post_type();

    abstract protected function get_taxonomy();

    protected function get_query() {
        return $this->query;
    }

    protected function get_query_args() {
        return $this->query_args;
    }

    public function query_posts() {
        $settings = $this->get_settings_for_display();
        $post_type = $this->get_post_type();
        $taxonomy = $this->get_taxonomy();
        $this->query = Module_Query_Custom::instance()->get_query( $settings, $post_type, $taxonomy );
        $this->query_args = Module_Query_Custom::instance()->get_query_args();
    }

    protected function register_controls() {
        $this->add_section_query();
    }

    protected function add_section_query() {
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__( 'Query', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'query_type',
            [
                'label' => esc_html__( 'Query type', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'custom_query'  => esc_html__( 'Custom Query', 'solutech' ),
                    'manual_selection' => esc_html__( 'Manual Selection', 'solutech' ),
                ),
                'default' => 'custom_query',
            ]
        );

        $posts_options = [];
        $posts_attributes = [];

        $posts_attributes = [
            'post_type' => $this->get_post_type(),
            'numberposts' => -1
        ];

        $posts = get_posts( $posts_attributes );

        foreach ( $posts as $post ) {
            $posts_options[ $post->ID ] = $post->post_title;
        }

        $this->add_control(
            'include_posts_ids',
            [
                'label' => esc_html__( 'Select Posts', 'solutech' ),
                'type' => Controls_Manager::SELECT2,
                'options' => $posts_options,
                'label_block' => true,
                'multiple' => true,
                'condition' => [
                    'query_type' => 'manual_selection',
                ],
            ]
        );

        $options = [];
        $attributes = [];

        $attributes = [
            'taxonomy' => $this->get_taxonomy(),
            'hide_empty' => false
        ];

        $categories = get_terms( $attributes );

        foreach ( $categories as $category ) {
            $options[ $category->slug ] = $category->name;
        }

        $this->add_control(
            'include_term_slugs',
            [
                'label' => esc_html__( 'Categories', 'solutech' ),
                'description' => esc_html__( 'Leave empty to choose All categories', 'solutech' ),
                'type' => Controls_Manager::SELECT2,
                'options' => $options,
                'label_block' => true,
                'multiple' => true,
                'condition' => [
                    'query_type' => 'custom_query',
                ],
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__( 'Number of items to show', 'solutech' ),
                'description' => esc_html__( 'Input "-1" or leave empty to show all posts.', 'solutech' ),
                'type' => Controls_Manager::NUMBER,
                'min' => -1,
                'max' => 100,
                'step' => 1,
                'separator' => 'before',
                'condition' => [
                    'query_type' => 'custom_query',
                ],
            ]
        );

         $this->add_control(
            'orderby',
            [
                'label' => esc_html__( 'Order by', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'date' => esc_html__( 'Date', 'solutech' ),
                    'author' => esc_html__( 'Author', 'solutech' ),
                    'title' => esc_html__( 'Title', 'solutech' ),
                    'modified' => esc_html__( 'Last modified date', 'solutech' ),
                    'menu_order' => esc_html__( 'Menu order', 'solutech' ),
                    'rand' => esc_html__( 'Random', 'solutech' ),
                ),
                'default' => 'date',
            ]
        );

         $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Sort order', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'DESC' => esc_html__( 'Descending', 'solutech' ),
                    'ASC'  => esc_html__( 'Ascending', 'solutech' ),
                ),
                'default' => 'DESC',
            ]
        );

        if ( 'post' === $this->get_post_type() ) {
            $this->add_control(
                'ignore_sticky_posts',
                [
                    'label' => esc_html__( 'Ignore Sticky Posts', 'solutech' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'description' => esc_html__( 'Sticky-posts ordering is visible on frontend only', 'solutech' ),
                    'condition' => [
                        'query_type' => 'custom_query',
                    ],
                ]
            );
        }

        if ( pixtheme_use_woo() && 'product' === $this->get_post_type() ) {
            $this->add_control(
                'product_type',
                [
                    'label' => esc_html__( 'Products type', 'solutech' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'all',
                    'options' => [
                        'all' => esc_html__( 'All products', 'solutech' ),
                        'featured' => esc_html__( 'Featured products', 'solutech' ),
                        'onsale' => esc_html__( 'Sale products', 'solutech' ),
                        'new' => esc_html__( 'New products', 'solutech' ),
                    ],
                    'condition' => [
                        'query_type' => 'custom_query',
                    ],
                ]
            );
        }

        $this->end_controls_section();
    }

    protected function render() {
        $this->print_items();
    }

}
