<?php

/**
 * @author  Alexander Bogomolov <wordpress@bogomolov.de>
 */
class AdvancedFaqTaxonomies {



	/**
	 *
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'buildCategory' ), 0 );
		add_action( 'init', array( $this, 'buildTag' ), 0 );
	}


	/**
	 *
	 */
	public function buildCategory() {

		$labels = array(
			'name'                       => _x( 'Categories', 'Taxonomy General Name', 'advanced_faq' ),
			'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'advanced_faq' ),
			'menu_name'                  => __( 'Category', 'advanced_faq' ),
			'all_items'                  => __( 'All Items', 'advanced_faq' ),
			'parent_item'                => __( 'Parent Item', 'advanced_faq' ),
			'parent_item_colon'          => __( 'Parent Item:', 'advanced_faq' ),
			'new_item_name'              => __( 'New Item Name', 'advanced_faq' ),
			'add_new_item'               => __( 'Add New Item', 'advanced_faq' ),
			'edit_item'                  => __( 'Edit Item', 'advanced_faq' ),
			'update_item'                => __( 'Update Item', 'advanced_faq' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'advanced_faq' ),
			'search_items'               => __( 'Search Items', 'advanced_faq' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'advanced_faq' ),
			'choose_from_most_used'      => __( 'Choose from the most used items', 'advanced_faq' ),
			'not_found'                  => __( 'Not Found', 'advanced_faq' ),
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
		);
		register_taxonomy( 'advanced_faq_category', array( 'advanced_faq' ), $args );
	}


	/**
	 *
	 */
	public function buildTag() {

		$labels = array(
			'name'                       => _x( 'Tags', 'Taxonomy General Name', 'advanced_faq' ),
			'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name', 'advanced_faq' ),
			'menu_name'                  => __( 'Tag', 'advanced_faq' ),
			'all_items'                  => __( 'All Items', 'advanced_faq' ),
			'parent_item'                => __( 'Parent Item', 'advanced_faq' ),
			'parent_item_colon'          => __( 'Parent Item:', 'advanced_faq' ),
			'new_item_name'              => __( 'New Item Name', 'advanced_faq' ),
			'add_new_item'               => __( 'Add New Item', 'advanced_faq' ),
			'edit_item'                  => __( 'Edit Item', 'advanced_faq' ),
			'update_item'                => __( 'Update Item', 'advanced_faq' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'advanced_faq' ),
			'search_items'               => __( 'Search Items', 'advanced_faq' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'advanced_faq' ),
			'choose_from_most_used'      => __( 'Choose from the most used items', 'advanced_faq' ),
			'not_found'                  => __( 'Not Found', 'advanced_faq' ),
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
		);
		register_taxonomy( 'advanced_faq_tag', array( 'advanced_faq' ), $args );
	}
}
