<?php
/**
 * Icon Medium File
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
if (!class_exists('ImageMedium')) {
	App::import('Vendor', 'Media.ImageMedium', array('file' => 'medium' . DS . 'image.php'));
}
/**
 * Icon Medium Class
 *
 * @package    media
 * @subpackage media.libs.medium
 */
class IconMedium extends ImageMedium {
}
?>