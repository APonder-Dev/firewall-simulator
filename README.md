# 🔥 Firewall Configuration Simulator

A full-stack web app that simulates firewall rule processing using user-defined UFW/iptables-style rules. Built with Node.js + Express on the backend, and PHP + JavaScript on the frontend. Hosted on a secured VPS.

## 🌐 Live Demo
Access the simulator at:  
🔗 https://project2.aponder.dev

## 🧠 Features

- ✅ Define firewall rules in JSON (source, destination, port, action)
- ✅ Simulate packets and evaluate outcomes (`allow` or `deny`)
- ✅ Visual flowchart using Mermaid.js
- ✅ Responsive, dark-mode friendly UI
- ✅ Hosted on a Linux VPS using Nginx + PM2
- ✅ Secure backend via RESTful API

## 📁 Project Structure

firewall-sim/
├── backend/                  # Node.js API
│   ├── app.js
│   ├── ruleParser.js
│   └── utils/
│       └── ipMatcher.js
├── html/                     # PHP Frontend
│   ├── index.php
│   ├── app.js
│   ├── visual.js
│   └── css/
│       └── style.css
├── static/                   # JS Libraries
│   └── mermaid.min.js

## 🚀 Local Setup

1. **Clone the repo**  
   git clone https://github.com/yourusername/firewall-simulator.git
   cd firewall-simulator

2. **Install backend dependencies**
   cd backend
   npm install

3. **Run backend locally**
   node app.js
   # Or
   pm2 start app.js --name firewall-sim

4. **Serve frontend**
   Use any PHP server or Apache/Nginx to serve /html directory.

## 🔐 Tech Stack

- **Frontend:** PHP, HTML5, CSS, Vanilla JS, Mermaid.js
- **Backend:** Node.js, Express, PM2
- **Server:** Ubuntu 22.04 VPS, Nginx
- **Tools:** CURL, JSON, ip-cidr, body-parser

## 👤 Author

Developed by Anthony Ponder  
📫 Contact: anthony@aponder.dev

## 📜 License

MIT License — free to use, modify, and share with attribution.