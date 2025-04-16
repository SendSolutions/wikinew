// public/js/company-edit.js

(function() {
    // FUNÇÃO: copia o link para a área de transferência e dá feedback
    function initCopyButton() {
      const btn       = document.getElementById('copyButton');
      const linkInput = document.getElementById('registrationLink');
      if (!btn || !linkInput) return;
  
      btn.addEventListener('click', function() {
        // Seleciona o texto e copia
        linkInput.select();
        document.execCommand('copy');
  
        // Feedback visual
        btn.textContent = 'Copiado!';
        resetButtonText();
      });
    }
  
    // Reseta o texto do botão após 2 segundos
    function resetButtonText() {
      setTimeout(reset, 2000);
  
      function reset() {
        const btn = document.getElementById('copyButton');
        if (btn) btn.textContent = 'Copiar Link';
      }
    }
  
    // FUNÇÃO: aplica filtros de status e busca por nome
    function applyUserFilters() {
      const filter    = filterSelect.value;
      const term      = searchInput.value.trim().toLowerCase();
  
      userRows.forEach(row => {
        const checkbox  = row.querySelector('input[type=checkbox]');
        const nameText  = row.querySelector('.user-name').textContent.toLowerCase();
        const isChecked = checkbox.checked;
  
        // Filtra por status
        const okStatus = (filter === 'all') ||
                         (filter === 'selected'   && isChecked) ||
                         (filter === 'unselected' && !isChecked);
  
        // Filtra por nome
        const okSearch = nameText.includes(term);
  
        // Exibe ou oculta
        row.style.display = (okStatus && okSearch) ? '' : 'none';
      });
    }
  
    // FUNÇÃO: inicializa os filtros
    function initFilters() {
      if (!filterSelect || !searchInput) return;
  
      filterSelect.addEventListener('change', applyUserFilters);
      searchInput.addEventListener('input', applyUserFilters);
  
      // Primeiro filtro ao carregar
      applyUserFilters();
    }
  
    // Elementos compartilhados
    let filterSelect, searchInput, userRows;
  
    // Inicialização principal
    document.addEventListener('DOMContentLoaded', function() {
      // Inicializa a cópia de link
      initCopyButton();
  
      // Prepara elementos do filtro
      filterSelect = document.getElementById('userFilter');
      searchInput  = document.getElementById('userSearch');
      userRows     = Array.from(document.querySelectorAll('#usersList .user-row'));
  
      // Inicializa os filtros
      initFilters();
    });
  })();
  