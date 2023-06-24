<?php
/**
 * Plugin Name: BotterFly Custom Modules for Beaver Builder
 * Description: A plugin that adds extra modules to Beaver Builder.
 * <<<<<<< HEAD
 * Version: 1.3
 * =======
 * Version: 1.2
 * >>>>>>> 6b59724ec650233050a78c1fd30abd2433afb0e5
 * Author: Online With You & MD Arif Islam
 */

// Define the plugin path and URL.
define( 'botterfly_custom_bb_modules_PATH', plugin_dir_path( __FILE__ ) );
define( 'botterfly_custom_bb_modules_URL', plugin_dir_url( __FILE__ ) );

// Load the hello world module.
function oa_load_modules() {
	if ( class_exists( 'FLBuilder' ) ) {
		require_once botterfly_custom_bb_modules_PATH . 'modules/botterfly-menu/botterfly-menu.php';
		require_once botterfly_custom_bb_modules_PATH . 'modules/letter-page/letter-page.php';
		require_once botterfly_custom_bb_modules_PATH . 'modules/ai-art-page/ai-art-page.php';
		require_once botterfly_custom_bb_modules_PATH . 'modules/templates-page/templates-page.php';
	}
}

add_action( 'init', 'oa_load_modules' );


function botterflyai_register_cpt() {


	$labels = array(
		'name'                  => 'Art Requests',
		'singular_name'         => 'Art Request',
		'menu_name'             => 'Art Requests',
		'name_admin_bar'        => 'Art Request',
		'archives'              => 'Art Request Archives',
		'attributes'            => 'Art Request Attributes',
		'parent_item_colon'     => 'Parent Art Request:',
		'all_items'             => 'All Art Requests',
		'add_new_item'          => 'Add New Art Request',
		'add_new'               => 'Add New',
		'new_item'              => 'New Art Request',
		'edit_item'             => 'Edit Art Request',
		'update_item'           => 'Update Art Request',
		'view_item'             => 'View Art Request',
		'view_items'            => 'View Art Requests',
		'search_items'          => 'Search Art Requests',
		'not_found'             => 'No Art Requests found',
		'not_found_in_trash'    => 'No Art Requests found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into Art Request',
		'uploaded_to_this_item' => 'Uploaded to this Art Request',
		'items_list'            => 'Art Requests list',
		'items_list_navigation' => 'Art Requests list navigation',
		'filter_items_list'     => 'Filter Art Requests list',
	);

	$args = array(
		'label'               => 'Art Request',
		'description'         => 'Custom post type for art requests',
		'labels'              => $labels,
		'supports'            => array( 'title', 'comments' ),
		'public'              => false,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_rest'        => false,
		"rest_base"           => "",
		'has_archive'         => false,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'exclude_from_search' => true,
		'capability_type'     => 'post',
		'rewrite'             => array( 'slug' => 'art-request' ),
		'hierarchical'        => false,
	);

	register_post_type( "art_request", $args );


	/**
	 * Post Type: Templates.
	 */

	$labels = [
		"name"          => esc_html__( "Templates", "astra-child" ),
		"singular_name" => esc_html__( "Template", "astra-child" ),
	];

	$args = [
		"label"                 => esc_html__( "Templates", "astra-child" ),
		"labels"                => $labels,
		"description"           => "",
		"public"                => true,
		"publicly_queryable"    => true,
		"show_ui"               => true,
		"show_in_rest"          => true,
		"rest_base"             => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace"        => "wp/v2",
		"has_archive"           => false,
		"show_in_menu"          => true,
		"show_in_nav_menus"     => true,
		"delete_with_user"      => false,
		"exclude_from_search"   => false,
		"capability_type"       => "post",
		"map_meta_cap"          => true,
		"hierarchical"          => false,
		"can_export"            => false,
		"rewrite"               => [ "slug" => "template", "with_front" => true ],
		"query_var"             => true,
		"menu_icon"             => "dashicons-category",
		"supports"              => [ "title", "editor", "thumbnail" ],
		"show_in_graphql"       => false,
	];

	register_post_type( "template", $args );


}

add_action( 'init', 'botterflyai_register_cpt' );

function botterflyai_change_menu( $menu ) {
	$art_req_count = get_transient( 'art_req_count' ) ? get_transient( 'art_req_count' ) : 0;

	if ( $art_req_count > 0 ) {
		$menu_index = array_search( 'edit.php?post_type=art_request', array_column( $menu, 2 ) );

		if ( $menu_index !== false ) {
			$menu[ $menu_index ][0] = "Art Requests <span class='awaiting-mod'>{$art_req_count}</span>";
		}
	}

	return $menu;
}

add_filter( 'add_menu_classes', 'botterflyai_change_menu' );


function botterflyai_admin_scripts( $screen ) {
	$_screen = get_current_screen();
	if ( 'edit.php' == $screen && 'art_request' == $_screen->post_type ) {
		delete_transient( 'art_req_count' );
	}
}

add_action( 'admin_enqueue_scripts', 'botterflyai_admin_scripts' );


?>
