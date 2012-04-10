<?php

if ( ! isset( $content_width ) )
	$content_width = 515;

add_theme_support( 'automatic-feed-links' );

load_theme_textdomain( 'steele', TEMPLATEPATH . '/languages' );
	
/* Sidebar Widget Styling */

add_action( 'widgets_init', 'steele_primary_sidebar' );
function steele_primary_sidebar() {

	register_sidebar( array(
		'id' => 'primary',
		'name' => __('Primary Sidebar', 'steele'),
		'description' => 'This is the main sidebar to display widgets within.',
		'before_widget' => '<div id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<p class="widget-title">',
		'after_title' => '</p>',
	) );
	
}

/* End Sidebar Widget Styling */

/* Comment Template Styling */

function steele_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
	<!-- Begin comment -->
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author vcard">
				<?php
					printf( __( '%1$s', 'steele' ), get_comment_author_link() );
					get_comment_author_link(); ?>
				<br />
				<?php echo get_avatar( $comment, $size='60' ); ?>
				<p><?php
					printf( __( '%1$s | %2$s' ), get_comment_date( ' n/j/Y' ), get_comment_time() ); ?>
				<br />
					<a href="<?php the_permalink(); echo "#li-comment-"; comment_ID(); ?>">Permalink</a>
				</p>
					<?php if ( current_user_can( 'edit_comment' ) )
					edit_comment_link( __( 'Edit Comment', 'steele' ) ); ?>
			</div>
			<?php comment_text(); ?>
			<!-- Start comment reply link -->
			<p class="comment-reply">
				<?php 
				if ( ! comments_open() ) : else :
				comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Respond to this comment', 'steele' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
				endif;
				?>
			</p>
		</div>
<?php

}

/* End Comment Template Styling */

function steele_pingback_trackback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	if ( $comment->comment_type == 'pingback' ) { ?>
		<li class="ping">
			<?php comment_author_link();
	} elseif ( $comment->comment_type == 'trackback' ) { ?>
		<li class="track">
			<?php comment_author_link();
	}
}

/* Comment Form Styling */

function steele_comment_form( $args = array(), $post_id = null ) {
	global $user_identity, $id;

	if ( null === $post_id )
		$post_id = $id;
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();

	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'steele' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<br /><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'steele' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<br /><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'steele' ) . '</label>' .
		            '<br /><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	$required_text = sprintf( ' ' . __('Required fields are marked %s', 'steele'), '<span class="required">*</span>' );
	$defaults = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'steele' ) . '</label><br /><textarea id="comment" name="comment" cols="57" rows="12" aria-required="true"></textarea></p>',
		'must_log_in'          => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'steele' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Leave a comment', 'steele' ),
		'title_reply_to'       => __( 'Leave a comment to %s', 'steele' ),
		'cancel_reply_link'    => __( 'Cancel comment', 'steele' ),
		'label_submit'         => __( 'Post Comment', 'steele' ),
	);

	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	?>
		<?php if ( comments_open() ) : ?>
			<?php do_action( 'comment_form_before' ); ?>
			<div id="respond">
				<p id="reply-title"><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></p>
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
					<?php do_action( 'comment_form_must_log_in_after' ); ?>
				<?php else : ?>
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
						<?php do_action( 'comment_form_top' ); ?>
						<?php if ( is_user_logged_in() ) : ?>
							<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
							<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
						<?php else : ?>
							<?php echo $args['comment_notes_before']; ?>
							<?php
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
							}
							do_action( 'comment_form_after_fields' );
							?>
						<?php endif; ?>
						<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
						<p class="form-submit">
							<input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
							<?php comment_id_fields( $post_id ); ?>
						</p>
						<?php echo $args['comment_notes_after']; ?>
						<?php do_action( 'comment_form', $post_id ); ?>
					</form>
				<?php endif; ?>
			</div><!-- #respond -->
			<?php do_action( 'comment_form_after' ); ?>
		<?php else : ?>
			<?php do_action( 'comment_form_comments_closed' ); ?>
		<?php endif; ?>
	<?php
}

/* End Comment Form Styling */

?>