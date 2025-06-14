<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8"><!--es para poner comas y comillas-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca CETI</title>
    <link rel="preload" href="css/styles.css" as="styles"><!--Este es para poder cargar mas rapido la pagina y para forzar a cargar las paginad de styles-->
    <link href="css/styles.css" rel="stylesheet"><!--Con este estamos llamando a la carpeta de styles de css-->
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

<!-- a partir de ahora sera el filtro de libros -->
<input type="text" id="searchInput" placeholder="Buscar por título...">
<select id="categoryFilter">
  <option value="">Todas las categorías</option>
  <option value="QC">Física</option>
  <option value="PQ">Literaturas románticas</option>
  <option value="QH">Historial natural</option>
  <option value="GV">Ocio. Deportes.</option>
  <option value="T">Tecnología</option>
</select>


    <section>
        <h2>Our Book Collection</h2>
        <p>Browse, search, and reserve books from our extensive library</p>
        <div class="booksContainer">
            <div class="book-card">
                <h3>Título del Libro</h3>
                <p><strong>Autor:</strong> Nombre del Autor</p>
                <p><strong>Año:</strong> 2024</p>
                <p><strong>Editorial:</strong> Editorial X</p>
                <p><strong>Ejemplares disponibles:</strong> 3</p>
            </div>
        </div>
        <img src="img/fondo.jpeg" alt="fondo">
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
    <script src="script.js"></script>
</body>
</html>