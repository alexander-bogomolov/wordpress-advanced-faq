<?php

defined('ABSPATH') or die("No script kiddies please!");

/**
 * @author  Alexander Bogomolov <wordpress@bogomolov.de>
 */
class AdvancedFaqPostTypes {



	/**
	 *
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register' ), 0 );
	}


	/**
	 *
	 */
	public function register() {

		$labels = array(
			'name'               => _x( 'FAQs', 'Post Type General Name', 'advanced_faq' ),
			'singular_name'      => _x( 'FAQ', 'Post Type Singular Name', 'advanced_faq' ),
			'menu_name'          => __( 'FAQ', 'advanced_faq' ),
			'parent_item_colon'  => __( 'Parent Item:', 'advanced_faq' ),
			'all_items'          => __( 'All Items', 'advanced_faq' ),
			'view_item'          => __( 'View Item', 'advanced_faq' ),
			'add_new_item'       => __( 'Add New Item', 'advanced_faq' ),
			'add_new'            => __( 'Add New', 'advanced_faq' ),
			'edit_item'          => __( 'Edit Item', 'advanced_faq' ),
			'update_item'        => __( 'Update Item', 'advanced_faq' ),
			'search_items'       => __( 'Search Item', 'advanced_faq' ),
			'not_found'          => __( 'Not found', 'advanced_faq' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'advanced_faq' ),
		);
		$args   = array(
			'label'               => __( 'advanced_faq', 'advanced_faq' ),
			'description'         => __( 'Advanced Frequently Asked Questions system', 'advanced_faq' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'author', ),
			'taxonomies'          => array( 'advanced_faq_category', 'advanced_faq_tag' ),
			'hierarchical'        => FALSE,
			'public'              => TRUE,
			'show_ui'             => TRUE,
			'show_in_menu'        => TRUE,
			'show_in_nav_menus'   => TRUE,
			'show_in_admin_bar'   => TRUE,
			'menu_position'       => 5,
//			'menu_icon'           => ADVANCED_FAQ_PLUGIN_URL . '/assets/images/icons/admin-menu.png',
			'can_export'          => TRUE,
			'has_archive'         => FALSE,
			'exclude_from_search' => FALSE,
			'publicly_queryable'  => TRUE,
			'capability_type'     => 'page',
      'rewrite'             => array( 'slug' => 'faq' ),
		);
		register_post_type( 'advanced_faq', $args );
	}
}