<?php

ob_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de empleados</title>
    
    <link rel="stylesheet" href="./css/estilo.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>


    <?php

    include ("administrador/config/db.php");

    $sentenciaSQL= $conexion->prepare("SELECT   persona.apellido,
                                                persona.nombre,
                                                persona.dniPersona,
                                                puesto.descPuesto,
                                                puesto.costo
                                            FROM persona
                                                INNER JOIN puesto_personas
                                            ON persona.dniPersona = puesto_personas.dni_Persona
                                                INNER JOIN puesto
                                            ON puesto_personas.cod_Puesto = puesto.codPuesto
                                            ORDER BY persona.apellido");
    $sentenciaSQL->execute();
    $listaPersonas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    $cantidadEmpleados=count($listaPersonas);
    

    ?>
    <div class="table-responsive">
        <div style="text-align:center"><h2>Reporte de Empleados</h2></div>

        <h5><?php $time = time(); echo date("d-m-Y (H:i:s)", $time); ?><br>
            Total de empleados a la fecha: <?php echo $cantidadEmpleados; ?></h5>
        
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Apellido</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">DNI</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Sueldo</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($listaPersonas as $persona ) {  ?>
                <tr class='clickable-row' data-href="empleado-detalle.html">
                    <td><?php echo $persona['apellido']; ?></td>
                    <td><?php echo $persona['nombre']; ?></td>
                    <td><?php echo $persona['dniPersona']; ?></td>
                    <td><?php echo $persona['descPuesto']; ?></td>
                    <td><?php echo $persona['costo']; ?></td>
                    
                </tr>
                <?php } ?>
                
                </tbody>
            </table>

            
    </div> 

</body>

</html>

<?php
$html=ob_get_clean();
//echo $html;

require_once 'administrador/libreria/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('A4','landscape');

$dompdf->render();
$dompdf->stream("Reporte Empleados.pdf", array("Attachment" => false));

?>