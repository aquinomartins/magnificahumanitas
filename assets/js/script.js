function trackEvent(eventName, params = {}) {
  if (typeof window.gtag === 'function') {
    window.gtag('event', eventName, params);
  }

  fetch('metrics.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ event: eventName, params, path: window.location.pathname, ts: new Date().toISOString() })
  }).catch(() => {});
}

document.addEventListener('DOMContentLoaded', () => {
  const y = document.getElementById('currentYear');
  if (y) y.textContent = String(new Date().getFullYear());

  const eventByPage = document.body.dataset.pageEvent;
  trackEvent(eventByPage || 'page_view_local');

  const toggle = document.querySelector('.menu-toggle');
  const nav = document.getElementById('mainNav');
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!expanded));
      nav.classList.toggle('open');
    });
  }

  document.querySelectorAll('[data-event]').forEach((el) => {
    el.addEventListener('click', () => trackEvent(el.dataset.event || 'page_view_local'));
  });

  document.querySelectorAll('.visual-placeholder').forEach((el) => {
    el.addEventListener('click', () => trackEvent('visual_placeholder_click'));
  });

  const form = document.getElementById('adhesionForm');
  const msg = document.getElementById('adhesionMessage');
  if (form) {
    form.addEventListener('submit', async (event) => {
      event.preventDefault();
      const data = new FormData(form);
      try {
        const response = await fetch(form.action, { method: 'POST', body: data, headers: { 'X-Requested-With': 'fetch' } });
        const json = await response.json();
        if (msg) msg.textContent = json.message || 'Solicitação recebida.';
        if (json.success) {
          form.reset();
          trackEvent('adhesion_submit');
        }
      } catch {
        form.submit();
      }
    });
  }
});
