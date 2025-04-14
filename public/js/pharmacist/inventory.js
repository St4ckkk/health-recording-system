document.addEventListener('DOMCondtentLoaded', function () {
    const searchInput = document.querySelector('input[placeholder="Search by medicine name or ID..."]');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');

    function filterMedicines() {
        const searchTerm = searchInput.value.toLowerCase();
        const categoryValue = categoryFilter.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();

        document.querySelectorAll('.medicines-table tbody tr').forEach(row => {
            if (row.querySelector('td[colspan]')) return;

            const nameCell = row.querySelector('td:first-child');
            const categoryCell = row.querySelector('td:nth-child(2)');
            const statusCell = row.querySelector('td:nth-child(7)');

            const name = nameCell.textContent.toLowerCase();
            const category = categoryCell.textContent.trim().toLowerCase();
            const status = statusCell.textContent.trim().toLowerCase();

            const matchesSearch = name.includes(searchTerm);
            const matchesCategory = !categoryValue || category.includes(categoryValue);
            const matchesStatus = !statusValue || status.includes(statusValue);

            row.style.display = (matchesSearch && matchesCategory && matchesStatus) ? '' : 'none';
        });
    }

    // Add event listeners
    searchInput.addEventListener('input', filterMedicines);
    categoryFilter.addEventListener('change', filterMedicines);
    statusFilter.addEventListener('change', filterMedicines);

    // Clear filters function
    window.clearFilters = function () {
        searchInput.value = '';
        categoryFilter.value = '';
        statusFilter.value = '';
        filterMedicines();
    }
});

// Function to confirm deletion
function confirmDelete(medicineId) {
    if (confirm('Are you sure you want to delete this medicine?')) {
        window.location.href = `<?= BASE_URL ?>/doctor/deleteMedicine/?id=${medicineId}`;
    }
}

