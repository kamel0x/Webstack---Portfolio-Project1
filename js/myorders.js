
let currentPage = 1;
const itemsPerPage = 1; // Number of items per page
const rows = document.querySelectorAll('tbody tr'); // Select all table rows
const totalPages = Math.ceil(rows.length / itemsPerPage);

function showPage(page) {
    rows.forEach((row, index) => {
        row.style.display = (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) ? 'table-row' : 'none';
    });
    document.querySelector('.page-number').textContent = page;
}

document.querySelector('.prev-page').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
    }
});

document.querySelector('.next-page').addEventListener('click', () => {
    if (currentPage < totalPages) {
        currentPage++;
        showPage(currentPage);
    }
});

// Show the first page on load
showPage(currentPage);
