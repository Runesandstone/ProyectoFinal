document.addEventListener('DOMContentLoaded', function () {
  const booksContainer = document.querySelector('.booksContainer');
  const searchInput = document.getElementById('searchInput');
  const categoryFilter = document.getElementById('categoryFilter');
  let allBooks = [];

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

  function renderBooks(books) {
    booksContainer.innerHTML = '';
    if (books.length === 0) {
      booksContainer.innerHTML = '<p>No se encontraron libros.</p>';
      return;
    }
    books.forEach(addBookToContainer);
  }

  function filterBooks() {
    const searchTerm = searchInput.value.toLowerCase(); 
    const category = categoryFilter.value;
    const filtered = allBooks.filter(book => {
      const matchesTitle = book.TITULO.toLowerCase().includes(searchTerm);
      const matchesCategory = category === '' || (book.ID_CATEGORIA && book.ID_CATEGORIA === category); 
      return matchesTitle && matchesCategory;
    });
    renderBooks(filtered);
  }

  fetch('get_books.php')
    .then(response => response.json())
    .then(books => {
      allBooks = books;
      renderBooks(allBooks);
    })
    .catch(error => {
      console.error('Error al cargar libros:', error);
      booksContainer.innerHTML = '<p style="color:red;">No se pudieron cargar los libros.</p>';
    });

  searchInput.addEventListener('input', filterBooks);
  categoryFilter.addEventListener('change', filterBooks);
});
