<?php
session_start();
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

$_SESSION['idEvento'];
$_SESSION['nombreEvento'];

$fechaEvento = DateTime::createFromFormat('Y-m-d', $_SESSION['fechaEvento']);
$fechaEvento = $fechaEvento->format('Y-m-d');
$fechaEventoFinal = rtrim($fechaEvento);
$_SESSION['hora_evento'];
$_SESSION['ubicacionEvento'];

if(isset($_POST['editar'])){
    $idEvento = $_SESSION['idEvento'];
    $nombreEvento = trim($_POST['nombreEvento']);
    $fechaEvento = $_POST['fechaEvento'];
    $hora_evento = $_POST['hora_evento'];
    $ubicacionEvento = trim($_POST['ubicacionEvento']);

    $sql = $cnnPDO->prepare('UPDATE eventos SET nombreEvento = :nombreEvento, fechaEvento = :fechaEvento, hora_evento = :hora_evento, ubicacionEvento = :ubicacionEvento WHERE idEvento = :idEvento');
    $sql->bindParam(':idEvento', $idEvento);
    $sql->bindParam(':nombreEvento', $nombreEvento);
    $sql->bindParam(':fechaEvento', $fechaEvento);
    $sql->bindParam(':hora_evento', $hora_evento);
    $sql->bindParam(':ubicacionEvento', $ubicacionEvento);
    $sql->execute();

    $_SESSION['nombreEvento'] = $nombreEvento;
    $_SESSION['fechaEvento'] = $fechaEvento;
    $_SESSION['hora_evento'] = $hora_evento;
    $_SESSION['ubicacionEvento'] = $ubicacionEvento;
    unset($sql);
    unset($cnnPDO);

    header('Location: ver_eventos.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Styles/editar_evento.css">
    <title>Editar Eventos</title>
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
                <p>Hola <?php echo $nombre; ?></p>
                <?php echo '<img class="foto-perfil" src="data:foto/png;base64,' . base64_encode($foto) . '"/>' ?>
            </a>
            <a href="./ver_eventos.php">
                <button class='btn1'>Regresar</button>
            </a>
            <form action="" method="post">
                <input class="btn2" type="submit" name="logout" value="Cerrar sesión">
            </form>
        </div>  
 </nav>
    <main>
    <h1 style="color: #2b2c34">Detalles del Evento</h1> <br>
        <div class="contenedor-evento">
            <div class="cards">
                <div class="parrafo">
                    <form class="form-editar" method="post">
                    <label for="nombreEvento">Nombre del Evento</label>
                    <input class="label-editar" required type="text" name="nombreEvento" value="<?php echo $_SESSION['nombreEvento']; ?>">
                    <label for="fechaEvento">Fecha</label>
                    <input class="label-editar" required type="date" name="fechaEvento" value="<?php echo $fechaEventoFinal;?>">
                    <label for="hora_evento">Hora</label>
                    <input class="label-editar" required type="time" name="hora_evento" value="<?php echo $_SESSION['hora_evento']; ?>">
                    <label for="ubicacionEvento">Ubicación</label>
                    <input class="label-editar" required type="text" name="ubicacionEvento" value="<?php echo $_SESSION['ubicacionEvento']; ?>">
                </div> 
                    <div class="contenedor-btns">
                        <input class="btn-editar" type="submit" value="Guardar" name="editar">
                    </div>
                </form> 
            </div>
        </div>
    </main>
</body>
</html>
