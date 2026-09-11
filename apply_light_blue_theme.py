import glob
import re

# Update dashboard.css
try:
    with open('public/style.css', 'r', encoding='utf-8') as f:
        pass
except:
    pass

with open('public/dashboard.css', 'r', encoding='utf-8') as f:
    css = f.read()

# Make it light blue & white
css = re.sub(r'--primary: #[a-zA-Z0-9]+;', r'--primary: #38bdf8;', css) # Light blue
css = re.sub(r'--primary-light: #[a-zA-Z0-9]+;', r'--primary-light: #e0f2fe;', css)
css = re.sub(r'--secondary: #[a-zA-Z0-9]+;', r'--secondary: #7dd3fc;', css)
css = re.sub(r'--success: #[a-zA-Z0-9]+;', r'--success: #0ea5e9;', css)
css = re.sub(r'--text-dark: #[a-zA-Z0-9]+;', r'--text-dark: #0f172a;', css) # Keep dark text for readability
css = re.sub(r'--bg-main: #[a-zA-Z0-9]+;', r'--bg-main: #f0f9ff;', css) # Very light blue background
css = re.sub(r'box-shadow: 0 0 0 10px #[a-zA-Z0-9]+;', r'box-shadow: 0 0 0 10px #bae6fd;', css)

with open('public/dashboard.css', 'w', encoding='utf-8') as f:
    f.write(css)

# Update Blade files
blade_files = glob.glob('resources/views/*.blade.php')
for file in blade_files:
    with open(file, 'r', encoding='utf-8') as f:
        html = f.read()
    
    # Replace inline greens/blues with light blues
    html = html.replace('#10b981', '#38bdf8') # Main green to light blue
    html = html.replace('#059669', '#0ea5e9') # Dark green hover to slightly darker light blue
    html = html.replace('#1d4ed8', '#7dd3fc') # Dark blue to lighter blue
    html = html.replace('rgba(16, 185, 129', 'rgba(56, 189, 248') # Green RGBA
    html = html.replace('rgba(29, 78, 216', 'rgba(125, 211, 252') # Blue RGBA
    
    # Donut chart colors in dashboard
    html = html.replace("'#1d4ed8', // Blue", "'#0ea5e9', // Light Blue")
    html = html.replace("'#10b981', // Green", "'#38bdf8', // Lighter Blue")
    html = html.replace("'#60a5fa', // Light Blue", "'#7dd3fc', // Very Light Blue")
    html = html.replace("'#34d399'  // Light Green", "'#bae6fd'  // Palest Blue")
    
    with open(file, 'w', encoding='utf-8') as f:
        f.write(html)

print("Theme updated to light blue and white.")
