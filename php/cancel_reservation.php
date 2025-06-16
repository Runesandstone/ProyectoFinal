<?php
// php/cancel_reservation.php
include '../conexion.php';
session_start();

header('Content-Type: application/json');

if (!$conexion) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos.']);
    exit;
}

// Ensure user is logged in
if (!isset($_SESSION['CORREO'])) {
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado.']);
    exit;
}

$user_email = $_SESSION['CORREO'];
$user_role = $_SESSION['ROL'] ?? 'Normal'; // Default to 'Normal' if not set

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);
$n_reserva = filter_var($data['n_reserva'] ?? '', FILTER_VALIDATE_INT);

if ($n_reserva === false || $n_reserva <= 0) {
    echo json_encode(['success' => false, 'error' => 'ID de reserva inválido.']);
    exit;
}

try {
    $email_for_sp = $user_email;

    $stmt = mysqli_prepare($conexion, "CALL CancelarReserva(?, ?, @mensaje, @exito)");

    if (!$stmt) {
        throw new Exception("Error al preparar la llamada al procedimiento: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "is", $n_reserva, $email_for_sp); // 'i' for int, 's' for string

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Get OUT parameters
    $result = mysqli_query($conexion, "SELECT @mensaje AS mensaje, @exito AS exito");
    if (!$result) {
        throw new Exception("Error al obtener los resultados del procedimiento: " . mysqli_error($conexion));
    }

    $row = mysqli_fetch_assoc($result);
    $mensaje = $row['mensaje'];
    $exito = (bool)$row['exito'];

    mysqli_free_result($result);

    echo json_encode(['success' => $exito, 'message' => $mensaje, 'error' => $exito ? '' : $mensaje]);

} catch (Exception $e) {
    error_log("Error al cancelar reserva: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

mysqli_close($conexion);
?>