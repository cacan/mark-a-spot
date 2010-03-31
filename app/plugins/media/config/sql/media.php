<?php
/**
 * Media Schema File
 *
 * Copyright (c) 2007-2010 David Persson
 *
 *
 * PHP version 5
 * CakePHP version 1.2
 *
 * @package    media
 * @subpackage media.config.sql
 * @copyright  2007-2010 David Persson <davidpersson@gmx.de>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://github.com/davidpersson/media
 */
/**
 * Media Schema Class
 *
 * @package    media
 * @subpackage media.config.sql
 */
class MediaSchema extends CakeSchema {
/**
 * before
 *
 * @param array $event
 * @access public
 */
	function before($event = array()) {
		return true;
	}
/**
 * after
 *
 * @param array $event
 * @access public
 */
	function after($event = array()) {
	}
/**
 * attachments
 *
 * @var array
 * @access public
 */
	var $attachments = array(
		'id'          => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'extra' => 'auto_increment', 'length' => 10),
		'model'       => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255),
		'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'dirname'     => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255),
		'basename'    => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255),
		'checksum'    => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 255),
		'group'       => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 255),
		'alternative' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'created'     => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified'    => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes'     => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>