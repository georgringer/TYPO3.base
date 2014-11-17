<?php
namespace GeorgRinger\Theme\Hooks\Backend;
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

class BackendUtilityHook {

	/**
	 * Hook function of t3lib_befunc
	 * It is used to change the flexform rendering
	 *
	 * @param array &$dataStructure Flexform structure
	 * @param array $conf some strange configuration
	 * @param array $row row of current record
	 * @param string $table table name
	 * @param string $fieldName some strange field name
	 * @return void
	 */
	public function getFlexFormDS_postProcessDS(&$dataStructure, $conf, $row, $table, $fieldName) {
		if ($table === 'tt_content' && $row['CType'] === 'table' && is_array($dataStructure)) {
			$this->updateFlexforms($dataStructure, $row);
		}
	}

	/**
	 * Update flexform configuration to change the input field for a class to a select
	 *
	 * @param array|string &$dataStructure flexform structure
	 * @param array $row row of current record
	 * @return void
	 */
	protected function updateFlexforms(array &$dataStructure, array $row) {
		$dataStructure['sheets']['sDEF']['ROOT']['el']['acctables_tableclass']['TCEforms']['config'] = array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:theme/Resources/Private/Language/locallang_be.xml:tableclasses.default', 'table'),
				array('LLL:EXT:theme/Resources/Private/Language/locallang_be.xml:tableclasses.striped', 'table table-striped'),
				array('LLL:EXT:theme/Resources/Private/Language/locallang_be.xml:tableclasses.condensed', 'table table-condensed'),
			),
			'size' => 1,
			'maxitems' => 1,
		);
	}
}
