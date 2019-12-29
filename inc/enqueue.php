<?php
/**
 * Understrap enqueue scripts
 *
 * @package understrap
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
if ( ! function_exists( 'understrap_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function understrap_scripts() {
		// Philip

		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get('Version');

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.min.css' );
		wp_enqueue_style('understrap-styles', get_template_directory_uri() . '/css/theme.min.css', [], $css_version);
		wp_enqueue_style('page-outlets', get_template_directory_uri() . '/css/outlets.css', [], null, 'all');

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
		wp_deregister_script('jquery');
		wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBEuVhVxxRtJXEbALnA3BOgXwpps1it_ZI', [], null, true);
		wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.4.1.js', [], '3.4.1', true);
		wp_enqueue_script('map', get_template_directory_uri() . '/js/map.js', [], null, true);
		wp_enqueue_script('understrap-scripts', get_template_directory_uri() . '/js/theme.min.js', [], $js_version, true);
		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}

		// Get themes
		$themes_query = new WP_Query([
			'post_type' => 'map_theme',
			'posts_per_page' => -1,
			'order' => 'ASC',
		]);

		// Push selected theme into array
		while ($themes_query->have_posts()) {
			$themes_query->the_post();
			if (get_option('kn_theme') === get_the_title()) {
				$content = explode('</p>', str_replace(' ', '', explode('<p>', get_the_content()))[1])[0];
				$theme = [
					'name' => get_the_title(),
					'style' => $content,
				];
				break;
			}
		}

		// Get markers
		$markers_query = new WP_Query([
			'order' => get_option('kn_locations'),
			'post_type' => 'kn_marker',
			'posts_per_page' => -1,
		]);

		// Push markers into array
		$markers = [];
		while ($markers_query->have_posts()) {
			$markers_query->the_post();
			array_push($markers, [
				'content' => apply_filters('the_content', get_the_content()), // To remove stupid HTML comments by WordPress
				'icon' => get_field('icon')['url'],
				'lng' => get_field('longitude'),
				'lat' => get_field('latitude'),
				'size' => get_field('size'),
				'name' => get_the_title(),
			]);
		}
		wp_reset_postdata();

		// Map controls settings from plugin
		$map_controls = [
			'streetViewControl' => get_option('kn_controls')['streetViewControl'] ? true : false,
			'fullscreenControl' => get_option('kn_controls')['fullscreenControl'] ? true : false,
			'mapTypeControl' => get_option('kn_controls')['mapTypeControl'] ? true : false,
			'rotateControl' => get_option('kn_controls')['rotateControl'] ? true : false,
			'scaleControl' => get_option('kn_controls')['scaleControl'] ? true : false,
			'zoomControl' => get_option('kn_controls')['zoomControl'] ? true : false,
		];

		// Send the settings data
		wp_localize_script('map', 'map_settings', [
			'locations' => get_option('kn_locations'),
			'zoom' => get_option('kn_zoom'),
			'controls' => $map_controls,
		]);
		wp_localize_script('map', 'map_markers', $markers); // Send the markers data
		wp_localize_script('map', 'map_theme', $theme); // Send the themes data
	}
} // endif function_exists( 'understrap_scripts' ).
add_action( 'wp_enqueue_scripts', 'understrap_scripts' );