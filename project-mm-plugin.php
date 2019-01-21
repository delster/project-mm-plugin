<?php

/*
 * Plugin Name:  Project MM Plugin
 * Plugin URI:   https://github.com/delster/project-mm-plugin
 * Description:  This plugin contains any WP-based custom code needed for Project MM.
 * Version:      0.1.0
 * Author:       David Elster
 * Author URI:   https://github.com/delster/
 * License:      MIT
 * Text Domain:  projmmp
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

# Expose Archetypes ACF Fields to GraphQL
add_action( 'graphql_register_types', function() {
	register_graphql_field( 'Archetype', 'related_posts', [
		 'type' => 'Array',
		 'description' => __( 'The related posts for this archetype.', 'projmmp' ),
		 'resolve' => function( $archetype ) {
			 $posts = get_post_meta( $archetype->ID, 'related_posts', true );
			 return ! empty( $posts ) ? $posts : [];
		 }
	]);
	register_graphql_field( 'Archetype', 'related_users', [
		 'type' => 'Array',
		 'description' => __( 'The related users for this archetype.', 'projmmp' ),
		 'resolve' => function( $archetype ) {
			 $users = get_post_meta( $archetype->ID, 'related_users', true );
			 return ! empty( $users ) ? $users : [];
		 }
	]);
});

# Register CPTs (Archetypes)
add_action( 'init', 'pmmp_register_cpts' );
function pmmp_register_cpts() {
	/**
	 * Post Type: Archetypes.
	 */
	$labels = array(
		"name"          => __( "Archetypes", "projmmp" ),
		"singular_name" => __( "Archetype", "projmmp" ),
		"edit_item"     => __( "Add New Archetype", "projmmp" ),
		"new_item"      => __( "New Archetype", "projmmp" ),
		"view_item"     => __( "View Archetype", "projmmp" ),
		"view_items"    => __( "View Archetypes", "projmmp" ),
		"search_items"  => __( "Search Archetypes", "projmmp" ),
		"not_found"     => __( "No Archetypes found", "projmmp" ),
		"not_found_in_trash"  => __( "No Archetypes found in Trash", "projmmp" ),
		"all_items" => __( "All Archetypes", "projmmp" ),
		"archives" => __( "Archetype Archives", "projmmp" ),
		"attributes" => __( "Archetype Attributes", "projmmp" ),
		"insert_into_item" => __( "Insert into Archetype", "projmmp" ),
		"uploaded_to_this_item" => __( "Uploaded to this Archetype", "projmmp" ),
	);
	$args = array(
		"label" => __( "Archetypes", "projmmp" ),
		"labels" => $labels,
		"description" => "This is the \"glue\" between posts and users. The \"meanings\" archive.",
		'show_in_graphql' => true,
		'graphql_single_name' => 'Archetype',
		'graphql_plural_name' => 'Archetypes',
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"menu_icon" => 'dashicons-visibility',
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "archetype", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title", "thumbnail", "excerpt", "custom-fields" ),
	);
	register_post_type( "archetype", $args );
}