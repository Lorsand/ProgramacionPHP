echo "<html><body><table border=1>";
echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
foreach ($json['countries'] as $row) {
    echo "<tr><td>".$row['name']."</td><td>".$row['area']."</td><td>".
         $row['people']."</td><td>".$row['density']."</td></tr>";
}
echo "</table></body></html>";