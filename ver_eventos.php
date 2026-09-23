<?php 
session_start();
ob_start();
require_once("conexion.php");
if(!isset($_SESSION['correo'])){
    header('Location:index.php');
}
if(isset($_POST['logout'])){
    session_destroy();
    header('Location:index.php');
}
$idUsuario = $_SESSION['idUsuario'];
$nombre = $_SESSION['nombre'];
$correo = $_SESSION['correo'];
$telefono = $_SESSION['telefono'];
$fechaNacimiento = $_SESSION['fechaNacimiento'];
$foto = $_SESSION['foto'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Styles/ver_eventos.css">
    <title>Mis eventos</title>
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
                <span styles"color: black;">Hola</span> <?php echo $nombre;  ?>
            </p>
            <?php echo '<img class="foto-perfil" src="data:foto/png;base64,' . base64_encode($foto) . '"/>' ?>
            </a>
            <a href="./bienvenido.php">
                <button class='btn1'>Regresar</button>
            </a>
            <form action="" method="post">
                <input class="btn2" type="submit" name="logout" value="Cerrar sesión">
            </form>
        </div>  
</nav>
<main>
<h1>Mis eventos</h1>
    <div class="contenedor-eventos">
        <?php
        $slq = $cnnPDO->prepare("SELECT * FROM eventos WHERE idUsuario = '$idUsuario'");
        $slq->execute(); 
        ?>
        <?php 
        while ($campo = $slq->fetch(PDO::FETCH_ASSOC)) {
            $idEvento = $campo['idEvento'];
            $nombreEvento = $campo['nombreEvento'];
            $fechaEvento = $campo['fechaEvento'];
            $hora_evento = $campo['hora_evento'];
            $ubicacionEvento = $campo['ubicacionEvento'];
            echo '<div class="cards">';
            echo '<form method="post">';
            echo '<h2>' . $campo['nombreEvento'] . '</h2>';
            $campo['idEvento'];
            echo '<p>' . $campo['fechaEvento'] . '</p>';
            echo '<p>' . $campo['hora_evento'] . '</p>';
            echo '<p>' . $campo['ubicacionEvento'] . '</p>
            <div class="contenedor-btns">
                    <input type="hidden" value="' . $idEvento . '" name="idEvento">
                    <input type="hidden" value="' . $nombreEvento . '" name="nombreEvento">
                    <input type="hidden" value="' . $fechaEvento . '" name="fechaEvento">
                    <input type="hidden" value="' . $hora_evento . '" name="hora_evento">
                    <input type="hidden" value="' . $ubicacionEvento . '" name="ubicacionEvento">
                    <input class="btn-invitado" type="submit" value="Ver Invitados" name="verInvitados">
                    <input class="btn-editar" type="submit" value="Editar Evento" name="editar">
                    <input class="btn-eliminar" type="submit" value="Eliminar Evento" name="eliminar">
                    </div>
                    </form>';
            echo '</div>';
        }
        if(isset($_POST['eliminar'])){
            $idEvento = $_POST['idEvento'];
            $sql = $cnnPDO->prepare("DELETE FROM eventos WHERE idEvento = '$idEvento'");
            $sql->execute();
            echo "<script>location.href = './ver_eventos.php';</script>";
                
        }
        if(isset($_POST['verInvitados'])){
            $idEvento = $_POST['idEvento'];
            $nombreEvento = $_POST['nombreEvento'];
            $fechaEvento = $_POST['fechaEvento'];
            $hora_evento = $_POST['hora_evento'];
            $ubicacionEvento = $_POST['ubicacionEvento'];
            $_SESSION['idEvento'] = $idEvento;
            $_SESSION['nombreEvento'] = $nombreEvento;
            $_SESSION['fechaEvento'] = $fechaEvento;
            $_SESSION['hora_evento'] = $hora_evento;
            $_SESSION['ubicacionEvento'] = $ubicacionEvento;
            echo "<script>location.href = './invitados.php';</script>";
        }
        if(isset($_POST['editar'])){
            $idEvento = $_POST['idEvento'];
            $_SESSION['idEvento'] = $idEvento;
            $_SESSION['nombreEvento'] = $_POST['nombreEvento'];
            $_SESSION['fechaEvento'] = $_POST['fechaEvento'];
            $_SESSION['hora_evento'] = $_POST['hora_evento'];
            $_SESSION['ubicacionEvento'] = $_POST['ubicacionEvento'];
            echo "<script>location.href = './editar_evento.php';</script>";
        }
        ob_end_flush();
        ?>
    </div>
</main>
</body>
</html>