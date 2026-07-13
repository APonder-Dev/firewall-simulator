# Firewall Simulator

An interactive, full-stack web app that simulates firewall rule processing using user-defined UFW/iptables-style JSON rules. Built with Node.js + Express on the backend and PHP + Vanilla JS on the frontend.

---

## Features

- Define firewall rules in JSON (source IP/CIDR, destination, port, action)
- Simulate packets and evaluate outcomes — `ALLOW` or `DENY`
- Visual packet-flow diagram powered by Mermaid.js
- Dark-first responsive UI with Inter and Fira Code fonts
- Accessible markup — ARIA roles, keyboard navigation, `prefers-reduced-motion` support
- Strict Content Security Policy (no `unsafe-inline`; Mermaid rendered via `mermaid.render()` API)

---

## Project Structure

```
firewall-simulator/
├── backend/
│   ├── app.js              # Express API (port 3000)
│   ├── ruleParser.js       # Rule evaluation logic
│   └── utils/
│       └── ipMatcher.js    # CIDR + exact-IP matching (ip-cidr v4)
├── frontend/
│   ├── index.php           # Main page (PHP for server-side date)
│   ├── index.html          # Static copy for local preview
│   ├── app.js              # UI logic — submit rules, evaluate packet, loading states
│   ├── visual.js           # Mermaid flowchart rendering
│   └── css/
│       └── style.css       # Design tokens, dark/light theme, layout
├── static/
│   └── mermaid.min.js      # Bundled Mermaid (served locally, no CDN)
└── _preview-server.js      # Local dev server (port 9173)
```

---

## API

### `POST /api/rules`

Load a ruleset. Rules are evaluated top-to-bottom; first match wins.

```json
{
  "rules": [
    { "source": "192.168.1.0/24", "destination": "10.0.0.5", "port": 22, "action": "deny" },
    { "source": "0.0.0.0/0",      "destination": "10.0.0.5", "port": 80, "action": "allow" }
  ]
}
```

**Response:** `{ "message": "Rules updated successfully" }`

### `POST /api/evaluate`

Evaluate a packet against the loaded ruleset.

```json
{ "packet": { "sourceIP": "1.2.3.4", "destinationIP": "10.0.0.5", "port": 80 } }
```

**Response:** `{ "verdict": "ALLOW" }` or `{ "verdict": "DENY" }`

---

## Local Setup

**Prerequisites:** Node.js 18+

```bash
# 1. Clone
git clone https://github.com/APonder-Dev/Firewall-Simulator.git
cd Firewall-Simulator

# 2. Install backend dependencies
cd backend && npm install && cd ..

# 3. Start the preview server (serves both API and frontend on one port)
node _preview-server.js
# Open http://localhost:9173
```

To run the backend independently on port 3000 (requires a separate PHP-capable server for the frontend):

```bash
cd backend && node app.js
# Serve /frontend with Apache, Nginx, or: php -S localhost:8080 -t frontend
```

---

## Tech Stack

| Layer     | Technology                                      |
|-----------|-------------------------------------------------|
| Backend   | Node.js, Express v5, ip-cidr v4, body-parser    |
| Frontend  | PHP, HTML5, Vanilla JS, Mermaid.js v10          |
| Styling   | CSS custom properties, Inter, Fira Code (Google Fonts) |
| Dev server | `_preview-server.js` (Node.js, port 9173)     |

---

## Author

Anthony Ponder — [aponder.dev](https://aponder.dev) · [anthony@aponder.dev](mailto:anthony@aponder.dev)

## License

MIT — free to use, modify, and share with attribution.
