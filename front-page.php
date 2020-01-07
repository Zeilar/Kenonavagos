
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
<img src="<?php the_field('frontpage_ad_2'); ?>"></img>
</div>
</div>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="<?php the_field('frontpage_hero_1'); ?>" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="<?php the_field('frontpage_hero_2'); ?>" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="<?php the_field('frontpage_hero_3'); ?>" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<?php get_template_part( 'global-templates/sales' ); ?>


<?php get_template_part( 'global-templates/hero' ); ?>

<//?php get_template_part( 'global-templates/men' ); ?>





<div class="section-men">
	<h1>Mens clothing</h1>
<!-- woocommerce -->
<?php 
$loop = new WP_Query( array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 30,
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
</div>
















<div class="section-women">
	<h1>Womens clothing</h1>
<!-- woocommerce -->
<?php 
$loop = new WP_Query( array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 30,
    'product_cat' => 'women',
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
</div>



<div class="section-kids">
	<h1>Kids clothing</h1>
<!-- woocommerce -->
<?php 
$loop = new WP_Query( array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 30,
    'product_cat' => 'kids,',
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
</div>












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

<?php get_footer(); ?>