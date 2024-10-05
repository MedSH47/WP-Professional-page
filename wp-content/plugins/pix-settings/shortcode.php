<?php
function share_buttons($atts, $content=NULL){

    extract(shortcode_atts(array(
        'class' => '',
        'title' => '',
        'post_type'=>'',
    ), $atts));

    global $post;
    if(!isset($post->ID)){
        $post = get_queried_object();
    }

    if (!isset($post->ID)){
        return;
    }

    $permalink = get_permalink($post->ID);
    $image =  wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'pixcustom-preview-thumb' );

    $post_title = rawurlencode(get_the_title($post->ID));

    if( $post_type == '' ){
        $out='
            <div class="footer-meta btn-social">
                <div class="blog-footer-title">'.esc_html($title).'</div>
                <ul class="pix-social-round-transparent">
                    <li><a href="https://www.facebook.com/sharer.php?u='.$permalink.'&amp;images='.$image[0].'" title="'.__('Facebook', 'pixcustom').'" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="https://twitter.com/share?url='.$permalink.'&text='.$post_title.'" title="'.__('Twitter', 'pixcustom').'" target="_blank"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url='.$permalink.'&title='.$post_title.'" title="'.__('LinkedIn', 'pixcustom').'" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="https://reddit.com/submit?url='.$permalink.'&amp;title='.$post_title.'" title="'.__('Reddit', 'pixcustom').'" target="_blank"><i class="fab fa-reddit-alien"></i></a></li>
                </ul>
			</div>
			';
    } elseif($post_type == 'product') {
        $out='
			<h4 class="font-additional font-weight-bold text-uppercase">'.esc_attr($title).'</h4>
			<ul class="social-list">
			    <li><a href="https://www.facebook.com/sharer.php?u='.$permalink.'&amp;images='.$image[0].'" title="'.__('Facebook', 'pixcustom').'" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="https://twitter.com/share?url='.$permalink.'&text='.$post_title.'" title="'.__('Twitter', 'pixcustom').'" target="_blank"><i class="fab fa-twitter"></i></a></li>
                <li><a href="https://www.linkedin.com/shareArticle?mini=true&url='.$permalink.'&title='.$post_title.'" title="'.__('LinkedIn', 'pixcustom').'" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                <li><a href="https://reddit.com/submit?url='.$permalink.'&amp;title='.$post_title.'" title="'.__('Reddit', 'pixcustom').'" target="_blank"><i class="fab fa-reddit-alien"></i></a></li>
			</ul>
			';
    } elseif($post_type == 'portfolio') {
        $out='
            
            <div class="pix-social-share">
                <ul>
                    <li><a href="https://www.facebook.com/sharer.php?u='.$permalink.'&amp;images='.$image[0].'" title="'.__('Facebook', 'pixcustom').'" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="https://twitter.com/share?url='.$permalink.'&text='.$post_title.'" title="'.__('Twitter', 'pixcustom').'" target="_blank"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url='.$permalink.'&title='.$post_title.'" title="'.__('LinkedIn', 'pixcustom').'" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="https://reddit.com/submit?url='.$permalink.'&amp;title='.$post_title.'" title="'.__('Reddit', 'pixcustom').'" target="_blank"><i class="fab fa-reddit-alien"></i></a></li>
                </ul>
            </div>
			';
    }

    return $out;
}

add_shortcode('share', 'share_buttons');


function pix_display_format($content){
    return do_shortcode($content);
}

function pix_vc_add_param($base, $func, $js){
    return vc_add_shortcode_param( $base, $func, $js );
}