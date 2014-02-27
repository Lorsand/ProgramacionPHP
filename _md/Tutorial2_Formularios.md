# Procesamiento de formularios

Es muy sencillo procesar formularios con PHP, ya que los parámetros del formulario están disponibles en los arreglos $_GET y $_POST.

## Métodos

Existen dos métodos HTTP que un cliente puede utilizar para pasar los datos del formulario al servidor: GET y POST. El método que utiliza un formulario particular, se especifica con el atributo *method* en la etiqueta *form*. En teoría, los métodos son sensibles a mayúsculas en el código HTML, pero en la práctica algunos navegadores fallan si el el nombre del método no está en mayúsculas.

A solicitud GET codifica los parámetros del formulario en la dirección URL en lo que se llama una cadena de consulta, el texto que sigue al carácter *?* es la cadena de consulta:

	/path/to/page.php?keyword=bell&length=3

Una solicitud POST pasa los parámetros del formulario en el cuerpo de la solicitud HTTP, dejando intacta la URL. El tipo de método que se utilizó para solicitar una página PHP está disponible a través de $_SERVER['REQUEST_METHOD']. Por ejemplo:

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	  // handle a GET request	} else {	  die("You may only GET this page."); 
	}
## Parámetros
Se utilizan los arreglos *$_POST*, *$_GET* y *$_FILES* para acceder a los parámetros de formulario desde el código PHP. Las llaves son los nombres de los parámetros y los valores son los valores de esos parámetros. Por ejemplo, considere la siguiente página utilizada para separar una palabra:
	<html>
	  <head><title>Formulario de separación</title></head>
	  <body>
	    <form action="separar.php" method="POST">
	      Ingrese una palabra: <input type="text" name="word" /><br />
	      Largo de las separaciones ?
	      <input type="text" name="number" /><br />
	      <input type="submit" value="Dividir">
	   </form>
	  </body> 
	</html>

El programa PHP para procesar dicho formulario sería el siguiente:

	$word = $_POST['word']; 
	$number = $_POST['number'];
	$chunks = ceil(strlen($word) / $number);
	echo "The {$number}-letter chunks of '{$word}' are:<br />\n";
	for ($i = 0; $i < $chunks; $i++) {
	  $chunk = substr($word, $i * $number, $number);
	  printf("%d: %s<br />\n", $i + 1, $chunk);
	}
## Páginas con auto-procesamiento
Una página PHP puede ser utilizada tanto para generar un formulario como para procesarlo.
	<html>
	  <head><title>Temperature Conversion</title></head>
	  <body>
	    <?php if ($_SERVER['REQUEST_METHOD'] == 'GET') { ?>
	      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
	        Fahrenheit temperature:
	        <input type="text" name="fahrenheit" /><br />
	        <input type="submit" value="Convert to Celsius!" />
	      </form>
	    <?php } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	      $fahrenheit = $_POST['fahrenheit']; 
	      $celsius = ($fahrenheit - 32) * 5 / 9;
	      printf("%.2fF is %.2fC", $fahrenheit, $celsius); 
	    } else {
	     die("This script only works with GET and POST requests.");
	    } ?>
	  </body>
	</html>

Otra forma de programa decide si se debe mostrar un formulario o proceso es ver si alguno de los parámetros se ha suministrado. Esto le permite escribir una página de auto-procesamiento que utiliza el método GET para enviar valores.

	<html>
	  <head><title>Temperature Conversion</title></head>
	  <body>
	    <?php $fahrenheit = $_GET['fahrenheit'];
	      if (is_null($fahrenheit)) { ?>
	    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
	      Fahrenheit temperature:
	      <input type="text" name="fahrenheit" /><br /> 
		  <input type="submit" value="Convert to Celsius!" />
	    </form>
	   <?php } else {
	     $celsius = ($fahrenheit - 32) * 5 / 9;
	     printf("%.2fF is %.2fC", $fahrenheit, $celsius); } ?>
	  </body> 
	</html>

## Formularios adhesivos

Muchos sitios web utilizan una técnica conocida como formularios adhesivos, en el que los resultados de una consulta se acompañan de un formulario de búsqueda cuyos valores por defecto son los de la consulta anterior.

La técnica básica consiste en utilizar el valor enviado por el formulario como el valor por defecto cuando se crea el campo HTML.

	<html>
	  <head><title>Temperature Conversion</title></head>
	  <body>
	    <?php $fahrenheit = $_GET['fahrenheit']; ?>
	   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
	     Fahrenheit temperature:
	     <input type="text" name="fahrenheit" value="<?php echo $fahrenheit; ?>" /><br/>
	     <input type="submit" value="Convert to Celsius!" />
	   </form>
	   <?php if (!is_null($fahrenheit)) {
	     $celsius = ($fahrenheit - 32) * 5 / 9; 
		 printf("%.2fF is %.2fC", $fahrenheit, $celsius);
	   } ?> 
	  </body>
	</html>

## Parámetros multivaluados

Las listas de selección HTML, creadas con la etiqueta *select*, pueden permitir selecciones múltiples. Para asegurarse de que PHP reconoce los múltiples valores que el navegador pasa a un programa de procesamiento de formularios, es necesario hacer que el nombre del campo en la formulario HTML finalice *[]*.

	<html>
	  <head><title>Personality</title></head>
	  <body>
	    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET"> 
	      Select your personality attributes: <br/>
	      <select name="attributes[]" multiple>
	        <option value="perky">Perky</option>
	        <option value="morose">Morose</option>
	        <option value="thinking">Thinking</option>
	        <option value="feeling">Feeling</option>
	        <option value="thrifty">Spend-thrift</option>
	        <option value="shopper">Shopper</option>
	      </select><br/>
	      <input type="submit" name="s" value="Record my personality!" />
	    </form>
	<?php if (array_key_exists('s', $_GET)) { 
	   $description = join(' ', $_GET['attributes']);
	   echo "You have a {$description} personality.";
	} ?> 
	  </body>
	</html>
	
Otro ejemplo similar pero que utiliza *checkboxes* es:

	<html>
	  <head><title>Personality</title></head>
	  <body>
	    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="GET">
	      Select your personality attributes:<br />
	      <input type="checkbox" name="attributes[]" value="perky" /> Perky<br />
	      <input type="checkbox" name="attributes[]" value="morose" /> Morose<br />
	      <input type="checkbox" name="attributes[]" value="thinking" /> Thinking<br />
	      <input type="checkbox" name="attributes[]" value="feeling" /> Feeling<br />
	      <input type="checkbox" name="attributes[]" value="thrifty" />Spend-thrift<br />
	      <input type="checkbox" name="attributes[]" value="shopper" /> Shopper<br /><br />
	      <input type="submit" name="s" value="Record my personality!" />
	    </form>
	<?php if (array_key_exists('s', $_GET)) { 
	  $description = join (' ', $_GET['attributes']); 
	  echo "You have a {$description} personality.";
	} ?> 
	  </body>
	</html>
	
## Parámetros multivaluados adhesivos

Para manejar parámetros multivaluados adhesivos es útil escribir una función para generar el código HTML de los valores posibles y trabajar a partir de una copia de los parámetros enviados.

	<html>
	  <head><title>Personality</title></head>
	  <body>
	
	<?php
	  $attrs = $_GET['attributes'];
	  if (!is_array($attrs)) {
	    $attrs = array();
	}
	
	function makeCheckboxes($name, $query, $options) {
	  foreach ($options as $value => $label) {
	    $checked = in_array($value, $query) ? "checked" : '';
	    echo "<input type=\"checkbox\" name=\"{$name}\" 
	          value=\"{$value}\" {$checked} />";
	    echo "{$label}<br />\n"; }
	  }
	
	$personalityAttributes = array(
	  'perky'=> "Perky",
	  'morose'=> "Morose",
	  'thinking'=> "Thinking",
	  'feeling'=> "Feeling",
	  'thrifty'=> "Spend-thrift",
	  'prodigal'=> "Shopper"
	); ?>
	
	  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
	    Select your personality attributes:<br />
	    <?php makeCheckboxes('attributes', $attrs, $personalityAttributes); ?><br />
	    <input type="submit" name="s" value="Record my personality!" />
	  </form>
	
	<?php if (array_key_exists('s', $_GET)) { 
	  $description = join (' ', $_GET['attributes']);
	  echo "You have a {$description} personality.";
	} ?>
	
	  </body>
	</html>

