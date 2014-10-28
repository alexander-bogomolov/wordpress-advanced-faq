<?php

class AdvancedFaqShortcodes {

	protected $search_query = null;
	protected $filter_categories = array();
	protected $filter_tags = array();
	protected $display_layout = null;


	public function __construct() {

		add_shortcode( 'advanced-faq', array( $this, 'addShortcode' ) );
	}


	public function addShortcode( $atts ) {

		// Attributes
		extract( shortcode_atts(
				array(
					'categories' => '',
					'tags'       => '',
					'layout'     => '',
				),
				$atts )
		);

		if ( ! empty( $categories ) ) {
			$this->filter_categories = explode( ',', $categories );
			array_walk( $this->filter_categories, 'trim' );
		}

		if ( ! empty( $tags ) ) {
			$this->filter_tags = explode( ',', $tags );
			array_walk( $this->filter_tags, 'trim' );
		}

		$layouts = array( 'dl' );
		if ( ! in_array( $layout, $layouts ) ) {
			$layout = null;
		}
		$this->display_layout = $layout;

		switch ( $layouts ) {
			default:
				$faqs = $this->renderDefinitionList();
				break;
		}

		return $faqs;
	}


	public function fetch() {
		$results = array();
		$args    = array(
			'post_type'              => 'advanced_faq',
			'post_status'            => '1',
			//		's'                      => 'search_q',
			'pagination'             => false,
			'orderby'                => array(
				'title' => 'ASC',
			),
			'cache_results'          => false,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		);

		if ( count( $this->filter_categories ) ) {
			$args['tax_query'] = array(
				'relation' => 'OR',
			);
			foreach ( $this->filter_categories as $category ) {
				$args['tax_query'][] = array(
					'taxonomy' => 'advanced_faq_category',
					'field'    => 'slug',
					'terms'    => $category
				);
			}
		}

		// The Query
		$query = new WP_Query( $args );

		$posts = $query->get_posts();

		// The Loop
		if ( $posts ) {
			foreach ( $posts as $post ) {
				/** @var WP_Post $post */
				$categories = get_the_terms( $post->ID, 'advanced_faq_category' );
				if ( $categories ) {

					foreach ( $categories as $category ) {
						if ( ! array_key_exists( $category->slug, $results ) ) {
							$results[ $category->slug ] = array();
						}

						$results[ $category->slug ][] = array( 'category' => $category, 'post' => $post );
					}
				} else {
					$category = new stdClass();
					$category->slug = __('Other', ADVANCED_FAQ_PLUGIN_NAME);
					$category->name = __('Other', ADVANCED_FAQ_PLUGIN_NAME);
					$results['xother'][] = array( 'category' => $category, 'post' => $post );
				}
			}
		}

		// Restore original Post Data
		wp_reset_postdata();

		ksort( $results );

		return $results;
	}


	public function renderDefinitionList() {

		$faqs    = array();
		$results = $this->fetch();

		$last_category = null;
		foreach ( $results as $category_slug => $entries ) {
			/** @var WP_Post $post */

			foreach ( $entries as $entry ) {

				if ( $last_category !== $category_slug ) {
					if ( $last_category !== null ) {
						$faqs[] = '</dl>';
					}
					$faqs[]        = '<h2>' . $entry['category']->name . '</h2>';
					$faqs[]        = '<dl>';
					$last_category = $category_slug;
				}

				$faqs[] = '<dt>' . $entry['post']->post_title . '</dt><dd>' . $entry['post']->post_content . '</dd>';
			}
		}

		return implode( "\n", $faqs );
	}
}
