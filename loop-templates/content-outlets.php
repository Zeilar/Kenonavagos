<div class="map-wrapper">

	<?php if (get_option('kn_locations')): ?>

		<div class="outlets-selection">

			<div class="outlets-header-wrapper">

				<h1 class="outlets-header">HITTA OSS</h1>

			</div><!-- outlets-header-wrapper -->

			<div class="outlets"><!-- outlet buttons --></div>
		
		</div><!-- outlets-selection -->

	<?php endif; ?>

	<div id="map" <?php if (get_option('kn_css') && get_option('kn_css') !== '') echo 'style="' . get_option('kn_css') . '"'; ?> >
		<!-- Google Maps -->
	</div>
	
</div><!-- map-wrapper -->