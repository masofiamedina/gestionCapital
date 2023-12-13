<?php include("template/cabecera.php");

?>

<?php
  include ("administrador/config/db.php");

  $txtDNI=(isset($_POST['txtDNI']))?$_POST['txtDNI']:"";

  $sentenciaSQL= $conexion->prepare("SELECT persona.apellido,
                                            persona.nombre,
                                            persona.dniPersona,
                                            puesto.descPuesto
                                          FROM persona
                                            INNER JOIN puesto_personas
                                          ON persona.dniPersona = puesto_personas.dni_Persona
                                            INNER JOIN puesto
                                          ON puesto_personas.cod_Puesto = puesto.codPuesto");

  $sentenciaSQL->execute();
  $listaPersonas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>
<br>

<div class="container">
                <div class="row justify-content-md-center">
                <h2>Empleados</h2>
                </div>
            </div>

            <div class="container">
                <div class="row justify-content-md-center">
                <div class="col col-lg-2">
                <a href="reporte-empleados.php"><button type="button" class="btn btn-warning">Imprimir Reporte</button></a>
                </div>
                
                </div>
            </div>


<br>
<div class="container">
  <div class="row">
    <div class="col-12">
    <div class="table-responsive">
          <table class="table" id="tabla_id">
            <thead>
              <tr>
                <th scope="col">Apellido</th>
                <th scope="col">Nombre</th>
                <th scope="col">DNI</th>
                <th scope="col">Puesto</th>
                <th scope="col">Más información</th>
              </tr>
            </thead>
            <tbody>
             <?php foreach($listaPersonas as $persona ){ ?>
              <tr class='clickable-row'>
                <td><?php echo $persona["apellido"]; ?></td>
                <td><?php echo $persona["nombre"]; ?></td>
                <td><?php echo $persona["dniPersona"]; ?></td>
                <td><?php echo $persona["descPuesto"]; ?></td>

                <td>
                  <form action="/gestionCapital/detalle-empleado.php" method="get" ectype="multipart/formdata">
                  <input type="hidden" name="txtDNI" id="txtDNI" value="<?php echo $persona['dniPersona']; ?>"/>
                  <input type="submit" class="btn btn-success" value="Ver detalle"/></td>
                  </form>
                </td>

              </tr>
              <?php } ?>
              
            </tbody>
          </table>
        </div> 


    </div>
    
  </div>
  <br>

</div>


<?php include("template/pie.php"); ?>