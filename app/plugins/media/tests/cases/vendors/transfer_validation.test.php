<?php
/**
 * Transfer Validation Test Case File
 *
 * Copyright (c) 2007-2010 David Persson
 *
 *
 * PHP version 5
 * CakePHP version 1.2
 *
 * @package    media
 * @subpackage media.tests.cases.libs
 * @copyright  2007-2010 David Persson <davidpersson@gmx.de>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://github.com/davidpersson/media
 */
App::import('Vendor', 'Media.TransferValidation');
require_once dirname(dirname(dirname(__FILE__))) . DS . 'fixtures' . DS . 'test_data.php';
/**
 * Transfer Validation Test Case Class
 *
 * @package    media
 * @subpackage media.tests.cases.libs
 */
class TransferValidationTest extends CakeTestCase {
	function setUp() {
		$this->TestData = new TestData();
	}

	function tearDown() {
		$this->TestData->flushFiles();
	}
}
?>