<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "leidy";
$password = "";
$dbname = "emeesa2024";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario solo si se envió por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Validar campos vacíos
    if (empty($user) || empty($pass)) {
        echo "Por favor, completa todos los campos.";
        exit();
    }

    // Preparar la consulta SQL
    $stmt = $conn->prepare("SELECT contraseña FROM usuario WHERE usuario_nombre = ?");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Enlazar los parámetros y ejecutar la consulta
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró un usuario
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hash = $row['contraseña'];

        // Verificar la contraseña con password_verify()
        if (password_verify($pass, $hash)) {
            echo "Inicio de sesión exitoso.";
            // Redirigir al usuario
            // header("Location: pagina_principal.php");
            // exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    // Cerrar la consulta y la conexión
    $stmt->close();
}

$conn->close();
?>
