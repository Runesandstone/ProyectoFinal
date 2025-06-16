<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['CORREO'])) {
    header("Location: login.php"); // Adjust to your login page path
    exit;
}

$user_email = $_SESSION['CORREO'];
$user_role = $_SESSION['ROL'] ?? 'user'; // Default to 'user' if role not set
$is_admin = ($user_role === 'Admin');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil de Usuario - Biblioteca</title>
    <link rel="stylesheet" href="css/styles.css"> <style>
        /* Basic styles for usuario.php - you can integrate this into your main styles.css */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 960px; margin: 20px auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #3a6351; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        p { line-height: 1.6; color: #555; }
        .user-info p strong { color: #333; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-top: 30px; margin-bottom: 15px; }
        .data-list { list-style: none; padding: 0; }
        .data-list li { background-color: #f9f9f9; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; }
        .data-list li span { color: #333; font-weight: bold; }
        .no-data-message { color: #777; font-style: italic; text-align: center; margin-top: 20px; }
        .admin-section { background-color: #e6ffe6; border: 1px dashed #3a6351; padding: 20px; margin-top: 30px; border-radius: 8px; }
        .admin-section h2 { color: #2b4d3f; border-bottom-color: #c9e6c9; }
        .admin-buttons { text-align: center; margin-top: 20px; }
        .admin-buttons button, .admin-buttons a {
            display: inline-block; padding: 10px 20px; margin: 0 10px;
            background-color: #3a6351; color: white; border: none;
            border-radius: 5px; cursor: pointer; text-decoration: none;
            font-size: 1em; transition: background-color 0.2s;
        }
        .admin-buttons button:hover, .admin-buttons a:hover { background-color: #2b4d3f; }

        /* Form for inserting new book */
        .book-form { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .book-form label { font-weight: bold; color: #555; }
        .book-form input[type="text"],
        .book-form input[type="number"],
        .book-form textarea,
        .book-form select {
            width: calc(100% - 20px); /* Adjust for padding */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box; /* Include padding in width */
        }
        .book-form textarea { resize: vertical; min-height: 80px; }
        .book-form button[type="submit"] {
            grid-column: 1 / -1; /* Span across both columns */
            background-color: #3a6351;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.2s;
        }
        .book-form button[type="submit"]:hover { background-color: #2b4d3f; }
        .message { padding: 10px; margin-top: 15px; border-radius: 5px; text-align: center; font-weight: bold; }
        .message.success { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
        .message.error { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        .header {
            padding: 20px;
            height: 80px;
        }
        .t1 {
            text-align: center;
            color: #3a6351;
            margin-top: 50px;
        }

    </style>
</head>
<body>
    <div class="container">
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
        <h1 class = "t1">Bienvenido, <?php echo htmlspecialchars($user_email); ?></h1>

        <div class="user-info">
            <h2>Mi Información</h2>
            <p><strong>Correo:</strong> <?php echo htmlspecialchars($user_email); ?></p>
            <p><strong>Rol:</strong> <?php echo htmlspecialchars($user_role); ?></p>
        </div>

        <div class="section-header">
            <h2>Mis Libros Prestados</h2>
        </div>
        <ul id="borrowedBooksList" class="data-list">
            <li class="no-data-message">Cargando libros prestados...</li>
        </ul>

        <div class="section-header">
            <h2>Mis Reservas Activas</h2>
        </div>
        <ul id="reservationsList" class="data-list">
            <li class="no-data-message">Cargando reservas...</li>
        </ul>

        <?php if ($is_admin): ?>
            <div class="admin-section">
                <h2>Funcionalidades de Administrador</h2>

                <h3>Insertar Nuevo Libro</h3>
                <form id="insertBookForm" class="book-form">
                    <label for="id_libro">ID Libro:</label>
                    <input type="text" id="id_libro" name="id_libro" required maxlength="10">

                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required maxlength="200">

                    <label for="autor">Autor:</label>
                    <input type="text" id="autor" name="autor" required maxlength="50">

                    <label for="anio">Año:</label>
                    <input type="number" id="anio" name="anio" required min="1000" max="<?php echo date('Y'); ?>">

                    <label for="isbn">ISBN:</label>
                    <input type="text" id="isbn" name="isbn" required maxlength="13">

                    <label for="editorial">Editorial:</label>
                    <input type="text" id="editorial" name="editorial" required maxlength="50">

                    <label for="status">Estado Inicial:</label>
                    <select id="status" name="status" required>
                        <option value="Disponible">Disponible</option>
                        <option value="Prestado">Prestado</option>
                    </select>

                    <label for="id_categoria">ID Categoría:</label>
                    <input type="text" id="id_categoria" name="id_categoria" required maxlength="2">

                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" maxlength="255"></textarea>

                    <button type="submit">Insertar Libro</button>
                    <div id="insertMessage" class="message" style="display:none;"></div>
                </form>

                <div class="admin-buttons">
                    <a href="log.php">Ir al Log de Actividad</a> </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userEmail = "<?php echo htmlspecialchars($user_email); ?>";
            const isAdmin = <?php echo json_encode($is_admin); ?>;

            const borrowedBooksList = document.getElementById('borrowedBooksList');
            const reservationsList = document.getElementById('reservationsList');

            // --- Function to fetch and display borrowed books ---
            function fetchBorrowedBooks() {
                borrowedBooksList.innerHTML = '<li class="no-data-message">Cargando libros prestados...</li>';
                fetch(`php/get_user_borrowed_books.php?email=${encodeURIComponent(userEmail)}`)
                    .then(response => response.json())
                    .then(data => {
                        borrowedBooksList.innerHTML = '';
                        if (data.error) {
                            borrowedBooksList.innerHTML = `<li class="no-data-message error">Error: ${data.error}</li>`;
                            console.error("Error fetching borrowed books:", data.error);
                            return;
                        }
                        if (data.length === 0) {
                            borrowedBooksList.innerHTML = '<li class="no-data-message">No tienes libros prestados actualmente.</li>';
                        } else {
                            data.forEach(book => {
                                const listItem = document.createElement('li');
                                listItem.innerHTML = `
                                    <span>${book.TITULO}</span>
                                    <span>Autor: ${book.AUTOR}</span>
                                    <span>Préstamo: ${book.FECHA_PRESTAMO}</span>
                                `;
                                borrowedBooksList.appendChild(listItem);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar libros prestados:', error);
                        borrowedBooksList.innerHTML = '<li class="no-data-message error">Error al cargar libros prestados.</li>';
                    });
            }

            // --- Function to fetch and display reservations ---
            function fetchReservations() {
                reservationsList.innerHTML = '<li class="no-data-message">Cargando reservas...</li>';
                fetch(`php/get_user_reservations.php?email=${encodeURIComponent(userEmail)}`)
                    .then(response => response.json())
                    .then(data => {
                        reservationsList.innerHTML = '';
                        if (data.error) {
                            reservationsList.innerHTML = `<li class="no-data-message error">Error: ${data.error}</li>`;
                            console.error("Error fetching reservations:", data.error);
                            return;
                        }
                        if (data.length === 0) {
                            reservationsList.innerHTML = '<li class="no-data-message">No tienes reservas activas.</li>';
                        } else {
                            data.forEach(reservation => {
                                const listItem = document.createElement('li');
                                listItem.innerHTML = `
                                    <span>${reservation.TITULO}</span>
                                    <span>Autor: ${reservation.AUTOR}</span>
                                    <span>Fecha Reserva: ${reservation.FECHA_RESERVA}</span>
                                    <span>Estado: ${reservation.ESTADO}</span>
                                    <button class="cancel-reservation" data-id="${reservation.N_RESERVA}">Cancelar Reserva</button>
                                `;
                                reservationsList.appendChild(listItem);
                            });
                            addCancelReservationListeners();
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar reservas:', error);
                        reservationsList.innerHTML = '<li class="no-data-message error">Error al cargar reservas.</li>';
                    });
            }

            function addCancelReservationListeners() {
                document.querySelectorAll('.cancel-reservation').forEach(button => {
                    button.addEventListener('click', function() {
                        const reservationId = this.dataset.id;
                        if (!reservationId) {
                            displayModalMessage('Error: No se pudo obtener el ID de la reserva.', 'error');
                            return;
                        }

                        if (!confirm(`¿Estás seguro de que quieres cancelar la reserva #${reservationId}?`)) {
                            return; // User cancelled
                        }

                        fetch('php/cancel_reservation.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                n_reserva: reservationId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                displayModalMessage(data.message, 'success');
                                // Refresh reservations list after successful cancellation
                                fetchReservations();
                            } else {
                                displayModalMessage(data.error || 'Error desconocido al cancelar la reserva.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error al cancelar la reserva:', error);
                            displayModalMessage('Error de red al cancelar la reserva.', 'error');
                        });
                    });
                });
            }

            // --- Admin: Handle Insert New Book Form ---
            if (isAdmin) {
                console.log("Usuario es administrador, habilitando funcionalidades de inserción de libros.");
                const insertBookForm = document.getElementById('insertBookForm');
                const insertMessage = document.getElementById('insertMessage');

                insertBookForm.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent default form submission

                    const formData = new FormData(insertBookForm);
                    const bookData = {};
                    formData.forEach((value, key) => {
                        bookData[key] = value;
                    });

                    // Convert year to integer
                    bookData.anio = parseInt(bookData.anio);

                    fetch('php/insert_book.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(bookData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            insertMessage.textContent = data.message;
                            insertMessage.className = 'message success';
                            insertBookForm.reset(); // Clear the form
                        } else {
                            insertMessage.textContent = data.error || 'Error desconocido al insertar el libro.';
                            insertMessage.className = 'message error';
                        }
                        insertMessage.style.display = 'block';
                        setTimeout(() => {
                            insertMessage.style.display = 'none'; // Hide message after a few seconds
                        }, 5000);
                    })
                    .catch(error => {
                        console.error('Error al insertar el libro:', error);
                        insertMessage.textContent = 'Error de red al insertar el libro.';
                        insertMessage.className = 'message error';
                        insertMessage.style.display = 'block';
                        setTimeout(() => {
                            insertMessage.style.display = 'none';
                        }, 5000);
                    });
                });
            }

            // Initial data load for user's sections
            fetchBorrowedBooks();
            fetchReservations();
        });
    </script>
</body>
</html>