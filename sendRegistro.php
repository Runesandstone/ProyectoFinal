<?php
include 'conexion.php';

if (isset($_POST['registrar'])) {

    if (
        strlen($_POST['NOMBRE']) >= 1 &&
        strlen($_POST['CORREO']) >= 1 &&
        strlen($_POST['CONTRASENA']) >= 1 &&
        strlen($_POST['FECHA_NAC']) >= 1 &&
        strlen($_POST['TELEFONO']) >= 1
    ) {
        $nombre = trim($_POST['NOMBRE']);
        $correo = trim($_POST['CORREO']);
        $contrasena = trim($_POST['CONTRASENA']);
        $fecha_nac = trim($_POST['FECHA_NAC']);
        $telefono = trim($_POST['TELEFONO']);


            // Calcular edad
        $hoy = new DateTime();
        $nacimiento = new DateTime($fecha_nac);
        $edad = $hoy->diff($nacimiento)->y;


        $consulta = "INSERT INTO usuario (NOMBRE, CORREO, CONTRASENA, EDAD, FECHA_NAC, TELEFONO, TIPO_USUARIO) VALUES ('$nombre', '$correo', '$contrasena','$edad', '$fecha_nac', '$telefono', 'normal')";
        $resultado = mysqli_query($conexion, $consulta); //linea

        if ($resultado) {
            echo "<script>
                alert('Usuario registrado exitosamente');
                window.location.href='index.php';
            </script>";
        } else {
            echo "<script>
                alert('Error al registrar el usuario');
                window.location.href='registro.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Por favor complete todos los campos');
            window.location.href='registro.php';
        </script>";
    }
}
?>