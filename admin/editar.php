<?php 
session_start();

require_once '../conexion.php';

$idUsuarioAdmin = $_SESSION['idUsuarioAdmin'];
$nombreAdmin = $_SESSION['nombreAdmin'];
$correoAdmin = $_SESSION['correoAdmin'];
$telefonoAdmin = $_SESSION['telefonoAdmin'];
$fechaNacimientoAdmin = $_SESSION['fechaNacimientoAdmin'];
$fotoAdmin = $_SESSION['fotoAdmin'];
$isActiveAdmin = $_SESSION['isActiveAdmin'];

$idEditar = $_SESSION['idUsuarioEditar'];
$nombreEditar = $_SESSION['nombreEditar'];
$correoEditar = $_SESSION['correoEditar'];
$telefonoEditar = $_SESSION['telefonoEditar'];

if(!isset($_SESSION['correoAdmin'])){
    header('Location:../index.php');
}
if(isset($_POST['logout'])){
    session_destroy();
    header('Location:../index.php');
}

if(isset($_POST['editar'])){
    $idUsuario = $_SESSION['idUsuarioEditar'];
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);

    if(!empty($nombre) && !empty($correo) && !empty($telefono)){
    $sql = $cnnPDO->prepare("UPDATE usuarios SET nombre =:nombre, correo =:correo, telefono =:telefono WHERE idUsuario =:idUsuario");
    $sql->bindParam(':nombre',$nombre);
    $sql->bindParam(':correo',$correo);
    $sql->bindParam(':telefono',$telefono);
    $sql->bindParam(':idUsuario',$idEditar);
    $sql->execute();
    unset($sql);
    unset($cnnPDO); 
    header('location:./admin.php');
    exit();
    }else{
        header('location:./editar.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/editarUsuario.css">
    <title>Editar Usuario</title>
</head>
<body>
<nav class='nav-bar'>
        <a href="./admin.php">
            <div class='logo'> 
                <img src="../assets/icons8-meeting.svg" alt="logo"class='logo'>
                <p>Party Owner</p>
            </div>
        </a>
        <div class="contenedor-name">
            <a href="./admin.php">
                <p>
                Hola <?php echo $nombreAdmin;  ?>
            </p>
            </a>
            <a href="./admin.php">
                <button class='btn1'>Regresar</button>
            </a>
            <form action="admin.php" method="post">
                <input class="btn2" type="submit" name="logout" value="Cerrar sesion">
            </form>
        </div>  
</nav>
<main>
            <div class="contenedor">
                <div class="card">
                <h2>Edita Usuario</h2>
                    <form class="form-editar" method="post">
                        <label for="">Nombre</label>
                        <input type="text" name="nombre" value="<?php echo $nombreEditar; ?>">
                        <label for="">Correo</label>
                        <input type="text" name="correo" value="<?php echo $correoEditar; ?>">
                        <label for="">Telefono</label>
                        <input type="text" name="telefono" value="<?php echo $telefonoEditar; ?>">
                        <button type="submit" name="editar" class="btn-editar">Editar</button>
                    </form>
                </div>
            </div>
        </main>
</body>
</html>