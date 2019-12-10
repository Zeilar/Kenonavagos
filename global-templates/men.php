<?php
/**
 * Men cloths  setup.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Get the three latest Dogs post
$men= new WP_Query([
	'post_type' => 'men_keno',
	'posts_per_page' => 3 ,
]);


if ($men->have_posts()) {
	// GREAT SUCCESS!
	?>
		<div class="wrapper" id="wrapper-men">
			<div class="container">
            	<h1><?php _e('Men', 'understrap'); ?></h1>

				<div class="row">
					<!-- Loop over the men Items -->
					<?php
						while ($men->have_posts()) {
							$men->the_post();
							?>
								<!-- For each men Item, include a template part? -->
								<?php get_template_part('loop-templates/content-men'); ?>
							<?php
						}
						

						// DON'T FORGET TO RESET POSTDATA!
						wp_reset_postdata();
					?>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /#wrapper-men-items -->
	<?php
}