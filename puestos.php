<?php include("template/cabecera.php"); ?>

<?php
  include ("administrador/config/db.php");
  $sentenciaSQL= $conexion->prepare("SELECT 	puesto.codPuesto,
                                              puesto.descPuesto,
                                              GROUP_CONCAT(descHabilidad SEPARATOR ', ') as gHabilidades
                                      FROM puesto
                                          JOIN puesto_habilidades ON puesto.codPuesto = puesto_habilidades.cod_Puesto
                                          JOIN habilidades ON puesto_habilidades.cod_Habilidad = habilidades.codHabilidad
                                      GROUP BY puesto.codPuesto, puesto.descPuesto;");
  $sentenciaSQL->execute();
  $listaPuestos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<br>
<div class="container">
                <div class="row justify-content-md-center">
                <h2>Puestos de trabajo</h2>
                </div>
            </div>

            <div class="container">
                <div class="row justify-content-md-center">
                <div class="col col-lg-2">
                <a href="reporte-puestos.php"><button type="button" class="btn btn-warning">Imprimir Reporte</button></a>
                </div>
                
                </div>
            </div>

        <br>
        <div class="container">
  <div class="row">
    <div class="col-12">
    <div class="table-responsive">
          <table class="table table-hover" id="tabla_id">
            <thead>
              <tr>
                <th scope="col">Código</th>
                <th scope="col">Nombre</th>
                <th scope="col">Habilidades</th>
                <th scope="col">Más información</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($listaPuestos as $puesto ) {  ?>
                <tr>
                  <td><?php echo $puesto['codPuesto']; ?></td>
                  <td><?php echo $puesto['descPuesto']; ?></td>
                  <td><?php echo $puesto['gHabilidades']; ?></td>
                  <td>
                    <form action="/gestionCapital/detalle-puesto.php" method="get" ectype="multipart/formdata">
                    <input type="hidden" name="txtPuesto" id="txtPuesto" value="<?php echo $puesto['codPuesto']; ?>"/>
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

  
</div>




<?php include("template/pie.php"); ?>