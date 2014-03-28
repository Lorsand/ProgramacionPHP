<html>
<?php
try {
  $dbh = new PDO('sqlite:test.db');
} catch (Exception $e) {
  die("Unable to connect: " . $e->getMessage());
}
try {
	$sth = $dbh->prepare("SELECT * FROM countries");
	$sth->execute();
	echo "<table border=1>";
	echo "<tr><th>Country</th><th>Area</th><th>People</th><th>Dens.</th></tr>";
	while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr><td>".$result['name']."</td><td>".$result['area'].
			"</td><td>".$result['population']."</td><td>".$result['density'].
			"</td></tr>";
    }
	echo "</table>";
} catch (Exception $e) {
  echo "Failed: " . $e->getMessage();
}
?>
</html>