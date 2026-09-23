<?php
session_start();
require_once 'conexion.php';

if(!isset($_SESSION['correo'])){
    header("Location: index.php");
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

if(isset($_POST['editarFoto'])){
    $inputFoto = '<input class="btn-foto" type="file" name="foto" accept="image/jpg">';
    $inputGuardarFoto = '<input class="btn1" type="submit" name="guardarFoto" value="Guardar">';
}

if(isset($_POST['guardarFoto'])){
    if(!empty($_FILES['foto']['tmp_name'])){
    $idUsuario = $_SESSION['idUsuario'];
    $size = getimagesize($_FILES["foto"]["tmp_name"]);

    if($size !== false)
    {
        $cargarImagen = $_FILES['foto']['tmp_name'];
        $foto = fopen($cargarImagen,'rb');
        $sql = $cnnPDO->prepare('UPDATE usuarios SET foto = :foto WHERE idUsuario = :idUsuario');
        $sql->bindParam(':idUsuario', $idUsuario);
        $sql->bindParam(':foto', $foto, PDO::PARAM_LOB);
        $foto = file_get_contents($cargarImagen);
        $_SESSION['foto'] = $foto; 
        $sql->execute();
        unset($sql);
        unset($cnnPDO);        

        header('Location: perfil.php');
    }else{
        echo "<script>alert('No se pudo actualizar')</script>";
    
    }
    }
}
if(isset($_POST['editarInfo'])){
    $inputNombre = '<input required type="text" name="nombre" value="'.$nombre.'">';
    $inputCorreo = '<input required type="text" name="correo" value="'.$correo.'">';
    $inputTelefono = '<input required type="text" name="telefono" value="'.$telefono.'">';
    $inputFechaNacimiento = '<input required type="date" name="fechaNacimiento" value="'.$fechaNacimiento.'">';
    $inputGuardar = '<input class="btn1" type="submit" name="guardar" value="Guardar">';
}

if(isset($_POST['guardar'])){

    $query = "SELECT * FROM usuarios WHERE correo = :correo";
    $sql = $cnnPDO->prepare($query);
    $sql->bindParam(':correo',$correo);
    $sql->execute();

    if($sql->fetch()){
        $alerta = "<div class='alert alert-danger' role='alert'>
        <b>El correo ya está registrado</b>
    </div>";
   }else{
    if(!empty($nombre) && !empty($correo) && !empty($telefono) && !empty($fechaNacimiento)){
        $idUsuario = $_SESSION['idUsuario'];
        $nombre = trim($_POST['nombre']);
        $correo = trim($_POST['correo']);
        $telefono = trim($_POST['telefono']);
        $fechaNacimiento = $_POST['fechaNacimiento'];

        $sql = $cnnPDO->prepare('UPDATE usuarios SET nombre = :nombre, correo = :correo, telefono = :telefono, fechaNacimiento = :fechaNacimiento WHERE idUsuario = :idUsuario');
        $sql->bindParam(':idUsuario', $idUsuario);
        $sql->bindParam(':nombre', $nombre);
        $sql->bindParam(':correo', $correo);
        $sql->bindParam(':telefono', $telefono);
        $sql->bindParam(':fechaNacimiento', $fechaNacimiento);
        
        $sql->execute();

        unset($sql);
        unset($cnnPDO);
        $_SESSION['nombre'] = $nombre;
        $_SESSION['correo'] = $correo;
        $_SESSION['telefono'] = $telefono;
        $_SESSION['fechaNacimiento'] = $fechaNacimiento;
        header('Location: perfil.php');
    }else{
        header('Location: perfil.php');
    }
   }

}

if(isset($_POST['eliminar'])){
    $idUsuario = $_SESSION['idUsuario'];
    $sql = $cnnPDO->prepare("DELETE FROM eventos WHERE idUsuario = '$idUsuario'");
    $sql->execute();
    $sql = $cnnPDO->prepare("DELETE FROM usuarios WHERE idUsuario = '$idUsuario'");
    $sql->execute();
    session_destroy();
    header('Location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/icons8-meeting.svg">
    <link rel="stylesheet" href="./Styles/perfil.css">
    <title>Perfil</title>
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
            <a href="./bienvenido.php">
                <button class='btn1'>Regresar</button>
            </a>
            <form action="" method="post">
                <input class="btn2" type="submit" name="logout" value="Cerrar sesion">
            </form>
        </div>  
</nav>
    <main>
        <h1>Perfil</h1>
        <div class="contenedor">
            <form action="" method="post" enctype='multipart/form-data'>
                <div class="contenedor-editable">
                <div class="contenedor-info">
                    <h3><?php echo $nombre; ?></h3>
                    <p>Nombre: <?php echo isset($_POST['editarInfo']) ? $inputNombre : $nombre; ?></p>
                    <p>Correo: <?php echo isset($_POST['editarInfo']) ? $inputCorreo : $correo; ?></p>
                    <p>Telefono: <?php echo isset($_POST['editarInfo'])? $inputTelefono: $telefono; ?></p>
                    <p>Fecha de nacimiento: <?php echo isset($_POST['editarInfo']) ? $inputFechaNacimiento: $fechaNacimiento; ?></p>
                </div>
                <div class="contenedor-perfil">
                    <div class="contenedor-foto">
                    <?php echo '<img class="foto" src="data:foto/png;base64,' . base64_encode($foto) . '"/>'?>
                    </div>
                </div>
                </div>
                <div class="contenedor-btn">
                    <input class="btn1" type="submit" name='editarInfo' value="Editar datos">
                    <input class="btn1" type="submit" name='editarFoto' value="Editar foto">
                    <?php echo isset($_POST['editarFoto']) ? $inputGuardarFoto . $inputFoto :'' ?>
                    <?php echo isset($_POST['editarInfo']) ? $inputGuardar: ''?>
                </div>
            </form>    
        </div>
        <div class="container-eliminar">
            <h2>¿Desea eliminar su Cuenta?</h2>
            <form method="post">
                <input class="btn-eliminar" type="submit" name="eliminar" value="Eliminar cuenta">
            </form>
        </div>
    </main>    
</body>
</html>