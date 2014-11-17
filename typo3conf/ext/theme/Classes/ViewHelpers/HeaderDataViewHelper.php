<?php
namespace GeorgRinger\Theme\ViewHelpers;
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

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * This view helper makes it possible to add data to the <head> section
 *
 * = Examples =
 *
 * <code title="Basic usage">
 *  <theme:headerData><script>alert(1)</script></theme:headerData>
 * </code>
 * <output>
 * alert msg
 * </output>
 */
class HeaderDataViewHelper extends AbstractViewHelper {

	/**
	 * Add content to the header
	 *
	 * @return void
	 */
	public function render() {
		$content = $this->renderChildren();

		if (!empty($content)) {
			$GLOBALS['TSFE']->additionalHeaderData[md5($content)] = $content;
		}
	}
}
