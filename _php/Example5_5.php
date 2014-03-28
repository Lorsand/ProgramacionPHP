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
		echo "<table border=1><tr>";
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		$keys = array_keys($result[0]);
		foreach ($keys as $key)
		  echo "<th>".$key."</th>";
		echo "</tr>";
		foreach ($result as $row) {
		  echo "<tr>";
		  foreach ($keys as $key)
			  echo "<td>".$row[$key]."</td>";
		  echo "</tr>";
	    }
		echo "</table>";
	} catch (Exception $e) {
	  echo "Failed: " . $e->getMessage();
	}
	?>
</html>