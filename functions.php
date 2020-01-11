<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$understrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/jetpack.php',                         // Load Jetpack compatibility file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567
	'/woocommerce.php',                     // Load WooCommerce functions.
	'/editor.php',                          // Load Editor functions.
	'/wp-admin.php',                        // /wp-admin/ related functions
	'/deprecated.php',                      // Load deprecated functions.
	'/filters.php',							// Loads custom filters
);

/**
 * Register Custom Navigation Walker
 */
function register_navwalker() {
	require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action('after_setup_theme', 'register_navwalker');

foreach ( $understrap_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}


 function arphabet_widgets_init() {
    
        register_sidebar( array(
            'name'          => 'Home Left sidebar',
            'id'            => 'home_right_1',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="rounded">',
            'after_title'   => '</h2>',
        ) );
    
    }
 add_action( 'widgets_init', 'arphabet_widgets_init' );

/**
 * Set up map
 * 
 * @param boolean $echo whether to echo the map or just initialize it
 */

function kn_map($echo = false) {
	wp_deregister_script('jquery');
	wp_enqueue_style('page-outlets', get_template_directory_uri() . '/css/outlets.css', [], null, 'all');
	wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBEuVhVxxRtJXEbALnA3BOgXwpps1it_ZI', [], null, true);
	wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.4.1.js', [], '3.4.1', true);
	wp_enqueue_script('map', get_template_directory_uri() . '/js/map.js', [], null, true);

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
			$content = strip_tags(get_the_content());
			$theme = [
				'name' => get_the_title(),
				'style' => $content,
			];
			break;
		}
	}

	// If no matches were found, it's probably the Custom option, send it and try it
	if (!$theme) {
		$theme = [
			'style' => get_option('kn_theme'),
		];
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
		if (get_field('marker_enable')) {
			array_push($markers, [
				'content' => apply_filters('the_content', get_the_content()), // To remove stupid HTML comments by WordPress
				'icon' => get_field('marker_icon')['url'],
				'lng' => get_field('marker_longitude'),
				'lat' => get_field('marker_latitude'),
				'size' => get_field('marker_size'),
				'name' => get_the_title(),
			]);
		}
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
		'enableInfoWindow' => get_option('kn_infowindow'),
		'locations' => get_option('kn_locations'),
		'zoom' => get_option('kn_zoom'),
		'controls' => $map_controls,
	]);
	wp_localize_script('map', 'map_markers', $markers); // Send the markers data
	wp_localize_script('map', 'map_theme', $theme); // Send the themes data

	if ($echo) return get_template_part('loop-templates/content', 'outlets');
}