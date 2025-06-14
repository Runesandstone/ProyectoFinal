<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8"><!--es para poner comas y comillas-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca CETI</title>
    <link rel="preload" href="css/styles.css" as="styles"><!--Este es para poder cargar mas rapido la pagina y para forzar a cargar las paginad de styles-->
    <link href="css/styles.css" rel="stylesheet"><!--Con este estamos llamando a la carpeta de styles de css-->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

</head>
<body>
<header class="header">
    <h2 class="logo">Biblioteca CETI</h2>
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

   <section>
    <h1>Welcome to CETI Academy library</h1>
    <p>Descubre, aprende y crezca de libros y recursos</p>
    <a href="libros.php">
        <button>Buscar Libros</button>
    </a>
    <a href="login.php">
        <button>Unirse ahora</button>
        </a>
   </section>
        <section>
            <section>
                        <!--
                category: Document
                tags: [read, dictionary, magazine, library, booklet, novel]
                version: "1.50"
                unicode: "efc5"
                -->
                <svg
                xmlns="http://www.w3.org/2000/svg"
                width="56"
                height="56"
                viewBox="0 0 24 24"
                fill="none"
                stroke="#1b4b23"
                stroke-width="2.25"
                stroke-linecap="round"
                stroke-linejoin="round"
                >
                <path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z" />
                <path d="M19 16h-12a2 2 0 0 0 -2 2" />
                <path d="M9 8h6" />
                </svg>
                <h3>Toda la colección</h3>
                <P>Access thousands of books across various disciplines and interests.</P>
            </section>

            <section>
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
                <h3>Digital Resources</h3>
                <p>Explore our e-books, journals, and online research materials.</p>
            </section>
    
            <section>
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
                <h3>Community</h3>
                <p>Join book clubs, study groups, and literary events.</p>
            </section>
        </section>
    </main>

    <section>
        <h2>About Our Library</h2>
        <p>The CETI Academy Library is dedicated to supporting the academic and personal growth of our students. Our mission is to provide access to quality resources, foster a love for reading, and create a collaborative learning environment.

        With a user-friendly online system, students can easily browse our collection, reserve books, and manage their borrowing history. Our library staff is always available to assist with research needs and recommendations.
        </p>
        <img src="img/fongo2.jpeg" alt="HOla">
    </section>


<!-------------------footer------------------------------------->


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

