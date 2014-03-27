<?php
try {
  $dbh = new PDO('sqlite:test.db');
} catch (Exception $e) {
  die("Unable to connect: " . $e->getMessage());
}

try {
	$sth = $dbh->prepare("SELECT * FROM countries");
	$sth->execute();
	while ($result = $sth->fetch(PDO::FETCH_ASSOC)) {
	  print_r($result);
    }
} catch (Exception $e) {
  echo "Failed: " . $e->getMessage();
}
?>