<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Firewall Configuration Simulator</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="/static/mermaid.min.js"></script>
</head>
<body>
  <header class="navbar">
    <div class="navbar-center">
      <h1>Firewall Configuration Simulator</h1>
      <div class="navbar-actions">
        <a class="btn-secondary" href="https://aponder.dev" target="_blank">← Back to Portfolio</a>
        <button class="btn-secondary" onclick="toggleDarkMode()">🌓 Toggle Dark Mode</button>
      </div>
    </div>
  </header>

  <main class="container">
    <section class="card">
      <h2>🛡️ Define Firewall Rules</h2>
      <p>Enter firewall rules in JSON format:</p>
      <pre>[
  {"source": "192.168.1.0/24", "destination": "10.0.0.5", "port": 22, "action": "deny"},
  {"source": "0.0.0.0/0", "destination": "10.0.0.5", "port": 80, "action": "allow"}
]</pre>
      <textarea id="rulesInput" rows="8" placeholder="Paste firewall rules here..."></textarea>
      <button onclick="submitRules()">💾 Submit Rules</button>
    </section>

    <section class="card">
      <h2>📦 Simulate a Packet</h2>
      <p>Test how the firewall handles this packet:</p>
      <input id="packetInput" placeholder='{"sourceIP": "1.2.3.4", "destinationIP": "10.0.0.5", "port": 22}' />
      <button onclick="evaluatePacket()">🚀 Evaluate Packet</button>
      <div id="result"></div>
    </section>

    <section class="card">
      <h2>📊 Packet Flowchart</h2>
      <div id="flowchart"></div>
    </section>
  </main>

  <footer>
    &copy; <?php echo date('Y'); ?> <a class="gradient-text" href="https://aponder.dev" target="_blank">Anthony Ponder</a>
  </footer>

  <script>
    function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
    }
  </script>
  <script src="app.js"></script>
  <script src="visual.js"></script>
</body>
</html>