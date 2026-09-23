<?php
session_start();
require_once 'conexion.php';
$nombre = $_SESSION['nombre'];
$correo = $_SESSION['correo'];
$telefono = $_SESSION['telefono'];
$fechaNacimiento = $_SESSION['fechaNacimiento'];
$foto = $_SESSION['foto'];

if(!isset($_SESSION['correo'])){
    header('Location:index.php');
}
if(isset($_POST['logout'])){
    session_destroy();
    header('Location:index.php');
}
if($_SESSION['isActive'] == 'no'){
    session_destroy();
    header('Location:iniciar_sesion.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/icons8-meeting.svg">
    <link rel="stylesheet" href="./Styles/bienvenido.css">
    
    <title>Inicio</title>
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
            <?php echo '<img class="foto-perfil" src="data:foto/png;base64,' . base64_encode($foto) . '"/>'?>
            </a>
            <form action="bienvenido.php" method="post">
                <input class="btn-cerrar-sesion" type="submit" name="logout" value="Cerrar sesión">
            </form>
        </div>     
</nav>
    <main>
        <div class="contenedor">
            <div class="cards-container">
                <a href="./crear_eventos.php">
                    <div class="card">
                        <h3>Crear nuevo evento</h3>
                        <img src="./assets/icons8-create.svg" alt="Nuevo Evento">
                    </div>
                </a>
                <a href="./ver_eventos.php">
                    <div class="card">
                        <h3>Ver mis eventos</h3>
                        <img src="./assets/icons8-list.svg" alt="Ver Eventos">
                    </div>
                </a>
            </div>
        </div>
    </main>
</body>
</html>