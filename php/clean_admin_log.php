<?php
// php/clear_admin_log.php
include '../conexion.php'; // Corrected path/filename to conexion.php

session_start();
header('Content-Type: application/json');

// Check database connection
if (!$conexion) { // Using $conexion as per your 'conexion.php' assumption
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos.']);
    exit;
}

// Security: Check if user is logged in AND is an Admin
// Using 'ROL' and 'Admin' (uppercase) as per your log.php HTML
if (!isset($_SESSION['ROL']) || $_SESSION['ROL'] !== 'Admin') {
    echo json_encode(['success' => false, 'error' => 'Acceso denegado. Solo administradores pueden limpiar el log.']);
    exit;
}

try {
    $sql = "CALL LimpiarLogAdmin()";
    $result = mysqli_query($conexion, $sql); // Using $conexion

    if ($result) {
        $row = mysqli_fetch_assoc($result); // Fetch the message row from the SP's SELECT statement
        mysqli_free_result($result);

        // Consume any remaining result sets (important for procedures)
        while (mysqli_more_results($conexion) && mysqli_next_result($conexion)) {
            if ($dummyResult = mysqli_use_result($conexion)) {
                mysqli_free_result($dummyResult);
            }
        }

        // Check the message returned by the stored procedure
        if (isset($row['MensajeExito'])) {
            echo json_encode(['success' => true, 'message' => $row['MensajeExito']]);
        } elseif (isset($row['MensajeError'])) {
            echo json_encode(['success' => false, 'error' => $row['MensajeError']]);
        } else {
            // Fallback if the procedure returned something unexpected
            echo json_encode(['success' => false, 'error' => 'La operación de limpieza del log no devolvió un mensaje de éxito o error esperado.']);
        }
    } else {
        // This catch is for errors directly from mysqli_query itself, not from the SP's internal handler
        throw new Exception("Error al ejecutar el procedimiento LimpiarLogAdmin: " . mysqli_error($conexion));
    }

} catch (Exception $e) {
    error_log("Error en clear_admin_log.php: " . $e->getMessage()); // Corrected filename in log
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

mysqli_close($conexion);
?>