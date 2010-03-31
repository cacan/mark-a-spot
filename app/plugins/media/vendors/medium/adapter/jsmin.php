<?php
 /**
 * Jsmin Medium Adapter File
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
 * Jsmin Medium Adapter Class
 *
 * @package    media
 * @subpackage media.libs.medium.adapter
 * @link       http://code.google.com/p/jsmin-php/
 */
class JsminMediumAdapter extends MediumAdapter {
	var $require = array(
		'mimeTypes' => array('application/javascript'),
		'imports' => array(array('type' => 'Vendor', 'name'=> 'JSMin', 'file' => 'jsmin.php')),
	);

	function initialize($Medium) {
		if (isset($Medium->contents['raw'])) {
			return true;
		}

		if (!isset($Medium->file)) {
			return false;
		}
		return $Medium->contents['raw'] = file_get_contents($Medium->file);
	}

	function store($Medium, $file) {
		return file_put_contents($Medium->contents['raw'], $file);
	}

	function compress($Medium) {
		return $Medium->contents['raw'] = trim(JSMin::minify($Medium->contents['raw']));
	}
}
?>