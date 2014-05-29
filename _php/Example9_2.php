<?php 

$path = "data.json";

require 'Mustache/Autoloader.php';
Mustache_Autoloader::register();

$mustache = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(
	                     dirname(__FILE__) . '/views',
	                     array('extension' => '.tpl')),
));

$countries = array(
	array("name"=>"Belice","area"=>"22966","people"=>"334000","density"=>"14.54"),
	array("area"=>"33444","people"=>"3434340","density"=>"0"),
	array("name"=>"Costa Rica","area"=>"51100","people"=>"4726000","density"=>"92.49"),
	array("area"=>"229656","people"=>"99800","density"=>"0"),
);

$tpl = $mustache->loadTemplate('Example9_2.tpl');
echo $tpl->render(array('countries' => $countries));

?>