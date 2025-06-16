// Ejemplo de cómo buscar un libro específico en JavaScript
function getBookDetails(tituloLibro) {
    console.log('Buscando detalles del libro:', tituloLibro);
    const url = `php/get_book_details.php?titulo=${encodeURIComponent(tituloLibro)}`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error || !data.TITULO) {
                console.error('Error desde el servidor:', data.error);
                displayModalMessage('Libro no encontrado o error al obtener los detalles.', 'error');
                return;
            }

            // Mostrar los detalles en el modal
            document.getElementById('modalBookTitle').textContent = data.TITULO;
            document.getElementById('modalBookAuthor').textContent = data.AUTOR || 'Autor no disponible';
            document.getElementById('modalBookYear').textContent = data.AÑO || 'Año no disponible';
            document.getElementById('modalBookISBN').textContent = data.ISBN || 'ISBN no disponible';
            document.getElementById('modalBookEditorial').textContent = data.EDITORIAL || 'Editorial no disponible';
            document.getElementById('modalBookCategory').textContent = data.CATEGORIA || 'Categoría no disponible';
            document.getElementById('modalBookDescription').textContent = data.DESCRIPCION || 'Descripción no disponible';
            document.getElementById('modalBookAvailability').textContent = data.DisponibleParaReserva ? 'Sí' : 'No';
            document.getElementById('requestLoanBtn').dataset.bookTitle = data.TITULO;
            document.getElementById('deleteBookBtn').dataset.bookTitle = data.TITULO;

            // Mostrar el modal
            document.getElementById('bookDetailModal').style.display = 'block';
        })
        .catch(error => {
            console.error('Fallo al obtener detalles:', error);
            displayModalMessage('Error de red o del servidor al obtener los detalles.', 'error');
        });
}


document.addEventListener('DOMContentLoaded', function () {
    const booksContainer = document.querySelector('.booksContainer');

    // --- Referencias a elementos del Modal ---
    const bookDetailModal = document.getElementById('bookDetailModal');
    bookDetailModal.style.display = 'none'; // Asegúrate de que el modal esté oculto al inicio
    const closeButton = document.querySelector('.close-button');
    const requestLoanBtn = document.getElementById('requestLoanBtn');
    const deleteBookBtn = document.getElementById('deleteBookBtn');
    const modalMessage = document.getElementById('modalMessage');

    // --- SIMULACIÓN DE ROL DE USUARIO (Esto debe venir de PHP en un entorno real) ---
    // Esto es un placeholder. En tu header.php o en una llamada AJAX a un endpoint de usuario,
    // deberías obtener si el usuario es admin o no.
    let isAdminUser = false; // Por defecto no es admin
    let currentUserEmail = ''; // Por defecto, ningún usuario logueado o email vacío

    // EJEMPLO: Esto debería ser una llamada AJAX a un script PHP que te diga
    // si el usuario está logueado y cuál es su rol.
    fetch('./php/get_user_status.php') // Crea este archivo PHP para devolver { isLoggedIn: true, isAdmin: true, email: 'user@example.com' }
        .then(response => response.json())
        .then(userStatus => {
            if (userStatus.isLoggedIn) {
                currentUserEmail = userStatus.email;
                isAdminUser = userStatus.isAdmin;
            }
            console.log(`Usuario logueado: ${currentUserEmail}, Rol: ${isAdminUser ? 'Administrador' : 'Usuario normal'}`);
        })
        .catch(error => console.error('Error al obtener estado del usuario:', error));
    // --- FIN SIMULACIÓN ---


    if (!booksContainer) {
        console.error("Error: 'booksContainer' element not found in the DOM. Please check your HTML.");
        return;
    }


    // --- Manejo del botón de Pedir Prestado ---
    requestLoanBtn.addEventListener('click', function() {
        const bookTitleToRequest = this.dataset.bookTitle;
        if (!bookTitleToRequest || !currentUserEmail) {
            displayModalMessage('Error: Información de libro o usuario no disponible.', 'error');
            return;
        }

        // Llamar a un endpoint PHP para procesar la solicitud de préstamo
        fetch('php/request_loan.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                titulo: bookTitleToRequest,
                userEmail: currentUserEmail
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayModalMessage('Solicitud de préstamo enviada exitosamente!', 'success');
                // Opcional: Cerrar el modal o actualizar la disponibilidad después de un tiempo
                setTimeout(() => {
                    bookDetailModal.style.display = 'none';
                    fetchAndRenderBooks(); // Refresca la lista de libros por si cambia la disponibilidad
                }, 2000);
            } else {
                displayModalMessage(data.error || 'Error al procesar la solicitud de préstamo.', 'error');
            }
        })
        .catch(error => {
            console.error('Error en la solicitud de préstamo:', error);
            displayModalMessage('Error de red al solicitar préstamo.', 'error');
        });
    });

    // --- Manejo del botón de Borrar Libro (Solo Admin) ---
    deleteBookBtn.addEventListener('click', function() {
        if (!isAdminUser) { // Doble verificación por seguridad
            displayModalMessage('No tienes permisos para borrar libros.', 'error');
            return;
        }

        const bookTitleToDelete = this.dataset.bookTitle;
        if (!bookTitleToDelete) {
            displayModalMessage('Error: No se pudo obtener el título del libro a borrar.', 'error');
            return;
        }

        if (!confirm(`¿Estás seguro de que quieres borrar el libro "${bookTitleToDelete}"? Esta acción es irreversible.`)) {
            return; // El usuario canceló
        }

        // Llamar a un endpoint PHP para borrar el libro
        fetch('php/delete_book.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                titulo: bookTitleToDelete
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayModalMessage(data.message, 'success');
                // Cerrar el modal y refrescar la lista de libros
                setTimeout(() => {
                    bookDetailModal.style.display = 'none';
                    fetchAndRenderBooks();
                }, 2000);
            } else {
                displayModalMessage(data.error || 'Error al borrar el libro.', 'error');
            }
        })
        .catch(error => {
            console.error('Error al borrar el libro:', error);
            displayModalMessage('Error de red al borrar el libro.', 'error');
        });
    });


    // --- Función para mostrar mensajes en el modal ---
    function displayModalMessage(msg, type) {
        modalMessage.textContent = msg;
        modalMessage.className = `message ${type}`; // Añade clase 'success', 'error', 'info'
        modalMessage.style.display = 'block';
    }

    // Function to show book details
function showBookDetails(bookTitle) {
    // Assuming you have logic here to fetch book details based on bookTitle
    getBookDetails(bookTitle);
    // For demonstration, let's mock some book data
    const bookDetails = {
        title: bookTitle,
        author: "Ejemplo Autor",
        year: "2023",
        isbn: "123-456-789",
        editorial: "Editorial Ejemplo",
        category: "QA",
        description: "Una descripción de ejemplo del libro.",
        availability: 5 // Example availability
    };

    // Populate modal with book details
    document.getElementById('modalBookTitle').textContent = bookDetails.title;
    document.getElementById('modalBookAuthor').textContent = bookDetails.author;
    document.getElementById('modalBookYear').textContent = bookDetails.year;
    document.getElementById('modalBookISBN').textContent = bookDetails.isbn;
    document.getElementById('modalBookEditorial').textContent = bookDetails.editorial;
    document.getElementById('modalBookCategory').textContent = bookDetails.category;
    document.getElementById('modalBookDescription').textContent = bookDetails.description;
    document.getElementById('modalBookAvailability').textContent = bookDetails.availability;

    // Get button elements
    const requestLoanBtn = document.getElementById('requestLoanBtn');
    const deleteBookBtn = document.getElementById('deleteBookBtn');

    // Hide buttons by default
    requestLoanBtn.style.display = 'none';
    deleteBookBtn.style.display = 'none';

    // Fetch session status
    fetch('./php/get_user_status.php') // Path to your new PHP file
        .then(response => response.json())
        .then(data => {
            console.log('Session status:', data);
            if (data.isLoggedIn) {
                // If logged in, show "Pedir Prestado" button
                requestLoanBtn.style.display = 'inline-block'; // Or 'block', depending on your CSS needs

                if (data.isAdmin) {
                    // If also admin, show "Borrar Libro" button
                    deleteBookBtn.style.display = 'inline-block'; // Or 'block'
                }
            }
        })
        .catch(error => {
            console.error('Error fetching session status:', error);
        });

    // Show the modal
    const bookDetailModal = document.getElementById('bookDetailModal');
    bookDetailModal.style.display = 'block';
}



// Event listener for closing the modal
document.querySelector('.close-button').addEventListener('click', function() {
    document.getElementById('bookDetailModal').style.display = 'none';
});

// Event listener for clicks outside the modal to close it
window.addEventListener('click', function(event) {
    const bookDetailModal = document.getElementById('bookDetailModal');
    if (event.target === bookDetailModal) {
        bookDetailModal.style.display = 'none';
    }
});

booksContainer.addEventListener('click', function(event) {
    const bookElement = event.target.closest('.book-card');
    if (bookElement && booksContainer.contains(bookElement)) {
        let bookTitle = bookElement.dataset.title || bookElement.getAttribute('data-title');
        console.log('Click event on booksContainer:', event);
        if (!bookTitle) {
            const titleElem = bookElement.querySelector('.data-title');
            if (titleElem) {
                bookTitle = titleElem.textContent.trim();
            }
        }
        if (bookTitle) {
            showBookDetails(bookTitle);
        } else {
            console.error('Error: El título del libro no está definido en el elemento seleccionado. Asegúrate de que cada .book tenga el atributo data-title.');
        }
    }
});



    // --- Cerrar el Modal ---
    closeButton.addEventListener('click', () => {
        bookDetailModal.style.display = 'none';
    });

    // Cerrar el modal al hacer clic fuera de su contenido
    window.addEventListener('click', (event) => {
        if (event.target === bookDetailModal) {
            bookDetailModal.style.display = 'none';
        }
    });
});