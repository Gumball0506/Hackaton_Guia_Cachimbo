# Importación de los módulos necesarios de Flask
from flask import Flask, render_template, redirect, request, url_for

# Importación del módulo MySQL de Flask-MySQLdb
from flask_mysqldb import MySQL

# Importación del módulo 'os' para manejar operaciones del sistema
import os

# Directorio absoluto de la carpeta de plantillas
template_dir = os.path.abspath('C:/Users/harol/Proyectos-Python/Proyecto/templates')

# Inicialización de la aplicación Flask con la ruta de las plantillas
app = Flask(__name__, template_folder=template_dir)

# Configuración de la base de datos MySQL
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = '0506'  # Contraseña de la base de datos MySQL
app.config['MYSQL_DB'] = 'registros'

# Creación de un objeto MySQL asociado a la aplicación Flask
mysql = MySQL(app)

# Ruta para la página principal
@app.route('/')
def index():
    # Renderiza la plantilla 'inicio.html'
    return render_template('inicio.html')

# Ruta para procesar el formulario de inicio de sesión
@app.route('/login', methods=['GET','POST'])
def process_login():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']
        cur = mysql.connection.cursor()
        # Ejecuta la consulta SQL para buscar al usuario en la base de datos
        cur.execute("SELECT * FROM usuarios WHERE nombre = %s AND contraseña = %s", (username, password))
        user = cur.fetchone()  # Obtiene el primer usuario que coincida con las credenciales
        cur.close()
        if user:
            # Si las credenciales son válidas, redirige al usuario a la página de bienvenida
            return redirect(url_for('welcome'))
        else:
            # Si las credenciales son inválidas, muestra un mensaje de error
            return "Usuario o contraseña incorrectos"
    # Si la solicitud no es POST, redirige a la página de inicio de sesión
    return render_template('login.html')

# Ruta para la página de registro
@app.route('/registro', methods=['GET', 'POST'])
def registro():
    if request.method == 'POST':
        # Si se envía un formulario con método POST, procesa los datos y registra al usuario en la base de datos
        nombre = request.form['nombre']
        dni = request.form['dni']
        fecha_nacimiento = request.form['fecha_nacimiento']
        codigo_estudiante = request.form['codigo_estudiante']
        facultad = request.form['facultad']
        correo_electronico = request.form['correo_electronico']
        contraseña = request.form['contraseña']
        # Establece una conexión a la base de datos
        cur = mysql.connection.cursor()
        # Inserta los datos del usuario en la tabla 'usuarios'
        cur.execute("INSERT INTO usuarios (nombre, dni, fecha_nacimiento, codigo_estudiante, facultad, correo_electronico, contraseña) VALUES (%s, %s, %s, %s, %s, %s, %s)", (nombre, dni, fecha_nacimiento, codigo_estudiante, facultad, correo_electronico, contraseña))
        mysql.connection.commit()  # Confirma la transacción
        cur.close()
        return "Registro exitoso"
    else:
        # Si es una solicitud GET, simplemente muestra el formulario de registro
        return render_template('registro.html')

# Ruta para la página de bienvenida
@app.route('/welcome')
def welcome():
    # Mensaje de bienvenida
    return "Bienvenido!"

if __name__ == '__main__':
    # Ejecuta la aplicación Flask en el puerto 3000 en modo de depuración
    app.run(port=3000, debug=True)
