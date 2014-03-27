	<?php
	try {
	  $dbh = new PDO('sqlite:test.db');
	} catch (Exception $e) {
	  die("Unable to connect: " . $e->getMessage());
	}
	
	try {
		$sth = $dbh->prepare("SELECT * FROM countries");
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
		  print_r($row);
		  print("\n");
	    }
	} catch (Exception $e) {
	  echo "Failed: " . $e->getMessage();
	}
	?>