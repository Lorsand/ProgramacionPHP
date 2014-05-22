<?php
// La base de datos podría ser creada 
// usando el comando: sqlite3 test.db ""
// Note que tanto el archivo test.db 
// como el directorio en que se ejecuta
// el script deben tener derechos de
// escritura
try {
	$dbh = new PDO('sqlite:test.db');
    $dbh->exec("CREATE TABLE countries (name TEXT, area INTEGER, population INTEGER, density REAL)");
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>