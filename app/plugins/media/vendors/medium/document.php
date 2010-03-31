<?php
/**
 * Document Medium File
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
 * Document Medium Class
 *
 * @package    media
 * @subpackage media.libs.medium
 */
class DocumentMedium extends Medium {
/**
 * Compatible adapters
 *
 * @var array
 */
	var $adapters = array('Imagick', 'ImagickShell');
/**
 * Current width of medium
 *
 * @return integer
 */
	function width()	{
		return $this->Adapters->dispatchMethod($this, 'width', null, array(
			'normalize' => true
		));
	}
/**
 * Current height of medium
 *
 * @return integer
 */
	function height() {
		return $this->Adapters->dispatchMethod($this, 'height', null, array(
			'normalize' => true
		));
	}
/**
 * Determines a (known) ratio of medium
 *
 * @return mixed if String if $known is true or float if false
 */
	function ratio($known = true) {
		if (!$known) {
			return $this->width() / $this->height();
		}
		return $this->_knownRatio($this->width(), $this->height());
	}
}
?>