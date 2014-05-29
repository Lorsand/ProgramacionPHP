<?php 

$path = "data.json";

require 'Mustache/Autoloader.php';
Mustache_Autoloader::register();

$mustache = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(
	                     dirname(__FILE__) . '/views',
	                     array('extension' => '.tpl')),
));

if (!file_exists($path))
    exit("File not found");

$data = file_get_contents($path);
$json = json_decode($data, true);

$tpl = $mustache->loadTemplate('Example9_1.tpl');
echo $tpl->render(array('countries' => $json['countries']));

?>