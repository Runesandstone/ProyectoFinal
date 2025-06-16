<?php
// php/get_admin_log.php
include '../conexion.php'; // Adjust path as needed
session_start();

header('Content-Type: application/json');

// --- SECURITY CHECK: ONLY ADMINS CAN ACCESS THIS LOG ---
if (!isset($_SESSION['ROL']) || $_SESSION['ROL'] !== 'Admin') {
    echo json_encode(['error' => 'Acceso denegado. Solo administradores pueden ver el log.']);
    exit;
}

if (!$conexion) {
    echo json_encode(['error' => 'Error de conexión a la base de datos.']);
    exit;
}

try {
    // Call the stored procedure
    $sql_call_procedure = "CALL ConsultaLogAdmin()";
    $result = mysqli_query($conexion, $sql_call_procedure);

    $log_entries = [];

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $log_entries[] = $row;
            }
        }
        mysqli_free_result($result);

        // Consume any remaining result sets (important for procedures)
        while (mysqli_more_results($conexion) && mysqli_next_result($conexion)) {
            if ($dummyResult = mysqli_use_result($conexion)) {
                mysqli_free_result($dummyResult);
            }
        }

        echo json_encode($log_entries);
    } else {
        throw new Exception("Error al ejecutar el procedimiento ConsultaLogAdmin: " . mysqli_error($conexion));
    }

} catch (Exception $e) {
    error_log("Error en get_admin_log.php: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
}

mysqli_close($conexion);
?>