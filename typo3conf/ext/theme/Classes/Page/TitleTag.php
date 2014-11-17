<?php
namespace Cyberhouse\Theme\Page;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

class TitleTag {

	/**
	 * Define the title tag
	 *
	 * @param string $content
	 * @param array $configuration
	 * @return string
	 */
	public function get($content, $configuration) {
		$pageTitle = $GLOBALS['TSFE']->cObj->TEXT((array)$GLOBALS['TSFE']->tmpl->setup['config.']['titleTagFunction.']);
		return trim($pageTitle);
	}
}
