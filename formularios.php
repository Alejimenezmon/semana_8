<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Meta charset para codificación de caracteres en UTF-8 -->
    <meta charset="UTF-8">
    <!-- Meta viewport para hacer que el sitio sea responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título de la página -->
    <title>Agencia de Viajes - Gestión de Vuelos, Hoteles y Reservas</title>
    <!-- Enlace al archivo CSS externo para los estilos -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Encabezado principal de la página con el título de la empresa -->
<header>
    <!-- Título principal de la página -->
    <h1 class="main-title">Agencia de Viajes</h1>
</header>

<!-- Contenedor principal que agrupa todos los formularios -->
<div class="container">
    <!-- Subtítulo para explicar la función de la página -->
    <h2 class="subtitle">Gestión de Vuelos, Hoteles y Reservas</h2>

    <!-- Formulario para registrar un vuelo -->
    <div class="form-container">
        <h2>Registrar Vuelo</h2>
        <!-- El formulario envía los datos a procesar a 'procesar_formulario.php' vía POST -->
        <form action="procesar_formulario.php" method="POST">
            <!-- Campo oculto para identificar el tipo de formulario enviado -->
            <input type="hidden" name="formulario" value="vuelo">
            <!-- Campos de entrada de datos para registrar un vuelo -->
            Origen: <input type="text" name="origen" required><br>
            Destino: <input type="text" name="destino" required><br>
            Fecha: <input type="date" name="fecha" required><br>
            Plazas Disponibles: <input type="number" name="plazas_disponibles" required><br>
            Precio: <input type="number" step="0.01" name="precio" required><br>
            <!-- Botón para enviar los datos del formulario -->
            <input type="submit" value="Registrar Vuelo">
        </form>
    </div>

    <!-- Formulario para registrar un hotel -->
    <div class="form-container">
        <h2>Registrar Hotel</h2>
        <!-- El formulario envía los datos a procesar a 'procesar_formulario.php' vía POST -->
        <form action="procesar_formulario.php" method="POST">
            <!-- Campo oculto para identificar el tipo de formulario enviado -->
            <input type="hidden" name="formulario" value="hotel">
            <!-- Campos de entrada de datos para registrar un hotel -->
            Nombre del Hotel: <input type="text" name="nombre" required><br>
            Ubicación: <input type="text" name="ubicacion" required><br>
            Habitaciones Disponibles: <input type="number" name="habitaciones_disponibles" required><br>
            Tarifa por Noche: <input type="number" step="0.01" name="tarifa_noche" required><br>
            <!-- Botón para enviar los datos del formulario -->
            <input type="submit" value="Registrar Hotel">
        </form>
    </div>

    <!-- Formulario para registrar una reserva -->
    <div class="form-container">
        <h2>Registrar Reserva</h2>
        <!-- El formulario envía los datos a procesar a 'procesar_formulario.php' vía POST -->
        <form action="procesar_formulario.php" method="POST">
            <!-- Campo oculto para identificar el tipo de formulario enviado -->
            <input type="hidden" name="formulario" value="reserva">
            <!-- Campos de entrada de datos para registrar una reserva -->
            ID Cliente: <input type="number" name="id_cliente" required><br>
            ID Vuelo: <input type="number" name="id_vuelo" required><br>
            ID Hotel: <input type="number" name="id_hotel" required><br>
            Fecha de Reserva: <input type="date" name="fecha_reserva" required><br>
            <!-- Botón para enviar los datos del formulario -->
            <input type="submit" value="Registrar Reserva">
        </form>
    </div>

    <!-- Formulario para buscar reservas según los criterios indicados -->
    <div class="form-container">
        <h2>Buscar Reservas</h2>
        <!-- El formulario envía los datos a procesar a 'procesar_formulario.php' vía POST -->
        <form action="procesar_formulario.php" method="POST">
            <!-- Campo oculto para identificar el tipo de formulario enviado -->
            <input type="hidden" name="formulario" value="buscar_reservas">
            <!-- Campos de entrada de datos para filtrar la búsqueda de reservas -->
            ID Cliente: <input type="number" name="id_cliente"><br>
            Fecha de Reserva: <input type="date" name="fecha_reserva"><br>
            ID Hotel: <input type="number" name="id_hotel"><br>
            <!-- Botón para buscar reservas con los criterios indicados -->
            <input type="submit" value="Buscar Reservas">
        </form>
    </div>
</div>

</body>
</html>
