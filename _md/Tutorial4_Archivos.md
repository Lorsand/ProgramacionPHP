# Manejo de archivos

La función *fopen(path,mode)* permite abrir un archivo local o mediante un URL. El *path* del archivo debe incluir la ruta completa al mismo. El *mode* puede ser *r*: lectura,*w*: escritura,*a*: agregar,*x*: escritura exclusiva. Se puede agregar un *+* al modo y si el archivo no existe, se intentará crear. La función *fclose(file)* cierra un puntero a un archivo abierto.

La función *feof(file)* comprueba si el puntero a un archivo se encuentra al final del archivo. La función *fgets(file,buffer)* obtiene una línea desde el puntero a un archivo, y su contenido se almacena en *buffer*. La función *file_exists(file)* comprueba si existe un archivo o directorio.

	<?php
	
	$path = "/home/user/file.txt";
	if (!file_exists($path))
	    exit("File not found");
	$file = fopen($path, "r");
	if ($file) {
		while (($line = fgets($file, 1024)) !== false) {
			echo $line;
		}
		if (!feof($file)) {
			echo "Error: EOF not found\n";
		}
		fclose($file);
	}
	
	?>

La función *fscanf* analiza la entrada desde un archivo de acuerdo a un formato. 

	<?php
	$path = "data.txt";
	if (!file_exists($path))
		exit("File not found");
	$file = fopen($path, "r");
	echo "<html><body><table>";
	echo "<th><td>Country</td><td>Area</td><td>Population</td></th>";
	while ($data = fscanf($file, "%s\t%s\t%s\n")) {
	    list ($country, $area, $population) = $data;
	    echo "<tr><td>".$country."</td><td>".$area.
			 "</td><td>".$population."</td></tr>";
	}
	echo "</table></body></html>";
	fclose($file);
	?>

## Directorios

La función *is_dir* indica si el nombre del archivo es un directorio y *is_file* indica si el nombre de archivo es realmente un archivo. La función *mkdir* crea un directorio. La función *rename* renombre un archivo o directorio. La función *rmdir* remueve un directorio y la función *unlink* remueve un archivo.

## Archivos binarios

Las funciones *fread* y *fwrite* leen y escriben, respectivamente, en un archivo en modo binario. La función *fseek* busca sobre un puntero de un archivo.

## Archivos de texto

De igual forma la función *file* transfiere un archivo completo a un arreglo.

Las funciones *file_get_contents* y *file_put_contents* permiten leer y escribir, respectivamente, el contenido completo de un archivo hacia/desde una cadena de texto (string).

## Archivos CSV

La función *fgetcsv* obtiene una línea del puntero a un archivo y la examina para tratar campos CSV. La función *fputcsv* da formato a una línea como CSV y la escribe en un puntero a un archivo.

## Archivos JSON

## Archivos XML