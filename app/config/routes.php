<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'markers', 'action' => 'index'));
	Router::connect('/karte', array('controller' => 'markers', 'action' => 'app'));
	//Router::connect('/markaspot/karte', array('controller' => 'markers', 'action' => 'app'));
	Router::connect('/startup', array('controller' => 'markers', 'action' => 'startup'));
	Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
	Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
	Router::connect('/impressum', array('controller' => 'pages', 'action' => 'impressum'));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */

	Router::connect('/seiten/*', array('controller' => 'pages', 'action' => 'display'));
	Router::connect('/rss', array('controller' => 'markers', 'action' => 'rss'));
	Router::connect('/search/*',	array('plugin' => 'search', 'controller' => 'searches', 'action' => 'index'));

	
/**
 *
 * set lang
 */	

	Router::connect('/:language/karte/*',
						array('controller' => 'markers', 'action' => 'app'),
						array('language' => '[a-z]{3}')
    );
    
	
	Router::connect('/:language/:controller/:action/*',
						array(),
						array('language' => '[a-z]{3}')
    );
?>