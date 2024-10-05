<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Video extends Base {

    public function get_name() {
        return 'pixtheme-video';
    }

    public function get_title() {
        return esc_html__( 'Video', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-play';
    }

    public function get_keywords() {
        return [ 'video' ];
    }

    protected function register_controls() {
        $this->add_section_content();

    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Video', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'url',
            [
                'label' => esc_html__( 'YouTube or Vimeo Link', 'solutech' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => '',
            ]
        );
        $this->add_control(
            'display',
            [
                'label' => esc_html__( 'Display Type', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'popup',
                'options' => [
                    'popup' => esc_html__( 'Popup Window', 'solutech' ),
                    'embed' => esc_html__( 'Embedded Video', 'solutech' ),
                    'button' => esc_html__( 'Button with Popup', 'solutech' ),
                ],
            ]
        );
        $this->add_control(
            'position',
            [
                'label' => esc_html__( 'Alignment', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-text-left',
                'options' => [
                    'pix-text-left' => esc_html__( 'Left', 'solutech' ),
                    'pix-text-center' => esc_html__( 'Center', 'solutech' ),
                    'pix-text-right' => esc_html__( 'Right', 'solutech' ),
                ],
                'condition' => [
                    'display' => 'button',
                ],
            ]
        );
        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Image', 'solutech' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'display' => ['popup', 'embed'],
                ],
            ]
        );
        $this->add_control(
            'radius',
            [
                'label' => esc_html__( 'Boxes Shape', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-global-shape',
                'options' => [
                    'pix-global-shape' => esc_html__( 'Global', 'solutech' ),
                    'pix-square' => esc_html__( 'Square', 'solutech' ),
                    'pix-rounded' => esc_html__( 'Rounded', 'solutech' ),
                    'pix-round' => esc_html__( 'Round', 'solutech' ),
                ],
            ]
        );
        $this->add_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'solutech' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'description' => esc_html__( 'Default 500px', 'solutech' ),
                'condition' => [
                    'display' => ['popup', 'embed'],
                ],
            ]
        );
        $this->add_control(
            'color',
            [
                'label' => esc_html__( 'Overlay color', 'solutech' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .pix-video' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'display' => ['popup', 'embed'],
                ],
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'solutech' ),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'display' => ['popup', 'embed'],
                ],
            ]
        );
        $this->add_control(
            'content',
            [
                'label' => esc_html__( 'Content', 'solutech' ),
                'type' => Controls_Manager::TEXTAREA,
                'condition' => [
                    'display' => ['popup', 'embed'],
                ],
            ]
        );
        
        $this->end_controls_section();
    }

    protected function render() {
        $out = $img_bg = $btn_class = $color = $pix_btn = '';
        $settings = $this->get_settings_for_display();

        $height = $settings['height'] == '' ? '500px' : $settings['height'];
        
        $title = ( $settings['title'] == '' ) ? '' : '<div class="title">'.($settings['title']).'</div>';
        $fullcontent = ($settings['content'] == '') ? '' : '<div class="duration">'.do_shortcode($settings['content']).'</div>';
        
        if( ! empty($settings['image']['url']) ) {
            $img_path = wp_get_attachment_image_src($settings['image']['id'], 'large');
            $img_bg = isset($img_path[0]) ? 'background: url(' . esc_url($img_path[0]) . ') no-repeat 50% 50%;' : '';
        }
        
        $display = $settings['display'];
        $pix_video_class = 'pix_video_' . rand();
        if($display == 'button'){
            $height = '70px';
            $btn_class = 'pix-video-button';
            $color = 'transparent';
            $pix_btn = '<div class="pix-button pix-transparent">'.esc_html__('Watch the Video', 'solutech').'</div>';
        }
        $pix_video_style = 'jQuery("head").append("<style> .'.esc_attr($pix_video_class).'{'.($img_bg).'display:grid;position:relative;height:'.esc_attr($height).'}.'.esc_attr($pix_video_class).' .pix-video{background-color:'.esc_attr($color).'}</style>");';
        wp_add_inline_script( 'pixtheme-common', $pix_video_style );
        
        $radius = $settings['radius'];
        $position = $settings['position'];
        $url = $settings['url'];
        if($display != 'embed') {
        $out .= '
             <div class="'.esc_attr($pix_video_class).' '.esc_attr($radius).'">
                <div class="pix-video '.esc_attr($btn_class).' '.esc_attr($position).'">
                    '.($title).'
                    <a class="pix-video-popup" href="'.esc_url($url).'" data-fancybox="1">
                        '.($pix_btn).'
                        <div class="item-pulse">
                            <img class="play" src="'.get_template_directory_uri().'/images/play.svg" alt="'.esc_attr($title).'">
                        </div>
                    </a>
                    '.($fullcontent).'
                </div>
            </div>';
        } else {
            $vendor = parse_url($url);
            $video_id = $vendor_name = '';
            if ($vendor['host'] == 'www.youtube.com' || $vendor['host'] == 'youtu.be' || $vendor['host'] == 'www.youtu.be' || $vendor['host'] == 'youtube.com') {
                if ($vendor['host'] == 'www.youtube.com') {
                    parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
                    $video_id = $my_array_of_vars['v'];
                } else {
                    $video_id = parse_url($url, PHP_URL_PATH);
                }
                $vendor_name = 'youtube';
            } elseif ($vendor['host'] == 'vimeo.com'){
                $video_id = parse_url($url, PHP_URL_PATH);
                $vendor_name = 'vimeo';
            }
            $out .= '
            <div class="' . esc_attr($pix_video_class) . ' '.esc_attr($radius).'">
                <div class="pix-video embed" data-vendor="' . esc_attr($vendor_name) . '" data-embed="' . esc_attr($video_id) . '">
                    ' . ($title) . '
                        <div class="play-button">
                            <div class="item-pulse">
                                <img class="play" src="' . get_template_directory_uri() . '/images/play.svg" alt="' . esc_attr($title) . '">
                            </div>
                        </div>
                    ' . ($fullcontent) . '
                </div>
            </div>';
        }
        
        pix_out ($out);

    }
    
    protected function content_template() {
        ?>
        <#
            var height = settings.height == '' ? '500px' : settings.height,
                container_style = 'background: url(' + settings.image.url + ') no-repeat 50% 50%;display:grid;position:relative;height:' + height,
                display = settings.display == 'button' ? 'pix-video-button' : '',
                pix_btn = settings.display == 'button' ? '<div class="pix-button pix-transparent">Watch the Video</div>' : '',
                content = settings.content == '' ? '' : '<div class="duration">' + settings.content + '</div>',
                template_uri = '<?php echo get_template_directory_uri() ?>';
        
                display = settings.display == 'embed' ? 'embed' : display;
            #>
            <div class="pix_video_ {{{ settings.radius }}}" style="{{{ container_style }}}">
                <div class="pix-video {{{ display }}} {{{ settings.position }}}">
                    <# if ( '' !== settings.title ) { #>
                    <div class="title">{{{ settings.title }}}</div>
                    <# } #>
                    <a class="pix-video-popup" href="{{{ settings.url }}}" data-fancybox="1">
                        {{{ pix_btn }}}
                        <div class="item-pulse">
                            <img class="play" src="{{{ template_uri }}}/images/play.svg" alt="{{{ settings.title }}}">
                        </div>
                    </a>
                    {{{ content }}}
                </div>
            </div>
        <?php
    }

}
