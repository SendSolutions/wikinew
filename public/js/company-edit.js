
document.addEventListener('DOMContentLoaded', function() {
    // Copy-button
    document.getElementById('copyButton').addEventListener('click', function() {
        const linkInput = document.getElementById('registrationLink');
        linkInput.select();
        document.execCommand('copy');
        this.textContent = 'Copiado!';
        setTimeout(() => this.textContent = 'Copiar Link', 2000);
    });

    // Filtros
    const filterSelect = document.getElementById('userFilter');
    const searchInput  = document.getElementById('userSearch');
    const userRows     = Array.from(document.querySelectorAll('#usersList .user-row'));

    function applyUserFilters() {
        const filter = filterSelect.value;
        const term   = searchInput.value.trim().toLowerCase();

        userRows.forEach(row => {
            const checkbox = row.querySelector('input[type=checkbox]');
            const name     = row.querySelector('.user-name').textContent.toLowerCase();
            const isChecked= checkbox.checked;

            // condição de filtro status
            let okStatus = (filter === 'all')
                        || (filter === 'selected'   && isChecked)
                        || (filter === 'unselected' && !isChecked);

            // condição de busca por nome
            let okSearch = name.includes(term);

            row.style.display = (okStatus && okSearch) ? '' : 'none';
        });
    }

    filterSelect.addEventListener('change', applyUserFilters);
    searchInput.addEventListener('input', applyUserFilters);

    // já aplica no carregamento
    applyUserFilters();
});
