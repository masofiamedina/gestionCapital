<?php
session_start();
  if(!isset($_SESSION['usuario'])){
    header("location:../index.php");
  }else{

    if($_SESSION['usuario']=="ok"){
      $nombreUsuario=$_SESSION["nombreUsuario"];
    }
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Administrador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/gestionCapital/css/estilo.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  
    <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
  
   <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
   <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
   <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>
  
  </head>

<body>

<?php $url="http://".$_SERVER['HTTP_HOST']."/gestionCapital" ?>

  <nav class="navbar navbar-expand navbar-dark bg-dark">
      <div class="nav navbar-nav">
          <a class="nav-item nav-link active" href="#">Administrador del sistema <span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/inicio.php">Inicio</a>
          <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/secciones/empleados.php">Empleados</a>
          <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/secciones/cerrar.php">Cerrar sesión</a>
          <a class="nav-item nav-link" href="<?php echo $url;?>">Ver Sistema</a>
      </div>
  </nav>

  <div class="container">
    <br>
    <div class="row">