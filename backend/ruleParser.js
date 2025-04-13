const { ipInRange } = require('./utils/ipMatcher');

function evaluatePacket(packet, rules) {
  for (const rule of rules) {
    if (
      ipInRange(packet.sourceIP, rule.source) &&
      ipInRange(packet.destinationIP, rule.destination) &&
      (rule.port == 'any' || rule.port == packet.port)
    ) {
      return { verdict: rule.action.toUpperCase() };
    }
  }
  return { verdict: 'DENY' };
}

module.exports = { evaluatePacket };