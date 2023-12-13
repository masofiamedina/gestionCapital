<?php include("../template/cabecera.php"); ?>
<?php 

$txtDNI=(isset($_POST['txtDNI']))?$_POST['txtDNI']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtApellido=(isset($_POST['txtApellido']))?$_POST['txtApellido']:"";

$puesto=(isset($_POST['puesto']))?$_POST['puesto']:"";
$habilidad=(isset($_POST['habilidad']))?$_POST['habilidad']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/db.php");

switch($accion){

    case "Registrar":
        $sentenciaSQL= $conexion->prepare("INSERT INTO persona (dniPersona, nombre, apellido) VALUES (:dni,:nombre,:apellido);");
        $sentenciaSQL->bindParam(':dni',$txtDNI);
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':apellido',$txtApellido);
        $sentenciaSQL->execute();


        break;

    case "Actualizar":
        $sentenciaSQL= $conexion->prepare("UPDATE persona SET nombre=:nombre, apellido=:apellido WHERE dniPersona=:dni");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':apellido',$txtApellido);
        $sentenciaSQL->bindParam(':dni',$txtDNI);
        $sentenciaSQL->execute();
        break;

    case "Seleccionar":
        $sentenciaSQL= $conexion->prepare("SELECT * FROM persona WHERE dniPersona=:dni");
        $sentenciaSQL->bindParam(':dni',$txtDNI);
        $sentenciaSQL->execute();
        $persona=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        
        $txtNombre=$persona['nombre'];
        $txtApellido=$persona['apellido'];
        break;

    case "Borrar":
        $sentenciaSQL= $conexion->prepare("DELETE FROM persona WHERE dniPersona=:dni");
        $sentenciaSQL->bindParam(':dni',$txtDNI);
        $sentenciaSQL->execute();
        //echo "Presionado botón borrar";
        break;

}

$sentenciaSQL= $conexion->prepare("SELECT   persona.apellido,
                                            persona.nombre,
                                            persona.dniPersona,
                                            puesto.descPuesto,
                                            GROUP_CONCAT(descHabilidad SEPARATOR ', ') as gHabilidades
                                    FROM persona
                                        JOIN puesto_personas ON persona.dniPersona = puesto_personas.dni_Persona
                                        JOIN puesto ON puesto_personas.cod_Puesto = puesto.codPuesto
                                        JOIN persona_habilidades ON persona.dniPersona = persona_habilidades.dni_Persona
                                        JOIN habilidades ON persona_habilidades.cod_Habilidad = habilidades.codHabilidad
                                    GROUP BY persona.apellido, persona.nombre, persona.dniPersona, puesto.descPuesto");
$sentenciaSQL->execute();
$listaPersonas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$sqlH="SELECT * FROM habilidades";
$listaHabilidades=$conexion->query($sqlH);
$habilidades=$listaHabilidades->fetchAll();

$sqlP="SELECT * FROM puesto";
$listaPuestos=$conexion->query($sqlP);
$puestos=$listaPuestos->fetchAll();

?>


<div class="col-md-5">
    
    <div class="card">
        <div class="card-header">
            Datos del empleado
        </div>

        <div class="card-body">

            <form method= "POST" enctype="multipart/form-data" >

                <div class = "form-group">
                <label for="txtDNI">DNI</label>
                <input type="text" class="form-control" value="<?php echo $txtDNI; ?>" id="txtDNI" name="txtDNI" placeholder="DNI">
                </div>

                <div class = "form-group">
                <label for="txtApellido">Apellido</label>
                <input type="text" class="form-control" value="<?php echo $txtApellido; ?>" id="txtApellido" name="txtApellido" placeholder="Apellido/s">
                </div>

                <div class = "form-group">
                <label for="txtNombre">Nombre</label>
                <input type="text" class="form-control" value="<?php echo $txtNombre; ?>" id="txtNombre" name="txtNombre" placeholder="Nombre/s">
                </div>

                <div class="mb-3">
                    <label for="puesto" class="form-label">Puesto de trabajo</label>
                    <select class="form-control" name="puesto" id="puesto">
                    <?php foreach($puestos as $puesto) { ?>
                        <option value="1"><?php echo $puesto['descPuesto'];?></option>
                    <?php }?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="habilidad" class="form-label">Habilidades</label>
                    <select multiple class="form-control" name="habilidades[]" id="listaHabilidades">
                    <?php foreach($habilidades as $habilidad) { ?>
                        <option value="1"><?php echo $habilidad['descHabilidad'];?></option>
                    <?php }?>
                    </select>
                </div>
                

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Registrar" class="btn btn-success">Registrar</button>
                    <button type="submit" name="accion" value="Actualizar" class="btn btn-warning">Actualizar</button>
                </div>
            </form>
        </div>

    </div>


</div>

<div class="col-md-7">
    
    <table class="table table-bordered" id="tabla_id">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>Puesto</th>
                <th>Habilidades</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaPersonas as $persona) {?>
            <tr>
                <td><?php echo $persona['dniPersona'];?></td>
                <td><?php echo $persona['apellido'];?></td>
                <td><?php echo $persona['nombre'];?></td>
                <td><?php echo $persona['descPuesto'];?></td>
                <td><?php echo $persona['gHabilidades'];?></td>
                <td>
                    
                
                <form method="post">
                    <input type="hidden" name="txtDNI" id="txtDNI" value="<?php echo $persona['dniPersona']; ?>"/>
                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-warning" />
                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />
                </form>
            
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>

<?php include("../template/pie.php"); ?>