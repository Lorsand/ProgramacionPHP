<?php 

$path = "/Users/armandoarce/Dropbox/GitHub/ProgramacionPHP/_php/data2.xml";

$writer = XMLWriter::open($path); 
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