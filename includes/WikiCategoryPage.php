<?php
/**
 * Special handling for category pages
 */
class WikiCategoryPage extends WikiPage {
	/**
	 * Constructor from a page id
	 * @param $id Int article ID to load
	 */
	public static function newFromID( $id ) {
		$t = Title::newFromID( $id );
		# @todo FIXME: Doesn't inherit right
		return $t == null ? null : new self( $t );
		# return $t == null ? null : new static( $t ); // PHP 5.3
	}

	/**
	 * Don't return a 404 for categories in use.
	 * In use defined as: either the actual page exists
	 * or the category currently has members.
	 */
	public function hasViewableContent() {
		if ( parent::hasViewableContent() ) {
			return true;
		} else {
			$cat = Category::newFromTitle( $this->mTitle );
			// If any of these are not 0, then has members
			if ( $cat->getPageCount()
				|| $cat->getSubcatCount()
				|| $cat->getFileCount()
			) {
				return true;
			}
		}
		return false;
	}
}
