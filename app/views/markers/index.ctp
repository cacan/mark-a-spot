<?php 
/**
 * Mark-a-Spot Index Template
 *
 * Index View Splashpage
 *
 * Copyright (c) 2010 Holger Kreis
 * http://www.mark-a-spot.org
 *
 *
 * PHP version 5
 * CakePHP version 1.2
 *
 * @copyright  2010 Holger Kreis <holger@markaspot.org>
 * @license    http://www.gnu.org/licenses/agpl-3.0.txt GNU Affero General Public License
 * @link       http://mark-a-spot.org/
 * @version    0.98
 */


echo $this->element('head');?>


<?php		
	/*
	 * Breadcrumb
	 *
	 */

	echo '<div id="breadcrumb"><div>';
	$html->addcrumb(
		__('Home',true),
			'/',
			array('escape'=>false)
		);
	echo $html->getCrumbs(' / ');
	echo '</div>';
	
		
	/*
	 * Welcome User with Nickname
	 *
	 */
	echo $this->element('welcome'); 
	echo '</div>';

?>
	<div id="content">
		<h2><?php __('Welcome to mas-city.com/markaspot') ?></h2>
		<?php echo $this->element('ajaxlist_element'); ?>
		
		<p class="intro"><?php __('Managing Concerns of Public Space') ?></p>
				
		<hr class="hidden"/>

		<div id="linksIndex">
				<?php echo $this->element('search');?>
				<hr class="hidden"/>
				<ul id="nav">
					<li id="MasOverviewAdd"><h3><?php __('Participate ...') ?></h3>
						<?php 	if ($session->read('Auth.User.id')) {
									$action = "add";
								} else {
									$action = "startup";
								}
					
							echo $html->link(__('Add a marker', true), array('controller' => 'markers', 'action' => $action),array('class'=>'add')); ?>
					</li>
<!--
					<li id="MasOverviewApp"><h3><?php __('Stay informed ...') ?></h3>
						<?php echo $html->link(__('What is going on ... ', true), array('controller' => 'markers', 'action' => 'app'),array('class'=>'view')); ?>
					</li>
-->
			</ul>
				<?php 					
					echo $this->element('intro_'.$lang);
				?>
		</div>	
		<hr class="hidden"/>
		<div id="listIndex">	
			<div id="map_wrapper_splash" style="position:relative; left: 0, right: 0">
			<?php echo $html->link('', array('controller' => 'markers', 'action' => 'app'), array('title' => __('Click to watch the map',true), 'id' => 'start', 'escape' => false)); ?></div>
			<noscript><p><?php 
				echo $html->link($html->image('http://maps.google.com/staticmap?center='.$googleCenter.'&amp;zoom=10&amp;size=320x200&amp;maptype=mobile\&amp;markers='.$googleCenter.',bluea%7C&amp;key='.$googleKey.'&amp;sensor=false'), array('controller' => 'markers', 'action' => 'app'), array('escape' => false)); ?> 
			</p></noscript>
			<div class="clear"></div>
			<h3><?php __('Recent changes') ?></h3>
			<ul class="marker_splash">
			<?php
			$i = 0;
			foreach ($markers as $marker):
			?>
				<li><div class="color_<?php echo $marker['Processcat']['Hex'] ?>"><h4><?php echo $html->link($marker['Marker']['subject'], array('controller'=>'markers', 'action' => 'view', $marker['Marker']['id']),array('title'=>'Status: '.$marker['Processcat']['Name'])); ?></h4><p class="status"><?php echo $marker['Processcat']['Name'] ?></p><p class="transactions"><?php __('This happened:') ?> <?php echo $marker['Transaction'][0]['name'];?></p></div><small class="meta"><?php echo $marker['User']['nickname']; ?><?php __(', on '); echo $datum->date_de($marker['Marker']['modified'],1);?></small>
				</li>		
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
