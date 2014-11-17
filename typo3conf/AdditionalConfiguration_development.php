<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Override configuration of LocalConfiguration
$customChanges = array(
	'BE' => array(
		'debug' => TRUE,
	),
	'FE' => array(
		'debug' => TRUE,
	),
	'SYS' => array(
		'devIPmask' => '*',
		'displayErrors' => TRUE,
		'enableDeprecationLog' => 'file',
		'sqlDebug' => 1,
		'systemLogLevel' => 0,
//		'debugExceptionHandler' => 'Opendo\Whoops\Error\WhoopsExceptionHandler'
	),
);

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);

if (extension_loaded('apc')) {
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_rootline']['backend'] =
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_datamapfactory_datamap']['backend'] =
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_object']['backend'] =
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_typo3dbbackend_tablecolumns']['backend'] =
	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['t3lib_l10n']['backend'] =
		'TYPO3\\CMS\\Core\\Cache\\Backend\\ApcBackend';
}

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pagesection']['options'] =
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_hash']['options'] =
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pages']['options'] = array();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pagesection']['backend'] =
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_hash']['backend'] =
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pages']['backend'] =
	'TYPO3\\CMS\\Core\\Cache\\Backend\\TransientMemoryBackend';

?>
