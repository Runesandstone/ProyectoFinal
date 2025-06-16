
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca CETI</title>
    <link href="css/styles.css" rel="stylesheet">
    <script type="module" src="scripts/footer.js"></script>
</head>
<body>
<header class="header">
    <div class="logo-group">
            <img src="img/logo.png" alt ="Logo CETI" class="logo-img">
            <h2 class="logo">Biblioteca CETI</h2>
    </div>
    <nav class="buttons-barra">
        <a href="index.php">Inicio</a>
        <a href="libros.php">Libros</a>

        <?php if (isset($_SESSION['CORREO'])): ?>
            <a href="logout.php">Cerrar sesión</a>
            <a href="usuario.php"><?php echo htmlspecialchars($_SESSION['NOMBRE']); ?></a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="registro.php">Registrar</a>
        <?php endif; ?>
    </nav>
</header>


    <section class="from-register">
        <h2>Crea tu Cuenta</h2>
        <form method="POST" action="sendRegistro.php">
            <input class="controls-register" type="text" name="NOMBRE" placeholder="Ingrese su nombre" required>
            <input class="controls-register" type="email" name="CORREO" id="correo" placeholder="Ingrese su correo" required>
            <input class="controls-register" type="password" name="CONTRASENA" placeholder="Ingresa tu Contraseña" required>
            <label for="fechaNacimiento">Fecha de nacimiento:</label>
            <input class="controls-register" type="date" id="fechaNacimiento" name="FECHA_NAC" required>
            <input class="controls-register" type="text" name="TELEFONO" placeholder="Ingrese su telefono" required>
            <input class="buttons" type="submit" name="registrar" value="Registrar">
        </form>
        <p>Estoy de acuerdo con <a href="#">Términos y condiciones</a></p>
        <p><a href="login.php">¿Ya tienes cuenta?</a></p>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-row" id="footer-row">

            </div>
        </div>
        <div class="footer-end">
            <p>© 2025 CETI Academy Library. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>