<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><!--es para poner comas y comillas-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca CETI</title>
    <script type="module" src="scripts/shadow.js"></script> <!-- Le da apariencia al menu -->
    <script type="module" src="scripts/footer.js"></script>
    <script type="module" src="scripts/conseguirDetalles.js"></script>
    <link rel="preload" href="css/styles.css" as="style"><!--Este es para poder cargar mas rapido la pagina y para forzar a cargar las paginad de styles-->
    <link href="css/styles.css" rel="stylesheet"><!--Con este estamos llamando a la carpeta de styles de css-->
    <link href="css/libros.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
</head>
<body>
    <header class="header" id ="header">
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

     
    <section class="explau-section">
        <div>
            <h1>Nuestra colección de libros</h2>
            <p>Explora, busca y reserva libros de nuestra extensa biblioteca</p>
        </div>
    </section>
    

    <!-- a partir de ahora sera el filtro de libros -->
    <section class="search-section">
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Buscar por título...">
            <button id="searchButton">
                <img class=imglupa src="img/glass.png" alt="🔎">
            </button>
        </div>

        <div class="filter-container">
            <select id="categoryFilter">
            <option value="">Todas las categorías</option>
            <option value="QC">Física</option>
            <option value="PQ">Literaturas románticas</option>
            <option value="QH">Historial natural</option>
            <option value="GV">Ocio. Deportes.</option>
            <option value="T">Tecnología</option>
            <option value="QP" >Fisiología</option>
            <option value="TP">Ingeniería Química</option>
            <option value="TK">Ingeniería Electrónica</option>
            <option value="TA">Ingeniería Civil</option>
            <option value="HF">Comercio y Finanzas</option>
            <option value="QA">Ciencias de la Computación</option>
            <option value="TL">Ingeniería Automotriz</option>
            <option value="LC">Educacion</option>
            <option value="QD">Química</option>
            </select>
        </div>
        
    </section>
    

    <section class = "book-section">
        <div class="booksContainer">
            <div class="book-card">
                <h3 class=data-title>Título del Libro</h3>
                <p><strong>Autor:</strong> Nombre del Autor</p>
                <p><strong>Año:</strong> 2024</p>
                <p><strong>Editorial:</strong> Editorial X</p>
                <p><strong>Ejemplares disponibles:</strong> 3</p>
            </div>
        </div>
        <script src="scripts/conseguirLibros.js"></script>
    </section>
    
    <div id="bookDetailModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2 id="modalBookTitle"></h2>
            <p><strong>Autor:</strong> <span id="modalBookAuthor"></span></p>
            <p><strong>Año:</strong> <span id="modalBookYear"></span></p>
            <p><strong>ISBN:</strong> <span id="modalBookISBN"></span></p>
            <p><strong>Editorial:</strong> <span id="modalBookEditorial"></span></p>
            <p><strong>Categoría:</strong> <span id="modalBookCategory"></span></p>
            <p><strong>Descripción:</strong> <span id="modalBookDescription"></span></p>

            <hr> <p><strong>Disponibilidad para reserva:</strong> <span id="modalBookAvailability"></span></p>

            <div class="modal-actions">
                <button id="requestLoanBtn" class="action-button primary-button" style="display: none;">Pedir Prestado</button>
                <button id="deleteBookBtn" class="action-button danger-button" style="display: none;">Borrar Libro</button>
            </div>

            <p id="modalMessage" class="message" style="display: none;"></p>
        </div>
    </div>
    

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