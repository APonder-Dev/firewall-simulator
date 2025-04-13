const IPCIDR = require('ip-cidr');

function ipInRange(ip, cidrOrIp) {
  if (cidrOrIp.includes('/')) {
    const cidr = new IPCIDR(cidrOrIp);
    return cidr.contains(ip);
  } else {
    return ip === cidrOrIp || cidrOrIp === 'any';
  }
}