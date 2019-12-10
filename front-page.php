
<?php
/**
 * The template for displaying the front page.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$container = get_theme_mod( 'understrap_container_type' );


?>
<div class="row">
<div class="col-lg-6">
<img src="<?php the_field('frontpage_ad_1'); ?>"></img>
</div>
<div class="col-lg-6">
<img src="<?php the_field('frontpage_ad_1'); ?>"></img>
</div>
</div>

<//?php get_template_part( 'global-templates/sales' ); ?>

<!-- hero -->
<?php get_template_part( 'global-templates/hero' ); ?>
<!-- end hero -->
<!-- men -->
<?php get_template_part( 'global-templates/men' ); ?>
<!-- end nen -->




<!-- woocommerce -->

<?php 
$loop = new WP_Query( array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 5,
    'product_cat' => 'men,',
	'orderby' => 'rand'
	
) );
while ($loop->have_posts()) {
	$loop->the_post();
	wc_get_template_part('content','product');
	//var_dump(the_post());
}

wp_reset_postdata();

?>

<!-- woocommerece -->


<!-- page content -->
<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<main class="site-main" id="main">

				<?php while ( have_posts() ) : the_post(); ?>
				

					<?php get_template_part( 'loop-templates/content', 'frontpage' ); ?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->
<!-- end page content -->

<?php get_footer(); ?>