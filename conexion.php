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

// Configurar el DSN para PDO
$dsn = "mysql:host=$servername;port=$port;dbname=$database;charset=utf8";

try {
    // Crear conexión PDO
    $connPDO = new PDO($dsn, $username, $password);
    $connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos AGENCIA con PDO";
} catch (PDOException $e) {
    echo "Conexión fallida con PDO - ERROR: " . $e->getMessage();
}


