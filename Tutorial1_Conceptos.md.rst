Introducción a PHP
==================

PHP es un lenguaje diseñado para crear contenido HTML. PHP puede ser
ejecutado de tres formas: en un servidor web, a través de la línea de
comandos, o mediante un cliente GUI.

El lenguaje puede ejecutarse en prácticamente todos los sistemas
operativos actuales y en múltiples servidores web. Este también soporta
una amplia variedad de bases de datos y cuenta con múltiples librerías
para ejecutar procesos comunes.

Una página PHP generalmente consiste de una página HTML con comandos PHP
incrustados en ella. El servidor web procesa los comandos PHP y envía la
salida al visualizador (browser). Un ejemplo de una página PHP sencilla
sería la siguiente:

::

    <html> 
      <head> <title>Hello, world</title> </head>      <body>        <?php echo "Hello, world!"; ?>    </body>
    </html>

El comando *echo* de PHP produce la salida que se inserta en la página
HTML. Note que el código PHP se escribe dentro de los delimitadores **.

Variables
---------

Estructuras de control
----------------------

Funciones
---------

Hileras de caracteres
---------------------

Arreglos
--------

Un arreglo mantiene un grupo de valores, que pueden ser identificados
por una posición (un número, con cero siendo la primera posición) o
algún otro identificador, llamado un índice asociativo:

::

    $color[0] = "Rojo";
    $color[1] = "Azul";
    $color[2] = "Blanco";

    $dia['lunes'] = "Soleado";
    $dia['martes'] = "Nublado";
    $dia['jueves'] = "Lluvia";

El constructor *array()* crea un arreglo ya sea basado en posición o
índice asociativo, por ejemplo:

::

    $color = array("Rojo","Azul","Blanco");
    $dia = array('lunes' => "Soleado",
                 'martes' => "Nublado",
                 'jueves' => "Luvia");

Clases y objetos
----------------

