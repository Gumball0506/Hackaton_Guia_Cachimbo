<?php
/* Connect To Database*/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "comunidad";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if (isset($_FILES["imagefile"])) {

    $target_dir = "../Imagenes/";
    $image_name = time() . "_" . basename($_FILES["imagefile"]["name"]);
    $target_file = $target_dir . $image_name;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $imageFileZise = $_FILES["imagefile"]["size"];



    /* Inicio Validacion*/
    // Allow certain file formats
    if (($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") and $imageFileZise > 0) {
        $errors[] = "<p>Lo sentimos, sólo se permiten archivos JPG , JPEG, PNG y GIF.</p>";
    } else if ($imageFileZise > 1048576) { //1048576 byte=1MB
        $errors[] = "<p>Lo sentimos, pero el archivo es demasiado grande. Selecciona logo de menos de 1MB</p>";
    } else {



        if ($imageFileZise > 0) {
            move_uploaded_file($_FILES["imagefile"]["tmp_name"], $target_file);
            $imagen_update = "foto_url='$target_file' "; // Usando la ruta completa de la imagen en el servidor
        } else {
            $imagen_update = "";
        }
        $sql = "UPDATE usuario SET $imagen_update WHERE id='1';";
        $query_new_insert = mysqli_query($conn, $sql);

        if ($query_new_insert) {
?>
            <img class="img-responsive" src="<?php echo $target_file; ?>" alt="Foto de Perfil">
<?php
        } else {
            $errors[] = "Lo sentimos, la actualización falló. Por favor, inténtalo de nuevo.";
        }
    }
}




?>
<?php
if (isset($errors)) {
?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error! </strong>
        <?php
        foreach ($errors as $error) {
            echo $error;
        }
        ?>
    </div>
<?php
}
?>