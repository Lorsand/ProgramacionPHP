Manejo de archivos
==================

La función *fopen(path,mode)* permite abrir un archivo local o mediante
un URL. El *path* del archivo debe incluir la ruta completa al mismo. El
*mode* puede ser *r* - lectura,\ *w* - escritura,\ *a* - agregar, o *x*
- escritura exclusiva. Se puede agregar un *+* al modo y si el archivo
no existe, se intentará crear. La función *fclose(file)* cierra un
puntero a un archivo abierto.

La función *feof(file)* comprueba si el puntero a un archivo se
encuentra al final del archivo. La función *fgets(file)* obtiene una
línea desde el puntero a un archivo. La función *file\_exists(file)*
comprueba si existe un archivo o directorio.

::

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

La función *fscanf* analiza la entrada desde un archivo de acuerdo a un
formato. Los tipos más importantes son: *%d* - entero, *%f* - flotante,
y *%s* - string. Un detalle importante es que *%s* no reconoce hileras
de texto con espacios en blanco, únicamente palabras completas.

::

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

El archivo de datos para el ejemplo anterior podría ser el siguiente.
Note que debe haber un tabulador que separe cada campo de un mismo
registro.

::

    Belice  22966   334000  14.54
    Costa_Rica  51100   4726000 92.49
    El_Salvador 21041   6108000 290.29
    Guatemala   108894  15284000    140.36
    Honduras    112492  8447000 75.09
    Nicaragua   129494  6028000 46.55
    Panama  78200   3652000 46.70

Directorios
-----------

La función *is\_dir* indica si el nombre del archivo es un directorio y
*is\_file* indica si el nombre de archivo es realmente un archivo. La
función *mkdir* crea un directorio. La función *rename* renombre un
archivo o directorio. La función *rmdir* remueve un directorio y la
función *unlink* remueve un archivo.

Archivos binarios
-----------------

Las funciones *fread* y *fwrite* leen y escriben, respectivamente, en un
archivo en modo binario. La función *fseek* posiciona el puntero del
archivo.

::

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

El archivo de datos para el ejemplo anterior podría ser el siguiente.
Note que este es un archivo de registros de tamaño fijo. Además, tome en
cuenta que es necesario omitir los encabezados del archivo.

::

    CountryName|Area  |People  |Densi.
    Belice     | 22966|  334000| 14.54
    Costa Rica | 51100| 4726000| 92.49
    El Salvador| 21041| 6108000|290.29
    Guatemala  |108894|15284000|140.36
    Honduras   |112492| 8447000| 75.09
    Nicaragua  |129494| 6028000| 46.55
    Panama     | 78200| 3652000| 46.70

Archivos de texto
-----------------

Otra forma de leer archivos de texto es utilizar la función *file*, la
cual transfiere un archivo completo a un arreglo. Note que no es
necesario abrir el archivo (*fopen*) para utilizar este función.

::

    <?php

    $path = "/home/usr/data2.txt";
    if (!file_exists($path))
        exit("File not found");
    $rows = file($path);
    echo "<html><body><table border=1>";
    echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
    for ($row in $rows) {
        $fields = explode("|",$row);
        echo "<tr><td>".$fields[0]."</td><td>".$fields[1]."</td><td>".
             $fields[2]."</td><td>".$fields[3]."</td></tr>";
    }
    echo "</table></body></html>";
    fclose($file);

    ?>

Archivos CSV
------------

La función *fgetcsv* obtiene una línea del puntero a un archivo y la
examina para tratar campos CSV. La función *fputcsv* da formato a una
línea como CSV y la escribe en un puntero a un archivo.

::

    <?php

    $path = "/home/usr/data3.txt";
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

::

    Belice,22966,334000,14.54
    Costa Rica,51100,4726000,92.49
    El_Salvador,21041,6108000,290.29
    Guatemala,108894,15284000,140.36
    Honduras,112492,8447000,75.09
    Nicaragua,129494,6028000,46.55
    Panama,78200,3652000,46.70

