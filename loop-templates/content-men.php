<?php
	$logo_id = get_field('logo');
	$logo = wp_get_attachment_image_src($logo_id, 'large');
?>
<div class="wrapper-men col-md-4">
	<article class="men">
		<header>
			<?php if ($logo) : ?>
				<a href="<?php the_permalink(); ?>">
					<img src="<?php echo $logo[0]; ?>" class="img-fluid">
				</a>
			<?php endif; ?>

			<h1><?php the_title(); ?></h1>
		</header>

		<main>
			<?php the_excerpt(); ?>
		</main>

		<footer>
			
		            <div class="cotton">
							<?php
								the_terms(
								get_the_ID(),
								'cotton',
								__('Cotton: ', 'understrap')
								);
							?>
					 </div> 

					 <div class="Gender">
							<?php
								the_terms(
								get_the_ID(),
								'gender',
								__('Gender: ', 'understrap')
								);
							?>
					 </div> 


					<?php
					    if ($gender = get_field('gender')) {
						printf(__('<div class="gender">gender: %d</div>', 'understrap'), $gender);
					    }
				    ?>

		</footer>
	</article>
</div>
  