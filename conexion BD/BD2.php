<?php
// Establecer conexión a la base de datos
include 'URL.php';

// Verificar si la sesión está iniciada y el id del usuario está disponible
session_start();
if (!isset($_SESSION['id'])) {
    die("Error: La sesión no está iniciada.");
}

$id = $_SESSION['id'];

// Consulta SQL para obtener los datos del perfil
$sql = "SELECT * FROM usuario WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

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
