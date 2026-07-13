const SPINNER_SVG = `<svg class="spinner-icon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>`;

const ICONS = {
  success: `<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>`,
  error:   `<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`,
  allow:   `<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`,
  deny:    `<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`,
};

const CLASS_MAP = {
  success: 'feedback-msg feedback-success',
  error:   'feedback-msg feedback-error',
  allow:   'feedback-msg verdict-allow',
  deny:    'feedback-msg verdict-deny',
};

function setLoading(btnId, isLoading) {
  const btn = document.getElementById(btnId);
  if (!btn) return;
  if (isLoading) {
    btn.disabled = true;
    btn.dataset.originalHtml = btn.innerHTML;
    btn.innerHTML = `${SPINNER_SVG}<span>Processing…</span>`;
  } else {
    btn.disabled = false;
    btn.innerHTML = btn.dataset.originalHtml || btn.innerHTML;
  }
}

function showFeedback(containerId, message, type) {
  const el = document.getElementById(containerId);
  if (!el) return;
  const cls = CLASS_MAP[type] || 'feedback-msg';
  const icon = ICONS[type] || '';
  el.innerHTML = `<span class="${cls}">${icon}${message}</span>`;
}

async function submitRules() {
  const textarea = document.getElementById('rulesInput');
  const raw = textarea ? textarea.value.trim() : '';

  if (!raw) {
    showFeedback('submitFeedback', 'Please enter firewall rules before submitting.', 'error');
    return;
  }

  let rules;
  try {
    rules = JSON.parse(raw);
  } catch {
    showFeedback('submitFeedback', 'Invalid JSON — check your syntax and try again.', 'error');
    return;
  }

  if (!Array.isArray(rules)) {
    showFeedback('submitFeedback', 'Rules must be a JSON array (starts and ends with [ ]).', 'error');
    return;
  }

  setLoading('submitBtn', true);
  document.getElementById('submitFeedback').innerHTML = '';

  try {
    const res = await fetch('/api/rules', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ rules }),
    });
    if (!res.ok) throw new Error(`Server error: ${res.status}`);
    const count = rules.length;
    showFeedback('submitFeedback', `${count} rule${count === 1 ? '' : 's'} loaded successfully.`, 'success');
  } catch (e) {
    showFeedback('submitFeedback', e.message || 'Failed to connect to the backend.', 'error');
  } finally {
    setLoading('submitBtn', false);
  }
}

async function evaluatePacket() {
  const input = document.getElementById('packetInput');
  const raw = input ? input.value.trim() : '';

  if (!raw) {
    showFeedback('result', 'Please enter a packet before evaluating.', 'error');
    return;
  }

  let packet;
  try {
    packet = JSON.parse(raw);
  } catch {
    showFeedback('result', 'Invalid JSON — check your packet syntax.', 'error');
    return;
  }

  setLoading('evalBtn', true);
  document.getElementById('result').innerHTML = '';

  try {
    const res = await fetch('/api/evaluate', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ packet }),
    });
    if (!res.ok) throw new Error(`Server error: ${res.status}`);
    const data = await res.json();
    const verdict = (data.verdict || 'DENY').toUpperCase();
    const type = verdict === 'ALLOW' ? 'allow' : 'deny';
    showFeedback('result', `Verdict: ${verdict}`, type);
    drawFlowchart(verdict);
  } catch (e) {
    showFeedback('result', e.message || 'Failed to evaluate packet.', 'error');
  } finally {
    setLoading('evalBtn', false);
  }
}

function toggleTheme() {
  const isDark = document.body.classList.toggle('dark-mode');
  const sunIcon = document.getElementById('icon-sun');
  const moonIcon = document.getElementById('icon-moon');
  const btn = document.getElementById('themeToggle');
  if (isDark) {
    sunIcon.style.display = '';
    moonIcon.style.display = 'none';
    btn.setAttribute('aria-label', 'Toggle light mode');
  } else {
    sunIcon.style.display = 'none';
    moonIcon.style.display = '';
    btn.setAttribute('aria-label', 'Toggle dark mode');
  }
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('submitBtn').addEventListener('click', submitRules);
  document.getElementById('evalBtn').addEventListener('click', evaluatePacket);
  document.getElementById('themeToggle').addEventListener('click', toggleTheme);
});

window.addEventListener('scroll', () => {
  const navbar = document.querySelector('.navbar');
  if (navbar) navbar.classList.toggle('scrolled', window.scrollY > 10);
});
