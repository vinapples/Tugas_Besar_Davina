    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.app-data-table').forEach((table) => {
            const labels = Array.from(table.querySelectorAll('thead th'), (cell) => cell.textContent.trim());
            table.querySelectorAll('tbody tr').forEach((row) => {
                row.querySelectorAll('td').forEach((cell, index) => {
                    if (cell.colSpan === 1 && labels[index]) {
                        cell.dataset.label = labels[index];
                    }
                });
            });
        });
    </script>
</body>

</html>
