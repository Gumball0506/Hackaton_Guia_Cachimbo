<?php
include('logeado.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['nombre'])) {
    $errors[] = "nombre_apellido esta vacío";
} else if (empty($_POST['correo_electronico'])) {
    $errors[] = "correo electronico esta vacío";
} else if (empty($_POST['dni'])) {
    $errors[] = "dni esta vacío";
} else if (empty($_POST['fecha_nacimiento'])) {
    $errors[] = "fecha_nacimiento esta vacío";
} else if (empty($_POST['facultad'])) {
    $errors[] = "facultad esta vacío";
} else if (
    !empty($_POST['nombre']) &&
    !empty($_POST['correo_electronico']) &&
    !empty($_POST['dni']) &&
    !empty($_POST['fecha_nacimiento']) &&
    !empty($_POST['facultad'])
) {

    // Establecer conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "comunidad";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    // escaping, additionally removing everything that could be (html/javascript-) code
    $nombre_apellido = mysqli_real_escape_string($con, (strip_tags($_POST["nombre_apellido"], ENT_QUOTES)));
    $correo_electronico = mysqli_real_escape_string($con, (strip_tags($_POST["correo_electronico"], ENT_QUOTES)));
    $dni = mysqli_real_escape_string($con, (strip_tags($_POST["dni"], ENT_QUOTES)));
    $fecha_nacimiento = mysqli_real_escape_string($con, (strip_tags($_POST["fecha_nacimiento"], ENT_QUOTES)));
    $facultad = mysqli_real_escape_string($con, (strip_tags($_POST["facultad"], ENT_QUOTES)));

    $sql = "UPDATE usuario SET nombre='" . $nombre_apellido . "', correo_electronico='" . $correo_electronico . "', dni='" . $dni . "', fecha_nacimiento='" . $fecha_nacimiento . "', facultad='" . $facultad . "' WHERE id='1'";
    $query_update = mysqli_query($con, $sql);
    if ($query_update) {
        $messages[] = "Datos han sido actualizados satisfactoriamente.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($con);
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {

?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong>
        <?php
        foreach ($errors as $error) {
            echo $error;
        }
        ?>
    </div>
<?php
}
if (isset($messages)) {

?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Bien hecho!</strong>
        <?php
        foreach ($messages as $message) {
            echo $message;
        }
        ?>
    </div>
<?php
}

?>