<?php
$servername = "localhost"; // Cambia localhost si tu servidor de base de datos tiene un nombre diferente
$username = "root"; // Cambia nombre_usuario por el nombre de usuario de tu base de datos
$password = ""; // Cambia contraseña por la contraseña de tu base de datos
$database = "comunidad"; // Cambia nombre_base_datos por el nombre de tu base de datos

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $database);

// Verificar la conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
// Consulta para obtener los datos del perfil del usuario
$sql = "SELECT * FROM usuario WHERE id = 1"; // Cambia tabla_usuarios por el nombre de tu tabla y 1 por el ID del usuario que deseas obtener

// Ejecutar la consulta
$result = mysqli_query($conn, $sql);

// Verificar si se obtuvieron resultados
if (mysqli_num_rows($result) > 0) {
    // Convertir los resultados a un array asociativo
    $row = mysqli_fetch_assoc($result);

    // Devolver los datos del perfil del usuario en formato JSON
    echo json_encode(array("success" => true, "usuario" => $row));
} else {
    // Si no se encontraron resultados, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se encontraron datos del perfil del usuario."));
}

// Cerrar la conexión
mysqli_close($conn);
