<?php

$path = "/Users/armandoarce/Sites/php/data.csv";
if (!file_exists($path))
    exit("File not found");
$file = fopen($path, "r");
echo "<html><body><table border=1>";
echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
while ($fields = fgetcsv($file,",")) {
    echo "<tr><td>".$fields[0]."</td><td>".$fields[1]."</td><td>".
         $fields[2]."</td><td>".$fields[3]."</td></tr>";
}
echo "</table></body></html>";
fclose($file);

?>