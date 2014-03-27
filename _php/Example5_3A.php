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
  $stmt->bindParam(1, $name);
  $stmt->bindParam(2, $area);
  $stmt->bindParam(3, $population);
  $stmt->bindParam(4, $density);
  
  $dbh->beginTransaction();
  $name = 'Nicaragua'; $area = 129494; $population = 602800; $density = 46.55;
  $stmt->execute();
  $name = 'Panama'; $area = 78200; $population = 3652000; $density = 46.70;
  $stmt->execute();
  $dbh->commit();
  
} catch (Exception $e) {
  $dbh->rollBack();
  echo "Failed: " . $e->getMessage();
}
?>