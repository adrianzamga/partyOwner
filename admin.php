<?php
session_start();
require_once 'conexion.php';
$nombre = $_SESSION['nombre'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];

if(!isset($_SESSION['email'])){
    header('Location:index.php');
    exit();
}
if(isset($_POST['logout'])){
    session_destroy();
    header('Location:index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/icons8-meeting.svg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="icon" href="./assets/icons8-meeting.svg">
    <link rel="stylesheet" href="./styles/admin.css">
    
    <title>Bienvenido</title>
</head>
<body>

<section>
    <nav class="navbar fixed-top " style="background-color: #F3F3F3;">
        <div class="container-fluid">
            <div class="page-header" style="color: #7B7C7C;">
                <h3>Pandora</h3>
            </div>
            <h2>Bienvenido/a <?php echo $nombre; ?></h2>
            <div align="right">
                <a href="index.php?logout=true" class="btn btn-dark btn-rounded"><strong>Cerrar Sesión</strong></a>&nbsp;&nbsp;&nbsp;
            </div>
        </div>
    </nav>
</section>
    <main>
        <div class="contenedor">
            <div class="cards-container">
                <a href="./curso.php">
                    <div class="card">
                        <h3>Crear Curso</h3>
                        
                    </div>
                </a>
                <a href="./verCurso.php">
                    <div class="card">
                        <h3>Ver Cursos</h3>
                    </div>
                </a>
            </div>
        </div>
    </main>
</body>
</html>

