<?php
echo $html->meta('Feed',    '/rss',    array('type' => 'rss'),false);
echo $javascript->link('http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key='.$googleKey, false);
// echo $javascript->link('http://openlayers.org/api/OpenLayers.js', false);
// echo $javascript->link('http://www.openstreetmap.org/openlayers/OpenStreetMap.js',false);
echo $javascript->link('http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js', false);
echo $javascript->link('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js', false);
echo $javascript->link('jquery/jquery.url.packed.js', false);
echo $javascript->link('jquery/jquery.cycle.lite.1.0.min.js', false);
echo $javascript->link('jquery/jquery.form.js', false);
echo $javascript->link('jquery/sf/superfish.js', false);
echo $javascript->link('jquery/jquery.cookie.js', false);
echo $javascript->link('jquery/fancybox/jquery.fancybox-1.2.6.pack.js', false);
echo $javascript->link('/rating/js/rating_jquery.js',false); 
echo $javascript->link('mapiconmaker_packed.js', false);
/*
$lang = $this->element(Configure::read('Config.language')).'js';
$javascript->link($lang, false);
*/
echo $javascript->link('common.js', false);
echo $javascript->link('markers.js', false);

// echo $javascript->link('gmap-wms.js', false);
// echo $javascript->link('markersOpenLayers.js', false);

echo $html->css('styles', null, null, false); 
?>