<?php

// Add Shortcode
function advanced_faq_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
			array(
				'categories' => '',
				'tags'       => '',
				'layout'     => '',
			),
			$atts )
	);

	$layouts = array( 'dl' );
	if ( ! in_array( $layout, $layouts ) ) {
		$layout = null;
	}

	$categories = explode( ',', $categories );
	array_walk( $categories, 'trim' );

	$tags = explode( ',', $tags );
	array_walk( $tags, 'trim' );

	$args = array(
		'post_type'              => 'advanced_faq',
		'post_status'            => '1',
		//		'category_name'          => 'cat_name',
		//		'tag_name'               => 'tag_name',
		//		's'                      => 'search_q',
		//		'pagination'             => false,
				'orderby'                => array(
					'title' => 'ASC',
				),
		'cache_results'          => false,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	);

	if ( count( $categories ) ) {
		$args['tax_query'] = $categories;
	}

	if ( count( $tags ) ) {
		$args['tax_query'] = $tags;
	}

	// The Query
	$query = new WP_Query( $args );


	$tax = fetchByCategories();

//
//	switch ( $layouts ) {
//		case 'dl' :
//			$faqs = advanced_faq_shortcode_dl( $query );
//			break;
//		default:
//			$faqs = advanced_faq_shortcode_dl( $query );
//			break;
//	}

	// Restore original Post Data
	wp_reset_postdata();

	//	var_dump($faqs);
	return $faqs;
}

add_shortcode( 'advanced-faq', 'advanced_faq_shortcode' );

function advanced_faq_shortcode_dl( $query ) {

	$faqs = array();

	// The Loop
	if ( $query->have_posts() ) {
		$last_category = null;

		while ( $query->have_posts() ) {
			$query->the_post();
			$categories = get_the_terms( get_the_ID(), 'advanced_faq_category' );
			$new_group  = ( $categories && $last_category !== $categories[0]->term_id );

			if ( $new_group ) {
				$last_category = $categories[0]->term_id;
				if ( count( $faqs ) ) {
					$faqs[] = '</dl>';
				}
				$faqs[] = '<h2>' . $categories[0]->name . '</h2>';
				$faqs[] = '<dl>';
			}

			$faqs[] = '<dt>' . get_the_title() . '</dt><dd>' . get_the_content() . '</dd>';
		}
	}

	return implode( "\n", $faqs );
}


function fetchByCategories() {
	$taxonomies = array(
		'advanced_faq_category',
	);

	$args = array(
		'orderby'           => 'name',
		'order'             => 'ASC',
		'hide_empty'        => true,
		'include'           => array(),
		'fields'            => 'all',
		'slug'              => '',
	);

	return get_terms($taxonomies, $args);
}