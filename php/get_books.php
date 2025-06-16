<?php
include '../conexion.php';

// El resultado de la consulta se devolverá en formato JSON
header('Content-Type: application/json');

// Llamada al procedimiento almacenado para obtener los libros disponibles
$sql = "CALL ConseguirLibrosDisponibles()";
$result = mysqli_query($conexion, $sql);

// Inicializar un array para almacenar los libros
$libros = [];

// Verificar si la consulta se ejecutó correctamente y si hay resultados
if ($result) {
    // Recorrer los resultados y agregarlos al array de libros
    while ($row = mysqli_fetch_assoc($result)) {
        $libros[] = $row;
    }
    echo json_encode($libros);
} else {
    echo json_encode([]);
}
?>