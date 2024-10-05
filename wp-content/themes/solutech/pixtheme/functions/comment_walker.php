<?php

function pixtheme_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'pixtheme_move_comment_field_to_bottom' );


class PixThemeCommentWalker extends Walker_Comment{

    protected function comment( $comment, $depth, $args ) {
        if ( 'div' == $args['style'] ) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo esc_attr($tag); ?> <?php comment_class( $this->has_children ? 'parent' : '' ); ?> id="comment-<?php comment_ID(); ?>">
        <?php if ( 'div' != $args['style'] ) : ?>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-body blog-article__comments-item">
        <?php endif; ?>
        <div class="comment-author vcard">
        <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        </div>
        <?php if ( '0' == $comment->comment_approved ) : ?>
            <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'solutech' ) ?></em>
            <br />
        <?php endif; ?>
        <div class="comment-content">
            <div class="comment-content__header">
                <?php printf( wp_kses_post(__( '<h3 class="fn">%s</h3>', 'solutech') ), get_comment_author_link() ); ?>
                <?php
                comment_reply_link( array_merge( $args, array(
                    'add_below' => $add_below,
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                ) ) );
                ?>
                <div class="comment-meta commentmetadata"><a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
                <?php
                /* translators: 1: date, 2: time */
                printf( wp_kses_post(__( '%1$s at %2$s', 'solutech') ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'solutech' ), '&nbsp;&nbsp;', '' );
                ?>
                </div>

            </div>
            <div class="comment-content__text">
            <?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div>

        </div>


        <?php if ( 'div' != $args['style'] ) : ?>
            </div>
        <?php endif; ?>
        <?php
    }

}