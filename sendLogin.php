<?php
session_start();
include 'conexion.php';

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
var_dump($_POST);

if (isset($_POST['CORREO']) && isset($_POST['CONTRASENA'])) {
    $correo = validate($_POST['CORREO']);
    $contrasena = validate($_POST['CONTRASENA']);

    if (empty($correo)) {
        header("Location: login.php?error=El correo es obligatorio");
        exit();
    } else if (empty($contrasena)) {
        header("Location: login.php?error=La contraseña es obligatoria");
        exit();
    } else {
        $consulta = "SELECT * FROM usuario WHERE CORREO='$correo' AND CONTRASENA='$contrasena'";
        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) === 1) {
            $row = mysqli_fetch_assoc($resultado);
            $_SESSION['CORREO'] = $row['CORREO'];
            $_SESSION['NOMBRE'] = $row['NOMBRE'];
            header("Location: index.php");
            exit();
        } else {
            header("Location: login.php?error=Credenciales incorrectas");
            exit();
        }
    }

} else {
    header("Location: login.php?error=Credenciales incorrectas");
    exit();
}