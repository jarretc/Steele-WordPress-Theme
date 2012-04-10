<ol class="commentlist">
	<?php if ( have_comments() && comments_open() ) : ?>
	<p id="comments-status">
		<?php printf( _n( 'One comment so far', '%1$s comments already', get_comments_number() ), number_format_i18n( get_comments_number() ) ); ?>
		| <a href="#respond">Leave your own comment</a>
	<?php else : endif; ?>
	</p>
	<?php
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<div class="comment-paging">
		<p class="older-comments">
			<?php previous_comments_link(); ?>
		</p>
		<p class="newer-comments">
			<?php next_comments_link(); ?>
		</p>
	</div>
	<?php
	endif;
	wp_list_comments( 'callback=steele_comments&type=comment' );
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<div class="comment-paging bottom">
		<p class="older-comments">
			<?php previous_comments_link(); ?>
		</p>
		<p class="newer-comments">
			<?php next_comments_link(); ?>
		</p>
	</div>
	<?php
	endif;
	if ( ! empty( $comments_by_type['pings'] ) ) :
	echo '<h6>Trackbacks & Pingbacks</h6>';
	wp_list_comments( 'callback=steele_pingback_trackback&type=pings' );
	endif;
	steele_comment_form();
	?>
</ol>