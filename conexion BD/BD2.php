<?php
// Establecer conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "comunidad";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si la sesión está iniciada y el id del usuario está disponible
session_start();
if (!isset($_SESSION['id_usuario'])) {
    die("Error: La sesión no está iniciada.");
}

$id_usuario = $_SESSION['id_usuario'];

// Consulta SQL para obtener los datos del perfil
$sql = "SELECT * FROM perfil WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);

// Ejecutar la consulta SQL
$stmt->execute();

// Obtener el resultado de la consulta
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener los datos del perfil
    $perfil = $result->fetch_assoc();
} else {
    echo "No se encontraron resultados para el perfil del usuario.";
}

// Cerrar la conexión
$conn->close();
