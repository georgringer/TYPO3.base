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

use TYPO3\CMS\Core\Error\Http\PageNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class PageNotFoundHandling
 * It can be registered in FE with
 * 'pageNotFound_handling' => 'USER_FUNCTION:Cyberhouse\Theme\Page\PageNotFoundHandling->pageNotFound'
 *
 * error pages can be configured per host by using
 * $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['errorPages'] map,
 * $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['errorPages']['_DEFAULT'] will be used if no key corresponds to a correct key
 * $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['errorPages']['www.domain1.tld'] should contain the error page Uid for the host www.domain1.tld
 * 
 * best to set via AdditionalConfiguration*.php
 *
 * @package Cyberhouse\Theme\Page
 */
class PageNotFoundHandling {

	/**
	 * @var UriBuilder
	 */
	protected $uriBuilder;

	/**
	 * @var ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var ConfigurationManagerInterface
	 */
	protected $configurationManager;

	public function __construct() {
		$this->initializeEnvironment();
	}

	protected function initializeEnvironment() {
		/**
		 * @var ConfigurationManager $configurationManager
		 * @var ContentObjectRenderer $contentObjectRenderer
		 */
		$this->objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
		$configurationManager = $this->objectManager->get('TYPO3\CMS\Extbase\Configuration\ConfigurationManager');
		$this->configurationManager = &$configurationManager;

		$contentObjectRenderer = GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');

		$this->configurationManager->setContentObject($contentObjectRenderer);
		$this->uriBuilder = $this->objectManager->get('TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder');
		if (empty($GLOBALS['TSFE']->sys_page)) {
			$GLOBALS['TSFE']->sys_page = GeneralUtility::makeInstance('TYPO3\CMS\Frontend\Page\PageRepository');
		}
		if (empty($GLOBALS['TSFE']->tmpl)) {
			$GLOBALS['TSFE']->initTemplate();
		}
		if (!isset($GLOBALS['TSFE']->config)) {
			$GLOBALS['TSFE']->config = array();
		}
		if (empty($GLOBALS['TSFE']->config['config'])) {
			$GLOBALS['TSFE']->config['config'] = array();
			$GLOBALS['TSFE']->config['config']['tx_realurl_enable'] = TRUE;
			$GLOBALS['TSFE']->config['mainScript'] = 'index.php';
		}
	}


	/**
	 * Page not found handling
	 *
	 * @param array $params
	 * @param TypoScriptFrontendController $ref
	 * @throws PageNotFoundException
	 * @return void
	 */
	public function pageNotFound(array $params, TypoScriptFrontendController $ref = NULL) {
		$domain = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
		$domainInformation = parse_url($domain);
		$errorPageUid = (int)$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['errorPages']['_DEFAULT'];


		if (!empty($domainInformation['host'])) {
			$tmpErrorPageUid = (int)$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['theme']['errorPages'][$domainInformation['host']];
			if ($tmpErrorPageUid > 0) {
				$errorPageUid = $tmpErrorPageUid;
			}
		}

		if ($errorPageUid > 0) {
			$sysLanguageUid = $this->getSysLanguage($ref);

			$this->uriBuilder->reset()->setTargetPageUid($errorPageUid)->setCreateAbsoluteUri(TRUE);
			if ($sysLanguageUid > 0) {
				$this->uriBuilder->setArguments(array('L' => $sysLanguageUid));
			}

			HttpUtility::redirect($this->uriBuilder->buildFrontendUri(), HttpUtility::HTTP_STATUS_404);
		}

		$message = 'The page not found handling could not handle the request. The original message was: "' . $params['reasonText'] . '" with URL "' . $params['currentUrl'] . '"';
		throw new PageNotFoundException($message, 1301648780);
	}


	/**
	 * Try to get the current sys_language from various places
	 *
	 * @param TypoScriptFrontendController $ref
	 * @return int
	 */
	protected function getSysLanguage(TypoScriptFrontendController $ref) {
		if ($ref->sys_language_uid > 0) {
			return (int)$ref->sys_language_uid;
		}

		$getRequest = (int)GeneralUtility::_GET('L');
		if ($getRequest > 0) {
			return $getRequest;
		}

		$realurlVars = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT']['preVars'];
		$firstUrlArgument = array_shift(GeneralUtility::trimExplode('/', GeneralUtility::getIndpEnv('REQUEST_URI'), TRUE));
		if ($firstUrlArgument) {
			foreach ($realurlVars as $mapping) {
				if ($mapping['GETvar'] === 'L' && isset($mapping['valueMap'][$firstUrlArgument])) {
					return (int)$mapping['valueMap'][$firstUrlArgument];
				}
			}
		}
		return 0;
	}
}
