<?php
namespace Cyberhouse\Theme\ViewHelpers;
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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

/**
 * This view helper implements a condition for an item list
 * which is especially useful if some layouts should be considered
 *
 * = Examples =
 *
 * <code title="Basic usage">
 * {theme:inList(list: '1,2', item:data.layout, then: 'someClass', else: '')}"
 * </code>
 * <output>
 * If the field "layout" of the current page contains either 1 or 2, the string "someClass" is shown.
 * </output>
 */
class InListViewHelper extends AbstractConditionViewHelper {

	/**
	 * Check if given list contains given item. If yes, render the thenChild, otherwise
	 * the elseChild
	 *
	 * @param string $list list of items
	 * @param string $item item
	 * @return string
	 */
	public function render($list, $item) {
		if (GeneralUtility::inList($list, $item)) {
			return $this->renderThenChild();
		} else {
			return $this->renderElseChild();
		}
	}
}
