<?php
try {
  $dbh = new PDO('sqlite:test.db');
  echo "Connected\n";
} catch (Exception $e) {
  die("Unable to connect: " . $e->getMessage());
}

try {  
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $dbh->prepare("INSERT INTO countries (name, area, population, density) 
	                            VALUES (?, ?, ?, ?)");
  
  $dbh->beginTransaction();
  $stmt->execute(array('Nicaragua',129494, 602800, 46.55));
  $stmt->execute(array('Panama',78200,3652000,46.70));
  $dbh->commit();
  
} catch (Exception $e) {
  $dbh->rollBack();
  echo "Failed: " . $e->getMessage();
}
?>