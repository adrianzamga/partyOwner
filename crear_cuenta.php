<?php
require_once 'conexion.php';

ob_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


if(isset($_POST['crear_cuenta'])){
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);
    $telefono = trim($_POST['telefono']);
    $fechaNacimiento = $_POST['fecha_nacimiento'];
    $size = getimagesize($_FILES["foto"]["tmp_name"]);
    $isActive = 'si';

    $query = "SELECT * FROM usuarios WHERE correo = :correo";
    $sql = $cnnPDO->prepare($query);
    $sql->bindParam(':correo',$correo);
    $sql->execute();

    if($sql->fetch()){
        $alerta = "<div class='alert alert-danger' role='alert'>
            <b>El correo ya está registrado</b>
        </div>";
    }else{
        if(!empty($nombre) && !empty($correo) && !empty($telefono) && !empty($fechaNacimiento) && !empty($password) && $_POST['password'] == $_POST['password2'] && $size != false){

            $cargarImagen = $_FILES['foto']['tmp_name'];
            $foto = fopen($cargarImagen,'rb');
            
            $idUsuario = uniqid();
    
    
            $sql=$cnnPDO->prepare("INSERT INTO usuarios
                (idUsuario, nombre, correo,password, telefono, fechaNacimiento,  foto, isActive) VALUES (:idUsuario, :nombre, :correo,:password, :telefono, :fechaNacimiento,  :foto, :isActive)");
    
            //Asignar el contenido de las variables a los parametros
            $sql->bindParam(':idUsuario',$idUsuario);
            $sql->bindParam(':nombre',$nombre);
            $sql->bindParam(':correo',$correo);
            $sql->bindParam(':password',$password);
            $sql->bindParam(':telefono',$telefono);
            $sql->bindParam(':fechaNacimiento',$fechaNacimiento);
            $sql->bindParam(':isActive',$isActive);
            
            $sql->bindParam(':foto',$foto, PDO::PARAM_LOB);
    
            //Ejecutar la variable $sql
            $sql->execute();
            $mail = new PHPMailer(true); 
            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'partyowner18@gmail.com'; //  tu correo donde se mandará
                $mail->Password = 'ttxy nwhx onii vfla'; //  tu contraseña de aplicaciones
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
    
                $imagen_url0 = "https://jaircamacho.000webhostapp.com/icons8-meeting-96.png";
    
                $mail->setFrom('partyowner18@gmail.com', 'Party Owner'); 
                $mail->addAddress($correo);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = '¡Gracias por ser parte de nosotros!';
                $mail->Body =  '
                <div style="background-color: #fff;">
                <div style="background-color: #fff; padding: 10px; text-align: center;">
                    <img src="' . $imagen_url0 . '" alt="" style="display:block; margin:0 auto; width: 100px;">
                    <h1 style="font-size: 24px; color: #black;">Gracias por registrarte en Party Owner. Verificamos que este es tu correo: ' . $correo . '</h1>
                    <div class="text-center">
                    </div>
                </div>
            </div>';
               
                $mail->send();
                unset($sql);
                unset($cnnPDO);
                header('Location: ./iniciar_sesion.php'); 
            } catch (Exception $e) {
                $notificacion = "<div class='alert alert-danger' role='alert'>
                    <b>El registro no pudo ser realizado<br> Revisa tu conexión y vuelve a intentarlo</b>
                </div>";
            }
        }else{
            header('Location: ./crear_cuenta.php');
        }
    }

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/icons8-meeting.svg">
    <link rel="stylesheet" href="./Styles/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="icon" href="./assets/icons8-meeting.svg">
    <title>Crear Cuenta</title>
    <link rel="stylesheet" href="./Styles/formulario2.css">
</head>
<body style="background-image: url(./Images/copas.jpeg);">
    <nav class='nav-bar'>
        <a href="./index.php">
            <div class='logo'> 
                <img src="./assets/icons8-meeting.svg" alt="logo"class='logo'>
                <p>Party Owner</p>
            </div>
        </a>
    </nav>
    <section class="form-main">
        <div class='form-content'>
            <div class="box">
                <form method='post' enctype='multipart/form-data'>
                    <h3>Crear Cuenta</h3>
                    <div class="foto-div">
                        <input required class='foto_circular' type="file" name="foto" id="foto"
                         accept='image/jpg'>
                    </div>

                    <div>
                        <input required class="input-control" type="text" name="nombre" placeholder="Nombre Completo" id="nombre" required>
                    </div>

                    <div>
                        <input required class="input-control" type="email" name="correo" placeholder="Correo" id="correo" required>
                    </div>

                    <div>
                        <input required class="input-control" type="text" name="telefono" placeholder="Telefono" id="telefono" required>
                    </div>

                    <div>
                        <input required class="input-control"type="date" name='fecha_nacimiento' id="fecha_nacimiento">
                    </div>

                    <div>
                        <input required class="input-control"type="password" name="password" placeholder="Contraseña" id="password"required>
                    </div>

                    <div>
                        <input required class="input-control"type="password" name="password2" placeholder="Confirmar contraseña" id="password2" required>
                    </div> <br>
                        <button type="submit" name="crear_cuenta" class="btn">Crear Cuenta</button>
                        <?php echo isset($alerta) ? $alerta : '' ?>
                    </form>
            </div>
            <div>
                <p style="color: wheat;">¿Ya tienes una cuenta? <a href="./iniciar_sesion.php">Inicia sesión</a></p>
            </div>
        </div>
    </section>
</body>
</html>
