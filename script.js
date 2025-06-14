document.addEventListener('DOMContentLoaded', function () {
  const booksContainer = document.querySelector('.booksContainer');
  if (!booksContainer) return;

  function addBookToContainer(book) {
    const bookCard = document.createElement('div');
    bookCard.className = 'book-card';
    bookCard.innerHTML = `
      <h3>${book.TITULO}</h3>
      <p><strong>Autor:</strong> ${book.AUTOR}</p>
      <p><strong>Año:</strong> ${book.AÑO}</p>
      <p><strong>Editorial:</strong> ${book.EDITORIAL}</p>
      <p><strong>Ejemplares disponibles:</strong> ${book.cantidad}</p>
    `;
    booksContainer.appendChild(bookCard);
  }

  fetch('get_books.php')
    .then(response => response.json())
    .then(books => {
      books.forEach(addBookToContainer);
    })
    .catch(error => {
      console.error('Error al cargar libros:', error);
      booksContainer.innerHTML = '<p style="color:red;">No se pudieron cargar los libros.</p>';
    });
});
