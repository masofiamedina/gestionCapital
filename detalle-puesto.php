<?php

ob_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del puesto</title>
    
    <link rel="stylesheet" href="./css/estilo.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <?php

    include ("administrador/config/db.php");

    $cod = $_GET['txtPuesto'];

    $sql= $conexion->prepare("SELECT 	puesto.codPuesto,
                                        puesto.descPuesto,
                                        puesto.unidad,
                                        puesto.costo,
                                        GROUP_CONCAT(descHabilidad SEPARATOR ', ') as gHabilidades
                                    FROM puesto
                                    JOIN puesto_habilidades ON puesto.codPuesto = puesto_habilidades.cod_Puesto
                                    JOIN habilidades ON puesto_habilidades.cod_Habilidad = habilidades.codHabilidad
                                    WHERE puesto.codPuesto = " . $cod);
    $sql->execute();
    $puestos=$sql->fetchAll(PDO::FETCH_ASSOC);
    $puesto=$puestos[0];

    $sql = $conexion->prepare("SELECT 	persona.nombre,
                                        persona.apellido,
                                        GROUP_CONCAT(descHabilidad SEPARATOR ', ') as gHabilidades
                                    FROM persona
                                    JOIN persona_habilidades ON persona.dniPersona = persona_habilidades.dni_Persona
                                    JOIN habilidades ON persona_habilidades.cod_Habilidad = habilidades.codHabilidad
                                    JOIN puesto_personas ON persona.dniPersona = puesto_personas.dni_Persona
                                    JOIN puesto ON puesto_personas.cod_Puesto = puesto.codPuesto
                                    WHERE puesto.codPuesto = " . $cod);
    $sql->execute();
    $personas=$sql->fetchAll(PDO::FETCH_ASSOC);


    $sql= $conexion->prepare("SELECT cod_Habilidad FROM puesto_habilidades WHERE cod_Puesto = " . $cod);
    $sql->execute();
    $habilidades=$sql->fetchAll(PDO::FETCH_ASSOC);
    

    foreach($habilidades as $habilidad){
        $hab = $habilidad['cod_Habilidad'];
        $condicion .= "persona_habilidades.cod_Habilidad = " . $hab . " OR ";
    }

    $sql= $conexion->prepare("SELECT 	persona.nombre,
                                        persona.apellido,
                                        GROUP_CONCAT(descHabilidad SEPARATOR ', ') as gHabilidades
                                    FROM persona
                                    JOIN persona_habilidades ON persona.dniPersona = persona_habilidades.dni_Persona
                                    JOIN habilidades ON persona_habilidades.cod_Habilidad = habilidades.codHabilidad
                                    WHERE "  . $condicion .  " persona_habilidades.cod_Habilidad = NULL
                                    GROUP BY persona.nombre, persona.apellido");
    $sql->execute();
    $candidatos=$sql->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div class="table-responsive">
    <div style="text-align:center"><h2>Puesto: <?php echo $puesto['descPuesto']; ?></h2></div>
        <br>
    <table class="table table-hover">
                
                <tbody class="lg-12">
                    <tr>
                        <td>Código:</td><td><?php echo $puesto['codPuesto']; ?></td>
                    </tr>
                    <tr>
                        <td>Unidad:</td><td><?php echo $puesto['unidad']; ?></td>
                    </tr>
                    <tr>
                        <td>Costo:</td><td>$<?php echo $puesto['costo']; ?></td>
                    </tr>
                    <tr>
                        <td>Habilidades:</td><td><?php echo $puesto['gHabilidades']; ?></td>
                    </tr>
                </tbody>
                <br>
                <h5>Empleados en el cargo:</h5>
                <thead>
                <tr>
                    <th scope="col">Apellido</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Habilidades</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($personas as $persona) {  ?>
                <tr>
                    <td><?php echo $persona['apellido']; ?></td>
                    <td><?php echo $persona['nombre']; ?></td>
                    <td><?php echo $persona['gHabilidades']; ?></td>
                    <?php } ?>
                </tr>
                </tbody>
                <br>
                <h5>Candidatos:</h5>
                
                <tr>
                    <th scope="col">Apellido</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Habilidades</th>
                </tr>
                
                <tbody>
                <?php foreach($candidatos as $candidato) {  ?>
                <tr>
                    <td><?php echo $candidato['apellido']; ?></td>
                    <td><?php echo $candidato['nombre']; ?></td>
                    <td><?php echo $candidato['gHabilidades']; ?></td>
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