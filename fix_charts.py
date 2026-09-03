import glob

files = glob.glob('*.html')
files = [f for f in files if f != 'index.html']

for f in files:
    with open(f, 'r', encoding='utf-8') as file:
        content = file.read()
    
    # We need to wrap the chart code.
    # From:
    #         // Cashflow Chart (Line/Area)
    #         const ctxLine = document.getElementById('cashflowChart').getContext('2d');
    # To:
    #         // Cashflow Chart (Line/Area)
    #         const cashflowCanvas = document.getElementById('cashflowChart');
    #         if (cashflowCanvas) {
    #             const ctxLine = cashflowCanvas.getContext('2d');
    
    # And we need to close the bracket before the next chart
    
    # Actually, the simplest fix is to just replace the getContext lines with a null check.
    
    if "const ctxLine = document.getElementById('cashflowChart').getContext('2d');" in content:
        content = content.replace(
            "const ctxLine = document.getElementById('cashflowChart').getContext('2d');",
            "const cashflowEl = document.getElementById('cashflowChart');\n        if (cashflowEl) {\n        const ctxLine = cashflowEl.getContext('2d');"
        )
        # Close the if block before // Category Chart
        content = content.replace(
            "// Category Chart (Donut)",
            "}\n\n        // Category Chart (Donut)"
        )
        
    if "const ctxDonut = document.getElementById('categoryChart').getContext('2d');" in content:
        content = content.replace(
            "const ctxDonut = document.getElementById('categoryChart').getContext('2d');",
            "const donutEl = document.getElementById('categoryChart');\n        if (donutEl) {\n        const ctxDonut = donutEl.getContext('2d');"
        )
        # Close the if block before // Terapkan aturan tampilan
        content = content.replace(
            "// Terapkan aturan tampilan berdasarkan Role dari localStorage",
            "}\n\n        // Terapkan aturan tampilan berdasarkan Role dari localStorage"
        )
    
    with open(f, 'w', encoding='utf-8') as file:
        file.write(content)
    print(f"Fixed charts in {f}")

print("Done fixing charts.")
