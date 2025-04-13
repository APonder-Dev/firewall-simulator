const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const { evaluatePacket } = require('./ruleParser');

const app = express();
app.use(cors());
app.use(bodyParser.json());

let firewallRules = [];

app.post('/api/rules', (req, res) => {
  firewallRules = req.body.rules;
  res.json({ message: 'Rules updated successfully' });
});

app.post('/api/evaluate', (req, res) => {
  const packet = req.body.packet;
  const result = evaluatePacket(packet, firewallRules);
  res.json(result);
});

const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Firewall Simulator API running on http://localhost:${PORT}`);
});