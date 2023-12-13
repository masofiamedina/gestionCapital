<?php

ob_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inversión</title>
    
    <link rel="stylesheet" href="./css/estilo.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <?php

    include ("administrador/config/db.php");

    $sql0= $conexion->prepare("SELECT 	puesto.codPuesto,
                                        puesto.descPuesto,
                                        puesto.costo,
                                        COUNT(puesto.descPuesto) as 'contador'
                                    FROM puesto
                                    JOIN puesto_personas ON puesto.codPuesto = puesto_personas.cod_Puesto
                                    WHERE puesto.unidad = 0
                                    GROUP BY puesto.descPuesto");
    $sql0->execute();
    $lista0=$sql0->fetchAll(PDO::FETCH_ASSOC);
    $cantidad0=(array_sum(array_column($lista0,'contador')));


    $sql00 = $conexion->prepare("SELECT  SUM(puesto.costo) as 'contador'
                                            FROM puesto
                                            JOIN puesto_personas ON puesto.codPuesto = puesto_personas.cod_Puesto
                                            WHERE puesto.unidad = 0");
    $sql00->execute();
    $contador0=$sql00->fetchAll(PDO::FETCH_ASSOC);
    $invertido0=$contador0[0]['contador'];


    
    $sql1= $conexion->prepare("SELECT 	puesto.codPuesto,
                                        puesto.descPuesto,
                                        puesto.costo,
                                        COUNT(puesto.descPuesto) as 'contador'
                                    FROM puesto
                                    JOIN puesto_personas ON puesto.codPuesto = puesto_personas.cod_Puesto
                                    WHERE puesto.unidad = 1
                                    GROUP BY puesto.descPuesto");
    $sql1->execute();
    $lista1=$sql1->fetchAll(PDO::FETCH_ASSOC);
    $cantidad1=(array_sum(array_column($lista1,'contador')));

    $sql01 = $conexion->prepare("SELECT  SUM(puesto.costo) as 'contador'
                                            FROM puesto
                                            JOIN puesto_personas ON puesto.codPuesto = puesto_personas.cod_Puesto
                                            WHERE puesto.unidad = 1");
    $sql01->execute();
    $contador1=$sql01->fetchAll(PDO::FETCH_ASSOC);
    $invertido1=$contador1[0]['contador'];


    $sql2= $conexion->prepare("SELECT 	puesto.codPuesto,
                                        puesto.descPuesto,
                                        puesto.costo,
                                        COUNT(puesto.descPuesto) as 'contador'
                                    FROM puesto
                                    JOIN puesto_personas ON puesto.codPuesto = puesto_personas.cod_Puesto
                                    WHERE puesto.unidad = 2
                                    GROUP BY puesto.descPuesto");
    $sql2->execute();
    $lista2=$sql2->fetchAll(PDO::FETCH_ASSOC);
    $cantidad2=(array_sum(array_column($lista2,'contador')));


    $sql02 = $conexion->prepare("SELECT  SUM(puesto.costo) as 'contador'
                                            FROM puesto
                                            JOIN puesto_personas ON puesto.codPuesto = puesto_personas.cod_Puesto
                                            WHERE puesto.unidad = 2");
    $sql02->execute();
    $contador2=$sql02->fetchAll(PDO::FETCH_ASSOC);
    $invertido2=$contador2[0]['contador'];

    $sql3= $conexion->prepare("SELECT 	puesto.codPuesto,
                                        puesto.descPuesto,
                                        puesto.costo,
                                        COUNT(puesto.descPuesto) as 'contador'
                                    FROM puesto
                                    JOIN puesto_personas ON puesto.codPuesto = puesto_personas.cod_Puesto
                                    WHERE puesto.unidad = 3
                                    GROUP BY puesto.descPuesto");
    $sql3->execute();
    $lista3=$sql3->fetchAll(PDO::FETCH_ASSOC);
    $cantidad3=(array_sum(array_column($lista3,'contador')));

    $sql03 = $conexion->prepare("SELECT  SUM(puesto.costo) as 'contador'
                                            FROM puesto
                                            JOIN puesto_personas ON puesto.codPuesto = puesto_personas.cod_Puesto
                                            WHERE puesto.unidad = 3");
    $sql03->execute();
    $contador3=$sql03->fetchAll(PDO::FETCH_ASSOC);
    $invertido3=$contador3[0]['contador'];

    $sql4= $conexion->prepare("SELECT 	puesto.codPuesto,
                                        puesto.descPuesto,
                                        puesto.costo,
                                        COUNT(puesto.descPuesto) as 'contador'
                                    FROM puesto
                                    JOIN puesto_personas ON puesto.codPuesto = puesto_personas.cod_Puesto
                                    WHERE puesto.unidad = 4
                                    GROUP BY puesto.descPuesto");
    $sql4->execute();
    $lista4=$sql4->fetchAll(PDO::FETCH_ASSOC);
    $cantidad4=(array_sum(array_column($lista4,'contador')));

    $sql04 = $conexion->prepare("SELECT  SUM(puesto.costo) as 'contador'
                                            FROM puesto
                                            JOIN puesto_personas ON puesto.codPuesto = puesto_personas.cod_Puesto
                                            WHERE puesto.unidad = 4");
    $sql04->execute();
    $contador4=$sql04->fetchAll(PDO::FETCH_ASSOC);
    $invertido4=$contador4[0]['contador'];


    $cantidadEmpleados = $cantidad0 + $cantidad1 + $cantidad2 + $cantidad3 + $cantidad4;
    $cantidadInvertido = $invertido0 + $invertido1 + $invertido2 + $invertido3 + $invertido4;

    ?>
    <div class="table-responsive">
    <div style="text-align:center"><h2>Reporte de Inversión</h2></div>
        <h5><?php $time = time(); echo date("d-m-Y (H:i:s)", $time); ?><br>
        Total de empleados a la fecha: <?php echo $cantidadEmpleados; ?> empleados<br>
        Total invertido en el mes de la fecha: $<?php echo $cantidadInvertido; ?> </h5><br>

            <table class="table table-hover">
                <h5>Unidad 0</h5>
                <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Empleados</th>
                    <th scope="col">Sueldo</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($lista0 as $puesto) {  ?>
                <tr>
                    <td><?php echo $puesto['codPuesto']; ?></td>
                    <td><?php echo $puesto['descPuesto']; ?></td>
                    <td><?php echo $puesto['contador']; ?></td>
                    <td><?php echo $puesto['costo']; ?></td>
                    <?php } ?>
                </tr>
                
                <h6>Total personas: <?php echo $cantidad0; ?></br>
                    Total invertido: $<?php echo $invertido0; ?></h6>
                    

                    <br><br>

                    <h5>Unidad 1</h5>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Empleados</th>
                    <th scope="col">Sueldo</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($lista1 as $puesto) {  ?>
                <tr>
                    <td><?php echo $puesto['codPuesto']; ?></td>
                    <td><?php echo $puesto['descPuesto']; ?></td>
                    <td><?php echo $puesto['contador']; ?></td>
                    <td><?php echo $puesto['costo']; ?></td>
                    <?php } ?>
                </tr>
                
                <h6>Total personas: <?php echo $cantidad1; ?></br>
                    Total invertido: $<?php echo $invertido1; ?></h6>
                    

                    <br><br>

                    <h5>Unidad 2</h5>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Empleados</th>
                    <th scope="col">Sueldo</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($lista2 as $puesto) {  ?>
                <tr>
                    <td><?php echo $puesto['codPuesto']; ?></td>
                    <td><?php echo $puesto['descPuesto']; ?></td>
                    <td><?php echo $puesto['contador']; ?></td>
                    <td><?php echo $puesto['costo']; ?></td>
                </tr>
                <?php } ?>
                
                <h6>Total personas: <?php echo $cantidad2; ?></br>
                    Total invertido: $<?php echo $invertido2;?></h6>
                    

                    <br><br>

                    <h5>Unidad 3</h5>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Empleados</th>
                    <th scope="col">Sueldo</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($lista3 as $puesto) {  ?>
                <tr>
                    <td><?php echo $puesto['codPuesto']; ?></td>
                    <td><?php echo $puesto['descPuesto']; ?></td>
                    <td><?php echo $puesto['contador']; ?></td>
                    <td><?php echo $puesto['costo']; ?></td>
                </tr>
                <?php } ?>
                
                <h6>Total personas: <?php echo $cantidad3; ?></br>
                    Total invertido: $<?php echo $invertido3; ?></h6>
                    

                    <br><br>

                    <h5>Unidad 4</h5>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Empleados</th>
                    <th scope="col">Sueldo</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($lista4 as $puesto) {  ?>
                <tr>
                    <td><?php echo $puesto['codPuesto']; ?></td>
                    <td><?php echo $puesto['descPuesto']; ?></td>
                    <td><?php echo $puesto['contador']; ?></td>
                    <td><?php echo $puesto['costo']; ?></td>
                </tr>
                <?php } ?>
                
                <h6>Total personas: <?php echo $cantidad4; ?></br>
                    Total invertido: $<?php echo $invertido4; ?></h6>
                   
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

$dompdf->setPaper('A4','portrait');

$dompdf->render();
$dompdf->stream("Empleados.pdf", array("Attachment" => false));

?>