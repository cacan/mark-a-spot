<?php
/**
 * AppController for the AJAX star rating plugin.
 *
 * @author Michael Schneidt <michael.schneidt@arcor.de>
 * @copyright Copyright 2009, Michael Schneidt
 * @license http://www.opensource.org/licenses/mit-license.php
 * @link http://bakery.cakephp.org/articles/view/ajax-star-rating-plugin-1
 * @version 2.2
 */ 
class RatingAppController extends AppController {
  var $uses = array('Rating');
  var $helpers = array('Javascript', 'Rating');
  var $components = array('Cookie');
}
?>