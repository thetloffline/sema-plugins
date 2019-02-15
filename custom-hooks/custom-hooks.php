<?php
/*
Plugin Name: Custom Hooks
Plugin URI:  
Description: This plugin adds additional functionality for SEMA website.
Version:     1.0
Author:      Cleven Lehispuu
Author URI:  
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

Copyright 2019 Cleven Lehispuu (email : clevenl@tlu.ee)
Custom Hooks is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.
 
Custom Hooks is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
*/


function get_the_author_full_name($userID) {
	$first_name = get_the_author_meta( 'first_name', $userID );
	$last_name = get_the_author_meta( 'last_name', $userID );
	return $first_name." ".$last_name;
}

add_action( 'pods_api_post_save_pod_item_project', 'institute_tax_update', 10, 3 );

function institute_tax_update( $pieces, $is_new_item, $id ) {
	
	//get values from pods - they are arrays of strings

	$institute_term_string_array = $pieces[ 'fields' ][ 'institute_prim' ][ 'value' ];
	//$category_term_string_array = $pieces[ 'fields' ][ 'project_category' ][ 'value' ];
    $supervisor_term_string_array = $pieces[ 'fields' ][ 'project_supervisor' ][ 'value' ];
	//$tags_term_string_array = $pieces[ 'fields' ][ 'project_tags' ][ 'value' ];
	$featured_image_id = key($pieces[ 'fields' ][ 'featured_img' ][ 'value' ]);
	
	//initiate arrays

	$institute_term_int_array = [];
	//$category_term_int_array = [];
	$supervisor_term_int_array = [];
	//$tags_term_int_array = [];
	
	//convert strings in arrays into ints and put them into int arrays

	foreach($institute_term_string_array as $its){$institute_term_int_array[] = intval($its);}
	//foreach($category_term_string_array as $cts){$category_term_int_array[] = intval($cts);}
	foreach($supervisor_term_string_array as $sts){$supervisor_term_int_array[] = intval($sts);}
	//foreach($tags_term_string_array as $tts){$tags_term_int_array[] = intval($tts);}
	
	//to avoid errors make array null if empty

	if ( empty( $institute_term_int_array ) ) { $institute_term_int_array = null; }
	//if ( empty( $category_term_int_array ) ) { $category_term_int_array = null; }
	if ( empty( $supervisor_term_int_array ) ) { $supervisor_term_int_array = null; }
	//if ( empty( $tags_term_int_array ) ) { $tags_term_int_array = null; }
	
	wp_set_object_terms( $id, $institute_term_int_array, 'institute', false );
	//wp_set_object_terms( $id, $category_term_int_array, 'category', false );
	wp_set_object_terms( $id, $supervisor_term_int_array, 'supervisor', false );
	//wp_set_object_terms( $id, $tags_term_string_array, 'post_tag', false );
	set_post_thumbnail($id, $featured_image_id);
}

?>