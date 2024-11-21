<?php
// Configuración de conexión a la base de datos desde variables de entorno
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$apialumno = getenv('API_ALUMNO');


// Conectar a la base de datos usando mysqli
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

// Obtener la lista de maestros
$sql = "SELECT nombre FROM maestros";
$result = $conn->query($sql);

$maestros = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $maestros[] = $row;
    }
}

// Función para consumir la API de alumnos
function getAlumnos($apialumno) {
    $url = "http://".$apialumno."/index.php?format=json"; // URL de la API de alumnos en JSON
    $response = file_get_contents($url);
    return json_decode($response, true);
}

$alumnos = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Llamada a la API de alumnos al presionar el botón
    $alumnos = getAlumnos($apialumno);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Maestros y Alumnos</title>
</head>
<body>
    <h1>Lista de Maestros</h1>
    <ul>
        <?php foreach ($maestros as $maestro): ?>
            <li><?php echo htmlspecialchars($maestro['nombre']); ?></li>
        <?php endforeach; ?>
    </ul>

    <form method="post">
        <button type="submit">Mostrar Alumnos</button>
    </form>

    <?php if (!empty($alumnos)): ?>
        <h1>Lista de Alumnos</h1>
        <ul>
            <?php foreach ($alumnos as $alumno): ?>
                <li><?php echo htmlspecialchars($alumno['nombre']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
