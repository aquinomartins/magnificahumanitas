// Menu mobile simples e leve, sem dependências externas.
(function () {
  const menuToggle = document.getElementById('menuToggle');
  const menu = document.getElementById('menuPrincipal');

  if (!menuToggle || !menu) return;

  menuToggle.addEventListener('click', function () {
    const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
    menuToggle.setAttribute('aria-expanded', String(!expanded));
    menu.classList.toggle('open');
  });

  // Fecha o menu ao clicar em um link (melhor experiência em celular).
  menu.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      menu.classList.remove('open');
      menuToggle.setAttribute('aria-expanded', 'false');
    });
  });
})();
