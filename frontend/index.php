<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Firewall Simulator</title>
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-eval'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.gstatic.com; font-src https://fonts.googleapis.com https://fonts.gstatic.com; img-src 'self' data:;">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="css/style.css">
  <script src="/static/mermaid.min.js"></script>
</head>
<body class="dark-mode">

  <header class="navbar" role="banner">
    <div class="navbar-inner">
      <div class="navbar-brand">
        <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        <span class="brand-title">Firewall Simulator</span>
      </div>
      <nav class="navbar-actions" aria-label="Site navigation">
        <a class="btn btn-ghost" href="https://aponder.dev" target="_blank" rel="noopener noreferrer">
          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          Portfolio
        </a>
        <button class="btn btn-icon" id="themeToggle" aria-label="Toggle light mode">
          <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
          <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </button>
      </nav>
    </div>
  </header>

  <main class="container" id="main-content">

    <section class="card" aria-labelledby="rules-heading">
      <div class="card-header">
        <span class="step-badge" aria-hidden="true">01</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        <h2 id="rules-heading">Define Firewall Rules</h2>
      </div>
      <p class="card-desc">Enter your ruleset in JSON format. Rules are evaluated top-to-bottom; the first match wins.</p>
      <div class="code-example">
        <span class="code-label">Example</span>
        <pre>[
  { "source": "192.168.1.0/24", "destination": "10.0.0.5", "port": 22, "action": "deny"  },
  { "source": "0.0.0.0/0",      "destination": "10.0.0.5", "port": 80, "action": "allow" }
]</pre>
      </div>
      <label for="rulesInput" class="input-label">Rules (JSON array)</label>
      <textarea id="rulesInput" rows="8" placeholder="Paste your rules array here…" aria-describedby="rules-hint" spellcheck="false"></textarea>
      <p class="input-hint" id="rules-hint">Must be a valid JSON array of rule objects with source, destination, port, and action fields.</p>
      <button class="btn btn-primary" id="submitBtn" aria-label="Submit firewall rules">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        Submit Rules
      </button>
      <div id="submitFeedback" role="alert" aria-live="polite"></div>
    </section>

    <section class="card" aria-labelledby="packet-heading">
      <div class="card-header">
        <span class="step-badge" aria-hidden="true">02</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
        <h2 id="packet-heading">Simulate a Packet</h2>
      </div>
      <p class="card-desc">Provide a test packet to evaluate against the loaded ruleset.</p>
      <label for="packetInput" class="input-label">Packet (JSON object)</label>
      <input id="packetInput" type="text" placeholder='{"sourceIP": "1.2.3.4", "destinationIP": "10.0.0.5", "port": 22}' aria-describedby="packet-hint" spellcheck="false" />
      <p class="input-hint" id="packet-hint">JSON object with sourceIP, destinationIP, and port fields.</p>
      <button class="btn btn-accent" id="evalBtn" aria-label="Evaluate packet against firewall rules">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="5 3 19 12 5 21 5 3"/></svg>
        Evaluate Packet
      </button>
      <div id="result" role="alert" aria-live="polite"></div>
    </section>

    <section class="card" aria-labelledby="flowchart-heading">
      <div class="card-header">
        <span class="step-badge" aria-hidden="true">03</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="18" cy="18" r="3"/><circle cx="6" cy="6" r="3"/><path d="M13 6h3a2 2 0 0 1 2 2v7"/><line x1="6" y1="9" x2="6" y2="21"/></svg>
        <h2 id="flowchart-heading">Packet Flow</h2>
      </div>
      <p class="card-desc">Visualizes how the packet traverses your ruleset.</p>
      <div id="flowchart" aria-label="Packet flow diagram">
        <div class="flowchart-placeholder" id="flowchartPlaceholder">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="6" height="6" rx="1"/><rect x="15" y="15" width="6" height="6" rx="1"/><rect x="15" y="3" width="6" height="6" rx="1"/><path d="M9 6h3a3 3 0 0 1 3 3v3"/><line x1="6" y1="9" x2="6" y2="18"/><line x1="6" y1="18" x2="9" y2="18"/></svg>
          <p>Complete steps 01 and 02 to generate the flow diagram</p>
        </div>
      </div>
    </section>

  </main>

  <footer role="contentinfo">
    <div class="footer-inner">
      <div class="footer-brand">
        <svg class="footer-brand-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        <div class="footer-brand-text">
          <span class="footer-name">Firewall Simulator</span>
          <span class="footer-tagline">An interactive network security education tool</span>
        </div>
      </div>
      <nav class="footer-links" aria-label="Footer navigation">
        <a class="footer-link" href="https://aponder.dev" target="_blank" rel="noopener noreferrer">
          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          Portfolio
        </a>
        <a class="footer-link" href="https://github.com/APonder-Dev/Firewall-Simulator" target="_blank" rel="noopener noreferrer">
          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
          GitHub
        </a>
      </nav>
    </div>
    <div class="footer-bottom">
      <span>&copy; <?php echo date('Y'); ?> <a class="accent-link" href="https://aponder.dev" target="_blank" rel="noopener noreferrer">Anthony Ponder</a></span>
      <span class="footer-stack">Node.js · Express · Mermaid.js · MIT License</span>
    </div>
  </footer>

  <script src="app.js"></script>
  <script src="visual.js"></script>
</body>
</html>
