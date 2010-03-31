<?php
/**
 * Pear Mp3 Medium Adapter File
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
 * Pear Mp3 Medium Adapter Class
 *
 * @package    media
 * @subpackage media.libs.medium.adapter
 * @link       http://pear.php.net/package/MP3_Id
 */
class PearMp3MediumAdapter extends MediumAdapter {
	var $require = array(
		'mimeTypes' => array('audio/mpeg'),
		'imports' => array(
			array('type' => 'Vendor', 'name'=> 'MP3_Id', 'file' => 'MP3/Id.php')
	));

	function initialize($Medium) {
		if (isset($Medium->objects['MP3_Id'])) {
			return true;
		}

		if (!isset($Medium->file)) {
			return false;
		}

		$Object = new MP3_Id();
		$Object->read($Medium->file);
		$Object->study();

		$Medium->objects['MP3_Id'] =& $Object;
		return true;
	}

	function artist($Medium) {
		return $Medium->objects['MP3_Id']->getTag('artists');
	}

	function title($Medium) {
		return $Medium->objects['MP3_Id']->getTag('name');
	}

	function album($Medium) {
		return $Medium->objects['MP3_Id']->getTag('album');
	}

	function year($Medium) {
		return $Medium->objects['MP3_Id']->getTag('year');
	}

	function duration($Medium) {
		$duration = $Medium->objects['MP3_Id']->getTag('lengths');

		if ($duration != -1) {
			return $duration;
		}
	}

	function track($Medium) {
		return $Medium->objects['MP3_Id']->getTag('track');
	}

	function samplingRate($Medium) {
		return $Medium->objects['MP3_Id']->getTag('frequency');
	}

	function bitRate($Medium) {
		if ($bitrate = $Medium->objects['MP3_Id']->getTag('bitrate')) {
			return $bitrate * 1000;
		}
	}
}
?>