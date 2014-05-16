<?php 

$path = "/Users/armandoarce/Dropbox/GitHub/ProgramacionPHP/_php/data.json";

if (!file_exists($path))
    exit("File not found");

$data = file_get_contents($path);
$json = json_decode($data, true);

echo "<html><body><table border=1>";
echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
foreach ($json['countries'] as $row) {
    echo "<tr><td>".$row['name']."</td><td>".$row['area']."</td><td>".
         $row['people']."</td><td>".$row['density']."</td></tr>";
}
echo "</table></body></html>";

?>