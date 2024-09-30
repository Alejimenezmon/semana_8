<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Variables de conexión a la base de datos
    $servername = "localhost";
    $username = 'root';
    $password = '0931';
    $database = 'AGENCIA';
    $port = '33064';

    // Crear la conexión PDO utilizando el DSN
    $dsn = "mysql:host=$servername;port=$port;dbname=$database";
    
    try {
        // Crear la instancia PDO y establecer el modo de errores
        $connPDO = new PDO($dsn, $username, $password);
        $connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Procesar el formulario de vuelos
        if ($_POST['formulario'] == "vuelo") {
            // Recoger los datos del formulario
            $origen = $_POST['origen'];
            $destino = $_POST['destino'];
            $fecha = $_POST['fecha'];
            $plazas_disponibles = $_POST['plazas_disponibles'];
            $precio = $_POST['precio'];

            // Validación de campos vacíos y tipos de datos
            if (empty($origen) || empty($destino) || empty($fecha) || empty($plazas_disponibles) || empty($precio)) {
                die("Todos los campos del formulario de vuelos son obligatorios.");
            }
            if (!is_numeric($plazas_disponibles) || !is_numeric($precio)) {
                die("Las plazas y el precio deben ser números.");
            }

            // Consulta SQL para insertar un nuevo vuelo en la base de datos
            $sql = "INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) 
                    VALUES (:origen, :destino, :fecha, :plazas_disponibles, :precio)";
            $stmt = $connPDO->prepare($sql);
            // Asociar los valores a los parámetros de la consulta
            $stmt->bindParam(':origen', $origen);
            $stmt->bindParam(':destino', $destino);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':plazas_disponibles', $plazas_disponibles);
            $stmt->bindParam(':precio', $precio);
            $stmt->execute();

            // Mensaje de confirmación
            echo "Vuelo registrado con éxito.";
        }

        // Procesar el formulario de hoteles
        if ($_POST['formulario'] == "hotel") {
            // Recoger los datos del formulario
            $nombre = $_POST['nombre'];
            $ubicacion = $_POST['ubicacion'];
            $habitaciones_disponibles = $_POST['habitaciones_disponibles'];
            $tarifa_noche = $_POST['tarifa_noche'];

            // Validación de campos vacíos y tipos de datos
            if (empty($nombre) || empty($ubicacion) || empty($habitaciones_disponibles) || empty($tarifa_noche)) {
                die("Todos los campos del formulario de hoteles son obligatorios.");
            }
            if (!is_numeric($habitaciones_disponibles) || !is_numeric($tarifa_noche)) {
                die("Las habitaciones y la tarifa deben ser números.");
            }

            // Consulta SQL para insertar un nuevo hotel en la base de datos
            $sql = "INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) 
                    VALUES (:nombre, :ubicacion, :habitaciones_disponibles, :tarifa_noche)";
            $stmt = $connPDO->prepare($sql);
            // Asociar los valores a los parámetros de la consulta
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':ubicacion', $ubicacion);
            $stmt->bindParam(':habitaciones_disponibles', $habitaciones_disponibles);
            $stmt->bindParam(':tarifa_noche', $tarifa_noche);
            $stmt->execute();

            // Mensaje de confirmación
            echo "Hotel registrado con éxito.";
        }

        // Procesar el formulario de reservas
        if ($_POST['formulario'] == "reserva") {
            // Recoger los datos del formulario
            $id_cliente = $_POST['id_cliente'];
            $id_vuelo = $_POST['id_vuelo'];
            $id_hotel = $_POST['id_hotel'];
            $fecha_reserva = $_POST['fecha_reserva'];

            // Validación de campos vacíos
            if (empty($id_cliente) || empty($id_vuelo) || empty($id_hotel) || empty($fecha_reserva)) {
                die("Todos los campos del formulario de reservas son obligatorios.");
            }

            // Consulta SQL para insertar una nueva reserva en la base de datos
            $sql = "INSERT INTO RESERVA (id_cliente, id_vuelo, id_hotel, fecha_reserva) 
                    VALUES (:id_cliente, :id_vuelo, :id_hotel, :fecha_reserva)";
            $stmt = $connPDO->prepare($sql);
            // Asociar los valores a los parámetros de la consulta
            $stmt->bindParam(':id_cliente', $id_cliente);
            $stmt->bindParam(':id_vuelo', $id_vuelo);
            $stmt->bindParam(':id_hotel', $id_hotel);
            $stmt->bindParam(':fecha_reserva', $fecha_reserva);
            $stmt->execute();

            // Mensaje de confirmación
            echo "Reserva registrada con éxito.";
        }

        // Mostrar reservas con más de 2 reservas por hotel (buscar reservas)
        if ($_POST['formulario'] == "buscar_reservas") {
            // Recoger los datos de búsqueda (opcional)
            $id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : null;
            $fecha_reserva = isset($_POST['fecha_reserva']) ? $_POST['fecha_reserva'] : null;
            $id_hotel = isset($_POST['id_hotel']) ? $_POST['id_hotel'] : null;

            // Construir la consulta SQL dinámica para filtrar según los criterios ingresados
            $query = "SELECT R.id_reserva, R.fecha_reserva, V.origen, V.destino, H.nombre AS hotel_nombre
                      FROM RESERVA R
                      JOIN VUELO V ON R.id_vuelo = V.id_vuelo
                      JOIN HOTEL H ON R.id_hotel = H.id_hotel
                      WHERE 1=1";

            $params = [];

            // Agregar filtros según los parámetros de búsqueda proporcionados
            if (!empty($id_cliente)) {
                $query .= " AND R.id_cliente = :id_cliente";
                $params[':id_cliente'] = $id_cliente;
            }

            if (!empty($fecha_reserva)) {
                $query .= " AND R.fecha_reserva = :fecha_reserva";
                $params[':fecha_reserva'] = $fecha_reserva;
            }

            if (!empty($id_hotel)) {
                $query .= " AND R.id_hotel = :id_hotel";
                $params[':id_hotel'] = $id_hotel;
            }

            // Preparar y ejecutar la consulta
            $stmt = $connPDO->prepare($query);
            $stmt->execute($params);
            $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Mostrar los resultados en una tabla HTML
            if ($reservas) {
                echo "<h2>Resultados de la búsqueda de reservas</h2>";
                echo "<table border='1'>
                        <tr>
                            <th>ID Reserva</th>
                            <th>Fecha de Reserva</th>
                            <th>Origen del Vuelo</th>
                            <th>Destino del Vuelo</th>
                            <th>Nombre del Hotel</th>
                        </tr>";
                foreach ($reservas as $reserva) {
                    echo "<tr>
                            <td>{$reserva['id_reserva']}</td>
                            <td>{$reserva['fecha_reserva']}</td>
                            <td>{$reserva['origen']}</td>
                            <td>{$reserva['destino']}</td>
                            <td>{$reserva['hotel_nombre']}</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                // Mensaje si no se encuentran reservas
                echo "<p>No se encontraron reservas para los criterios ingresados.</p>";
            }
        }

    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
    }
}
?>
