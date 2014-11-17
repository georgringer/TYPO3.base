<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Override configuration of LocalConfiguration
$customChanges = array(
	'BE' => array(
		'debug' => FALSE,
	),
	'FE' => array(
		'debug' => FALSE,
	),
	'SYS' => array(
		'devIPmask' => '*',
		'displayErrors' => FALSE,
		'enableDeprecationLog' => '',
		'sqlDebug' => 0,
		'systemLogLevel' => 0,
	),
	'LOG' => array(
		'writerConfiguration' => array(
			\TYPO3\CMS\Core\Log\LogLevel::DEBUG => array(
				'TYPO3\\CMS\\Core\\Log\\Writer\\NullWriter' => array()
			)
		),
		'deprecated' => array(
			'writerConfiguration' => array(
				\TYPO3\CMS\Core\Log\LogLevel::WARNING => array(
					'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
						'logFile' => 'typo3conf/deprecation.log'
					)
				)
			)
		)
	)
);

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);
unset($GLOBALS['TYPO3_CONF_VARS']['LOG']['writerConfiguration'][\TYPO3\CMS\Core\Log\LogLevel::DEBUG]['TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter']);
