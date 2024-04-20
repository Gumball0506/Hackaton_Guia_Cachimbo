<?php
// Inicia la validación del lado del servidor    
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "comunidad";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si la sesión no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['id'])) {
    // Redirigir al formulario de inicio de sesión
    header("location: templates/login.html");
    exit;
}

// El usuario ha iniciado sesión, obtener su ID
$user_id = $_SESSION['id'];

// Consultar la base de datos para obtener los datos del usuario
$query = "SELECT * FROM usuario WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontraron los datos del usuario
if ($result->num_rows > 0) {
    // Obtener los datos del usuario
    $row = $result->fetch_assoc();
} else {
    // No se encontraron datos del usuario, mostrar un mensaje de error
    exit("Error: Usuario no encontrado");
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
