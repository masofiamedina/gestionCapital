<?php
session_start();

if($_POST){

  if(($_POST['usuario']=="admin")&&($_POST['contrasena']=="sistema")){
    
    $_SESSION['usuario']="ok";
    $_SESSION['nombreUsuario']="admin";
    header('Location:inicio.php');
  } else{

    $mensaje="Error: El usuario y contraseña son incorrectos.";
  }
}

?>

<!DOCTYPE html>
<html><head>
  <link rel="stylesheet" href="/gestionCapital/css/estilo.css">
  <link rel="stylesheet" href="/gestionCapital/css/bootstrap.min.css"/>
 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://kit.fontawesome.com/165e20792f.js" crossorigin="anonymous"></script>

  <title>Ingresar al sistema</title>
  <link rel="icon" type="image/x-icon" href="iconlogo.png">
</head>

<body>
    <div class="container">
        <!-- code here -->
        <div class="card"  style="border-radius: 10px;">
            <br>
            <h2>
              Iniciar sesión
            </h2>
            <br>

            <?php if(isset($mensaje)) {?>
            <div class="alert alert-danger" role="alert">
              <?php echo $mensaje; ?>
            </div>
              <?php }?>
            <form method="POST">
                <div class = "form-group">
                <label for="exampleInputEmail1">Usuario</label>
                <input type="text" class="form-control" name="usuario" placeholder="Ingresar usuario">
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Contraseña</label>
                <input type="password" class="form-control" name="contrasena" placeholder="Ingresar contraseña">
                </div><br>
                <button type="submit" class="btn btn-success" style="width: 100%;font-size: 1.25rem;padding: 0.5em;">Ingresar como administrador</button>
                <br><br>
                <a href="../" class="btn btn-secondary" style="width: 100%;font-size: 1.25rem;padding: 0.5em;" role="button">Regresar al sistema</a>
            </form>
        </div>
    </div>

</body></html>