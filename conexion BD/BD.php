<?php
// Validamos datos del servidor
$user = "root"; // Nombre de usuario de la base de datos
$pass = ""; // Contraseña de la base de datos
$host = "localhost"; // Dirección del servidor de la base de datos
$dbname = "comunidad"; // Nombre de la base de datos

// Conectamos a la base de datos
$connection = mysqli_connect($host, $user, $pass, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Hacemos llamado a los datos del formulario de inicio de sesión
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Ejecutamos la consulta SQL para buscar al usuario en la base de datos
    $consulta = "SELECT * FROM usuario WHERE nombre = ? AND contraseña = ?";
    $stmt = mysqli_stmt_init($connection);

    if (mysqli_stmt_prepare($stmt, $consulta)) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }

    if ($user) {
        // Si las credenciales son válidas, retorna un éxito
        echo "success";
    } else {
        // Si las credenciales son inválidas, retorna un mensaje de error
        echo "error";
    }
}

// Cerramos la conexión a la base de datos
mysqli_close($connection);
