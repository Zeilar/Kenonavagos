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
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get('Version');

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.min.css' );
		wp_enqueue_style('understrap-styles', get_template_directory_uri() . '/css/theme.min.css', [], $css_version);
		wp_enqueue_style('page-outlets', get_template_directory_uri() . '/css/page-outlets.css', [], null, 'all');
		wp_enqueue_style('map', get_template_directory_uri() . '/css/map.css', [], null, 'all');

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
		wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBEuVhVxxRtJXEbALnA3BOgXwpps1it_ZI', [], null, true);
		wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.4.1.js', [], '3.4.1', true);
		wp_enqueue_script('map', get_template_directory_uri() . '/js/map.js', [], null, true);
		wp_enqueue_script('understrap-scripts', get_template_directory_uri() . '/js/theme.min.js', [], $js_version, true);
		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}

		// Get maps marker image dynmaically by searching for 'maps-marker'
		$args = [
			'post_type' => 'attachment',
			'name' => sanitize_title('maps-marker'),
			'posts_per_page' => 1,
			'post_status' => 'inherit',
		];
		$_header = get_posts($args);
		$header = $_header ? array_pop($_header) : null;
		$maps_marker = $header ? wp_get_attachment_url($header->ID) : '';

		$translation_array = ['marker_url' => $maps_marker];
		wp_localize_script('map', 'map_marker', $translation_array);
	}
} // endif function_exists( 'understrap_scripts' ).
add_action( 'wp_enqueue_scripts', 'understrap_scripts' );