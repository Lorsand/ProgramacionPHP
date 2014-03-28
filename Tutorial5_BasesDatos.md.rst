Bases de datos con PDO
======================

La extensión PDO (PHP Data Objects) de PHP consiste de una capa de
abstracción para acceder a diferentes tipos de bases de datos.
Utilizando PDO se logran estandarizar los diferentes mecanismos para
realizar la conexión a una base de datos, así como recuperar y modificar
información. Sin embargo, PDO no estandariza SQL lo que significa que se
debe lidiar con las diferentes sintaxis de las instrucciones en cada
administrador de bases de datos.

Manejadores de bases de datos
-----------------------------

Para cada base de datos existe un manejador (driver) específico, que
debe estar habilitado en el archivo de configuración de PHP (el archivo
*php.ini*). Los manejadores se administran mediante extensiones de PHP,
las cuales tienen nombres finalizando con *dll* en Windows y con *so* en
Unix.

::

    extension=php_pdo.dll
    extension=php_pdo_firebird.dll
    extension=php_pdo_informix.dll
    extension=php_pdo_mssql.dll
    extension=php_pdo_mysql.dll
    extension=php_pdo_oci.dll
    extension=php_pdo_oci8.dll
    extension=php_pdo_odbc.dll
    extension=php_pdo_pgsql.dll
    extension=php_pdo_sqlite.dll

Todas estas extensiones deben existir en el directorio de *extensiones*
de PHP. Generalmente las extensiones *php\_pdo* y *php\_pdo\_sqlite*
estarán habilitadas por omisión.

Conexiones
----------

Para realizar una nueva conexión se debe crear una instancia del objeto
*PDO*. Este constructor acepta una serie de parámetros de conexión
(string de conexión) que pueden ser específicos para cada sistema de
bases de datos.

Si no se logra establecer la conexión se producirá una excepción
(PDOException). Si la conexión es exitosa, una instancia de *PDO* será
devuelta. La conexión permanece activa por todo le ciclo de vida del
objeto *PDO*. Para cerrar la conexión, se debe destruir el objeto
asegurándose que toda referencia sea eliminada, o bien, PHP cerrará la
conexión automáticamente cuando el programa finalice.

Si se desea hacer una conexión persistente, que no sea eliminada al
final de la ejecución del programa, es necesario habilitar la opción
*PDO:ATTR\_PERSISTENT* en el arreglo de las opciones de la conexión.

::

    <?php 
    try {
        $dbh = new PDO('sqlite:test.db');
        $dbh->exec("CREATE TABLE countries 
                     (name TEXT, area INTEGER, population INTEGER, density REAL)");
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    ?>

Note que en el ejemplo anterior la base de datos podría ser creada
usando el comando *sqlite3 test.db ""* (si está disponible en el
ambiente). Además, el archivo *test.db* como el directorio en que se
encuentra, deben tener derechos de escritura.

Transacciones
-------------

Debido a que no todas las bases de datos soportan transacciones, PHP
corre en el modo de *auto-commit* que ejecuta cada instrucción
individual en forma implícita. Si se desea usar transacciones, y no se
desea utilizar el modo de *auto-commit*, es necesario invocar el método
*PDO::beginTransaction()* al inicio de la transacción. Si el manejador
de la base de datos no permite el uso de transacciones se producirá una
excepción (*PDOException*). Cuando se acabe de especificar la
transacción se pueden utilizar los métodos *PDO::Commit* para aplicar
dichas instrucciones, o bien, *PDO::rollBack* para abortar dicha
transacción.

::

    <?php
    try {
      $dbh = new PDO('sqlite:test.db');
      echo "Connected\n";
    } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
    }

    try {

      $dbh->beginTransaction();
      $dbh->exec("INSERT INTO countries (name, area, population, density) 
                              values ('Belice',22966,334000,14.54)");
      $dbh->exec("INSERT INTO countries (name, area, population, density) 
                              values ('Costa Rica',51100,4726000,92.49)");
      $dbh->exec("INSERT INTO countries (name, area, population, density) 
                              values ('El Salvador',21041,6108000,290.29)");
      $dbh->exec("INSERT INTO countries (name, area, population, density) 
                              values ('Guatemala',108894,15284000,140.36)");
      $dbh->exec("INSERT INTO countries (name, area, population, density) 
                              values ('Honduras',112492,8447000,75.09)");
      $dbh->commit();
      
    } catch (Exception $e) {
      $dbh->rollBack();
      echo "Failed: " . $e->getMessage();
    }
    ?>

Si una transacción no fue terminada con la instrucción *commit* y el
programa finaliza, la base de datos abortará la transacción
automáticamente.

Instrucciones preparadas
------------------------

Una *instrucción preparada* es un tipo de plantilla para SQL que puede
ser personalizada utilizando parámetros. Existen dos beneficios de
utilizar *instrucciones preparadas*: la base de datos únicamente
compilará una vez la instrucción lo cual ahorra mucho tiempo, y los
parámetros no necesitan *comillas* ya que el manejador se encarga de
agregarlas a la instrucción.

::

    <?php
    try {
      $dbh = new PDO('sqlite:test.db');
      echo "Connected\n";
    } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
    }

    try {
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

Otra forma de hacer el enlace de variables es por posición y no por
nombre.

::

    <?php
    try {
      $dbh = new PDO('sqlite:test.db');
      echo "Connected\n";
    } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
    }

    try {
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

Adicionalmente, es posible utilizar un arreglo para pasar los parámetros
de la consulta. En este caso no es necesario incluir el enlace (bind) de
parámetros. Es importante notar que el orden de los parámetros resulta
vital aquí.

::

    <?php
    try {
      $dbh = new PDO('sqlite:test.db');
      echo "Connected\n";
    } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
    }

    try {
      $stmt = $dbh->prepare("INSERT INTO countries (name, area, population, density) 
                                    VALUES (?, ?, ?, ?)");
      
      $dbh->beginTransaction();
      $stmt->execute(array('Nicaragua', 129494, 602800, 46.55));
      $stmt->execute(array('Panama', 78200, 3652000, 46.70));
      $dbh->commit();
      
    } catch (Exception $e) {
      $dbh->rollBack();
      echo "Failed: " . $e->getMessage();
    }
    ?>

Recuperación de datos
---------------------

El método *PDOStatement::fetch* permite obtener la siguiente fila de un
conjunto de resultados de una consulta. Esta instrucción tiene varios
estilos de recuperación,entre ellos:

-  PDO::FETCH\_NUM: Retorna la siguiente fila como un arreglo indexado
   por posición.
-  PDO::FETCH\_ASSOC: Retorna la siguiente fila como un arreglo indexado
   por el nombre de la columna.
-  PDO::FETCH\_OBJ: Retorna la siguiente fila como un objeto anónimo con
   los nombres de las columnas como propiedades.

Si se produce un error, la instrucción *fetch* retornará *FALSE*.

::

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

Por su parte la instrucción *PDOStatement::fetchAll* retornará un
arreglo conteniendo todos las filas de un conjunto de resultados. El
arreglo representa cada columna como un arreglo de valores por columnas
o un objeto en donde las propiedades corresponden a los nombres de las
columnas. Esta instrucción cuenta con varios modos al igual que la
instrucción *fetch*, e inclusive se pueden especificar las columnas que
se desean recuperar. Se retorna un arreglo vacío si no existen
resultados, o *FALSE* si la consulta falla.

::

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

