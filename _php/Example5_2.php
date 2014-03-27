<?php
try {
  $dbh = new PDO('sqlite:test.db');
  echo "Connected\n";
} catch (Exception $e) {
  die("Unable to connect: " . $e->getMessage());
}

try {  
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $dbh->beginTransaction();
  $dbh->exec("INSERT INTO countries (name, area, population, density) values ('Belice',22966,334000,14.54)");
  $dbh->exec("INSERT INTO countries (name, area, population, density) values ('Costa Rica',51100,4726000,92.49)");
  $dbh->exec("INSERT INTO countries (name, area, population, density) values ('El Salvador',21041,6108000,290.29)");
  $dbh->exec("INSERT INTO countries (name, area, population, density) values ('Guatemala',108894,15284000,140.36)");
  $dbh->exec("INSERT INTO countries (name, area, population, density) values ('Honduras',112492,8447000,75.09)");
  $dbh->commit();
  
} catch (Exception $e) {
  $dbh->rollBack();
  echo "Failed: " . $e->getMessage();
}
?>