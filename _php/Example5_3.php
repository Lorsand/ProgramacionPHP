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
	                            VALUES (:name, :area, :population, :density)");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':area', $area);
  $stmt->bindParam(':population', $population);
  $stmt->bindParam(':density', $density);
  
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