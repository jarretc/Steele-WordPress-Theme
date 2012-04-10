<?php get_header(); ?>

<div id="wrapper">
<div id="content">
		<?php 
		if ( is_category() ) {
			echo '<p class="archive-title">Category: ' . single_cat_title( '', false ) . '</p>';
		} elseif ( is_tag() ) {
			echo '<p class="archive-title">Tag: ' . single_tag_title( '', false ) . '</p>';
		} elseif ( is_month() ) {
			echo '<p class="archive-title">Month: ' . single_month_title( ' ', false ) . '</p>';
		} elseif ( is_day() ) {
			echo '<p class="archive-title">Day: ' . get_the_date() . '</p>';
		} elseif ( is_year() ) {
			echo '<p class="archive-title">Year: ' . get_the_date( 'Y' ) . '</p>';
		} elseif ( is_author() ) {
			echo '<p class="archive-title">Author: ' . get_the_author_meta( 'display_name', $_GET['author'] ) . '</p>';
		} elseif ( is_search() ) {
			echo '<p class="archive-title">Search Term: ' . $term = $_GET['s']; $term . '</p>';
		}
			
		if ( $paged > 1 ) : ?>
		<div class="postnav">
			<?php posts_nav_link(); ?>
		</div>
	<?php endif; if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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
		</div>
		<div class="post-content">
		<h2 class="post-title">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h2>
		<?php if ( is_archive() || is_search() ) :
				the_excerpt(); wp_link_pages();
				else :
				the_content(); wp_link_pages();
				endif;
		?>
		<p class="post-link">
				<?php if ( the_title( ' ', ' ', false ) == "" )
						echo '<a href="<?php the_permalink(); ?>" rel="nofollow">View Post</a>';
				?>
			</p>
		</div>
		<div class="clear"></div>
		</div>
	<?php endwhile; endif; ?>
		<div class="postnav">
			<?php posts_nav_link(); ?>
		</div>
</div><!-- End #content -->

<?php get_sidebar('primary'); get_footer(); ?>