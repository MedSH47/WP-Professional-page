<?php

if ( post_password_required() ) {
    return;
}

?>
<?php if ( have_comments() ) : ?>
    <div class="blog-article__comments">

        <h2><?php printf( _nx( '<span>%s</span> Comment', '<span>%s</span> Comments', get_comments_number(), 'comments title', 'solutech' ), number_format_i18n( get_comments_number() ) ); ?></h2>

        <ol class="comment-list rtd">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 56,
                'walker'      => new PixThemeCommentWalker()
            ) );
            ?>
        </ol>
    
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'solutech' ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'solutech' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'solutech' ) ); ?></div>
        </nav><!-- #comment-nav-below -->
    <?php endif; // Check for comment navigation. ?>

    </div>
<?php endif;?>

<?php
// If comments are closed and there are comments, let's leave a little note, shall we?
if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
    <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'solutech' ); ?></p>
<?php endif;?>


<?php
	$commenter = wp_get_current_commenter();
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html_req = ( $req ? " required='required'" : '' );
	$required_text = sprintf( ' ' . wp_kses_post(__('Required fields are marked %s', 'solutech' )), '<span class="required">*</span>' );

	$fields   =  array(
        'author' => '<div class="col-md-4"><p class="comment-form-author form-group">
            <label class="form-label" for="author">' . esc_html__( 'Name', 'solutech' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label>
			<input class="form-control" id="author" name="author" type="text" placeholder="' . esc_attr__( 'Name', 'solutech' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></p></div>',
        'email'  => '<div class="col-md-4"><p class="comment-form-email form-group">
            <label class="form-label" for="email">' . esc_html__( 'Email', 'solutech' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label>
            <input class="form-control" id="email" name="email" type="email" placeholder="' . esc_attr__( 'Email', 'solutech' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p></div>',
        'url'    => '<div class="col-md-4"><p class="comment-form-url form-group">
            <label class="form-label" for="url">' . esc_html__( 'Website', 'solutech' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label>
            <input class="form-control" id="url" name="url" type="url" placeholder="' . esc_attr__( 'Website', 'solutech' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p></div>',
    );

	$comments_args = array(
		'must_log_in'          => '<div class="col-md-12"><p class="must-log-in">' . sprintf( wp_kses_post(__( 'You must be <a href="%s">logged in</a> to post a comment.', 'solutech' ) ), wp_login_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) ) ) . '</p></div>',
		'logged_in_as'         => '<div class="col-md-12"><p class="logged-in-as">' . sprintf( wp_kses_post(__( '<a href="%1$s" aria-label="Logged in as %2$s. Edit your profile.">Logged in as %2$s</a>. <a href="%3$s">Log out?</a>', 'solutech' ) ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) ) ) . '</p></div>',
		'comment_notes_before' => '<div class="col-md-12"><p class="comment-notes"><span id="email-notes">' . wp_kses_post(__( 'Your email address will not be published.', 'solutech' ) ) . '</span>'. ( $req ? $required_text : '' ) . '</p></div>',
			'class_form' => 'comment-form row',
		'fields' => apply_filters( 'comment_form_default_fields', $fields ),
        'comment_field' => '<div class="col-md-12"><p class="comment-form-comment form-group"><label class="form-label" for="comment">' . esc_html__( 'Comment', 'solutech' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label><textarea class="form-control" id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'solutech' ) . ( $req ? ' *' : '' ) . '" aria-required="true"></textarea></p></div>',
		'submit_field' => '<div class="col-md-12"><p class="form-submit">%1$s %2$s</p></div>',
	);

	comment_form($comments_args);

?>


