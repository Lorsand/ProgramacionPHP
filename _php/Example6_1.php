<?php 

$path = "/Users/armandoarce/Dropbox/GitHub/ProgramacionPHP/_php/data.xml";

if (!file_exists($path))
    exit("File not found");
$xml = XMLReader::open($path);
echo "<html><body><table border=1>";
echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
while ($xml->read())
if ($xml->nodeType == XMLReader::ELEMENT && $xml->name == 'country') {
	$fields = array();
	$fields[0] = $xml->getAttribute('name');
	$fields[1] = $xml->getAttribute('area');
	$fields[2] = $xml->getAttribute('people');
	$fields[3] = $xml->getAttribute('density');
    echo "<tr><td>".$fields[0]."</td><td>".$fields[1]."</td><td>".
         $fields[2]."</td><td>".$fields[3]."</td></tr>";
}
echo "</table></body></html>";
$xml->close();

?> 