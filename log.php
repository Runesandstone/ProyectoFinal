<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log de Actividad - Biblioteca CETI</title>
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/log.css" rel="stylesheet">
    <script type="module" src="scripts/footer.js"></script>
</head>
<body>
<?php
session_start();
// Security Check: Only allow admins to view this page
if (!isset($_SESSION['ROL']) || $_SESSION['ROL'] !== 'Admin') {
    header("Location: index.php"); // Redirect non-admins
    exit;
}
?>
<header class="header">
    <div class="logo-group">
        <img src="img/logo.png" alt ="Logo CETI" class="logo-img">
        <h2 class="logo">Biblioteca CETI</h2>
    </div>
    <nav class="buttons-barra">
        <a href="index.php" class="menu-button">Inicio</a>
        <a href="libros.php" class="menu-button">Libros</a>

        <?php if (isset($_SESSION['CORREO'])): ?>
            <a href="logout.php" class="menu-button">Cerrar sesión</a>
            <a href="usuario.php" class="menu-button"><?php echo htmlspecialchars($_SESSION['NOMBRE']); ?></a>
        <?php else: ?>
            <a href="login.php" class="menu-button">Login</a>
            <a href="registro.php" class="menu-button">Registrar</a>
        <?php endif; ?>
    </nav>
</header>

<div class="log-container">
    <h1>Log de Actividad del Sistema</h1>
    <div id="logContent">
        <p class="no-log-message">Cargando log de actividad...</p>
        <!-- Log data will be inserted here by JavaScript -->
    </div>
    <button id="clearLogButton" class="button-clear">Limpiar Log</button>
</div>

<script type="module" src="scripts/log.js"></script>

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