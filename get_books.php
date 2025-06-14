<?php
include 'conexion.php';

header('Content-Type: application/json');
$sql = " 
SELECT TITULO, AUTOR, AÑO, EDITORIAL, ID_CATEGORIA, COUNT(*) AS cantidad 
FROM libro
GROUP BY TITULO, AUTOR, AÑO, EDITORIAL, ID_CATEGORIA
";
$result = mysqli_query($conexion, $sql);

$libros = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $libros[] = $row;
    }
    echo json_encode($libros);
} else {
    echo json_encode([]);
}
?>
