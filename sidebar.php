	<div id="sidebar">
		<?php
			if ( is_active_sidebar( 'primary' ) ) :
				dynamic_sidebar( 'primary' );
			else :
				echo '<p class="no-widgets">Oops! Looks like you need to configure some widgets for this area.<br /> Click <a href="wp-admin/widgets.php">here</a> to do so.</p>';
			endif;
		?>
		
	</div>