<?php
/*
 * Plugin Name:  MyMythos - Custom Decoupling
 * Plugin URI:   https://github.com/delster/project-mm-plugin
 * Description:  This plugin contains any WP-based custom code needed to serve MyMythos headlessly.
 * Version:      1.0.0
 * Author:       David Elster
 * Author URI:   https://github.com/delster/
 * License:      MIT
 * Text Domain:  projmmp
 */
defined( 'ABSPATH' ) or die();

# Register CPT: Meanings and expose it to GraphQL.
function register_meanings_cpt() {
  /**
   * Post Type: Meanings.
   */
  $labels = array(
    "name"          => __( "Meanings", "projmmp" ),
    "singular_name" => __( "Meaning", "projmmp" ),
    "menu_name"     => __( "Meanings", "projmmp" ),
    "all_items"     => __( "All Meanings", "projmmp" ),
    "add_new"       => __( "Add New", "projmmp" ),
    "add_new_item"  => __( "Add New Meaning", "projmmp" ),
    "edit_item"     => __( "Edit Meaning", "projmmp" ),
    "new_item"      => __( "New Meaning", "projmmp" ),
    "view_item"     => __( "View Meaning", "projmmp" ),
    "view_items"    => __( "View Meanings", "projmmp" ),
    "search_items"  => __( "Search Meanings", "projmmp" ),
    "not_found"     => __( "No Meanings Found", "projmmp" ),
    "not_found_in_trash"    => __( "No Meanings in the Trash", "projmmp" ),
    "parent_item_colon"     => __( "Parent Meaning:", "projmmp" ),
    "featured_image"        => __( "Featured Image of this Meaning", "projmmp" ),
    "set_featured_image"    => __( "Set Featured Image of this Meaning", "projmmp" ),
    "remove_featured_image" => __( "Remove Featured Image for this Meaning", "projmmp" ),
    "use_featured_image"    => __( "Use as Featured Image of this Meaning", "projmmp" ),
    "archives"              => __( "Meaning Archives", "projmmp" ),
    "insert_into_item"      => __( "Insert into Meaning", "projmmp" ),
    "uploaded_to_this_item" => __( "Uploaded to this Meaning", "projmmp" ),
    "filter_items_list"     => __( "Filter Meanings", "projmmp" ),
    "items_list_navigation" => __( "Meanings List Navigation", "projmmp" ),
    "items_list"            => __( "Meanings List", "projmmp" ),
    "attributes"            => __( "Meanings Attributes", "projmmp" ),
    "name_admin_bar"        => __( "Meaning", "projmmp" ),
    "parent_item_colon"     => __( "Parent Meaning:", "projmmp" ),
  );
  $args = array(
    "label"                 => __( "Meanings", "projmmp" ),
    "labels"                => $labels,
    'show_in_graphql'       => true,
    'graphql_single_name'   => 'Meaning',
    'graphql_plural_name'   => 'Meanings',
    "description"           => "Meanings are the core taxonomy of the site.",
    "public"                => true,
    "publicly_queryable"    => true,
    "show_ui"               => true,
    "delete_with_user"      => false,
    "show_in_rest"          => true,
    "rest_base"             => "meaning",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive"           => false,
    "show_in_menu"          => true,
    "show_in_nav_menus"     => true,
    "exclude_from_search"   => false,
    "capability_type"       => "post",
    "map_meta_cap"          => true,
    "hierarchical"          => false,
    "rewrite"               => array( "slug" => "meaning", "with_front" => true ),
    "query_var"             => true,
    "menu_position"         => 6,
    "menu_icon"             => "dashicons-format-status",
    "supports"              => array( "title", "editor", "thumbnail", "excerpt", "custom-fields", "revisions", "author" ),
  );
  register_post_type( "meaning", $args );
}
add_action( 'init', 'register_meanings_cpt' );


# Filter empty ACF fields to return `null` instead to prevent GraphQL issues.
if (!function_exists('acf_nullify_empty')) {
  function acf_nullify_empty($value, $post_id, $field) {
    if (empty($value)) { return null; }
    return $value;
  }
}
add_filter('acf/format_value', 'acf_nullify_empty', 100, 3);