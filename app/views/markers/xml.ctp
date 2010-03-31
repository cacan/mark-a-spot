<?php 
echo('<?xml version="1.0" encoding="utf-8"?>'); 
echo "<markers>";
echo $xml->serialize($markers);
echo '<votes sum="'.$votes.'"/>';
echo "</markers>";
?>