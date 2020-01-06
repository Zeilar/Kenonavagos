<?php
/**
 * Sales - Right now wow CAT!
 * @package understrap
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
// Get sales
$sales = new WP_Query([
	'post_type' => 'sales',
	'posts_per_page' =>2,
]);
// Did we get any sales?
if ($sales->have_posts()) {
	// GREAT SUCCESS!
	?>
	<div class="wrapper">
		<div class="container-fluid">
				<div class="row">
					<!-- Loop over the sales -->
					<?php
						while ($sales->have_posts()) {
							$sales->the_post();
							?>
								<!-- For each USP, include a template part? -->
								<?php get_template_part('loop-templates/content', 'sales'); ?>
							<?php
						}
						// DON'T FORGET TO RESET POSTDATA!
						wp_reset_postdata();
					?>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.wrapper -->
	<?php
}