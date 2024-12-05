<?php
// Configuración de la conexión a la base de datos
$host = "127.0.0.1"; // Cambia según tu configuración
$usuario = "leidy";    // Usuario de MySQL
$password = "";       // Contraseña de MySQL
$basedatos = "emeesa2024";

// Crear la conexión
$conn = new mysqli($host, $usuario, $password, $basedatos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$usuario = $_POST['usuario'];
$password = md5($_POST['password']); // Encriptamos la contraseña para comparar

// Consulta para verificar el usuario y la contraseña
$sql = "SELECT * FROM usuario WHERE usuario_nombre = ? AND contraseña = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $password);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró el usuario
if ($result->num_rows > 0) {
    echo "¡Inicio de sesión exitoso! Bienvenido, " . htmlspecialchars($usuario) . ".";
} else {
    echo "<p class='error'>Usuario o contraseña incorrectos.</p>";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
