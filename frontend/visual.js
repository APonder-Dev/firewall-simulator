mermaid.initialize({ startOnLoad: false, theme: 'dark', securityLevel: 'loose' });

async function drawFlowchart(verdict) {
  const placeholder = document.getElementById('flowchartPlaceholder');
  if (placeholder) placeholder.remove();

  const chart = [
    'graph TD',
    'A([Start]) --> B[Evaluate Rules]',
    'B --> C{Match Found?}',
    `C -- Yes --> D([${verdict}])`,
    'C -- No --> E([DENY])',
  ].join('\n');

  const container = document.getElementById('flowchart');
  try {
    const { svg } = await mermaid.render('packet-flow-' + Date.now(), chart);
    container.innerHTML = svg;
  } catch {
    container.innerHTML = '<p class="input-hint">Could not render flow diagram.</p>';
  }
}
