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
		wp_enqueue_style('page-outlets', get_template_directory_uri() . '/css/page-outlets.css', [], null, 'all'); // Philip

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
		wp_deregister_script('jquery'); // upgrade jQuery, a bit risky (Philip)
		wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBEuVhVxxRtJXEbALnA3BOgXwpps1it_ZI', [], null, true); // Philip
		wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.4.1.js', [], '3.4.1', true); // Philip
		wp_enqueue_script('map', get_template_directory_uri() . '/js/map.js', [], null, true);
		wp_enqueue_script('understrap-scripts', get_template_directory_uri() . '/js/theme.min.js', [], $js_version, true);

		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}

		// Get map marker image dynmaically by searching for 'maps-marker' (Philip)
		$args = [
			'name' => sanitize_title('map-marker'),
			'post_type' => 'attachment',
			'post_status' => 'inherit',
			'posts_per_page' => 1,
		];
		$_header = get_posts($args);
		$header = $_header ? array_pop($_header) : null;
		$map_marker = $header ? wp_get_attachment_url($header->ID) : '';

		wp_localize_script('map', 'map_marker', [
			'marker_url' => $map_marker,
		]);
	}
} // endif function_exists( 'understrap_scripts' ).
add_action( 'wp_enqueue_scripts', 'understrap_scripts' );