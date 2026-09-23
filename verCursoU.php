<?php
session_start();
require_once './conexion.php';

if (isset($_POST['registrar'])) {  
    
    $idCurso = $_POST['idCurso'];
    $idUsuario = $_SESSION['idUsuario']; 
    $email = $_SESSION['email'];

    if (!empty($idCurso) && !empty($idUsuario)) {
        $sql = $cnnPDO->prepare("INSERT INTO cursoins (idCurso, idUsuario, email) VALUES (:idCurso, :idUsuario, :email)");
        
        $sql->bindParam(':idCurso', $idCurso);
        $sql->bindParam(':idUsuario', $idUsuario);
        $sql->bindParam(':email', $email);
       
        if ($sql->execute()) {
            echo "El usuario se ha registrado en el curso exitosamente";
        } else {
            echo "Hubo un error al registrar al usuario en el curso";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/icons8-meeting.svg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="icon" href="./assets/icons8-meeting.svg">
    <link rel="stylesheet" href="./styles/card.css">
    <title>Pandora</title>
</head>
<body>
<section>
		<nav class="navbar fixed-top " style="background-color: #F3F3F3;">
  			<div class="container-fluid">
    			<div class="page-header" style="color: #7B7C7C;">
        			<h3>Pandora</h3>
        		</div>
        		<div align="right">
                    <a href="./vistaUser.php"  class="btn btn-dark btn-rounded"><strong>Regresar</strong></a>&nbsp;&nbsp;&nbsp;
                    <a href="index.php" name="logout" class="btn btn-dark btn-rounded"><strong>Cerrar Sesión</strong></a>&nbsp;&nbsp;&nbsp;
         		</div>
         	</div>
		</nav>
    </section> <br> <br> <br> <br>  
    <div class="contenedor">
            <?php
        require_once 'conexion.php';

        $sql = $cnnPDO->prepare("SELECT * FROM curso");
        $sql->execute();
        $resultados = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultados as $cursoV) 
         {
            echo "<div class='card'>";
            echo "<ul>";
            echo "<h4>Nombre del Curso: " . $cursoV['ncurso'] . "</h4>";
            echo "<p>ID del Curso: " . $cursoV['idCurso'] . "</p>";
            echo "<p>Nombre del Instructor: " . $cursoV['ninstructor'] . "</p>";
            echo "<p>Horas: " . $cursoV['horas'] . "</p>";
            echo "<p>Fecha: " . $cursoV['fecha'] . "</p>";
            echo "<p>Costo: $" . $cursoV['costo'] . "</p>";
            echo "</ul>";
            // Este formulario registra a usuario
            echo "<form action='verCursoU.php' method='post'>";
            echo "<input type='hidden' name='idCurso' value='" . $cursoV['idCurso'] . "'>";
            echo "<button type='submit' class='btn btn-success' name='registrar'>Registrarse</button>";
            echo "</form>";
            echo "</div>";
        }
        ?>
</div>
</body>
</html>