<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Override configuration of LocalConfiguration
$customChanges = array();

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);

?>