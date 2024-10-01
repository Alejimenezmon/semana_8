<?php
$servername = "localhost";   // Dirección del servidor MySQL
$username = 'root';
$password = '0931';
$database = "AGENCIA";       // Cambiado a la base de datos AGENCIA
$port = "33064";             // Puerto MySQL

// Conexión MySQLi
$conn = new mysqli($servername, $username, $password, $database, $port);

// Verificar la conexión MySQLi
if ($conn->connect_error) {
    die("Error de conexión con MySQLi: " . $conn->connect_error);
}
echo "Conexión exitosa a la base de datos AGENCIA con MySQLi<br>";

// sanitización de entradas en MySQLi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origen = mysqli_real_escape_string($conn, $_POST['origen']);
    $destino = mysqli_real_escape_string($conn, $_POST['destino']);
    $fecha_vuelo = mysqli_real_escape_string($conn, $_POST['fecha_vuelo']);

    // Consulta segura en MySQLi
    $sql = "SELECT * FROM VUELO WHERE origen='$origen' AND destino='$destino' AND fecha='$fecha_vuelo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Vuelo encontrado: Origen: " . $row["origen"] . " - Destino: " . $row["destino"] . " - Precio: " . $row["precio"] . "<br>";
        }
    } else {
        echo "No se encontraron vuelos para los criterios de búsqueda.";
    }
}

// Configurar el DSN para PDO
$dsn = "mysql:host=$servername;port=$port;dbname=$database;charset=utf8";

try {
    // Crear conexión PDO
    $connPDO = new PDO($dsn, $username, $password);
    $connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos AGENCIA con PDO";
   
    // sanitización de entradas con consultas preparadas en PDO
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $origen = $_POST['origen'];
        $destino = $_POST['destino'];
        $fecha_vuelo = $_POST['fecha_vuelo'];

        // Consulta preparada en PDO
        $sqlPDO = "SELECT * FROM VUELO WHERE origen = :origen AND destino = :destino AND fecha = :fecha";
        $stmt = $connPDO->prepare($sqlPDO);
        $stmt->bindParam(':origen', $origen, PDO::PARAM_STR);
        $stmt->bindParam(':destino', $destino, PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $fecha_vuelo, PDO::PARAM_STR);
        
        $stmt->execute();
        $resultPDO = $stmt->fetchAll();

        if (count($resultPDO) > 0) {
            foreach ($resultPDO as $row) {
                echo "Vuelo encontrado: Origen: " . $row["origen"] . " - Destino: " . $row["destino"] . " - Precio: " . $row["precio"] . "<br>";
            }
        } else {
            echo "No se encontraron vuelos para los criterios de búsqueda.";
        }
    }

} catch (PDOException $e) {
    echo "Conexión fallida con PDO - ERROR: " . $e->getMessage();
}
$conn->close();  // Cerrar conexión MySQLi

