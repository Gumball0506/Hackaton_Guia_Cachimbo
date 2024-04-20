<?php
session_start();
include('logeado.php'); //Archivo verifica que el usuario que intenta acceder a la URL está logueado

// Inicia la validación del lado del servidor
if (empty($_POST['nombre_apellido'])) {
    $errors[] = "El campo 'nombre_apellido' está vacío";
} else if (empty($_POST['correo'])) {
    $errors[] = "El campo 'correo' está vacío";
} else if (empty($_POST['dni'])) {
    $errors[] = "El campo 'dni' está vacío";
} else if (empty($_POST['fecha_nacimiento'])) {
    $errors[] = "El campo 'fecha_nacimiento' está vacío";
} else if (empty($_POST['facultad'])) {
    $errors[] = "El campo 'facultad' está vacío";
} else {
    // Establecer conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "comunidad";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Escapar y limpiar los datos del formulario
    $nombre_apellido = mysqli_real_escape_string($conn, trim($_POST["nombre_apellido"]));
    $correo = mysqli_real_escape_string($conn, trim($_POST["correo"]));
    $dni = mysqli_real_escape_string($conn, trim($_POST["dni"]));
    $fecha_nacimiento = mysqli_real_escape_string($conn, trim($_POST["fecha_nacimiento"]));
    $facultad = mysqli_real_escape_string($conn, trim($_POST["facultad"]));

    // Actualizar los datos en la base de datos
    $query_update = $conn->prepare("UPDATE usuario SET nombre=?, correo_electronico=?, dni=?, fecha_nacimiento=?, facultad=? WHERE id=?");
    $query_update->bind_param("sssssi", $nombre_apellido, $correo, $dni, $fecha_nacimiento, $facultad, $_SESSION['id']);
    if ($query_update->execute()) {
        $messages[] = "Los datos se han actualizado satisfactoriamente.";
    } else {
        $errors[] = "Ocurrió un error al actualizar los datos: " . $conn->error;
    }
}

// Mostrar mensajes de error o éxito
if (isset($errors)) {
    foreach ($errors as $error) {
        echo "<div class='alert alert-danger' role='alert'>$error</div>";
    }
}
if (isset($messages)) {
    foreach ($messages as $message) {
        echo "<div class='alert alert-success' role='alert'>$message</div>";
    }
}
