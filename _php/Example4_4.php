<?php

$path = "/Users/armandoarce/Sites/php/data2.txt";
if (!file_exists($path))
    exit("File not found");
$rows = file($path);
array_shift($rows);
echo "<html><body><table border=1>";
echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
foreach ($rows as $row) {
    $fields = explode("|",$row);
    echo "<tr><td>".$fields[0]."</td><td>".$fields[1]."</td><td>".
         $fields[2]."</td><td>".$fields[3]."</td></tr>";
}
echo "</table></body></html>";

?>