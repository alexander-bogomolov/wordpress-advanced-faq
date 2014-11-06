<?php


/**
 * @author  Alexander Bogomolov <wordpress@bogomolov.de>
 */
class AdvancedFaq {



	/**
	 *
	 */
	public function init() {
		$this->insertAssets();

		new AdvancedFaqPostTypes();
		new AdvancedFaqTaxonomies();
		new AdvancedFaqShortcodes();
	}

	/**
	 *
	 */
	protected function insertAssets() {
		add_action( 'admin_enqueue_scripts', function () {
			wp_enqueue_style(
				'wordpress-advanced-faq-admin-css',
				ADVANCED_FAQ_PLUGIN_URL . '/assets/css/wordpress-advanced-faq.css',
				FALSE,
				NULL
			);
		} );
	}
}