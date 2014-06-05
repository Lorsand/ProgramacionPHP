# Generación de imágenes

PHP permite la generación de imágenes mediante una serie de primitivas de dibujo. El primer paso para realizar esto consiste en definir el tamaño de la imagen mediante la instrucción *imagecreate(width,height)*. Luego se aplican sobre dicha imagen las primitivas de dibujo deseadas, al final se debe usar una instrucción para convertir la imagen en algún formato conocido como: *imagepng(image)*, *imagegif(image)* ó *imagejpeg(image)*. Posteriormente, se puede destruir la imagen en memoria utilizando la instrucción *imagedestroy(image)*. Si la imagen se desea desplegar en el navegador es necesario enviar el encabezado adecuado, por ejemplo:

	header( "Content-type: image/png" )

## Definición de colores

Para definir los colores que se utilizarán con las diferentes primitivas de dibujo es necesario utilizar la instrucción *imagecolorallocate(image, red, green, blue)*. Los rangos de los valores de rojo, verde y azul deben estar entre 0 y 255. Estos valores también pueden ser especificados en hexadecimal, por ejemplo: 0xFF

Es importante indicar que la primer llamada que se realice a esta función definirá automáticamente el color de fondo (background) de la imagen, por ejemplo:

	<?php
	     $myImage = imagecreate( 200, 100 );
	     $myGray = imagecolorallocate( $myImage, 204, 204, 204 );
	     header( "Content-type: image/png" );
	     imagepng( $myImage );
	     imagedestroy( $myImage );
	?>

## Primitivas de dibujo

Se cuenta con diferentes primitivas de dibujo que permiten crear gráficos sobre la imagen. Existen primitivas para dibujar líneas: *imageline(image, posX1, posY1, posX2, posY2, color)*, rectángulos: *imagerectangle(image, minX, minY, maxX, maxY, color)*, elipses *imageellipse(image, posX, posY, width, height, color)*, y polígonos *imagepolygon(image, array, num_points, color)*. Para dibujar primitivas rellenas se deben usar las instrucciones *imagefilledrectangle(image, minX, minY, maxX, maxY, color)*, elipses *imagefilledellipse(image, posX, posY, width, height, color)*, y polígonos *imagefilledpolygon(image, array, num_points, color)*.

	<?php
	     $myImage = imagecreate( 200, 100 );
	     $myGray = imagecolorallocate( $myImage, 204, 204, 204 );
	     $myBlack = imagecolorallocate( $myImage, 0, 0, 0 );
	     imageline( $myImage, 15, 35, 120, 60, $myBlack );
		 imagerectangle( $myImage, 15, 35, 120, 60, $myBlack );
		 imageellipse( $myImage, 90, 60, 160, 50, $myBlack );
		 $myPoints = array( 20, 20, 185, 55, 70, 80 );
		 imagepolygon( $myImage, $myPoints, 3, $myBlack );
	     header( "Content-type: image/png" );
	     imagepng( $myImage );
	     imagedestroy( $myImage );
	?>
	
## Manejo de texto

Es posible incluir texto en las imágenes para lo cual se puede utilizar la instrucción *imagestring(image, font, posX, posY, string, color)*. El tipo de fuente (font) puede ser un número entre 1 y 5 para los tipos de fuente predefinidos. Es posible cargar nuevas fuentes de letra desde archivos en formato *gdf* mediante la instrucción *imageloadfont(filename)*. También se puede obtener el ancho y tamaño del tipo de letra actual mediante las instrucciones *imagefontwidh()* e *imagefontheight()*. 

	<?php
	     $textImage = imagecreate( 200, 100 );
	     $white = imagecolorallocate( $textImage, 255, 255, 255 );
	     $black = imagecolorallocate( $textImage, 0, 0, 0 );
	     $yOffset = 0;
	for ( $i = 1; $i <= 5; $i++ ) {
	imagestring( $textImage, $i, 5, $yOffset, "This is system font $i", $black
	     );
	       $yOffset += imagefontheight( $i );
	}
	     header("Content-type: image/png");
	     imagepng( $textImage );
	     imagedestroy( $textImage );
	?>
	
En ocasiones es conveniente utilizar tipos de letra *TrueType* que mejoren la apariencia de la imagen. Para cargar archivos de este tipo se utiliza la instrucción *imagefttext(image, size, angle, posX, posY, color, filename, string)*

	<?php
	      $textImage = imagecreate( 200, 120 );
	      $white = imagecolorallocate( $textImage, 255, 255, 255 );
	      $black = imagecolorallocate( $textImage, 0, 0, 0 );
	      imagefttext( $textImage, 16, 0, 10, 50, $black, "fonts/truetype/
	      ttf-bitstream-vera/Vera.ttf", "Vera, 16 pixels" );
	      header( "Content-type: image/png" );
	      imagepng( $textImage );
	      imagedestroy( $textImage );
	?>