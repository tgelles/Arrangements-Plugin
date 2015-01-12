<?php
/*
Plugin Name: Arrangements
Plugin URI:  http://kevinwalko.com
Description: Custom Content Type Arrangements
Version: 1.0
Author: Timmy Gelles
Author URI: mailto:timothygelles@gmail.com
License: GPL2
*/
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_arrangement_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_arrangement_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
			'name' 					=> _x( 'Arrangement Types', 'taxonomy general name' ),
			'singular_name' 		=> _x( 'Arrangement Type', 'taxonomy singular name' ),
			'add_new' 				=> _x( 'Add New Arrangement Type', 'Arrangement Type'),
			'add_new_item' 			=> __( 'Add New Arrangement Type' ),
			'edit_item' 			=> __( 'Edit Arrangement Type' ),
			'new_item' 				=> __( 'New Arrangement Type' ),
			'view_item' 			=> __( 'View Arrangement Type' ),
			'search_items' 			=> __( 'Search Arrangement Types' ),
			'not_found' 			=> __( 'No Arrangement Type found' ),
			'not_found_in_trash' 	=> __( 'No Arrangement Type found in Trash' ),
		);

		$args = array(
			'labels' 			=> $labels,
			'singular_label' 	=> __('Arrangement Type'),
			'public' 			=> true,
			'show_ui' 			=> true,
			'hierarchical' 		=> true,
			'show_tagcloud' 	=> false,
			'show_in_nav_menus' => false,
			'rewrite' 			=> array('slug' => 'Arrangement', 'with_front' => false ),
		 );
	register_taxonomy( 'arrangement_type', 'arrangement', $args );
}

function register_arrangement_posttype() {
	$labels = array(
			'name' 				=> _x( 'Arrangements', 'post type general name' ),
			'singular_name'		=> _x( 'Arrangement', 'post type singular name' ),
			'add_new' 			=> __( 'Add Arrangement' ),
			'add_new_item' 		=> __( 'Add Arrangement' ),
			'edit_item' 		=> __( 'Edit Arrangement' ),
			'new_item' 			=> __( 'New Arrangement' ),
			'view_item' 		=> __( 'View Arrangement' ),
			'search_items' 		=> __( 'Search Arrangement' ),
			'not_found' 		=> __( 'No Arrangement found' ),
			'not_found_in_trash'=> __( 'No Arrangement found in Trash' ),
			'parent_item_colon' => __( '' ),
			'menu_name'			=> __( 'Arrangements' )
		);

		//$taxonomies = array( 'exhibition_type' );
		
		$supports = array('title','revisions','thumbnail' );

		$post_type_args = array(
			'labels' 			=> $labels,
			'singular_label' 	=> __('Arrangement'),
			'public' 			=> true,
			'show_ui' 			=> true,
			'publicly_queryable'=> true,
			'query_var'			=> true,
			'capability_type' 	=> 'post',
			'has_archive' 		=> false,
			'hierarchical' 		=> true,
			'rewrite' 			=> array('slug' => 'arrangement', 'with_front' => false ),
			'supports' 			=> $supports,
			'menu_position' 	=> 5,
			//'taxonomies'		=> $taxonomies,
			'show_in_nav_menus' => true
		 );
	register_post_type('arrangement',$post_type_args);
}
add_action('init', 'register_arrangement_posttype');

$arrangementinformation_5_metabox = array(
	'id' => 'arrangementinformation',
	'title' => 'Arrangement Information',
	'page' => array('arrangement'),
	'context' => 'normal',
	'priority' => 'default',
	'fields' => array(

		array(
			'title' 		=> 'Title',
			'desc' 			=> '',
			'id' 				=> 'ecpt_arrangement_title',
			'class' 			=> 'ecpt_arrangement_title',
			'type'  		=> 'text',
			'rich_editor' 	=> 0,
			'max' 			=> 0,
			'std' 			=> ''
			),

		array(
			'name' 			=> 'Subtitle',
			'desc' 			=> '',
			'id' 				=> 'ecpt_arrangement_subtitle',
			'class' 			=> 'ecpt_arrangement_subtitle',
			'type' 			=> 'text',
			'rich_editor' 	=> 0,			
			'max' 			=> 0,
			'std'			=> ''	
			),

		array(
			'name' 			=> 'Instrumentation',
			'desc' 			=> '',
			'id' 				=> 'ecpt_instrumentation',
			'class' 			=> 'ecpt_instrumentation',
			'type' 			=> 'text',
			'rich_editor' 	=> 0,			
			'max' 			=> 0,
			'std'			=> ''			
			),

		array(
			'name' 			=> 'Length',
			'desc' 			=> '',
			'id' 				=> 'ecpt_length',
			'class' 			=> 'ecpt_length',
			'type' 			=> 'text',
			'rich_editor' 	=> 0,			
			'max' 			=> 0,
			'std'			=> ''			
			),

		array(
			'name' 			=> 'Price',
			'desc' 			=> '',
			'id' 				=> 'ecpt_price',
			'class' 			=> 'ecpt_price',
			'type' 			=> 'text',
			'rich_editor' 	=> 0,			
			'max' 			=> 0,
			'std'			=> ''			
			),

		array(
			'name' 			=> 'Description',
			'desc' 			=> '',
			'id' 				=> 'ecpt_description',
			'class' 			=> 'ecpt_description',
			'type' 			=> 'textarea',
			'rich_editor' 	=> 0,			
			'max' 			=> 0,
			'std'			=> ''		
			),
		)
	);

add_action('admin_menu', 'ecpt_add_arrangementinformation_5_meta_box');

function ecpt_add_arrangementinformation_5_meta_box() {

	global $arrangementinformation_5_metabox;		

	foreach($arrangementinformation_5_metabox['page'] as $page) {
		add_meta_box($arrangementinformation_5_metabox['id'], $arrangementinformation_5_metabox['title'], 'ecpt_show_arrangementinformation_5_box', $page, 'normal', 'default', $arrangementinformation_5_metabox);
	}
}

//function to show meta boxes
function ecpt_show_arrangementinformation_5_box() {
global $post;
	global $arrangementinformation_5_metabox;
	global $ecpt_prefix;
	global $wp_version;

// Use nonce for verification
	echo '<input type="hidden" name="ecpt_arrangementinformation_5_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

	echo '<table class="form-table">';

	foreach ($arrangementinformation_5_metabox['fields'] as $field) {
		// get current post meta data

		$meta = get_post_meta($post->ID, $field['id'], true);
		
		echo '<tr>',
				'<th style="width:20%"><label for="', $field['id'], '">', stripslashes($field['name']), '</label></th>',
				'<td class="ecpt_field_type_' . str_replace(' ', '_', $field['type']) . '">';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" /><br/>', '', stripslashes($field['desc']);
				break;
			case 'textarea':
			
				if($field['rich_editor'] == 1) {
						echo wp_editor($meta, $field['id'], array('textarea_name' => $field['id'], 'wpautop' => false)); }
					 else {
					echo '<div style="width: 100%;"><textarea name="', $field['id'], '" class="', $field['class'], '" id="', $field['id'], '" cols="60" rows="8" style="width:97%">', $meta ? $meta : $field['std'], '</textarea></div>', '', stripslashes($field['desc']);				
				}
				
				break;			
		}
		echo     '<td>',
			'</tr>';
	}
	
	echo '</table>';
}

// Save data from meta box
add_action('save_post', 'ecpt_arrangementinformation_5_save');
function ecpt_arrangementinformation_5_save($post_id) {
	global $post;
	global $arrangementinformation_5_metabox;
	
	// verify nonce
	if (!isset($_POST['ecpt_arrangementinformation_5_meta_box_nonce']) || !wp_verify_nonce($_POST['ecpt_arrangementinformation_5_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
	foreach ($arrangementinformation_5_metabox['fields'] as $field) {
	
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		
		if ($new && $new != $old) {
			if($field['type'] == 'date') {
				$new = ecpt_format_date($new);
				update_post_meta($post_id, $field['id'], $new);
			} else {
				if(is_string($new)) {
					$new = $new;
				} 
				update_post_meta($post_id, $field['id'], $new);
				
				
			}
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}

function define_arrangement_type_terms() {
	$terms = array(
		'0' => array( 'name' => 'Clarinet','slug' => 'clarinet'),
		'1' => array( 'name' => 'Woodwind Sextet','slug' => 'woodwind'),
		'2' => array( 'name' => 'Other','slug' => 'other'),
    	);
    return $terms;
}

function check_arrangement_type_terms(){

	//see if we already have populated any terms
	$terms = get_terms ('arrangement_type', array( 'hide_empty' => false ) );

	//if no terms then lets add our terms
	  if( empty( $terms ) ){
	$terms = array(
		'0' => array( 'name' => 'Clarinet','slug' => 'clarinet'),
		'1' => array( 'name' => 'Woodwind Sextet','slug' => 'woodwind'),
		'2' => array( 'name' => 'Other','slug' => 'other'),
    	);
        foreach( $terms as $term ){
            if( !term_exists( $term['name'], 'arrangement_type' ) ){
                wp_insert_term( $term['name'], 'arrangement_type', array( 'slug' => $term['slug'] ) );
            }
        }
    }

}

add_action ( 'init', 'check_arrangement_type_terms' );



add_filter( 'manage_edit-arrangement_columns', 'my_arrangement_columns' ) ;

function my_arrangement_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'arrangement' => __( 'Arrangement Type' ),
		'date' => __( 'Date' ),
	);

	return $columns;
}

add_action( 'manage_studyfields_posts_custom_column', 'my_manage_arrangement_columns', 10, 2 );

function my_manage_program_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'program_type' column. */

		case 'arrangement' :

			/* Get the program_types for the post. */
			$terms = get_the_terms( $post_id, 'arrangement_type' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'arrangement_type' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'arrangement_type', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( 'No Arrangements Available' );
			}

			break;
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

?>
