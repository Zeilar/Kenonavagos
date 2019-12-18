<?php
/**
 * The template for displaying a single men  post.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="single-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<main class="site-main col-md-9" id="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'loop-templates/content-men', 'single' ); ?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

			<aside class="col-md-3">
				<div class="hund-info" style="background-color:black; color:white">
				
				<?php
					if ($cotton = get_field('cotton')) {
						printf(__('<div class="cotton">cotton: %d</div>', 'understrap'), $cotton);
					}
				?>	


				<?php
					if ($gender = get_field('gender')) {
						printf(__('<div class="gender">gender: %d</div>', 'understrap'), $gender);
					}
				?>



				     <div class="cotton">
							<?php
								the_terms(
								get_the_ID(),
								'cotton',
								__('Cotton: ', 'understrap')
								);
							?>
					 </div>  <!--/ (custom fields).cotton-->


					 <div class="gender">
						<?php
							the_terms(
								get_the_ID(),
								'gender',
								__('Gender: ', 'understrap')
							);
						?>
					  </div>  <!--/ (custom fields).gender-->


			</aside>

		</div>  <!-- .row -->

	</div>  <!-- #content -->

</div>   <!-- #single-wrapper -->

<?php get_footer(); ?>
