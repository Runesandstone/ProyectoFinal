<?php
session_start();
header('Content-Type: application/json');

$response = [
    'isLoggedIn' => false,
    'isAdmin' => false,
    'email' => ''
];

if (isset($_SESSION['CORREO'])) {
    $response['isLoggedIn'] = true;
    $response['email'] = $_SESSION['CORREO'];
    // Verifica si el rol existe y si es 'admin'
    if (isset($_SESSION['ROL']) && $_SESSION['ROL'] === 'Admin') {
        $response['isAdmin'] = true;
    }
}
echo json_encode($response);
?>