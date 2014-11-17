<?php
namespace GeorgRinger\Theme\Error;

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

use TYPO3\CMS\Core\Error\ExceptionHandlerInterface;
use TYPO3\CMS\Core\Error\ProductionExceptionHandler as DefaultProductionHandler;

class ProductionExceptionHandler extends DefaultProductionHandler implements ExceptionHandlerInterface {

	/**
	 * @param \Exception $exception exception
	 * @return void
	 */
	public function echoExceptionWeb(\Exception $exception) {
		if (!headers_sent()) {
			header("HTTP/1.1 500 Internal Server Error");
		}

		$this->writeLogEntries($exception, self::CONTEXT_WEB);

		/** @var \TYPO3\CMS\Core\Messaging\ErrorpageMessage $messageObj */
		$messageObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\ErrorpageMessage', $this->getMessage($exception));
		$messageObj->setHtmlTemplate('typo3conf/ext/theme/Resources/Private/Templates/Standalone/Errors/Production.html');
		$messageObj->output();
	}
}
