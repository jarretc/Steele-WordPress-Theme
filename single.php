<?php get_header(); ?>

<div id="wrapper">
<div id="content">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('post-wrapper'); ?>>
		<div class="pre-meta">
			<p class="post-date">
				Date: <?php the_time( 'F j, Y' ); ?> 
			</p>
			<p class="post-author">
				Author: <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>">
						<?php printf( __( '%s', 'steele' ), get_the_author() ); ?></a>
			</p>
			<p class="post-comments">
				<?php if ( !comments_open() ) {
					echo 'Comments disabled';
				} else { ?>
				<a href="<?php the_permalink() ?>#comments-wrapper"><?php comments_number( 'Add a comment!', '1 comment', '% comments' ); ?></a>
				<?php } ?>
			</p>
			<p class="post-link">
				<a href="<?php the_permalink(); ?>" rel="nofollow">Permalink</a>
			</p>
		</div>
		<div class="post-content">
		<h1 class="post-title">
			<?php the_title(); ?>
		</h1>
		<?php the_content(); wp_link_pages(); ?>
		</div>
		<div class="post-meta clear">
			<?php echo get_the_tag_list( '<div id="taglist"><strong>Tags</strong><br />', ' | ', '</div>' );
				echo '<div id="categorylist"><strong>Categories</strong><br />';
				echo get_the_category_list( ' | ' );
			?>
		</div>
		</div>
		<div id="postnav">
			<div class="alignleft">
			<?php previous_post_link(); ?></div>
			<div class="alignright"><?php next_post_link(); ?></div>
			<div class="clear"></div>
		</div>
		</div>
	<?php endwhile; endif; ?>
		<div id="comments-wrapper">
			<?php comments_template( '', true); ?>
		</div>
</div>

<?php get_sidebar('primary'); get_footer(); ?>