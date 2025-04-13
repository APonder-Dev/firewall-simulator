function drawFlowchart(verdict) {
    const chart = `graph TD\nA[Start] --> B[Evaluate Rules]\nB --> C{Match Found?}\nC -- Yes --> D[${verdict}]\nC -- No --> E[DENY]`;
    document.getElementById('flowchart').innerHTML = `<div class='mermaid'>${chart}</div>`;
    mermaid.init();
  }
  