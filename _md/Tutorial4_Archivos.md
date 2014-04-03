# Manejo de archivos

La función *fopen(path,mode)* permite abrir un archivo local o mediante un URL. El *path* del archivo debe incluir la ruta completa al mismo. El *mode* puede ser *r* - lectura,*w* - escritura,*a* - agregar, o *x* - escritura exclusiva. Se puede agregar un *+* al modo y si el archivo no existe, se intentará crear. La función *fclose(file)* cierra un puntero a un archivo abierto.

La función *feof(file)* comprueba si el puntero a un archivo se encuentra al final del archivo. La función *fgets(file)* obtiene una línea desde el puntero a un archivo. La función *file_exists(file)* comprueba si existe un archivo o directorio.

	<?php
	
	$path = "/home/user/file.txt";
	if (!file_exists($path))
	    exit("File not found");
	$file = fopen($path, "r");
	if ($file) {
		while (($line = fgets($file)) !== false) {
			echo $line;
		}
		if (!feof($file)) {
			echo "Error: EOF not found\n";
		}
		fclose($file);
	}
	
	?>

La función *fscanf* analiza la entrada desde un archivo de acuerdo a un formato. Los tipos más importantes son: *%d* - entero, *%f* - flotante, y *%s* - string. Un detalle importante es que *%s* no reconoce hileras de texto con espacios en blanco, únicamente palabras completas.

	<?php
	
	$path = "/home/usr/data.txt";
	if (!file_exists($path))
		exit("File not found");
	$file = fopen($path, "r");
	echo "<html><body><table border=1>";
	echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
	while ($data = fscanf($file, "%s\t%d\t%d\t%f\n")) {
	    list ($country, $area, $pop, $dens) = $data;
	    echo "<tr><td>".$country."</td><td>".$area."</td><td>".
			 $pop."</td><td>".$dens."</td></tr>";
	}
	echo "</table></body></html>";
	fclose($file);
	
	?>

El archivo de datos para el ejemplo anterior podría ser el siguiente. Note que debe haber un tabulador que separe cada campo de un mismo registro.

	Belice	22966	334000	14.54
	Costa_Rica	51100	4726000	92.49
	El_Salvador	21041	6108000	290.29
	Guatemala	108894	15284000	140.36
	Honduras	112492	8447000	75.09
	Nicaragua	129494	6028000	46.55
	Panama	78200	3652000	46.70

## Directorios

La función *is_dir* indica si el nombre del archivo es un directorio y *is_file* indica si el nombre de archivo es realmente un archivo. La función *mkdir* crea un directorio. La función *rename* renombre un archivo o directorio. La función *rmdir* remueve un directorio y la función *unlink* remueve un archivo.

## Archivos binarios

Las funciones *fread* y *fwrite* leen y escriben, respectivamente, en un archivo en modo binario. La función *fseek* posiciona el puntero del archivo.

	<?php
	
	$path = "/home/usr/data2.txt";
	if (!file_exists($path))
		exit("File not found");
	$file = fopen($path, "r");
	echo "<html><body><table border=1>";
	echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
	fseek($file,35);
	while ($data = fread($file, 35)) {
	    $fields = explode("|",$data);
	    echo "<tr><td>".$fields[0]."</td><td>".$fields[1]."</td><td>".
			 $fields[2]."</td><td>".$fields[3]."</td></tr>";
	}
	echo "</table></body></html>";
	fclose($file);
	
	?>

El archivo de datos para el ejemplo anterior podría ser el siguiente. Note que este es un archivo de registros de tamaño fijo. Además, tome en cuenta que es necesario omitir los encabezados del archivo.

	CountryName|Area  |People  |Densi.
	Belice     | 22966|  334000| 14.54
	Costa Rica | 51100| 4726000| 92.49
	El Salvador| 21041| 6108000|290.29
	Guatemala  |108894|15284000|140.36
	Honduras   |112492| 8447000| 75.09
	Nicaragua  |129494| 6028000| 46.55
	Panama     | 78200| 3652000| 46.70

## Archivos de texto

Otra forma de leer archivos de texto es utilizar la función *file*, la cual transfiere un archivo completo a un arreglo. Note que no es necesario abrir el archivo (*fopen*) para utilizar este función.

	<?php
	
	$path = "/home/usr/data2.txt";
	if (!file_exists($path))
	    exit("File not found");
	$rows = file($path);
	array_shift($rows);
	echo "<html><body><table border=1>";
	echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
	foreach ($rows as $row) {
	    $fields = explode("|",$row);
	    echo "<tr><td>".$fields[0]."</td><td>".$fields[1]."</td><td>".
	         $fields[2]."</td><td>".$fields[3]."</td></tr>";
	}
	echo "</table></body></html>";
	
	?>

## Archivos CSV

La función *fgetcsv* obtiene una línea del puntero a un archivo y la examina para tratar campos CSV. La función *fputcsv* da formato a una línea como CSV y la escribe en un puntero a un archivo.

	<?php
	
	$path = "/home/usr/data3.csv";
	if (!file_exists($path))
		exit("File not found");
	$file = fopen($path, "r");
	echo "<html><body><table border=1>";
	echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
	while ($fields = fgetcsv($file,",")) {
	    echo "<tr><td>".$fields[0]."</td><td>".$fields[1]."</td><td>".
			 $fields[2]."</td><td>".$fields[3]."</td></tr>";
	}
	echo "</table></body></html>";
	fclose($file);
	
	?>

El archivo de datos para el ejemplo anterior podría ser el siguiente.

	Belice,22966,334000,14.54
	Costa Rica,51100,4726000,92.49
	El Salvador,21041,6108000,290.29
	Guatemala,108894,15284000,140.36
	Honduras,112492,8447000,75.09
	Nicaragua,129494,6028000,46.55
	Panama,78200,3652000,46.70
	
## Ejemplo

A continuación se muestra un ejemplo de una aplicación Web en PHP que permite llevar una lista de contactos. Cada contacto tiene un nombre, teléfono del trabajo, teléfono móvil, dirección electrónica y dirección postal. Se pueden agregar nuevos contactos, modificar los existentes, o eliminarlos.

![](Agenda.png)

Note que se utiliza *borrado perezoso* en esta solución, es decir, se marcan los registros borrados y no se eliminan realmente del archivo. También, en este ejemplo se utiliza un archivo con registros de tamaño fijo delimitados por el carácter '|'.

	<?php
	$path = "data.txt";
	if (file_exists($path))
	  $file = fopen($path, "r+");
	else
	  $file = fopen($path, "a+");
	while ($data = fread($file,154)) {
	  $array[] = explode('|',$data);
	};
	
	if (isset($_GET['get'])) {
	  $curr = (int)$_GET['get'];
	  $item = $array[$curr];
	} else if (isset($_GET['delete'])) {
	  $curr = (int)$_GET['delete'];
	  fseek($file,$curr*154,SEEK_SET);
	  fwrite($file,'**deleted**');
	  $array[$curr][0] = '**deleted**';
	  $item = array('','','','','');
	  $curr = 0;
	} else if (isset($_GET['save'])) {
		$curr = (int)$_GET['save'];
		$item = array(str_pad($_GET['name'],30),
		              str_pad($_GET['work'],30),
					  str_pad($_GET['mobile'],30),
					  str_pad($_GET['email'],30),
					  str_pad($_GET['address'],30));
		fseek($file,$curr*154,SEEK_SET);
		fwrite($file,implode('|',$item));
		$array[$curr] = $item;
	} else if (isset($_GET['append'])) {
	  $item = array('','','','','');
	  $curr = sizeof($array);
	};
	
	fclose($file);
	?>
	<html>
	    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<head>
			<title>Contacts</title>
		</head>
		<body>
		 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
		  <div style="width: 250px; float: left;">
		  	<h3>All Contacts</h3>
			<table width="150" border=1>
			  <?php
				for ($i=0;$i<sizeof($array);$i++) {
				  if (trim($array[$i][0])!="**deleted**")
				    echo '<tr><td><a href="?get='.$i.
					     '" style="text-decoration:none;">'.
					     $array[$i][0].'</a></td></tr>';
			    }
			  ?>
			</table>
		    </p>
			<button name="append" value="">+</button>
		  </div>
		  <div style="margin-left:250px;">
			  <table>
				<tr><td>&nbsp;</td></tr>
				<tr><td><label>name</label></td><td>
					<input name="name" size="30" value="<?php echo $item[0]; ?>"/></td></tr>
				<tr><td><label>work</label></td><td>
					<input name="work" size="30" value="<?php echo $item[1]; ?>"/></td></tr>
				<tr><td><label>mobile</label></td><td>
					<input name="mobile" size="30" value="<?php echo $item[2]; ?>"/></td></tr>
				<tr><td><label>email</label></td><td>
					<input name="email" size="30" value="<?php echo $item[3]; ?>"/></td></tr>
				<tr><td><label>address</label></td><td>
					<input name="address" size="30" value="<?php echo $item[4]; ?>"/></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td><button name="delete" value="<?php echo $curr; ?>">-</button></td>
					<td align="right">
					<button name="save" value="<?php echo $curr; ?>">Save</button></td></tr>
			  </table>
		    </div>
		  </form>
		</body>
	</html>
	
## Ejercicios

1. Intente modificar el ejemplo anterior para que utilice dos archivos, uno que almacene el nombre del contacto y un índice. Este índice indicará la posición en otro archivo en donde se encontrará el detalle del contacto.

2. Ahora, intente modificar el ejemplo para resolver el mismo problema pero utilizando registros de tamaño variable. Trate de solucionar de una forma 'elegante' el borrado de registros.

3. Debido a que cada vez que se ejecuta la aplicación es necesario cargar todo el archivo en memoria, una mejor solución sería 'paginar' los registros, es decir, cargar solo una pequeña parte en memoria y permitir que el usuario cargara más registros conforme los necesite (posiblemente mediante un par de botones adicionales).