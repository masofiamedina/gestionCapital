<?php

ob_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del empleado</title>
    
    <link rel="stylesheet" href="./css/estilo.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <?php

    include ("administrador/config/db.php");

    $dni = $_GET['txtDNI'];

    $sql= $conexion->prepare("SELECT 	persona.nombre,
                                        persona.apellido,
                                        persona.dniPersona,
                                        puesto.descPuesto,
                                        puesto.costo,
                                        GROUP_CONCAT(descHabilidad SEPARATOR ', ') as gHabilidades
                                    FROM persona
                                    JOIN puesto_personas ON persona.dniPersona = puesto_personas.dni_Persona
                                    JOIN puesto ON puesto_personas.cod_Puesto = puesto.codPuesto
                                    JOIN persona_habilidades ON persona.dniPersona = persona_habilidades.dni_Persona
                                    JOIN habilidades ON persona_habilidades.cod_Habilidad = habilidades.codHabilidad
                                    WHERE persona.dniPersona = " . $dni );
    $sql->execute();
    $empleados=$sql->fetchAll(PDO::FETCH_ASSOC);
    $empleado=$empleados[0];

    $sql= $conexion->prepare("SELECT cod_Habilidad FROM persona_habilidades WHERE dni_Persona = " . $dni);
    $sql->execute();
    $habilidades=$sql->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($habilidades as $habilidad){
        $hab = $habilidad['cod_Habilidad'];
        $condicion .= "puesto_habilidades.cod_Habilidad = " . $hab . " OR ";
    }

    $sql= $conexion->prepare("SELECT 	puesto.codPuesto,
                                        puesto.descPuesto,
                                        GROUP_CONCAT(descHabilidad SEPARATOR ', ') as gHabilidades
                                    FROM puesto
                                    JOIN puesto_habilidades ON puesto.codPuesto = puesto_habilidades.cod_Puesto
                                    JOIN habilidades ON puesto_habilidades.cod_Habilidad = habilidades.codHabilidad
                                    WHERE " . $condicion . " puesto_habilidades.cod_Habilidad = NULL
                                    GROUP BY puesto.codPuesto, puesto.descPuesto;");
    $sql->execute();
    $posiblesCargos=$sql->fetchAll(PDO::FETCH_ASSOC);
    ?>



    <div class="table-responsive">
    <div style="text-align:center"><h2><?php echo $empleado['apellido']; ?>, <?php echo $empleado["nombre"]; ?></h2></div>
            <br>
    <table class="table table-hover">
                    <tbody class="lg-12">
                        <tr>
                            <td>DNI:</td><td><?php echo $empleado["dniPersona"]; ?></td>
                        </tr>
                        <tr>
                            <td>Puesto:</td><td><?php echo $empleado["descPuesto"]; ?></td>
                        </tr>
                        <tr>
                            <td>Sueldo:</td><td>$<?php echo $empleado["costo"]; ?></td>
                        </tr>
                        <tr>
                            <td>Habilidades:</td><td><?php echo $empleado["gHabilidades"]; ?></td>
                        </tr>
                    </tbody>
                    <br>
           
                <h5>Posibles cargos:</h5>
                <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Habilidades</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($posiblesCargos as $cargo) {  ?>
                <tr>
                    <td><?php echo $cargo['codPuesto']; ?></td>
                    <td><?php echo $cargo['descPuesto']; ?></td>
                    <td><?php echo $cargo['gHabilidades']; ?></td>
                    <?php } ?>
                </tr>
                   
                </tbody>
            </table>
            <h5><?php $time = time(); echo date("d-m-Y (H:i:s)", $time); ?></h5>
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

$dompdf->setPaper('A4','portrait');

$dompdf->render();
$dompdf->stream("Empleados.pdf", array("Attachment" => false));

?>