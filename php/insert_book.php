<?php
// php/insert_book.php
include '../conexion.php';
session_start();

header('Content-Type: application/json');

if (!$conexion) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos.']);
    exit;
}

// --- VERIFY ADMIN ROLE ---
if (!isset($_SESSION['ROL']) || $_SESSION['ROL'] !== 'Admin') {
    echo json_encode(['success' => false, 'error' => 'Acceso denegado. Solo administradores pueden insertar libros.']);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate and sanitize inputs
$id_libro = filter_var($data['id_libro'] ?? '', FILTER_SANITIZE_STRING);
$titulo = filter_var($data['titulo'] ?? '', FILTER_SANITIZE_STRING);
$autor = filter_var($data['autor'] ?? '', FILTER_SANITIZE_STRING);
$anio = filter_var($data['anio'] ?? '', FILTER_VALIDATE_INT);
$isbn = filter_var($data['isbn'] ?? '', FILTER_SANITIZE_STRING);
$editorial = filter_var($data['editorial'] ?? '', FILTER_SANITIZE_STRING);
$status = filter_var($data['status'] ?? '', FILTER_SANITIZE_STRING); // Should be 'Disponible' or 'Prestado'
$id_categoria = filter_var($data['id_categoria'] ?? '', FILTER_SANITIZE_STRING);
$descripcion = filter_var($data['descripcion'] ?? '', FILTER_SANITIZE_STRING);

// Basic input validation
if (empty($id_libro) || empty($titulo) || empty($autor) || $anio === false || empty($isbn) || empty($editorial) || empty($status) || empty($id_categoria)) {
    echo json_encode(['success' => false, 'error' => 'Todos los campos requeridos deben ser completados y válidos.']);
    exit;
}
if (!in_array($status, ['Disponible', 'Prestado'])) {
    echo json_encode(['success' => false, 'error' => 'Estado de libro inválido.']);
    exit;
}


try {
    $stmt = mysqli_prepare($conexion, "CALL InsertarNuevoLibro(?, ?, ?, ?, ?, ?, ?, ?, ?, @mensaje, @exito)");

    if (!$stmt) {
        throw new Exception("Error al preparar la llamada al procedimiento: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "sssisssss",
        $id_libro, $titulo, $autor, $anio, $isbn, $editorial, $status, $id_categoria, $descripcion
    );

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
    error_log("Error al insertar libro: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

mysqli_close($conexion);
?>