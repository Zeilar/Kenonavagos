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
		// Initalize the map
		kn_map();

		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get('Version');

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.min.css' );
		wp_enqueue_style('understrap-styles', get_template_directory_uri() . '/css/theme.min.css', [], $css_version);

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
		wp_enqueue_script('understrap-scripts', get_template_directory_uri() . '/js/theme.min.js', [], $js_version, true);
		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
} // endif function_exists( 'understrap_scripts' ).
add_action( 'wp_enqueue_scripts', 'understrap_scripts' );