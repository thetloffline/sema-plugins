<?php
/*
Plugin Name: Custom Hooks
Plugin URI:  http://example.com
Description: This plugin adds additional functionality for SEMA website.
Version:     1.0
Author:      Clev
Author URI:  http://example.com
License:     GPL2 etc
License URI: http://example.com

Copyright YEAR PLUGIN_AUTHOR_NAME (email : your email address)
(Plugin Name) is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
(Plugin Name) is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with (Plugin Name). If not, see (http://link to your plugin license).
*/

function set_featured_image($pieces, $is_new_item) {
    $pieces[ 'fields' ][ 'post_thumbnail' ][ 'value' ] = $pieces[ 'fields' ][ 'featured_img' ][ 'value' ];
    return $pieces;
} 
add_filter('pods_api_pre_save_pod_item_project', 'set_featured_image', 10, 2);

function get_the_author_full_name($userID) {
	$first_name = get_the_author_meta( 'first_name', $userID );
	$last_name = get_the_author_meta( 'last_name', $userID );
	return $first_name." ".$last_name;
}

add_action( 'pods_api_post_save_pod_item_project', 'institute_tax_update', 10, 3 );

function institute_tax_update( $pieces, $is_new_item, $id ) {
	
	$institute_term_string_array = $pieces[ 'fields' ][ 'institute_prim' ][ 'value' ];
	$category_term_string_array = $pieces[ 'fields' ][ 'project_category' ][ 'value' ];
    $supervisor_term_string_array = $pieces[ 'fields' ][ 'project_supervisor' ][ 'value' ];
	
	$institute_term_int_array = [];
	$category_term_int_array = [];
	$supervisor_term_int_array = [];
	
	foreach($institute_term_string_array as $its){$institute_term_int_array[] = intval($its);}
	foreach($category_term_string_array as $cts){$category_term_int_array[] = intval($cts);}
	foreach($supervisor_term_string_array as $sts){$supervisor_term_int_array[] = intval($sts);}
	
	if ( empty( $institute_term_int_array ) ) { $institute_term_int_array = null; }
	if ( empty( $category_term_int_array ) ) { $category_term_int_array = null; }
	if ( empty( $supervisor_term_int_array ) ) { $supervisor_term_int_array = null; }
	
	wp_set_object_terms( $id, $institute_term_int_array, 'institute', false );
	wp_set_object_terms( $id, $category_term_int_array, 'category', false );
	wp_set_object_terms( $id, $supervisor_term_int_array, 'supervisor', false );
}

?>