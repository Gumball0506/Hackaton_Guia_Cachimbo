<?php
// Validamos datos del servidor
$user = "root"; // Nombre de usuario de la base de datos
$pass = ""; // Contraseña de la base de datos
$host = "localhost"; // Dirección del servidor de la base de datos
$dbname = "comunidad"; // Nombre de la base de datos

// Conectamos a la base de datos
$connection = mysqli_connect($host, $user, $pass, $dbname);
// Verificamos la conexión a la base de datos
if (!$connection) {
    die("No se ha podido conectar con el servidor: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $dni = $_POST["dni"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $codigo_estudiante = $_POST["codigo_estudiante"];
    $facultad = $_POST["facultad"];
    $correo_electronico = $_POST["correo_electronico"];
    $contraseña = $_POST["contraseña"];

    // Preparar la consulta SQL
    $sql = "INSERT INTO usuario (nombre, dni, fecha_nacimiento, codigo_estudiante, facultad, correo_electronico, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);

    if ($stmt) {
        // Enlazar parámetros
        $stmt->bind_param("sssssss", $nombre, $dni, $fecha_nacimiento, $codigo_estudiante, $facultad, $correo_electronico, $contraseña);
        // Ejecutar la consulta
        $stmt->execute();
        // Verificar si se insertaron los datos correctamente
        if ($stmt->affected_rows > 0) {
            // Redirigir al usuario a la página principal si la inserción es exitosa
            header("Location: /Proyecto/templates/inicio.html");
            exit(); // Terminar el script después de redirigir
        } else {
            die("Error al registrar el usuario: " . $stmt->error); // Error en el registro
        }
        // Cerrar el statement
        $stmt->close();
    } else {
        die("Error al preparar la consulta: " . $connection->error); // Error al preparar la consulta
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($connection);
