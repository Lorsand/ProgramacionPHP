Manteniendo el estado
=====================

HTTP es un protocolo sin estado, lo que significa que una vez que un
servidor web completa la petición de un cliente para una página web, la
conexión entre los dos desaparece. En otras palabras, no hay manera en
que un servidor pueda reconocer que toda una secuencia de peticiones se
originan desde el mismo cliente.

Para solucionar esta falta de estado del protocolo HTTP, existen varias
técnicas para realizar un seguimiento de la información de estado entre
las solicitudes (también conocido como el seguimiento de sesión).

Campos ocultos en formularios
-----------------------------

Una de estas técnicas es el uso de campos de formulario ocultos para
pasar la información. PHP trata a los campos de formulario ocultos al
igual que los campos de formulario normales, por lo que los valores
están disponibles en los arreglos :math:`\_GET y `\ \_POST. Mediante el
uso de campos de formulario ocultos, se puede mantener toda la
información que fuera necesaria para cualquier aplicación. Sin embargo,
una técnica más común consiste en asignar a cada usuario un
identificador único y pasar el identificador usando un único campo de
formulario oculto. Mientras que los campos de formulario ocultos
funcionan en todos los navegadores, ellos trabajan sólo para una
secuencia de formularios generados de forma dinámica, por lo que
generalmente no son tan útiles como algunas otras técnicas.

::

    <?php
      $number = $_POST['number'];
      if (isset($number)) {
         $count = intval($_POST['count']);
         $count++;
         $numbers = Array();
         array_push($numbers,$number);
         for ($i = 0; $i < $count-1; $i++) {
            array_push($numbers,$_POST['number'.$i]);
        }
      } else {
        $count = 0;
      }
    ?>
    <html>
        <head>
            <title>My Lottery</title>
        </head>
        <body>
       <h2>My Lottery</h2>
       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
       <?php
          if ($count == 0) {
            echo "<h3>Wellcome!!</h3>";
          } else {
            echo "<label>Your winning numbers are: </label>";
            for ($i = 0; $i < $count-1; $i++)
                echo "<b>".$numbers[$i]."</b>, ";
            echo "<b>".$numbers[$count-1]."</b></p>";
          }
          if ($count == 6) {
              echo "<h3>Good luck!!</h3>";
          } else { 
        ?>
       <label>Please, enter a number:</label>
       <input type='text' name='number'/>
       <input type='submit'>
       <?php } ?>
       <input type="hidden" value="<?php echo $count; ?>" name="count"/>
       <?php
          for ($i = 0; $i < $count; $i++) { ?>
          <input type="hidden" value="<?php echo $numbers[$i]; ?>" 
                 name="number<?php echo $i?>"/>
       <?php } ?>
       </form>
      </body>
     </html>

Cookies
-------

La segunda y más amplia técnica de mantener el estado es el uso de
cookies. Una cookie es un fragmento de información que el servidor puede
dar a un cliente. En cada solicitud posterior el cliente le dará esa
información de vuelta al servidor, identificando así a sí mismo. Las
cookies son útiles para conservar la información a través de las
repetidas visitas de un navegador, pero también tienen sus propios
problemas. El principal problema es que la mayoría de los navegadores
permiten a los usuarios desactivar las cookies. Por lo que cualquier
aplicación que utiliza las cookies para el mantenimiento del estado
tiene que usar otra técnica como un mecanismo de reserva.

Una cookie es básicamente una cadena que contiene varios campos. Un
servidor puede enviar una o más cookies a un navegador en las cabeceras
de una respuesta. Algunos de los campos de la galleta indican las
páginas para las que el navegador debe enviar la cookie como parte de la
solicitud.

PHP soporta cookies HTTP de forma transparente. Se pueden configurar
cookies usando la función *setcookie()* o *setrawcookie()*. Las cookies
son parte del header HTTP, así es que *setcookie()* debe ser llamada
antes que cualquier otra salida sea enviada al browser. Los envíos de
cookies desde el cliente serán incluidos automáticamente en el arreglo
$\_COOKIE.

::

    <?php
      $number = $_POST['number'];
      if (isset($number)) {
         $count = intval($_COOKIE['count']);
         setcookie('number'.$count,$number);
         $count++;
      } else {
        foreach ($_COOKIE as $key => $value )
          setcookie($key, FALSE);
        $count = 0;
      }
      setcookie('count', $count);
    ?>
    <html>
        <head>
            <title>My Lottery</title>
        </head>
        <body>
           <h2>My Lottery</h2>
           <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
           <?php
              if ($count == 0) {
                echo "<h3>Wellcome!!</h3>";
              } else {
                echo "<label>Your winning numbers are: </label>";
                for ($i = 0; $i < $count-1; $i++)
                    echo "<b>".$_COOKIE['number'.$i]."</b>, ";
                echo "<b>$number</b></p>";
              }
              if ($count == 6) {
                  echo "<h3>Good luck!!</h3>";
              } else { 
            ?>
           <label>Please, enter a number:</label>
           <input type='text' name='number'/>
           <input type='submit'>
           <?php } ?>
           </form>
        </body>
    </html>

Uso de sesiones
---------------

La mejor manera de mantener el estado con PHP es utilizar el sistema
integrado de seguimiento de sesiones. Este sistema permite crear
variables persistentes que son accesibles desde diferentes páginas de la
aplicación, así como en diferentes visitas al sitio por el mismo
usuario. Internamente, el mecanismo de seguimiento de la sesión de PHP
utiliza cookies (o URLs) para resolver con elegancia la mayoría de los
problemas que requieren del estado, cuidando de todos los detalles para
el programador.

La función PHP *session\_start* crea una sesión o reanuda la actual
basada en un identificador de sesión pasado mediante una petición GET o
POST, o pasado mediante una cookie. El soporte para sesiones permite
almacenar los datos entre peticiones en el arreglo $\_SESSION. La
función *session\_destroy* destruye toda la información asociada con la
sesión actual. No destruye ninguna de las variables globales asociadas
con la sesión, ni destruye la cookie de sesión.

::

    <?php
      session_start();
      $number = $_POST['number'];
      if (isset($number)) {
         $count = intval($_SESSION['count']);
         $_SESSION['number'.$count] = $number;
         $count++;
      } else {
        session_destroy();
        $count = 0;
      }
      $_SESSION['count'] = $count;
    ?>
    <html>
        <head>
            <title>My Lottery</title>
        </head>
        <body>
           <h2>My Lottery</h2>
           <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
           <?php
              if ($count == 0) {
                echo "<h3>Wellcome!!</h3>";
              } else {
                echo "<label>Your winning numbers are: </label>";
                for ($i = 0; $i < $count-1; $i++)
                    echo "<b>".$_SESSION['number'.$i]."</b>, ";
                echo "<b>$number</b></p>";
              }
              if ($count == 6) {
                  echo "<h3>Good luck!!</h3>";
              } else { 
            ?>
           <label>Please, enter a number:</label>
           <input type='text' name='number'/>
           <input type='submit'>
           <?php } ?>
           </form>
        </body>
    </html>

Reescritura del URL
-------------------

Otra técnica es la reescritura de URL, donde cada URL local en el que el
usuario puede hacer clic se modifica dinámicamente para incluir
información adicional. Esta información adicional se suele especificar
como un parámetro en la URL. Por ejemplo, si se asigna a cada usuario un
identificador único, es posible incluir ese ID en todas las direcciones
URL, de la siguiente manera:

::

    http://www.example.com/catalog.php?userid=123

Si es posible modificar dinámicamente todos los enlaces locales para
incluir un ID de usuario, se podrá realizar un seguimiento de los
usuarios individuales en su aplicación. La reescritura de URL trabaja
para todos los documentos generados dinámicamente, y no sólo los
formularios, pero en realidad llevar a cabo la reescritura puede ser
tedioso.

Ejemplo
-------

A continuación se muestra un ejemplo programado de una aplicación Web en
PHP que permite llevar una lista de eventos. Cada evento tiene una
fecha, hora, y asunto. Se pueden agregar nuevos eventos o eliminar los
existentes. En este caso se utilizaron "cookies" para solucionarlo, sin
embargo, la implementación utilizando campos ocultos o variables de
sesión resulta muy similar.

::

    <?php
      if (isset($_COOKIE['eventos'])) { 
        $array = split("/n",$_COOKIE['eventos']);
      }  else {
        $array = array();
      };
      
      if (isset($_POST['borrar'])) {
          $id = $_POST['borrar'];
          unset($array[$id]);
          $array = array_values($array);
          setcookie('eventos',implode("/n",$array));
      } else if (isset($_POST['agregar'])) {
          $new_item = $_POST['dia'].'|'.$_POST['hora'].'|'.$_POST['evento'];
          $array[] = $new_item;
          setcookie('eventos',implode("/n",$array));
      } else {
          setcookie('eventos',null);
          $array = array();
      }
    ?>
    <html>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <head>
            <title>Calendario de eventos</title>
        </head>
        <body>
          <h2>Calendario de eventos</h2>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <table border=1>
                <tr><th>Día</th><th>Hora</th><th>Evento</th><th>Operación</th></tr>
                <?php
                  for ($i=0;$i<sizeof($array);$i++) {
                    $values = explode("|",$array[$i]);
                    echo '<tr><td>'.$values[0].'</td><td>'.$values[1].'</td><td>'.
                        $values[2].'</td><td><button name="borrar" value="'.$i.
                        '">Borrar</button></td></tr>';
                  }
                ?>
                <tr><td><input size="10" name="dia" type="date"/></td>
                    <td><input name="hora" size="10" type="time"/></td>
                    <td><input size="40" name="evento"/></td>
                    <td><button name="agregar">Agregar</button></td>
                </tr>
            </table>
          </form>
        </body>
    </html>

