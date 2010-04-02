<?php
/**
 * Mark-a-Spot Config  File
 *
 * Mails, Google API Key
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


$config['Config.language'] = 'deu';

//deprecated? 
$config['Auth.Norights'] = 'Sie sind nicht berechtigt, auf diesen Teil der Seite zuzugreifen';
$config['Auth.Nologin'] = 'Benutzer oder Passwort wurden nicht gefunden: Versuchen Sie es noch einmal';

$config['Gov.zip'] = '10000';
$config['Gov.town'] = 'Berlin';

$config['Site.domain'] = 'mas-city.com';
$config['Site.admin.name'] = 'info@markaspot.de';
$config['Site.e-mail'] = 'info@markaspot.de';
$config['Site.name'] = 'placeceholder www.markaspot.de';

$config['e-mail.welcome.subject'] = 'Welcome to Mark-a-Spot / Mas-City';
$config['e-mail.add.subject'] = 'Your Marker at Mark-a-Spot / Musterstadt';
$config['e-mail.update.subject'] = 'Your Marker has been updated';
$config['e-mail.resetpw.subject'] = 'Passwort Reset at Mark-a-Spot / Mas-city';


$config['Google.Key'] = 'ABQIAAAAzAaa1p0iGUs-Hzx9dW_8KhS2SIgkSweE_2mDFpyoUqumsa2_SxT-xhAfdq1FLr9zK-frbi1QKkmihw';
$config['Google.Center'] = '52.5234051,13.4113999'; // http://www.getlatlon.com/ << there


$config['Publish.Markers'] = 1;
$config['Publish.Comments'] = 1;

$config['userGroup.admins'] = '4abe28d5-bab4-4ea0-a696-e930510ab7ac';
$config['userGroup.sysadmins'] = '4abba313-d3e8-45be-b5f5-48bb510ab7ac';
$config['userGroup.users'] = '4abe2bc9-2554-427f-bb9e-e88e510ab7ac';

//$config['Service.recaptcha_public_key'] = '6LesHQwAAAAAACDgyXDjMKK7ZwfP1oYtK627uBoD';
//$config['Service.recaptcha_private_key'] = '6LesHQwAAAAAABtVXmPCaY12-sMTj3aAmieaJdWi'; 

$config['mas'] = '0.98';
?>