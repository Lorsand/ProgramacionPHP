Servicios Web tipo RESTfull
===========================

La librería *ToroPHP* permite la creación de servicios web tipo RESTfull
de forma sencilla y eficiente en PHP. Esta se encuentra disponible en
http://toroweb.org. Una vez que se descarga el archivo *Toro.php* éste
puede ser probado utilizando un pequeño programa de ejemplo, llamado
*prueba.php*:

::

    <?php

    require("Toro.php");

    class HelloHandler {
        function get() {
            echo "Hello, world";
        }
    }

    Toro::serve(array(
        "/" => "HelloHandler",
    ));

    ?>

Dicho programa se puede ejecutar mediante el url
*http://localhost/webservice/prueba.php/*

Consulta de datos
-----------------

En el protocolo *RESTfull* se utiliza el método *GET* para recuperar
información. Para identificar el tipo de elemento a consultar se puede
utilizar un "subdirectorio" en el URL.

Por ejemplo, considere el siguiente programa que recupera todos datos de
los países desde la base de datos y los presenta en formato JSON. Para
invocarlo se debe usar un URL como
*http://localhost/prueba.php/country*.

::

    <?php
    require("Toro.php");

    class DBHandler {
        function get() {
            try {
              $dbh = new PDO('sqlite:test.db');
            } catch (Exception $e) {
              die("Unable to connect: " . $e->getMessage());
            }
            try {
                $stmt = $dbh->prepare("SELECT * FROM countries");
                $stmt->execute();
        
                json_encode($countries);
        
                $data = Array();
                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $result;
                }
                echo json_encode($data);
            } catch (Exception $e) {
              echo "Failed: " . $e->getMessage();
            }
        }
    }

    Toro::serve(array(
        "/country" => "DBHandler",
    ));
    ?>

Si se desea invocar a este servicio web desde otro programa PHP basta
con definir el contenido a partir de la dirección URL del servicio, por
ejemplo:

::

    <?php 
        
        $path = "http://localhost/prueba.php/country";
        
        $data = file_get_contents($path);
        $json = json_decode($data, true);
        
        echo "<html><body><table border=1>";
        echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
        foreach ($json as $row) {
            echo "<tr><td>".$row['name']."</td><td>".$row['area']."</td><td>".
                 $row['population']."</td><td>".$row['density']."</td></tr>";
        }
        echo "</table></body></html>";
        
    ?>

Paso de parámetros
~~~~~~~~~~~~~~~~~~

En los servicios web tipo RESTfull, y en ToroPHP en particular, los
parámetros de la consulta son pasados también como se fueran
subdirectorios y no mediante el símbolo ?. Por ejemplo, una llamada que
normalmente se realizaría de la siguiente forma:

::

    http://localhost/prueba.php?table=country&name=Nicaragua

se realizaría de la siguiente forma utilizando un servicio RESTfull:

::

    http://localhost/prueba.php/country/Nicaragua

note que en este caso el nombre de los parámetros no aparecen y ellos
deben ser identificados de forma implícita por su posición en la
solicitud.

Por ejemplo, considere ahora una modificación al programa anterior que
recuperará los datos de un país en la base de datos y los presenta en
formato JSON. Para invocarlo se debe usar un URL como
*http://localhost/prueba.php/country/Nicaragua*.

::

    <?php
        require("Toro.php");
        
        class DBHandler {
           
            function get($name=null) {
                try {
                  $dbh = new PDO('sqlite:test.db');
                } catch (Exception $e) {
                  die("Unable to connect: " . $e->getMessage());
                }
                try {
                    if ($name!=null) {
                        $stmt = $dbh->prepare("SELECT * FROM countries WHERE name = :name");
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    } else {
                        $stmt = $dbh->prepare("SELECT * FROM countries");
                    }
                    $stmt->execute();
            
                    $data = Array();
                    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $data[] = $result;
                    }
                    echo json_encode($data);
                } catch (Exception $e) {
                  echo "Failed: " . $e->getMessage();
                }
            }
        }
        
        Toro::serve(array(
            "/country" => "DBHandler",
            "/country/:alpha" => "DBHandler",
        ));
    ?>

Note que existen tres tipos de parámetros que reconoce ToroPHP: number,
alpha y string; o bien se puede utilizar una expresión regular como:
([0-9]+), ([a-zA-Z0-9-\_]+) ó ([a-zA-Z]+). Note que pueden ser
utilizados múltiples parámetros en la solicitud, y estos serán pasados
en el orden en que aparecen al método *get* de la clase utilizada como
manejador (handler).

Envío de datos
--------------

Para enviar información a un servicio *RESTfull* se utiliza el método
*POST* ó *PUT*. Generalmente el método *PUT* se utiliza para crear un
elemento, y el método *POST* para modificar los datos de un elemento
existente. Una nueva modificación al servicio web incorpora la capacidad
de modificar los datos de un registro, tal como se muestra a
continuación:

::

    <?php
        require("Toro.php");
        
        class DBHandler {
           
            function get($name=null) {
                // como en el ejemplo anterior
            }
            
            function post($name=null) {
                try {
                  $dbh = new PDO('sqlite:test.db');
                } catch (Exception $e) {
                  die("Unable to connect: " . $e->getMessage());
                }
                try {
                  $area = $_POST['area'];
                  $population = $_POST['population'];
                  $density = $_POST['density'];
                  echo $area;
                  
                  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                  $stmt = $dbh->prepare("UPDATE countries SET area=:area,
                                        population=:population, density=:density 
                                        WHERE name = :name");
                  $stmt->bindParam(':area', $area);
                  $stmt->bindParam(':population', $population);
                  $stmt->bindParam(':density', $density);
      
                  $dbh->beginTransaction();
                  $stmt->execute();
                  $dbh->commit();
                  echo 'Successfull';
                } catch (Exception $e) {
                  $dbh->rollBack();
                  echo "Failed: " . $e->getMessage();
                }
            }
        }
        
        Toro::serve(array(
            "/country" => "DBHandler",
            "/country/:alpha" => "DBHandler",
        ));
    ?>

Sin embargo para invocar esta función del servicio web, desde otro
programa PHP, es necesario utilizar un *stream PHP* tal como se muestra
a continuación:

::

    <?php
    $name='Nicaragua';

    $url = 'http://localhost/tarea/Example10_2.php/country/'.$name;
    $data = array('name'=>'Nicaragua','area'=>'129000',
                  'population'=>'6548000','density' => '46.55');
    $options = array(
            'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    echo $result;
    ?>

Borrado de datos
----------------

El método *DELETE* permite eliminar elementos cuando se utiliza el
protocolo *RESTfull*
