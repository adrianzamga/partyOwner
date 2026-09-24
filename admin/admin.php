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

if(!isset($_SESSION['correoAdmin'])){
    header('Location:../index.php');
}
if(isset($_POST['logout'])){
    session_destroy();
    header('Location:../index.php');
}
if (isset($_POST['desactiva'])) 
{
    if($_POST['correo'] == $_SESSION['correoAdmin']){
        $alerta = "<div class='alerta'>No puedes bloquearte a ti mismo</div>";
    }else{
        $correo =$_POST['correo'];
        $act ='no';
    
        $sql = $cnnPDO->prepare(
                'UPDATE usuarios SET isActive =:act WHERE correo =:correo');
            $sql->bindParam(':act',$act);
            $sql->bindParam(':correo',$correo);
            $sql->execute();
            header('location:admin.php');
            exit();
    }
}
if (isset($_POST['activa'])) 
{
    $correo =$_POST['correo'];
    $act ='si';

    $sql = $cnnPDO->prepare(
            'UPDATE usuarios SET isActive =:act WHERE correo =:correo');
        $sql->bindParam(':act',$act);
        $sql->bindParam(':correo',$correo);
        $sql->execute();
        header('location:admin.php');
        exit();
}
if(isset($_POST['eliminar'])){

    if($_POST['correo'] == $_SESSION['correoAdmin']){
        $alerta = "<div class='alerta'>No puedes eliminarte a ti mismo</div>";
    }else{
    $idUsuario = $_POST['idUsuario'];
    $sql = $cnnPDO->prepare("DELETE FROM usuarios WHERE idUsuario =:idUsuario");
    $sql->bindParam(':idUsuario',$idUsuario);
    $sql->execute();
    header('location:admin.php');
    exit();
}
}
if(isset($_POST['editar'])){
    if($_POST['correo'] == $_SESSION['correoAdmin']){
        $alerta = "<div class='alerta'>No puedes editarte a ti mismo</div>";
    }else{

    $_SESSION['idUsuarioEditar'] = $_POST['idUsuario'];
    $_SESSION['correoEditar'] = $_POST['correo'];
    $_SESSION['nombreEditar'] = $_POST['nombre'];
    $_SESSION['passwordEditar'] = $_POST['password'];
    $_SESSION['telefonoEditar'] = $_POST['telefono'];

    header('location:./editar.php');
    exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/admin.css">
    <title>Vista admin</title>
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
            <form action="admin.php" method="post">
                <input class="btn-cerrar-sesion" type="submit" name="logout" value="Cerrar sesion">
            </form>
        </div>    
</nav>
<!--
<div class="container">
    <div class="contenedor-bloquear">
        <form class="form-correo" method="POST">
        <label class="label-correo" for="correo">Ingresa un correo para bloquear</label>
        <input class="input-correo" type="text" name="correo" placeholder="Ingresa el correo">
        <button type="submit" name="desactiva" class="btn-bloquear">Bloquear</button>
    </form>
    </div>
</div>
-->
  <div class="container-tabla">
  <?php echo isset($alerta) ? $alerta : ''; ?>
    <h1 class="">Usuarios</h1>
    <?php
  $sql = $cnnPDO->prepare("SELECT * FROM usuarios");
  $sql->execute();
  ?>
    <table class='table'>
  <tr>
    <th class="text-white"><b>ID</b></th>
    <th class="text-white"><b>Nombre</b></th>
    <th class="text-white"><b>EMAIL</b></th>
    <th class="text-white"><b>PASSWORD</b></th>
    <th class="text-white"><b>TELEFONO</b></th>
    <th class="text-white"><b>ACTIVO</b></th>
    <th class="text-white"><b>ACCIONES</b></th>
  </tr>
  <?php
  while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td class='text-white'>" . $row['idUsuario'] . "</td>";
    echo "<td class='text-white'>" . $row['nombre'] . "</td>";
    echo "<td class='text-white'>" . $row['correo'] . "</td>";
    echo "<td class='text-white'>" . $row['password'] . "</td>";
    echo "<td class='text-white'>" . $row['telefono'] . "</td>";
    echo "<td class='text-white'>" . $row['isActive'] . "</td>";
    echo "<td>
    <form class='acciones' method='post'>
    <input type='hidden' name='idUsuario' value='" . $row['idUsuario'] . "'>
    <input type='hidden' name='correo' value='" . $row['correo'] . "'>
    <input type='hidden' name='nombre' value='" . $row['nombre'] . "'>
    <input type='hidden' name='password' value='" . $row['password'] . "'>
    <input type='hidden' name='telefono' value='" . $row['telefono'] . "'>
    <input type='hidden' name='isActive' value='" . $row['isActive'] . "'>
    <button class='btn-editar' type='submit' name='editar' value='editar'>Editar</button>
    <button class='btn-desbloquea' type='submit' name='activa' value='activa'>Activa</button>
    <button class='btn-bloquear' type='submit' name='desactiva' value='bloquear'>Bloquear</button>
    <button class='btn-eliminar' type='submit' name='eliminar' value='eliminar'>Eliminar</button>
    </form>
    </td>";
    echo "</tr>";
  }
  ?>
    </table> 
</div>
</body>
</html>