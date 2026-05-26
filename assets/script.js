function trackEvent(eventName, params = {}) {
  if (typeof window.gtag === "function") {
    window.gtag("event", eventName, params);
  }
  fetch("metrics.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      event: eventName,
      params,
      path: window.location.pathname,
      ts: new Date().toISOString()
    })
  }).catch(() => {});
}

document.addEventListener("DOMContentLoaded", () => {
  const yearEl = document.getElementById("currentYear");
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  trackEvent("page_view_local");

  const toggle = document.querySelector(".menu-toggle");
  const nav = document.getElementById("mainNav");
  if (toggle && nav) {
    toggle.addEventListener("click", () => {
      const expanded = toggle.getAttribute("aria-expanded") === "true";
      toggle.setAttribute("aria-expanded", String(!expanded));
      nav.classList.toggle("open");
    });
  }

  document.querySelectorAll("[data-event]").forEach((el) => {
    el.addEventListener("click", () => trackEvent(el.dataset.event || "unknown_click"));
  });

  const adhesionForm = document.getElementById("adhesionForm");
  const msg = document.getElementById("adhesionMessage");
  if (adhesionForm) {
    adhesionForm.addEventListener("submit", async (event) => {
      event.preventDefault();
      const formData = new FormData(adhesionForm);

      try {
        const response = await fetch(adhesionForm.action, {
          method: "POST",
          body: formData,
          headers: { "X-Requested-With": "fetch" }
        });
        const data = await response.json();
        if (msg) {
          msg.textContent = data.message || "Solicitação recebida.";
          msg.style.color = data.success ? "#314f3a" : "#8a2332";
        }
        if (data.success) {
          adhesionForm.reset();
          trackEvent("adhesion_submit");
        }
      } catch (err) {
        adhesionForm.submit();
      }
    });
  }
});
