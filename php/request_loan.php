<?php
include '../conexion.php'; 
session_start(); // Inicia la sesión para acceder a $_SESSION['CORREO']

header('Content-Type: application/json');

// Verificar la conexión
if (!$conexion) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos.']);
    exit;
}

// Verificar si el usuario está logueado y tiene correo en la sesión
if (!isset($_SESSION['CORREO']) || empty($_SESSION['CORREO'])) {
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado. Por favor, inicia sesión.']);
    mysqli_close($conexion);
    exit;
}
$user_email = $_SESSION['CORREO'];

// Leer los datos del cuerpo de la solicitud (JSON)
$data = json_decode(file_get_contents('php://input'), true);
$book_title = isset($data['titulo']) ? $data['titulo'] : '';

if (empty($book_title)) {
    echo json_encode(['success' => false, 'error' => 'Título del libro no proporcionado.']);
    mysqli_close($conexion);
    exit;
}

// --- Lógica para registrar la solicitud de préstamo ---
// 1. Encontrar un ID_LIBRO disponible para el título dado.
// 2. Insertar en la tabla RESERVA y RESERVADO.
// 3. Opcional: Actualizar el STATUS del libro a 'Prestado' inmediatamente,
//    o mantenerlo 'Disponible' hasta que un admin apruebe.
//    Para este ejemplo, solo crearemos la reserva en estado 'Espera'.

$conexion->begin_transaction(); // Iniciar transacción para asegurar la consistencia

try {
    // 1. Encontrar un ID_LIBRO disponible
    // Usaremos el mismo criterio que en el SP ConsultarLibroDetalleYDisponibilidad
    $stmt_find_book = $conexion->prepare("
        SELECT L.ID_LIBRO
        FROM LIBRO L
        WHERE L.TITULO = ?
        AND L.STATUS = 'Disponible'
        AND NOT EXISTS (
            SELECT 1
            FROM RESERVADO R
            JOIN RESERVA RES ON R.N_RESERVA = RES.N_RESERVA
            WHERE R.ID_LIBRO = L.ID_LIBRO AND RES.ESTADO = 'Espera'
        )
        LIMIT 1
    ");
    $stmt_find_book->bind_param("s", $book_title);
    $stmt_find_book->execute();
    $result_find_book = $stmt_find_book->get_result();

    $available_book_id = null;
    if ($result_find_book->num_rows > 0) {
        $row = $result_find_book->fetch_assoc();
        $available_book_id = $row['ID_LIBRO'];
    }
    $stmt_find_book->close();

    if (is_null($available_book_id)) {
        throw new Exception("No hay ejemplares disponibles para este libro en este momento.");
    }

    // 2. Insertar en la tabla RESERVA
    // Generar un nuevo N_RESERVA (debería ser AUTO_INCREMENT en la DB)
    // Asumimos N_RESERVA es AUTO_INCREMENT, si no, necesitarías generar uno.
    $stmt_reserve = $conexion->prepare("INSERT INTO RESERVA (FECHA_RESERVA, ESTADO, CORREO) VALUES (CURDATE(), 'Espera', ?)");
    $stmt_reserve->bind_param("s", $user_email);
    $stmt_reserve->execute();

    $new_n_reserva = $conexion->insert_id; // Obtener el ID de la reserva recién creada
    $stmt_reserve->close();

    if ($new_n_reserva === 0) { // Si insert_id es 0, la inserción falló o no es AUTO_INCREMENT
        throw new Exception("Error al crear la reserva (no se generó N_RESERVA).");
    }

    // 3. Insertar en la tabla RESERVADO
    $stmt_reserved_book = $conexion->prepare("INSERT INTO RESERVADO (N_RESERVA, ID_LIBRO) VALUES (?, ?)");
    $stmt_reserved_book->bind_param("is", $new_n_reserva, $available_book_id);
    $stmt_reserved_book->execute();
    $stmt_reserved_book->close();

    $conexion->commit(); // Confirmar la transacción
    echo json_encode(['success' => true, 'message' => 'Solicitud de préstamo registrada.']);

} catch (Exception $e) {
    $conexion->rollback(); // Revertir la transacción si algo falla
    error_log("Error en solicitud de préstamo: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

mysqli_close($conexion);
?>