<?php

ob_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Puestos</title>
    
    <link rel="stylesheet" href="./css/estilo.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <?php

    include ("administrador/config/db.php");

    $sentenciaSQL= $conexion->prepare("SELECT 	puesto.codPuesto,
                                                puesto.descPuesto,
                                                puesto.costo,
                                                GROUP_CONCAT(descHabilidad SEPARATOR ', ') as gHabilidades
                                            FROM puesto
                                            JOIN puesto_habilidades ON puesto.codPuesto = puesto_habilidades.cod_Puesto
                                            JOIN habilidades ON puesto_habilidades.cod_Habilidad = habilidades.codHabilidad
                                            GROUP BY puesto.codPuesto, puesto.descPuesto;");
    $sentenciaSQL->execute();
    $listaPuestos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div class="table-responsive">
        <div style="text-align:center"><h2>Reporte de Puestos</h2></div>
        <h5><?php $time = time(); echo date("d-m-Y (H:i:s)", $time); ?></h5>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Habilidades Requeridas</th>
                    <th scope="col">Salario</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($listaPuestos as $puesto ) {  ?>
                <tr>
                  <td><?php echo $puesto['codPuesto']; ?></td>
                  <td><?php echo $puesto['descPuesto']; ?></td>
                  <td><?php echo $puesto['gHabilidades']; ?></td>
                  <td><?php echo $puesto['costo']; ?></td>
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
$dompdf->stream("Empleados.pdf", array("Attachment" => false));

?>