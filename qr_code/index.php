<?php
require 'phpqrcode/qrlib.php';
$dir = 'temp/';
	
//Si la carpeta no existe, se crea una
if (!file_exists($dir))
    mkdir($dir);

    //Se declara la ruta y el nombre que tendrá la imágen
$filename = $dir.'test.png';

    //Parametros de Condiguración

$tamaño = 10; //Tamaño de Pixel
$level = 'H'; //Precisión 
$frameSize = 3; //Tamaño en blanco
$contenido = "https://sourceforge.net/projects/phpqrcode/"; //Texto

    //Enviamos los parametros a la Función para generar código QR 
QRcode::png($contenido, $filename, $level, $tamaño, $frameSize);

    //Se muestra la imágen generada
echo '<img src="'.$dir.basename($filename).'" /><hr/>';  
?>