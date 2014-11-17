<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$context = \TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->__toString();

$customChanges = array(
	'BE' => array(
		'explicitADmode' => 'explicitAllow',
		'fileCreateMask' => '0660',
		'folderCreateMask' => '0770',
		'maxFileSize' => '30480',
	),
	'FE' => array(
		'addRootLineFields' => $GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] . ',keywords,description',
		'disableNoCacheParameter' => TRUE,
		'hidePagesIfNotTranslatedByDefault' => TRUE
	),
	'GFX' => array(
		'png_truecolor' => 1
	),
	'EXT' => array(
		'extConf' => array(
			'be_acl_file' => serialize(array(
				'path' => 'typo3conf/ext/theme/Configuration/BeAcl',
			)),
			'news' => serialize(array(
				'removeListActionFromFlexforms' => 2,
				'pageModuleFieldsNews' => 'LLL:EXT:news/Resources/Private/Language /locallang_be.xml:pagemodule_simple = title,datetime;LLL:EXT:news/Resources/Private/Language/locallang_be.xml:pagemodule_advanced = title,datetime,teaser,category;LLL:EXT:news/Resources/Private/Language/locallang_be.xml:pagemodule_complex = title,datetime,teaser,category,archive;',
				'pageModuleFieldsCategory' => 'title,description',
				'tagPid' => 23,
				'prependAtCopy' => 0,
				'categoryRestriction' => 'none',
				'contentElementRelation' => 0,
				'manualSorting' => 0,
				'archiveDate' => 'date',
				'showImporter' => 0,
				'showAdministrationModule' => 1,
				'showMediaDescriptionField' => 0,
				'useFal' => 1,
			)),
			'realurl' => serialize(array(
				'configFile' => 'typo3conf/ext/theme/Resources/Private/Extensions/realurl/configuration.php',
				'enableAutoConf' => 0,
				'autoConfFormat' => 0,
				'enableDevLog' => 0,
				'enableChashUrlDebug' => 0,
			)),
			'rgsmoothgallery' => serialize(array(
				'showConfigurationFields' => 0
			)),
			'scheduler' => serialize(array(
				'maxLifetime' => 144,
				'enableBELog' => 0,
				'showSampleTasks' => 0,
				'useAtdaemon' => 0
			)),
		)
	),
	'SYS' => array(
		'sitename' => 'Base Distribution' . ' ' . $context,
		'defaultCategorizedTables' => '',
	)
);

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);


$file = realpath(__DIR__) . '/AdditionalConfiguration_' . strtolower($context) . '.php';
if (is_file($file)) {
	include_once($file);
	$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);
}

// load custom configuration, that is not placed in git, e.g. for local development only changes
$file = realpath(__DIR__) . '/AdditionalConfiguration_custom.php';
if (is_file($file)) {
	include_once($file);
	$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);
}

$composerAutoloader = realpath(__DIR__ . '/../Packages/Libraries/autoload.php');

if (!empty($composerAutoloader) && is_file($composerAutoloader)) {
	include_once($composerAutoloader);
}

?>
