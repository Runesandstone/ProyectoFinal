
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca CETI</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
<header class="header">
    <h2 class="logo">Biblioteca CETI</h2>
    <nav class="buttons-barra">
        <a href="index.php">Inicio</a>
        <a href="libros.html">Libros</a>

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
            <div class="footer-row">
                <div class="footer-links">
                    <h4>CETI Academy Library</h4>
                    <ul>
                        <li><a href="#">Empowering minds through</a></li>
                        <li><a href="#">knowledge and resources.</a></li>
                        <li><a href="#">home</a></li>
                        <li><a href="#">home</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Hours</h4>
                    <ul>
                        <li><a href="#">home</a></li>
                        <li><a href="#">Books</a></li>
                        <li><a href="#">Login</a></li>
                        <li><a href="#">Register</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Contact</h4>
                    <ul>
                        <li><a href="#">123 Academic Ave, Campus</a></li>
                        <li><a href="#">Email: library@ceti.edu</a></li>
                        <li><a href="#">Phone: (123) 456-7890</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#">Monday-Friday: 8am - 8pm</a></li>
                        <li><a href="#">Saturday: 10am - 6pm</a></li>
                        <li><a href="#">Sunday: Closed</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-end">
            <p>© 2025 CETI Academy Library. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>