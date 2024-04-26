document.getElementById('register-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que el formulario se envíe automáticamente

    // Obtener los valores del formulario de registro
    var nombre = document.getElementById('nombre').value;
    var dni = document.getElementById('dni').value;
    var fecha_nacimiento = document.getElementById('fecha_nacimiento').value;
    var codigo_estudiante = document.getElementById('codigo_estudiante').value;
    var facultad = document.getElementById('facultad').value;
    var correo_electronico = document.getElementById('correo_electronico').value;
    var contraseña = document.getElementById('contraseña').value;

    // Realizar la solicitud al servidor para registrar al usuario
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/conexion BD/BD1.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = xhr.responseText;
            if (response.trim() === 'success') {
                // Crear un formulario oculto para redirigir al usuario a la página de inicio
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '/templates/inicio.html';
                document.body.appendChild(form);
                form.submit();
            } else {
                // Manejar el error de registro si es necesario
                console.error('Error al registrar el usuario');
            }
        }
    };
    // Enviar los datos del formulario de registro al servidor
    xhr.send('nombre=' + encodeURIComponent(nombre) +
            '&dni=' + encodeURIComponent(dni) +
            '&fecha_nacimiento=' + encodeURIComponent(fecha_nacimiento) +
            '&codigo_estudiante=' + encodeURIComponent(codigo_estudiante) +
            '&facultad=' + encodeURIComponent(facultad) +
            '&correo_electronico=' + encodeURIComponent(correo_electronico) +
            '&contraseña=' + encodeURIComponent(contraseña));
});
