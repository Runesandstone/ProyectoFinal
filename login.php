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
<?php session_start(); ?>
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


    <section class="from-login">
        <h2>Formulario Login</h2>
        <?php if (isset($_GET['error'])): ?>
            <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <form method="POST" action="sendLogin.php">
            <input class="controls" type="email" name="CORREO" placeholder="Ingrese su correo" required>
            <input class="controls" type="password" name="CONTRASENA" placeholder="Ingresa tu Contraseña" required>
            <input class="buttons" type="submit" name="login" value="Iniciar Sesión">
        </form>
        <p><a href="#">Olvidaste la Contraseña </a></p>

    </section>

     <footer class="footer">
        <div class="container">
            <div class="footer-row" id = "footer-row">
                
            </div>
        </div>

        <div class="footer-end">
        <p>© 2025 CETI Academy Library. All rights reserved.</p>
        </div>
    </footer>
    
    
</body>
</html>