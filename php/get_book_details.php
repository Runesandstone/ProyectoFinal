<?php
header('Content-Type: application/json');

if (!isset($_GET['titulo'])) {
    echo json_encode(['error' => 'Falta el título del libro']);
    exit;
}

$titulo = $_GET['titulo'];

$conexion = new mysqli("localhost", "root", "", "proyecto_biblioteca");
if ($conexion->connect_error) {
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

// --- Paso 1: Llamar a ConsultarLibroDetalles ---
$stmtDetalles = $conexion->prepare("CALL ConsultarLibroDetalles(?)");
$stmtDetalles->bind_param("s", $titulo);
$stmtDetalles->execute();
$resultDetalles = $stmtDetalles->get_result();
$detalles = $resultDetalles->fetch_assoc();
$stmtDetalles->close();
$conexion->next_result(); // Limpiar resultado previo

if (!$detalles) {
    echo json_encode(['error' => 'Libro no encontrado']);
    exit;
}

// --- Paso 2: Llamar a ConsultarDisponibilidadLibro ---
$stmtDisponibilidad = $conexion->prepare("CALL ConsultarDisponibilidadLibro(?)");
$stmtDisponibilidad->bind_param("s", $titulo);
$stmtDisponibilidad->execute();
$resultDisp = $stmtDisponibilidad->get_result();
$disp = $resultDisp->fetch_assoc();
$stmtDisponibilidad->close();
$conexion->next_result();

$conexion->close();

// --- Unir resultados ---
$detalles['DisponibleParaReserva'] = $disp['DisponibleParaReserva'] ?? false;

// Opcional: Puedes calcular la cantidad de ejemplares disponibles si lo necesitas
$detalles['cantidad'] = $detalles['DisponibleParaReserva'] ? 'Sí' : 'No'; // O busca el número exacto si lo deseas

echo json_encode($detalles);
