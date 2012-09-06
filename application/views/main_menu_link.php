<?php if( ! defined( 'BASEPATH')) die(); 

$config = ConfigFactory::APPLICATION_CONFIG();

echo '<a href="'.$config->controller_root_uri . 'install/index/' .'">Back to Main Menu</a><br /><br />';

?>