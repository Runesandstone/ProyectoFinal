<?php
session_start();
include 'conexion.php';

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//var_dump($_POST); // Comenta o elimina esto en producción
//comentario para aprender a usar github lol

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
        // En un entorno real, aquí deberías hashear la contraseña antes de compararla con la base de datos
        // $hashed_contrasena = password_hash($contrasena, PASSWORD_DEFAULT); o similar

        // Asegúrate de que 'BuscarLoginUsuario' devuelva también el campo ROL
        $consulta = "CALL BuscarLoginUsuario('$correo', '$contrasena')";
        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) === 1) {
            $row = mysqli_fetch_assoc($resultado);
            $_SESSION['CORREO'] = $row['CORREO'];
            $_SESSION['NOMBRE'] = $row['NOMBRE'];
            // ¡Aquí es donde añades el rol a la sesión!
            $_SESSION['ROL'] = $row['TIPO_USUARIO']; // Asume que el campo en la BD se llama 'ROL'

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
?>

