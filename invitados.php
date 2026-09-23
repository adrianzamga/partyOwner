<?php
require './qr_code/phpqrcode/qrlib.php';

session_start();
require_once("conexion.php");

$idUsuario = $_SESSION['idUsuario'];
$nombre = $_SESSION['nombre'];
$correo = $_SESSION['correo'];
$telefono = $_SESSION['telefono'];
$fechaNacimiento = $_SESSION['fechaNacimiento'];
$foto = $_SESSION['foto'];

$_SESSION['idEvento'];
$_SESSION['nombreEvento'];
$_SESSION['fechaEvento'];
$_SESSION['hora_evento'];
$_SESSION['ubicacionEvento'];

require_once("conexion.php");
if(!isset($_SESSION['correo'])){
    header('Location:index.php');
}

if(isset($_POST['logout'])){
    session_destroy();
    header('Location:index.php');
}

function borrar_directorio($dirname) {
	//si es un directorio lo abro
         if (is_dir($dirname))
           $dir_handle = opendir($dirname);
        //si no es un directorio devuelvo false para avisar de que ha habido un error
	 if (!$dir_handle)
	      return false;
        //recorro el contenido del directorio fichero a fichero
	 while($file = readdir($dir_handle)) {
	       if ($file != "." && $file != "..") {
                   //si no es un directorio elemino el fichero con unlink()
	            if (!is_dir($dirname."/".$file))
	                 unlink($dirname."/".$file);
	            else //si es un directorio hago la llamada recursiva con el nombre del directorio
	                 borrar_directorio($dirname.'/'.$file);
	       }
	 }
	 closedir($dir_handle);
	//elimino el directorio que ya he vaciado
	 rmdir($dirname);
	 return true;
}

if(isset($_POST['whats'])){

    $idInvitado = $_POST['idInvitado'];
    $nombreInvitado = trim($_POST['nombreInvitado']);
    $telefonoInvitado = trim($_POST['telefonoInvitado']);
    $idEvento = $_SESSION['idEvento'];
    $sql = $cnnPDO->prepare("SELECT qr FROM invitados WHERE idInvitado = '".$_POST['idInvitado']."'");
    $sql->execute();
    $campo = $sql->fetch(PDO::FETCH_ASSOC);
    // Obtén la imagen de la base de datos
    $qr = $campo['qr'];
    $tmpPath = tempnam(sys_get_temp_dir(), 'qr');
    file_put_contents($tmpPath, $qr);


    $telIndetificador = '122994230907089';
    //TOKEN QUE NOS DA FACEBOOK
    $token = 'EAAFR2jaqMbkBO5sz5HgXHfKy3kamAa1hGQLZCgx5dUnUCvNR63UDjYwqrMzL1a08a77BEbaQZAnRX6LsaUJXi8r9PTyZB8wLAzWQ5J9BCWmL8C9ZCOHjMi4Vp4dCOcZArtvRsb6laN59ay8J4ayJKsAYtSCyniPw9w4LdEZBHBeznNJJkv7a0Klz7x1x94dWqhUyWxlsfi8TcqJXiXzbACPFc6WIxQbqVipOgZD';

    $url = 'https://graph.facebook.com/v17.0/'.$telIndetificador.'/messages';
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://graph.facebook.com/v17.0/'.$telIndetificador.'/media',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('messaging_product' => 'whatsapp','file'=> new CURLFILE($tmpPath, 'image/png' , 'qr.png')),
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$token.''
  ),
));

$response = curl_exec($curl);
$idResponse = json_decode($response, true);

curl_close($curl);
//echo $response;

    //TELEFONO DONDE SE ENVIARA EL MENSAJE
    $telefono = '52'.$_POST['telefonoInvitado'];
        
    $nombreEveneto = $_SESSION['nombreEvento'];;
    $usuario = $_SESSION['nombre'];
    $fecha = $_SESSION['fechaEvento'];
    $hora = $_SESSION['hora_evento'];
    $ubicacion = $_SESSION['ubicacionEvento'];
    
    //CONFIGURACION DEL MENSAJE
    $mensaje = ''
            . '{'
            . '"messaging_product": "whatsapp", '
            . '"to": "'.$telefono.'", '
            . '"type": "template", '
            . '"template": '
            . '{'
            . '     "name": "invitacion",'
            . '     "language":{ "code": "es_MX" }, '
            . '     "components": ['
            . '         {'
            . '             "type": "header",'
            . '             "parameters": ['
            . '                 {'
            . '                     "type": "IMAGE",'
            . '                      "image": {'
            . '                      "id" : "'.$idResponse['id'].'"'
            . '                      }'
            . '                 }'
            . '             ]'
            . '         },'
            . '         {'
            . '             "type": "body",'
            . '             "parameters": ['
            . '                 {'
            . '                     "type": "TEXT",'
            . '                     "text": "'.$nombreEveneto.'"'
            . '                 },'
            . '                 {'
            . '                     "type": "TEXT",'
            . '                     "text": "'.$usuario.'"'
            . '                 },'
            . '                 {'
            . '                     "type": "TEXT",'
            . '                     "text": "'.$fecha.'"'
            . '                 },'
            . '                 {'
            . '                     "type": "TEXT",'
            . '                     "text": "'.$hora.'"'
            . '                 },'
            . '                 {'
            . '                     "type": "TEXT",'
            . '                     "text": "'.$ubicacion.'"'
            . '                 }'
            . '             ]'
            . '         }'
            . '     ]'
            . '} '
            . '}';
    
    //DECLARAMOS LAS CABECERAS
    $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
    //INICIAMOS EL CURL
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
    $response = json_decode(curl_exec($curl), true);
    //IMPRIMIMOS LA RESPUESTA 
    //print_r($response);
    //OBTENEMOS EL CODIGO DE LA RESPUESTA
    $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    //CERRAMOS EL CURL
    curl_close($curl);
}

function generarQR($invitadoQR){
    $dir = './temp/';
    if (!file_exists($dir))
        mkdir($dir);
    $filename = $invitadoQR.'.png';
    $tamaño = 10; //Tamaño de Pixel
    $level = 'H'; //Precisión 
    $frameSize = 3; //Tamaño en blanco
    $contenido = $invitadoQR; //Texto
    $rutaArchivo = $dir.$filename;
    QRcode::png($contenido, $rutaArchivo, $level, $tamaño, $frameSize);
    return $rutaArchivo;
}

if(isset($_POST['agregarInvitado'])){           
    $idInvitado = uniqid();
    $nombreInvitado = trim($_POST['nombreInvitado']);
    $telefonoInvitado = trim($_POST['telefonoInvitado']);
    $idEvento = $_SESSION['idEvento'];
    $qr = generarQR($nombreInvitado.$telefonoInvitado);
    
    if(!empty($nombreInvitado) && !empty($telefonoInvitado)){
        $data = file_get_contents($qr,$use_include_path=true);
        $qr = $data;

        $sql = $cnnPDO->prepare("INSERT INTO invitados (idInvitado, nombreInvitado, telefonoInvitado, idEvento, qr) VALUES (:idInvitado, :nombreInvitado, :telefonoInvitado, :idEvento, :qr)");
        $sql->bindParam(':idInvitado',$idInvitado);
        $sql->bindParam(':nombreInvitado',$nombreInvitado);
        $sql->bindParam(':telefonoInvitado',$telefonoInvitado);
        $sql->bindParam(':idEvento',$idEvento);
        $sql->bindParam(':qr',$qr, PDO::PARAM_LOB);
        $sql->execute();
        
        unset($sql);
        unset($cnnPDO);
        borrar_directorio('./temp');
        header('Location:invitados.php');
    }

}

if(isset($_POST['eliminar'])){
    $idInvitado = $_POST['idInvitado'];
    $sql = $cnnPDO->prepare("DELETE FROM invitados WHERE idInvitado = '$idInvitado'");
    $sql->execute();
    unset($sql);
    unset($cnnPDO);
    header('Location:invitados.php');
}

if(isset($_POST['editar'])){
    $idInvitado = $_POST['idInvitado'];
    $sql = $cnnPDO->prepare("SELECT * FROM invitados WHERE idInvitado = '$idInvitado'");
    $sql->execute();
    $campo = $sql->fetch(PDO::FETCH_ASSOC);
    $_SESSION['idInvitado'] = $campo['idInvitado'];
    $_SESSION['nombreInvitado'] = $campo['nombreInvitado'];
    $_SESSION['telefonoInvitado'] = $campo['telefonoInvitado'];
    header('Location:editar_invitado.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Styles/invitados.css">
    <title>Inivitados</title>
</head>
<body>
<nav class='nav-bar'>
        <a href="./bienvenido.php">
            <div class='logo'> 
                <img src="./assets/icons8-meeting.svg" alt="logo"class='logo'>
                <p>Party Owner</p>
            </div>
        </a>
        <div class="contenedor-name">
            <a href="./perfil.php">
                <p>
                Hola <?php echo $nombre;  ?>
            </p>
            <?php echo '<img class="foto-perfil" src="data:foto/png;base64,' . base64_encode($foto) . '"/>' ?>
            </a>
            <a href="./ver_eventos.php">
                <button class='btn1'>Regresar</button>
            </a>
            <form action="" method="post">
                <input class="btn2" type="submit" name="logout" value="Cerrar sesion">
            </form>
        </div>  
</nav>
<div class="container">    
    <div class="card-agg-invitado">
        <h1> <?php echo $_SESSION['nombreEvento']; ?> </h1>
        <h2>Fecha del evento: <?php echo $_SESSION['fechaEvento']; ?></h2>
        <h2>Hora del evento: <?php echo $_SESSION['hora_evento']; ?></h2>
        <h2>Ubicacion del evento: <?php echo $_SESSION['ubicacionEvento']; ?></h2>
        <form class='form-invitado' action="" enctype='multipart/form-data' method="post">
            <label for="invitado">Nombre Invitado</label>
            <input required class="input-agg" id="invitado" type="text" name="nombreInvitado" placeholder="Nombre Invitado" id="invitado">
            <label for="tel-invitado">telefono Invitado</label>
            <input required class="input-agg" type="text" name="telefonoInvitado" id="tel-invitado" placeholder="Telefono invitado">
            <input class="btn-editar" name='agregarInvitado' action="agregarInvitado" type="submit" value="Agregar lista inviatdos">  
        </form>
    </div>
    <div class="container-table">
        <h2>Lista de invitados</h2>
        <table>
            <tr>
            <!--    <th>Id</th> -->
                <th>Nombre</th>
                <th>Telefono</th>
                <th>QR</th>
                <th>Acciones</th>
            </tr>
            <?php
                $idEvento = $_SESSION['idEvento'];
                $sql = $cnnPDO->prepare("SELECT * FROM invitados WHERE idEvento = '$idEvento'");
                $sql->execute();
                while($campo = $sql->fetch(PDO::FETCH_ASSOC)){
                    echo '<tr>';
                    $campo['idInvitado'];
                    echo '<td>' . $campo['nombreInvitado'] . '</td>';
                    echo '<td>' . $campo['telefonoInvitado'] . '</td>';
                    echo '<td>' .
                        '<img src="data:image/png;base64,' . base64_encode($campo['qr']) . '" width="150px" height="150px"/>'
                        . '</td>';
                    echo '<form method="post">'
                    . '<input type="hidden" name="telefonoInvitado" value="'.$campo['telefonoInvitado'].'">'
                    .'<input type="hidden" name="idInvitado" value="'.$campo['idInvitado'].'">'
                    .'<input type="hidden" name="nombreInvitado" value="'.$campo['nombreInvitado'].'">'
                    . '<input type="hidden" name="idEvento" value="'.$campo['idEvento'].'">'
                    . '<td class="column-btn">'
                    . '<input class="btn-mensaje" type="submit" value="Enviar WhatsApp" name="whats">'
                    . '<input class="btn-editar" type="submit" value="Editar Invitado" name="editar">'
                    . '<input class="btn-eliminar" type="submit" value="Eliminar Invitado" name="eliminar">' 
                    .'</td>'
                    .'</form>';

                    echo '</tr>';
                }
            ?>
        </table>
        
</div>
</body>
</html>