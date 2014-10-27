<?php
/*
Plugin Name: Advanced FAQ
Plugin URI: http://bogomolov.de
Description: Advanced Frequently Asked Questions system
Version: 0.0.1
Author: Alexander Bogomolov
Author URI: http://bogomolov.de
License: GPL2
*/


require plugin_dir_path( __FILE__ ) . 'inc/post_type.inc';
require plugin_dir_path( __FILE__ ) . 'inc/taxonomies.inc';
require plugin_dir_path( __FILE__ ) . 'inc/shortcode.inc';




//add_action( 'init', 'ebs_faq_init' );
//function ebs_faq_init() {
//	$faq_args = array(
//		'labels'             => array(
//			'name'               => _x( 'FAQs', 'post type general name' ),
//			'singular_name'      => _x( 'FAQ', 'post type singular name' ),
//			'add_new'            => _x( 'Add New', 'faq' ),
//			'add_new_item'       => __( 'Add New FAQ' ),
//			'edit_item'          => __( 'Edit FAQ' ),
//			'new_item'           => __( 'New FAQ' ),
//			'view_item'          => __( 'View FAQ' ),
//			'search_items'       => __( 'Search FAQs' ),
//			'not_found'          => __( 'No faqs found' ),
//			'not_found_in_trash' => __( 'No faqs found in Trash' ),
//			'parent_item_colon'  => ''
//		),
//		'public'             => TRUE,
//		'publicly_queryable' => TRUE,
//		'show_ui'            => TRUE,
//		'query_var'          => TRUE,
//		'rewrite'            => TRUE,
//		'capability_type'    => 'page',
//		'hierarchical'       => FALSE,
//		'menu_position'      => NULL,
//		'supports'           => array( 'title', 'editor' )
//	);
//	register_post_type( 'faq', $faq_args );
//
//
//	register_taxonomy( 'tag', 'faq', array(
//		'hierarchical' => FALSE,
//		'labels'       => array(
//			'name'                       => _x( 'Tags', 'taxonomy general name' ),
//			'singular_name'              => _x( 'Tag', 'taxonomy singular name' ),
//			'search_items'               => __( 'Search Tags' ),
//			'popular_items'              => __( 'Popular Tags' ),
//			'all_items'                  => __( 'All Tags' ),
//			'parent_item'                => NULL,
//			'parent_item_colon'          => NULL,
//			'edit_item'                  => __( 'Edit Tag' ),
//			'update_item'                => __( 'Update Tag' ),
//			'add_new_item'               => __( 'Add New Tag' ),
//			'new_item_name'              => __( 'New Tag Name' ),
//			'separate_items_with_commas' => __( 'Separate tags with commas' ),
//			'add_or_remove_items'        => __( 'Add or remove tags' ),
//			'choose_from_most_used'      => __( 'Choose from the most used tags' )
//		),
//		'show_ui'      => TRUE,
//		'query_var'    => TRUE,
//		'rewrite'      => array( 'slug' => 'faq' )
//	) );
//}
//
//
//
////add filter to insure the text FAQ, or faq, is displayed when user updates a faq
//add_filter( 'post_updated_messages', 'ebs_faq_updated_messages' );
//function ebs_faq_updated_messages( $messages ) {
//	global $post, $post_ID;
//
//	$messages['faq'] = array(
//		0  => '', // Unused. Messages start at index 1.
//		1  => sprintf( __( 'FAQ updated. <a href="%s">View faq</a>' ), esc_url( get_permalink( $post_ID ) ) ),
//		2  => __( 'Custom field updated.' ),
//		3  => __( 'Custom field deleted.' ),
//		4  => __( 'FAQ updated.' ),
//		/* translators: %s: date and time of the revision */
//		5  => isset( $_GET['revision'] ) ?
//			sprintf( __( 'FAQ restored to revision from %s' ), wp_post_revision_title( (int) $_GET['revision'], FALSE ) ) :
//			FALSE,
//		6  => sprintf( __( 'FAQ published. <a href="%s">View faq</a>' ), esc_url( get_permalink( $post_ID ) ) ),
//		7  => __( 'FAQ saved.' ),
//		8  => sprintf( __( 'FAQ submitted. <a target="_blank" href="%s">Preview faq</a>' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
//		9  => sprintf( __( 'FAQ scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview faq</a>' ),
//			// translators: Publish box date format, see http://php.net/date
//			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
//		10 => sprintf( __( 'FAQ draft updated. <a target="_blank" href="%s">Preview faq</a>' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
//	);
//
//	return $messages;
//}
//
////display contextual help for FAQs
//add_action( 'contextual_help', 'ebs_faq_add_help_text', 10, 3 );
//function ebs_faq_add_help_text( $contextual_help, $screen_id, $screen ) {
//	if ( 'faq' == $screen->id ) {
//		$contextual_help = '<p>Beim Erstellen</p>';
//	} elseif ( 'edit-faq' == $screen->id ) {
//		$contextual_help =
//			'<p>Bei der Übersicht</p>';
//	}
//
//	return $contextual_help;
//}
//
//
//function ebs_faq_shortcode() {
//	$query = new WP_Query( array(
//		'post_type' => 'faq',
//	) );
//
//	$faqs = array();
//	while ( $query->have_posts() ) {
//		$query->the_post();
//
//		$faqs[] = '<dt>' . get_the_title() . '</dt><dd>' . get_the_content() . '</dd>';
//	}
//
//	return '<dl>' . implode( "\n", $faqs ) . '</dl>';
//}
//
//
//
//add_shortcode( 'faq', 'ebs_faq_shortcode' );


//add_action( "add_meta_boxes", "ebs_faq_add_meta_boxes" );
//function ebs_faq_add_meta_boxes() {
//	add_meta_box( 'faq_settings', 'Einstellungen', 'faq_settings_meta_options', 'faq', 'side', 'default' );
//}
//
//function ebs_faq_settings_meta_options() {
//	global $post;
//	$custom     = get_post_custom( $post->ID );
//	$post_order = $custom['post_order'][0];
//
//	echo '<dl>';
//	echo '<dt><label for="post_order">Reihenfolge</label></dt>';
//	echo '<dd><input type="text" id="post_order" name="post_order" value="' . $post_order . '" size="10" /></dd>';
//	echo '</dl>';
//}
//
//
//add_action( 'save_post', 'ebs_faq_save_meta' );
//function ebs_faq_save_meta() {
//	global $post;
//
//	if($post) {
//		update_post_meta( $post->ID, "post_order", intval( $_POST["post_order"] ) );
//	}
//}
