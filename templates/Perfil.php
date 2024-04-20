<?php
session_start();
include('logeado.php'); //Archivo verifica que el usuario que intenta acceder a la URL está logueado

// Establecer conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "comunidad";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    // Redirigir al formulario de inicio de sesión si no ha iniciado sesión
    header("location: login.html");
    exit;
}

// Obtener el ID del usuario de la sesión
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
    // Mostrar los datos del usuario en la página de perfil
} else {
    // Si no se encontraron datos del usuario, mostrar un mensaje de error
    exit("Error: Usuario no encontrado");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-Lvs/Gu8IsKDPM/Au9V3L+Vc0w5KvMCz+DLD/rE60Ml9aJXFaz7qLhwlAOk4K9qU5d+rbvF94UgiZibitS1mk0A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Estilos CSS personalizados -->
    <link rel="stylesheet" href="/Estilo/foto-perfil.css">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-3 text-center">
                <?php
                // Obtener la ruta de la foto de perfil del usuario
                $foto_url = $row['foto_url'];

                // Verificar si la ruta está vacía o tiene la ruta predeterminada
                if (empty($foto_url) || $foto_url === 'path/to/default-profile-pic.jpg') {
                    // Mostrar la imagen predeterminada
                    $foto_url = 'path/to/default-profile-pic.jpg';
                }
                ?>
                <div class="profile-picture-container">
                    <img class="img-responsive img-circle profile-picture" src="<?php echo $foto_url; ?>" alt="Foto de Perfil">
                    <!-- Botón para seleccionar una imagen -->
                    <!-- Botón para seleccionar una imagen -->
                    <input class='filestyle' data-buttonText="<i class='fas fa-upload'></i> Cambiar Foto" type="file" name="imagefile" id="imagefile" onchange="upload_image();">

                </div>
            </div>
            <div class="col-md-9">
                <h2 class="text-center">Perfil de Usuario</h2>
                <form method="post" id="perfil">
                    <div class="form-group">
                        <label for="nombre_apellido">Nombres y Apellidos:</label>
                        <input type="text" class="form-control" id="nombre_apellido" name="nombre_apellido" value="<?php echo $row['nombre'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $row['correo_electronico'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI:</label>
                        <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $row['dni'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $row['fecha_nacimiento'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="facultad">Facultad:</label>
                        <input type="text" class="form-control" id="facultad" name="facultad" value="<?php echo $row['facultad'] ?>" required>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success">Actualizar Información</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Archivo JS personalizado -->
    <script src="footer.js"></script>
    <script src="js/bootstrap-filestyle.js"></script>
    <script>
        // Función para enviar el formulario con AJAX
        $("#perfil").submit(function(event) {
            $('.guardar_datos').attr("disabled", true);
            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "/conexion BD/Verificacion.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $("#resultados_ajax").html("Mensaje: Cargando...");
                },
                success: function(datos) {
                    $("#resultados_ajax").html(datos);
                    $('.guardar_datos').attr("disabled", false);
                }
            });
            event.preventDefault();
        });
    </script>
    <script>
        // Función para cargar la imagen con AJAX
        function upload_image() {
            var inputFileImage = document.getElementById("imagefile");
            var file = inputFileImage.files[0];
            if ((typeof file === "object") && (file !== null)) {
                $("#load_img").text('Cargando...');
                var data = new FormData();
                data.append('imagefile', file);
                $.ajax({
                    url: "/conexion BD/imagen.php",
                    type: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $("#load_img").html(data);
                    }
                });
            }
        }
    </script>
</body>

</html>