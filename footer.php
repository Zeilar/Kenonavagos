<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">
<!-- Footer -->
<footer class="page-footer font-small cyan darken-3">

  <!-- Footer Elements -->
  <div class="container">

    <!-- Grid row-->
    <div class="row">
	  <div class="col">
	  

				<?php 
				$args = array(
					'post_type' => 'footer',
							array(
							'address' => 'Södra',
							'field'    => 'name',
										),
							); 
							$query1 = new WP_Query( $args );
			
									// The Loop

									while ( $query1->have_posts() ) {
										$query1->the_post();

										//echo '<br>' .get_the_title();
										echo '<br>' .the_content();

										echo '<br>' . the_field('name');
										
										echo '<br>' . the_field('telephone_number');
                    echo '<br>' . the_field('address');
					echo '<br>' . the_field('email');
					
                    
										
										
									}
									
										?>
										</div>
										

      

	</div>
	<div>
	
  <a href="http://kenonavagos.test/index.php/new-form/">contact Us
          </a>
	</div>
    <!-- Grid row-->

  </div>
  
  <!-- Footer Elements -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">:
              <!-- Facebook -->
          <a class="fb-ic">
            <i class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
          </a>
        
            <!--Instagram-->
          <a href="https://www.instagram.com/anjusweden/"
            class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x">
           
             
          </a>

          <!--Pinterest-->
          <a class="pin-ic">
            <i class="fab fa-pinterest fa-lg white-text fa-2x"> </i>
          </a>
          </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info">

						<?php understrap_site_info(); ?>

					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!--col end -->

		</div><!-- row end -->

	</div><!-- container end -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

