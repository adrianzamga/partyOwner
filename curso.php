<?php
require_once './conexion.php';
# Inicia Código de REGISTRAR
 if (isset($_POST['registrar'])) 
{  
	$ncurso = trim ($_POST['ncurso']);
	$ninstructor = trim ($_POST['ninstructor']);
    $horas = $_POST['horas'];
    $nivel = $_POST['nivel'];
	$fecha = $_POST['fecha'];
    $costo = $_POST['costo'];
	
	if (!empty($ncurso) && !empty($ninstructor) && !empty($nivel))
	{
			$idCurso = uniqid();
		
			$sql=$cnnPDO->prepare("INSERT INTO curso
			(idCurso, ncurso, ninstructor, horas, nivel, fecha, costo) VALUES (:idCurso, :ncurso, :ninstructor, :horas, :nivel, :fecha, :costo)");

			
			$sql->bindParam(':idCurso',$idCurso);
			$sql->bindParam(':ncurso',$ncurso);
			$sql->bindParam(':ninstructor',$ninstructor);
			$sql->bindParam(':horas',$horas);
            $sql->bindParam(':nivel',$nivel);
			$sql->bindParam('fecha', $fecha);
			$sql->bindParam(':costo', $costo);
			$sql->execute();
			unset($sql);
			unset($cnnPDO);	   
	}  
}
# Termina Código de REGISTRAR
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/icons8-meeting.svg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="icon" href="./assets/icons8-meeting.svg">
    <link rel="stylesheet" href="./styles/curso.css">
    <title>Document</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</head>
<body>
    <section>
        <nav class="navbar fixed-top " style="background-color: #F3F3F3;">
            <div class="container-fluid">
                <div class="page-header" style="color: #7B7C7C;">
                    <h3>Pandora</h3>
                </div>
                <div align="right">
                    <a href="admin.php"  class="btn btn-dark btn-rounded"><strong>Regresar</strong></a>&nbsp;&nbsp;&nbsp;
                    <a href="index.php" name="logout" class="btn btn-dark btn-rounded"><strong>Cerrar Sesión</strong></a>&nbsp;&nbsp;&nbsp;
                </div>
            </div>
        </nav>
    </section>
    <div class="contenedor">
        <form id="cursoForm" method="post">
            <div class="contenedor-form">
                <h1>Crear Curso</h1>

                <label for="ncurso">Nombre del Curso</label>
                <input  name="ncurso" id="Nombre del Curso" placeholder="Nombre del Curso">

                <label for="ninstructor">Nombre del Instructor</label>
                <input  name="ninstructor" id="Nombre del Instructor" placeholder="Nombre del Instructor">
                <label for="horas">Horas totales</label>
                <input  name="horas" id="Horas" type="number">
                <label for="hora">Nivel</label>
                <select name="nivel">
                    <option>Básico</option>
                    <option>Intermedio</option>
                    <option>Avanzado</option>
                </select>
                <label for="fecha">Fecha</label>
                <input  name="fecha" type="date" id="Fecha">
                <label>Costo</label>
                <input name="costo" id="Costo" type="number">

                <input type="submit" name="registrar" class="btn-crear" value="Crear Curso">
            </div>
        </form>
    </div>
</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="plugins/toastr.js"></script>

<script>
toastr.options = 
{
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

   $(document).ready(function() {

	$('form').submit(function(event) {
		var sincampos = [];


		$(this).find('input, select').each(function() {
			if ($(this).val() === '') {
				sincampos.push($(this).attr('id'));
			}
		});


		if (sincampos.length > 0) {
			toastr.error('Favor de llenar el campo : ' + sincampos.join(', '));
			event.preventDefault(); 
		}
	});
	});
</script>