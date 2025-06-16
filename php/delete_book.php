<?php
// delete_book.php
include '../conexion.php'; 
session_start(); // Inicia la sesión para verificar el rol

header('Content-Type: application/json');

// Verificar la conexión
if (!$conexion) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos.']);
    exit;
}

// --- Verificar si el usuario es administrador (IMPRESINDIBLE) ---
if (!isset($_SESSION['ROL']) || $_SESSION['ROL'] !== 'Admin') {
    echo json_encode(['success' => false, 'error' => 'Permiso denegado. Solo administradores pueden borrar libros.']);
    mysqli_close($conexion);
    exit;
}

// Leer los datos del cuerpo de la solicitud (JSON)
$data = json_decode(file_get_contents('php://input'), true);
$book_title = isset($data['titulo']) ? $data['titulo'] : '';

if (empty($book_title)) {
    echo json_encode(['success' => false, 'error' => 'Título del libro no proporcionado para borrar.']);
    mysqli_close($conexion);
    exit;
}

try {
    // Preparar la llamada al procedimiento almacenado
    $stmt = mysqli_prepare($conexion, "CALL BorrarLibroPorTitulo(?, @mensaje, @exito)");

    if (!$stmt) {
        throw new Exception("Error al preparar la llamada al procedimiento: " . mysqli_error($conexion));
    }

    // Vincular el parámetro de entrada
    mysqli_stmt_bind_param($stmt, "s", $book_title);

    // Ejecutar el procedimiento
    mysqli_stmt_execute($stmt);

    // Cerrar el statement
    mysqli_stmt_close($stmt);

    // Obtener los valores de los parámetros de salida
    $result = mysqli_query($conexion, "SELECT @mensaje AS mensaje, @exito AS exito");
    if (!$result) {
        throw new Exception("Error al obtener los resultados del procedimiento: " . mysqli_error($conexion));
    }

    $row = mysqli_fetch_assoc($result);
    $mensaje = $row['mensaje'];
    $exito = (bool)$row['exito']; // Convertir a booleano

    mysqli_free_result($result);

    // Devolver la respuesta basada en el éxito del procedimiento
    if ($exito) {
        echo json_encode(['success' => true, 'message' => $mensaje]);
    } else {
        echo json_encode(['success' => false, 'error' => $mensaje]);
    }

} catch (Exception $e) {
    error_log("Error al borrar libro (SP): " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

mysqli_close($conexion);
?>