<?php

namespace Pixtheme_Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Module_Query_Custom {

    protected $post_type;
    protected $taxonomy;
    protected $include_term_slug;
    protected $query_args;

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function get_query( array $settings, $post_type = 'post', $taxonomy = 'category',  $include_term_slug = 'include_term_slugs') {
        $this->post_type = $post_type;
        $this->taxonomy = $taxonomy;
        $this->include_term_slug = $include_term_slug;
        $this->build_query_args( $settings );

        $query_args = $this->get_query_args();
        $query = new \WP_Query( $query_args );

        return $query;
    }

    public function get_query_args() {
        return $this->query_args;
    }

    private function build_query_args( $settings ) {

        $orderby = ! empty( $settings['orderby'] ) ? $settings['orderby'] : 'date';
        $order = ! empty( $settings['order'] ) ? $settings['order'] : 'DESC';

        $this->query_args = array(
            'post_type' => $this->post_type,
            'orderby' => $orderby,
            'order' => $order,
            'post_status' => 'publish'
        );

        if ( get_query_var( 'paged' ) ) {
            $this->query_args['paged'] = get_query_var( 'paged' );
        } elseif ( get_query_var( 'page' ) ) {
            $this->query_args['paged'] = get_query_var( 'page' );
        } else {
            $this->query_args['paged'] = 1;
        }

        if ( 'manual_selection' === $settings['query_type'] ) {
            $this->query_args['post__in'] = $settings['include_posts_ids'];
            $this->query_args['posts_per_page'] = -1;
        }

        if ( 'custom_query' === $settings['query_type'] ) {

            $posts_per_page = ! empty( $settings['posts_per_page'] ) ? $settings['posts_per_page'] : -1;
            $this->query_args['posts_per_page'] = $posts_per_page;

            if ( isset( $settings['ignore_sticky_posts'] ) ) {
                $sticky_post = ( 'yes' === $settings['ignore_sticky_posts'] ) ? true : false;
                $this->query_args['ignore_sticky_posts'] = $sticky_post;
            }

            if ( ! empty( $slugs = $settings[$this->include_term_slug] ) ) {
                $tax_query = [
                    'taxonomy' => $this->taxonomy,
                    'field' => 'slug',
                    'terms' => $slugs
                ];

                $this->query_args['tax_query'][] = $tax_query;
            }

            if ( 'product' === $this->post_type ) {
                $product_visibility_terms  = wc_get_product_visibility_term_ids();
                $product_visibility_not_in = array( $product_visibility_terms['exclude-from-catalog'] );

                // Hide out of stock products.
                if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
                    $product_visibility_not_in[] = $product_visibility_terms['outofstock'];
                }

                if ( ! empty( $product_visibility_not_in ) ) {
                    $this->query_args['tax_query'][] = [
                        'taxonomy' => 'product_visibility',
                        'field'    => 'term_taxonomy_id',
                        'terms'    => $product_visibility_not_in,
                        'operator' => 'NOT IN',
                    ];
                }

                if ( isset( $settings['product_type'] ) ) {
                    $product_type = $settings['product_type'];

                    if ( 'onsale' === $product_type ) {
                        $product_ids_on_sale = wc_get_product_ids_on_sale();
                        $product_ids_on_sale[] = 0;
                        $this->query_args['post__in'] = $product_ids_on_sale;
                    }

                    if ( 'featured' === $product_type ) {
                        $product_visibility_term_ids = wc_get_product_visibility_term_ids();
                        $product_featured = [
                            'taxonomy' => 'product_visibility',
                            'field' => 'term_taxonomy_id',
                            'terms' => $product_visibility_term_ids['featured']
                        ];
                        $this->query_args['tax_query'][] = $product_featured;
                    }

                    if ( 'new' === $product_type ) {

                        $this->query_args['query_label'] = 'solutech_products_widgets_query';

                        add_filter( 'posts_where', 'lamita_filter_date_posts_where', 10, 2 );

                    }

                }

                if ( ! empty( $this->query_args['tax_query'] ) ) {
                    $this->query_args['tax_query']['relation'] = 'AND';
                }

            } // end if is product

        } // end custom_query

    }

    public static function get_indicator_availability_featured_product_in_catalog( $settings ) {
        $posts_per_page = ! empty( $settings['posts_per_page'] ) ? $settings['posts_per_page'] : -1;
        $args = [
            'post_type' => 'product',
            'posts_per_page' => $posts_per_page,
        ];
        if ( ! empty( $slugs = $settings['include_term_slugs'] ) ) {
            $tax_query = [
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $slugs
            ];
            $args['tax_query'][] = $tax_query;
        }
        $product_visibility_terms  = wc_get_product_visibility_term_ids();
        $product_visibility_not_in = array( $product_visibility_terms['exclude-from-catalog'] );

        // Hide out of stock products.
        if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $product_visibility_not_in[] = $product_visibility_terms['outofstock'];
        }

        if ( ! empty( $product_visibility_not_in ) ) {
            $args['tax_query'][] = [
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => $product_visibility_not_in,
                'operator' => 'NOT IN',
            ];
        }

        $product_visibility_term_ids = wc_get_product_visibility_term_ids();
        $product_featured = [
            'taxonomy' => 'product_visibility',
            'field' => 'term_taxonomy_id',
            'terms' => $product_visibility_term_ids['featured']
        ];
        $args['tax_query'][] = $product_featured;

        if ( ! empty( $args['tax_query'] ) ) {
            $args['tax_query']['relation'] = 'AND';
        }

        $featured_products = get_posts( $args );
        return ! empty( $featured_products ) ? 1 : 0;
    }

    public static function get_indicator_availability_sale_product_in_catalog( $settings ) {
        $posts_per_page = ! empty( $settings['posts_per_page'] ) ? $settings['posts_per_page'] : -1;
        $args = [
            'post_type' => 'product',
            'posts_per_page' => $posts_per_page,
        ];
        if ( ! empty( $slugs = $settings['include_term_slugs'] ) ) {
            $tax_query = [
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $slugs
            ];
            $args['tax_query'][] = $tax_query;
        }
        $product_visibility_terms  = wc_get_product_visibility_term_ids();
        $product_visibility_not_in = array( $product_visibility_terms['exclude-from-catalog'] );

        // Hide out of stock products.
        if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $product_visibility_not_in[] = $product_visibility_terms['outofstock'];
        }

        if ( ! empty( $product_visibility_not_in ) ) {
            $args['tax_query'][] = [
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => $product_visibility_not_in,
                'operator' => 'NOT IN',
            ];
        }

        if ( ! empty( $args['tax_query'] ) ) {
            $args['tax_query']['relation'] = 'AND';
        }

        $product_ids_on_sale = wc_get_product_ids_on_sale();
        $product_ids_on_sale[] = 0;
        $args['post__in'] = $product_ids_on_sale;

        $sale_products = get_posts( $args );
        return ! empty( $sale_products ) ? 1 : 0;
    }

    public static function get_indicator_availability_new_product_in_catalog( $settings ) {
        $posts_per_page = ! empty( $settings['posts_per_page'] ) ? $settings['posts_per_page'] : -1;
        $args = [
            'post_type' => 'product',
            'posts_per_page' => $posts_per_page,
        ];
        if ( ! empty( $slugs = $settings['include_term_slugs'] ) ) {
            $tax_query = [
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $slugs
            ];
            $args['tax_query'][] = $tax_query;
        }
        $product_visibility_terms  = wc_get_product_visibility_term_ids();
        $product_visibility_not_in = array( $product_visibility_terms['exclude-from-catalog'] );

        // Hide out of stock products.
        if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $product_visibility_not_in[] = $product_visibility_terms['outofstock'];
        }

        if ( ! empty( $product_visibility_not_in ) ) {
            $args['tax_query'][] = [
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => $product_visibility_not_in,
                'operator' => 'NOT IN',
            ];
        }

        $days = solutech_get_option( 'shop_badge_new_days', '30' );
        $args['date_query'][] = [
            'after'     => "-{$days} days",
            'inclusive' => true,
        ];

        if ( ! empty( $args['tax_query'] ) ) {
            $args['tax_query']['relation'] = 'AND';
        }

        $new_products = get_posts( $args );
        return ! empty( $new_products ) ? 1 : 0;
    }

}
