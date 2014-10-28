<?php


class AdvancedFaq {

	public function init( ){
		$postTypes = new AdvancedFaqPostTypes();
		$taxonomies = new AdvancedFaqTaxonomies();
		$shortcode = new AdvancedFaqShortcodes();
	}
}