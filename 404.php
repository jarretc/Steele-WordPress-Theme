<?php

get_header();

?>

<div id="wrapper">
<div id="content">
	
	<p class="archive-title">
		Whoops! Looks like you came across something that doesn't exist anymore.
	</p>
	<p class="padding">
		Try heading to the <a href="<?php echo home_url() ?>">homepage</a> to get some footing, or try searching below for more information.
	</p>
	<?php get_search_form(); ?>

</div>
<?php get_sidebar('primary'); get_footer(); ?>