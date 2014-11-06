<?php


/**
 * @author  Alexander Bogomolov <wordpress@bogomolov.de>
 */
class AdvancedFaqShortcodes {



	/**
	 * @var string
	 */
	protected $search_query = '';

	/**
	 * @var array
	 */
	protected $filter_categories = array();

	/**
	 * @var array
	 */
	protected $filter_tags = array();

	/**
	 * @var string
	 */
	protected $display_layout = 'default';

	/**
	 *
	 */
	public function __construct() {

		add_shortcode( 'advanced-faq', array( $this, 'addShortcode' ) );
	}

	/**
	 * @param string|array $atts
	 * @param string|null  $content
	 *
	 * @return string
	 */
	public function addShortcode( $atts, $content = NULL ) {

		extract( shortcode_atts(
				array(
					'categories' => '',
					'tags'       => '',
					'layout'     => 'default',
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

		if ( ! empty( $layout ) ) {
			$layouts = array( 'default', 'questions-first' );
			if ( ! in_array( $layout, $layouts ) ) {
				$layout = 'default';
			}
		}
		$this->display_layout = $layout;


		return $this->render();
	}

	/**
	 * @return string
	 */
	public function render() {
		switch ( $this->display_layout ) {
			case 'questions-first' :
				return $this->renderQuestionsFirstLayout();
			default:
				return $this->renderDefaultLayout();
				break;
		}
	}

	/**
	 * @return array
	 */
	public function fetch() {
		$results = array();
		$args    = array(
			'post_type'              => 'advanced_faq',
			'post_status'            => '1',
			//		's'                      => 'search_q',
			'pagination'             => FALSE,
			'orderby'                => array(
				'title' => 'ASC',
			),
			'cache_results'          => FALSE,
			'update_post_meta_cache' => FALSE,
			'update_post_term_cache' => FALSE,
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

		$query = new WP_Query( $args );
		$posts = $query->get_posts();

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
					$category            = new stdClass();
					$category->slug      = __( 'Other', ADVANCED_FAQ_PLUGIN_NAME );
					$category->name      = __( 'Other', ADVANCED_FAQ_PLUGIN_NAME );
					$results['xother'][] = array( 'category' => $category, 'post' => $post );
				}
			}
		}

		// Restore original Post Data
		wp_reset_postdata();

		ksort( $results );

		return $results;
	}

	/**
	 * @return string
	 */
	public function renderDefaultLayout() {

		$output  = array();
		$results = $this->fetch();

		$output[] = '<div class="advanced-faq-default">';
		foreach ( $results as $category_slug => $entries ) {
			/** @var WP_Post $post */

			$question_id = 'faq-' . $entries[0]['category']->slug;

			$output[] = '<section id="' . $question_id . '">';
			$output[] = '<h2 class="faq-category">' . $entries[0]['category']->name . '</h2>';
			$output[] = '<dl>';

			foreach ( $entries as $entry ) {
				$question_id = 'faq-' . $entry['category']->slug . '-' . $entry['post']->ID;

				$output[] = '<dt class="faq-question" id="' . $question_id . '">';
				$output[] = $entry['post']->post_title;
				$output[] = '</dt>';
				$output[] = '<dd class="faq-answer">' . do_shortcode( $entry['post']->post_content ) . '</dd>';
			}

			$output[] = '</dl>';
			$output[] = '</section>';
		}
		$output[] = '</div>';

		return implode( "\n", $output );
	}


	public function renderQuestionsFirstLayout() {

		$results   = $this->fetch();
		$questions = array();
		$answers   = array();

		$output[] = '<div class="advanced-faq-questions-first">';
		foreach ( $results as $category_slug => $entries ) {
			$questions[] = '<section id="' . 'faq-category-' . $entries[0]['category']->slug . '-questions' . '">';
			$questions[] = '<h2 class="faq-category">' . $entries[0]['category']->name . '</h2>';
			$questions[] = '<ol class="faq-question-list">';

			$answers[] = '<section id="' . 'faq-category-' . $entries[0]['category']->slug . '-answers' . '">';
			$answers[] = '<h2>' . $entries[0]['category']->name . '</h2>';
			$answers[] = '<dl>';

			foreach ( $entries as $entry ) {
				$question_id = 'faq-question-' . $entry['category']->slug . '-' . $entry['post']->ID;

				$questions[] = '<li class="faq-question-item"><a href="#' . $question_id . '">' .
				               $entry['post']->post_title . '</a></li>';

				$answers[] = '<dt id="' . $question_id . '">' . $entry['post']->post_title . '</dt>';
				$answers[] = '<dd > ' . do_shortcode( $entry['post']->post_content ) . ' </dd > ';
			}

			$questions[] = '</ol > ';
			$questions[] = '</section>';

			$answers[] = '</dl > ';
			$answers[] = '</section>';
		}
		$output[] = '</div>';

		return implode( "\n", $questions ) . implode( "\n", $answers );
	}
}

