<?php include("template/cabecera.php"); ?>

<?php
  include ("administrador/config/db.php");
  $sentenciaSQL= $conexion->prepare("SELECT   persona.apellido
                                            FROM persona
                                            INNER JOIN puesto_personas
                                            ON persona.dniPersona = puesto_personas.dni_Persona");
  $sentenciaSQL->execute();
  $listaPersona=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
  $cantidadEmpleados=count($listaPersona);

  $sentenciaSQL2= $conexion->prepare("SELECT SUM(puesto.costo) total
                                            FROM persona
                                                INNER JOIN puesto_personas
                                            ON persona.dniPersona = puesto_personas.dni_Persona
                                                INNER JOIN puesto
                                            ON puesto_personas.cod_Puesto = puesto.codPuesto");
  $sentenciaSQL2->execute();
  $inversion=$sentenciaSQL2->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="row">
        <div class="col">
            <div class="card text-center border-success" >
                <div class="card-header" style="font-size:60px;"><?php echo $cantidadEmpleados; ?></div>
                    <div class="card-body">
                        <h5 class="card-title">Empleados en la empresa</h5>
                        <p class="card-text">Pulse para obtener el reporte con detalle de unidades y puestos de trabajo</p>
                        <a href="reporte-empleados.php" class="btn btn-success">Ver reporte</a>
                    </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-center border-info">
                <div class="card-header" style="font-size:50px;">$<?php echo ($inversion[0]['total']);; ?></div>
                    <div class="card-body">
                        <h5 class="card-title">Invertidos en capital humano</h5>
                        <p class="card-text">Pulse para obtener el reporte con detalle de unidades y puestos de trabajo</p>
                        <a href="reporte-inversion.php" class="btn btn-info">Ver reporte</a>
                    </div>
            </div>
        </div>
    </div>

<?php include("template/pie.php"); ?>
