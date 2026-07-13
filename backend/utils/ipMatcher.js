const IPCIDR = require('ip-cidr').default;

function ipInRange(ip, cidrOrIp) {
  if (!ip || !cidrOrIp) return false;
  if (cidrOrIp === 'any') return true;
  if (cidrOrIp.includes('/')) {
    if (!IPCIDR.isValidCIDR(cidrOrIp)) return false;
    const cidr = new IPCIDR(cidrOrIp);
    return cidr.contains(ip);
  }
  return ip === cidrOrIp;
}

module.exports = { ipInRange };