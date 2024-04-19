<?php
// Establecer conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "comunidad";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si la sesión está iniciada y el id del usuario está disponible
session_start();
if (!isset($_SESSION['id'])) {
    die("Error: La sesión no está iniciada.");
}

$id = $_SESSION['id'];

// Consulta SQL para obtener los datos del perfil
$sql = "SELECT * FROM usuario WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Bind de parámetros
$stmt->bind_param("i", $id);

// Ejecutar la consulta SQL
if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}

// Obtener el resultado de la consulta
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener los datos del perfil
    $perfil = $result->fetch_assoc();
    // Devolver los datos del perfil en formato JSON
    echo json_encode(array("success" => true, "usuario" => $perfil));
} else {
    echo json_encode(array("success" => false, "message" => "No se encontraron resultados para el perfil del usuario."));
}

// Cerrar la conexión
$stmt->close();
$conn->close();
