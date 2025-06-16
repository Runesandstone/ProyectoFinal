<?php
// php/get_user_borrowed_books.php
include '../conexion.php';
session_start();

header('Content-Type: application/json');

if (!$conexion) {
    echo json_encode(['error' => 'Error de conexión a la base de datos.']);
    exit;
}

// Security: Check if user is logged in and if the email matches
if (!isset($_SESSION['CORREO'])) {
    echo json_encode(['error' => 'Usuario no autenticado.']);
    exit;
}
$user_email = $_SESSION['CORREO'];

// Get email from GET parameter (for flexibility, though session is primary)
$request_email = isset($_GET['email']) ? $_GET['email'] : '';

// Ensure the requested email matches the logged-in user's email for security
if ($user_email !== $request_email) {
    echo json_encode(['error' => 'Acceso denegado: El correo no coincide con el usuario autenticado.']);
    exit;
}

try {
    $stmt = mysqli_prepare($conexion, "CALL GetLibrosPrestadosUsuario(?)");
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conexion));
    }

    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $borrowed_books = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $borrowed_books[] = $row;
        }
        mysqli_free_result($result);
    }

    // Consume any remaining results from the procedure call (good practice)
    while (mysqli_more_results($conexion) && mysqli_next_result($conexion)) {
        if ($dummyResult = mysqli_use_result($conexion)) {
            mysqli_free_result($dummyResult);
        }
    }

    mysqli_stmt_close($stmt);

    echo json_encode($borrowed_books);

} catch (Exception $e) {
    error_log("Error al obtener libros prestados: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
}

mysqli_close($conexion);
?>