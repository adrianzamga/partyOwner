<?php 
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

$idInvitado = $_SESSION['idInvitado'];
$nombreInvitado = $_SESSION['nombreInvitado'];
$telefonoInvitado = $_SESSION['telefonoInvitado'];

require_once("conexion.php");
if(!isset($_SESSION['correo'])){
    header('Location:index.php');
}

if(isset($_POST['logout'])){
    session_destroy();
    header('Location:index.php');
}

if(isset($_POST['editarInvitado'])){
    $nombreInvitado = trim($_POST['nombreInvitado']);
    $telefonoInvitado = trim($_POST['telefonoInvitado']);
    $idInvitado = $_SESSION['idInvitado'];
    if(!empty($nombreInvitado) && !empty($telefonoInvitado)){
        $sql = $cnnPDO->prepare('UPDATE invitados SET nombreInvitado = :nombreInvitado, telefonoInvitado = :telefonoInvitado WHERE idInvitado = :idInvitado');
        $sql->bindParam(':idInvitado', $idInvitado);
        $sql->bindParam(':nombreInvitado', $nombreInvitado);
        $sql->bindParam(':telefonoInvitado', $telefonoInvitado);
        $sql->execute();
        unset($sql);
        unset($cnnPDO);
        header('Location:./invitados.php');
    }else{
        header('Location:./invitados.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Styles/editar_invitado.css">
    <title>Editar invitado</title>
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
            <a href="./invitados.php">
                <button class='btn1'>Regresar</button>
            </a>
            <form action="" method="post">
                <input class="btn2" type="submit" name="logout" value="Cerrar sesion">
            </form>
        </div>  
</nav>
<main>
<div class="container">
<form class='form-editar' action="" enctype='multipart/form-data' method="post">
            <label for="invitado">Nombre Invitado</label>
            <input required class="input" id="invitado" type="text" name="nombreInvitado" placeholder="Nombre Invitado" id="invitado" value="<?php echo $nombreInvitado; ?>">
            <label for="tel-invitado">telefono Invitado</label>
            <input required class="input" type="text" name="telefonoInvitado" id="tel-invitado" placeholder="Telefono invitado" value="<?php echo $telefonoInvitado; ?>">
            <input class="btn-editar" name='editarInvitado' action="editarInvitado" type="submit" value="Editar invitado">  
        </form>
</div>
</main>
</body>
</html>