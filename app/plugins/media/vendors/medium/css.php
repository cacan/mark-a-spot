<?php
/**
 * Css Medium File
 *
 * Copyright (c) 2007-2010 David Persson
 *
 *
 * PHP version 5
 * CakePHP version 1.2
 *
 * @package    media
 * @subpackage media.libs.medium
 * @copyright  2007-2010 David Persson <davidpersson@gmx.de>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://github.com/davidpersson/media
 */
App::import('Vendor', 'Media.Medium');
/**
 * Css Medium Class
 *
 * @package    media
 * @subpackage media.libs.medium
 */
class CssMedium extends Medium {
/**
 * Compatible adapters
 *
 * @var array
 */
	var $adapters = array('CssTidy', 'BasicText');
/**
 * Number of characters
 *
 * @return integer
 */
	function characters() {
		return $this->Adapters->dispatchMethod($this, 'characters', null, array(
			'normalize' => true
		));
	}
/**
 * Compresses contents. of the medium
 *
 * @return string
 */
	function compress() {
		return $this->Adapters->dispatchMethod($this, 'compress');
	}
}
?>