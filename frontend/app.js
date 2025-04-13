async function submitRules() {
  const rules = JSON.parse(document.getElementById('rulesInput').value);
  await fetch('/api/rules', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ rules })
  });
}

async function evaluatePacket() {
  const packet = JSON.parse(document.getElementById('packetInput').value);
  const res = await fetch('/api/evaluate', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ packet })
  });
  const data = await res.json();
  document.getElementById('result').innerText = `Verdict: ${data.verdict}`;
  drawFlowchart(data.verdict);
}

window.addEventListener("scroll", () => {
  const navbar = document.querySelector(".navbar");
  if (window.scrollY > 10) {
    navbar.classList.add("scrolled");
  } else {
    navbar.classList.remove("scrolled");
  }
});
