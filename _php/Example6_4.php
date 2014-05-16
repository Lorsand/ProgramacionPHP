<?php 

$path = "/Users/armandoarce/Dropbox/GitHub/ProgramacionPHP/_php/data2.json";
$file = fopen($path, "w");

$countries = array(
	array("name"=>"Belice","area"=>"22966","people"=>"334000","density"=>"14.54"),
	array("name"=>"Costa Rica","area"=>"51100","people"=>"4726000","density"=>"92.49")
); 

$json = json_encode($countries);
fwrite($file, $json);
fclose($file);

?>