import glob
import re

# Update dashboard.css
with open('dashboard.css', 'r', encoding='utf-8') as f:
    css = f.read()

css = re.sub(r'--primary: #0f766e;', r'--primary: #1d4ed8;', css)
css = re.sub(r'--primary-light: #f0fdfa;', r'--primary-light: #eff6ff;', css)
css = re.sub(r'--secondary: #14b8a6;', r'--secondary: #10b981;', css)
css = re.sub(r'--success: #10b981;', r'--success: #059669;', css)
css = re.sub(r'--text-dark: #134e4a;', r'--text-dark: #0f172a;', css)
css = re.sub(r'--bg-main: #f4fcfb;', r'--bg-main: #f8fafc;', css)
css = re.sub(r'box-shadow: 0 0 0 10px #ccfbf1;', r'box-shadow: 0 0 0 10px #dbeafe;', css)

with open('dashboard.css', 'w', encoding='utf-8') as f:
    f.write(css)

# Update HTML files
html_files = glob.glob('*.html')
for html_file in html_files:
    if html_file == 'index.html': continue
    
    with open(html_file, 'r', encoding='utf-8') as f:
        html = f.read()
    
    # Chart line colors
    html = html.replace("borderColor: '#0f766e'", "borderColor: '#1d4ed8'") # Blue
    html = html.replace("rgba(15, 118, 110, 0.2)", "rgba(29, 78, 216, 0.2)")
    html = html.replace("rgba(15, 118, 110, 0)", "rgba(29, 78, 216, 0)")
    html = html.replace("pointBackgroundColor: '#0f766e'", "pointBackgroundColor: '#1d4ed8'")
    
    html = html.replace("borderColor: '#14b8a6'", "borderColor: '#10b981'") # Green
    html = html.replace("rgba(20, 184, 166, 0.2)", "rgba(16, 185, 129, 0.2)")
    html = html.replace("rgba(20, 184, 166, 0)", "rgba(16, 185, 129, 0)")
    html = html.replace("pointBackgroundColor: '#14b8a6'", "pointBackgroundColor: '#10b981'")
    
    # Donut chart colors
    html = html.replace("'#0f766e', // Dark Toska", "'#1d4ed8', // Blue")
    html = html.replace("'#14b8a6', // Toska", "'#10b981', // Green")
    html = html.replace("'#5eead4', // Light Toska", "'#60a5fa', // Light Blue")
    html = html.replace("'#f59e0b'  // Orange", "'#34d399'  // Light Green")
    
    with open(html_file, 'w', encoding='utf-8') as f:
        f.write(html)

print("Theme updated to blue and green combination.")
