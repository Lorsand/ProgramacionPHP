Plantillas
==========

*Mustache* es un motor de plantillas para PHP, es decir, separa el
código PHP, como lógica de negocios, del código HTML, como lógica de
presentación, y genera contenidos web mediante la colocación de
etiquetas *mustache* en un documento. *Mustache* está disponible en
muchos lenguajes de programación y es consistente entre plataformas.

La versión para PHP puede ser descargada desde
https://github.com/bobthecow/mustache.php. Unicamente es necesario
copiar, en el directorio en donde se correrá el programa, el directorio
*src/mustache*.

Uso básico
----------

Un programa PHP debe realizar la inicialización del motor *mustache*
mediante el *autoloader* que viene incluido con el código. En dicha
inicialización se puede indicar la extensión y ubicación de los archivos
de plantillas, por ejemplo */views*. Dentro del programa la plantilla se
carga mediante el método *loadTemplate* y luego se puede *aplicar*
mediante la función *render*. Note que a esta última función se deben
pasar como parámetros, mediante un arreglo, el conjunto de datos que
serán utilizados por la plantilla.

::

    <?php 

    require 'Mustache/Autoloader.php';
    Mustache_Autoloader::register();

    $mustache = new Mustache_Engine(array(
        'loader' => new Mustache_Loader_FilesystemLoader(
                             dirname(__FILE__) . '/views',
                             array('extension' => '.tpl')),
    ));

    $path = "data.json";
    if (!file_exists($path))
        exit("File not found");

    $data = file_get_contents($path);
    $json = json_decode($data, true);

    $tpl = $mustache->loadTemplate('Example9_1.tpl');
    echo $tpl->render(array('countries' => $json['countries']));

    ?>

El mecanismo de marcado (etiquetas) de *mustache* utiliza pares de
"corchetes" para definir el inicio y final de cada bloque de elementos.
Por ejemplo, para el programa anterior la plantilla se vería de la
siguiente forma. Recuerde que esta plantilla tiene como nombre
*Example9\_1.tpl* y se encuentra bajo el directorio */views*

::

    <html><body><table border=1>
    <tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>
    {{#countries}}
        <tr><td>{{name}}</td><td>{{area}}</td><td>
             {{people}}</td><td>{{density}}</td></tr>
    {{/countries}}
    </table></body></html>

Es importante indicar que el lenguaje de marcado de *mustache* es
consistente entre las distintas implementaciones de la librería, en
diferentes lenguajes de programación. Por lo tanto no se puede incluir
código PHP en una plantilla de *mustache*, pero dicha plantilla puede
ser "transportada" a otro ambiente de programación como: javascript,
python, Java, C++ ó ASP; y seguirá funcionando de la misma forma.

Condicionales
-------------

Es posible indicar que cierto contenido debe aparecer en la salida bajo
ciertas condiciones y otro no. Para eso se utiliza combinaciones de
etiquetas con "#" y "^". Por ejemplo considere el siguiente programa que
utiliza algunos datos de países, pero algunos están incompletos.

::

    <?php

    require 'Mustache/Autoloader.php';
    Mustache_Autoloader::register();

    $mustache = new Mustache_Engine(array(
        'loader' => new Mustache_Loader_FilesystemLoader(
                             dirname(__FILE__) . '/views',
                             array('extension' => '.tpl')),
    ));

    $countries = array(
        array("name"=>"Belice","area"=>"22966","people"=>"334000","density"=>"14.54"),
        array("area"=>"33444","people"=>"3434340","density"=>"0"),
        array("name"=>"Costa Rica","area"=>"51100","people"=>"4726000","density"=>"92.49"),
        array("area"=>"229656","people"=>"99800","density"=>"0"),
    );

    $tpl = $mustache->loadTemplate('Example9_2.tpl');
    echo $tpl->render(array('countries' => $countries));

    ?>

La plantilla asociada, llamada *Example9\_2.tpl*, mostraría una etiqueta
"desconocido" en aquellos registros que no aparezca su nombre, tal como
se muestra a continuación:

::

    <html><body><table border=1>
    <tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>
    {{#countries}}
      {{#name}}
        <tr><td>{{name}}</td><td>{{area}}</td><td>
             {{people}}</td><td>{{density}}</td></tr>
      {{/name}}
      {{^name}}
        <tr><td>Desconocido</td><td>{{area}}</td><td>
             {{people}}</td><td>{{density}}</td></tr>
      {{/name}}
    {{/countries}}
    </table></body></html>

