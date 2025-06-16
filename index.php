<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><!--es para poner comas y comillas-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca CETI</title>
    <link href="css/styles.css" rel="stylesheet"><!--Con este estamos llamando a la carpeta de styles de css-->
    <script type="module" src="scripts/footer.js"></script>
    <script type="module" src="scripts/shadow.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
</head>
<body>
    <header class="header" id = "header">
        <div class="logo-group">
            <img src="img/logo.png" alt ="Logo CETI" class="logo-img">
            <h2 class="logo">Biblioteca CETI</h2>
        </div>
        <nav class="buttons-barra">
            <a href="index.php" class = "menu-button">Inicio</a>
            <a href="libros.php" class = "menu-button">Libros</a>

            <?php if (isset($_SESSION['CORREO'])): ?>
                <a href="logout.php" class = "menu-button">Cerrar sesión</a>
                <a href="usuario.php" class = "menu-button"><?php echo htmlspecialchars($_SESSION['NOMBRE']); ?></a>
            <?php else: ?>
                <a href="login.php" class = "menu-button">Login</a>
                <a href="registro.php" class = "menu-button">Registrar</a>
            <?php endif; ?>
        </nav>
    </header>


    <section class="hero-section" id = "hero-section">
        <div class = hero-content>
            <h1>Bienvenido a la Libreria Academica CETI</h1>
            <p>Descubra, aprenda y crezca de libros y recursos</p>

            <div class="hero-buttons-container">
                <a href="libros.php">
                    <button class = "hero-button">Buscar Libros</button>
                </a>
                <a href="registro.php">
                    <button class = "hero-button join-now">Unirse ahora</button>
                </a>
            </div>
        </div>
    </section>

    <section class= features id = "features">
            <div class="feature-card">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                width="56"
                height="56"
                viewBox="0 0 24 24"
                fill="none"
                stroke="#2b7337"
                stroke-width="2.25"
                stroke-linecap="round"
                stroke-linejoin="round"
                >
                <path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z" />
                <path d="M19 16h-12a2 2 0 0 0 -2 2" />
                <path d="M9 8h6" />
                </svg>
                <h3>Toda la colección</h3>
                <P>Acceda a miles de libros sobre diversas disciplinas e intereses.</P>
            </div>

            <div class="feature-card">
                        <!--
                category: Devices
                tags: [workstation, mac, notebook, portable, screen, computer]
                version: "1.2"
                unicode: "eb64"
                -->
                <svg
                xmlns="http://www.w3.org/2000/svg"
                width="56"
                height="56"
                viewBox="0 0 24 24"
                fill="none"
                stroke="#2b7337"
                stroke-width="2.25"
                stroke-linecap="round"
                stroke-linejoin="round"
                >
                <path d="M3 19l18 0" />
                <path d="M5 6m0 1a1 1 0 0 1 1 -1h12a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-12a1 1 0 0 1 -1 -1z" />
                </svg>
                <h3>Recursos Digitales</h3>
                <p>Explore nuestros libros electrónicos, revistas y materiales de investigación disponibles para reservar.</p>
            </div>

            <div class="feature-card">
                    <!--
                tags: [people, persons, accounts]
                version: "1.7"
                unicode: "ebf2"
                category: System
                -->
                <svg
                xmlns="http://www.w3.org/2000/svg"
                width="56"
                height="56"
                viewBox="0 0 24 24"
                fill="none"
                stroke="#207e2f"
                stroke-width="2.25"
                stroke-linecap="round"
                stroke-linejoin="round"
                >
                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                </svg>
                <h3>Comunidad</h3>
                <p>Únase a clubes de lectura, grupos de estudio y eventos literarios.<br>(Proximamente)</p>
            </div>
    </section>

    <section class="library-info" id = "library-info">
        <div class="libinfo-content">
            <h2>Sobre la Librería</h2>
            <p>La Biblioteca de la Academia CETI se dedica a apoyar el crecimiento académico y personal de nuestros estudiantes.<br>
                Nuestra misión es brindar acceso a recursos de calidad, fomentar el amor por la lectura y crear un ambiente de aprendizaje colaborativo.
                <br>Con un sistema en línea intuitivo, los estudiantes pueden explorar fácilmente nuestra colección, reservar libros y administrar su historial de préstamos.
                <br>Nuestro personal bibliotecario está siempre disponible para atender sus necesidades de investigación y brindar recomendaciones.
            </p>
            <img src="img/fongo2.jpeg" alt="HOla">
        </div>
    </section>


<!-------------------footer------------------------------------->


    <footer class="footer">
        <div class="footer-container">
            <div class="footer-row" id = "footer-row">
            </div>
        </div>

        <div class="footer-end">
        <p>© 2025 CETI Academy Library. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>

