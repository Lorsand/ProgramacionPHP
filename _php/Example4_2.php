<?php

$path = "/Users/armandoarce/Sites/php/data.txt";
if (!file_exists($path))
    exit("File not found");
$file = fopen($path, "r");
echo "<html><body><table border=1>";
echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
while ($data = fscanf($file, "%s\t%d\t%d\t%f\n")) {
    list ($country, $area, $pop, $dens) = $data;
    echo "<tr><td>".$country."</td><td>".$area."</td><td>".
         $pop."</td><td>".$dens."</td></tr>";
}
echo "</table></body></html>";
fclose($file);

?>