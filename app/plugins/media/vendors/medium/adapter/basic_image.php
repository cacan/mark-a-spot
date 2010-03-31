<?php
/**
 * Basic Image Medium Adapter File
 *
 * Copyright (c) 2007-2010 David Persson
 *
 *
 * PHP version 5
 * CakePHP version 1.2
 *
 * @package    media
 * @subpackage media.libs.medium.adapter
 * @copyright  2007-2010 David Persson <davidpersson@gmx.de>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://github.com/davidpersson/media
 */
/**
 * Basic Image Medium Adapter Class
 *
 * @package    media
 * @subpackage media.libs.medium.adapter
 */
class BasicImageMediumAdapter extends MediumAdapter {
	var $require = array(
		'mimeTypes' => array(
			'image/jpeg',
			'image/gif',
			'image/png',
			'image/tiff',
			'image/xbm',
			'image/wbmp',
			'image/ms-bmp',
			'image/xpm',
			'image/ico',
			'image/psd',
	));

	function initialize($Medium) {
		if (!isset($Medium->file)) {
			return false;
		}
		return true;
	}

	function width($Medium) {
		list($width, $height) = getimagesize($Medium->file);
		return $width;
	}

	function height($Medium) {
		list($width, $height) = getimagesize($Medium->file);
		return $height;
	}
}
?>