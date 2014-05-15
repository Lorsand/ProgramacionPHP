Manipulando XML y JSON
======================

Lectura de datos XML
--------------------

El método *XMLReader::open*, utilizado como método estático, establece
el URL de entrada para el contenido XML que se procesará y
*XMLReader::close* cierra dicha entrada. La función *XMLReader::read*
mueve al siguiente nodo en el documento. Por su parte la función
*XMLReader::next* mueve el cursor al siguiente nodo saltándose todos los
subárboles.

Para obtener el valor de un atributo se utiliza la función
*XMLReader::getAttribute(name)*. Para obtener el valor (texto) de un
nodo se puede utilizar el atributo *XMLReader:value* y para conocer el
nombre del elemento se utiliza el atributo *XMLRead:name*. El tipo del
nodo se obtiene mediante *XMLReadear::nodeType*. Algunos tipos de nodo
son: *XMLReader::ELEMENT*, *XMLReader::TEXT*, *XMLReader::END\_ELEMENT*.

Considere el siguiente archivo en formato XML con información sobre
varios países:

::

    <countries>
      <country name="Belice" area="22966" 
               people="334000" density="14.54"/>
      <country name="Costa Rica" area="51100" 
               people="4726000" density="92.49"/>
      <country name="El Salvador" area="21041" 
               people="6108000" density="290.29"/>
      <country name="Guatemala" area="108894" 
               people="15284000" density="140.36"/>
      <country name="Honduras" area="112492" 
               people="8447000" density="75.09"/>
      <country name="Nicaragua" area="129494" 
               people="6028000" density="46.55"/>
      <country name="Panama" area="78200" 
               people="3652000" density="46.70"/>
    </countries>

El siguiente programa genera una tabla en formato HTML a partir del
anterior archivo de datos:

::

    <?php 

    $path = "/Users/xxx/data.xml";

    if (!file_exists($path))
        exit("File not found");
    $xml = XMLReader::open($path);
    echo "<html><body><table border=1>";
    echo "<tr><th>Country</th><th>Area</th><th>Population</th><th>Density</th></tr>";
    while ($xml->read())
    if ($xml->nodeType == XMLReader::ELEMENT && $xml->name == 'country') {
        $fields = array();
        $fields[0] = $xml->getAttribute('name');
        $fields[1] = $xml->getAttribute('area');
        $fields[2] = $xml->getAttribute('people');
        $fields[3] = $xml->getAttribute('density');
        echo "<tr><td>".$fields[0]."</td><td>".$fields[1]."</td><td>".
             $fields[2]."</td><td>".$fields[3]."</td></tr>";
    }
    echo "</table></body></html>";
    $xml->close();

    ?> 

Escritura de datos mediante XML
-------------------------------

La clase *XMLWriter* crea un objeto de escritura XML, y el método
*XMLWriter::openURI(path)* establece el URI de salida para el contenido
XML que se generará y *XMLReader::flush* escribe dicha entrada. La
función *XMLReader::startDocument* crea el nodo principal de un
documento xml, y el método *XMLReader::endDocument* finaliza el
documento. Por su parte la función *XMLReader::startElement* crea un
elemento XML y el método *XMLReader::endElement* lo finaliza.

Para escribir el valor de un atributo se utiliza la función
*XMLReader::writeAttribute(name,value)*. Para obtener el valor (texto)
de un nodo se puede utilizar el atributo *XMLReader:value*.

El siguiente programa escribe una serie de datos al archivo XML de
países:

::

    <?php 

    $path = "/Users/xxx/data2.xml";

    $writer = new XMLWriter(); 
    $writer->openURI($path); 
    $writer->startDocument('1.0');

    $writer->startElement('countries'); 

    $writer->startElement('country');
    $writer->writeAttribute('name', 'Belice'); 
    $writer->writeAttribute('area', '22966'); 
    $writer->writeAttribute('people', '334000'); 
    $writer->writeAttribute('density', '14.54'); 
    $writer->endElement(); 

    $writer->startElement('country');
    $writer->writeAttribute('name', 'Costa Rica'); 
    $writer->writeAttribute('area', '51100'); 
    $writer->writeAttribute('people', '4726000'); 
    $writer->writeAttribute('density', '92.49'); 
    $writer->endElement();

    $writer->endElement(); 

    $writer->endDocument(); 

    $writer->flush();

    ?>

Uso de JSON
-----------

