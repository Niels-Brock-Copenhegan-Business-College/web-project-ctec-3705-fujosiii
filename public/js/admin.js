// ── CSRF token injection ──────────────────────────────────────────
// Twig function csrf_token() needs a PHP-side extension;
// for the login form, token is set via PHP session in a Twig function.
// A simple approach: output it as a meta tag in the layout.

// ── Add module row (programme form) ──────────────────────────────
const addBtn = document.getElementById('add-module-row');
if (addBtn) {
  const modules = JSON.parse(addBtn.dataset.modules || '[]');
  const container = document.getElementById('module-assignments');
  let idx = container ? container.querySelectorAll('.module-row').length : 0;

  addBtn.addEventListener('click', () => {
    const row = document.createElement('div');
    row.className = 'module-row';
    row.dataset.index = idx;

    const select = document.createElement('select');
    select.name = 'modules[]';
    select.setAttribute('aria-label', 'Module');
    modules.forEach(m => {
      const opt = document.createElement('option');
      opt.value = m.id;
      opt.textContent = m.code + ' — ' + m.title;
      select.appendChild(opt);
    });

    const yearLabel = document.createElement('label');
    yearLabel.textContent = 'Year ';
    const yearInput = document.createElement('input');
    yearInput.type = 'number';
    yearInput.name = 'module_years[]';
    yearInput.value = '1';
    yearInput.min = '1';
    yearInput.max = '6';
    yearInput.style.width = '60px';
    yearLabel.appendChild(yearInput);

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'btn btn--sm btn--danger remove-module-row';
    removeBtn.textContent = '✕';
    removeBtn.addEventListener('click', () => row.remove());

    row.appendChild(select);
    row.appendChild(yearLabel);
    row.appendChild(removeBtn);
    container.appendChild(row);
    idx++;
  });

  // Handle existing remove buttons
  container && container.addEventListener('click', e => {
    if (e.target.classList.contains('remove-module-row')) {
      e.target.closest('.module-row').remove();
    }
  });
}

// ── Alert auto-dismiss ────────────────────────────────────────────
document.querySelectorAll('.alert').forEach(alert => {
  setTimeout(() => {
    alert.style.transition = 'opacity .4s';
    alert.style.opacity = '0';
    setTimeout(() => alert.remove(), 400);
  }, 6000);
});
