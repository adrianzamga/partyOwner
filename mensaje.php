<?php 

session_start();

$_SESSION['nombre'];
$_SESSION['idEvento'];
$_SESSION['nombreEvento'];
$_SESSION['fechaEvento'];
$_SESSION['hora_evento'];
$_SESSION['ubicacionEvento'];
$_POST['telefonoInvitado'];


if(isset($_POST['whats'])){
        //TOKEN QUE NOS DA FACEBOOK
        $token = '';
        //NUESTRO TELEFONO
        $telefono = '52'.$_POST['telefonoInvitado'];
        //URL A DONDE SE MANDARA EL MENSAJE
        $url = '';
        
        $urlImage = 'https://jaircamacho.000webhostapp.com/icons8-meeting-96.png';
        
        $nombreEveneto = $_SESSION['nombreEvento'];
        $usuario = $_SESSION['nombre'];
        $fecha = $_SESSION['fechaEvento'];
        $hora = $_SESSION['hora_evento'];
        $ubicacion = $_POST['telefonoInvitado'];
        
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
                . '                     "image": { "link": "'.$urlImage.'" }'
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
        print_r($response);
        //OBTENEMOS EL CODIGO DE LA RESPUESTA
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //CERRAMOS EL CURL
        curl_close($curl);
}
?>