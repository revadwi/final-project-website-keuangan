import os
import re

html_file = 'dashboard.html'
with open(html_file, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Update sidebar links
# From <a href="#" class="nav-link" data-target="NAME">
# To <a href="NAME.html" class="nav-link" data-target="NAME">
sidebar_pattern = r'<a href="#" class="nav-link" data-target="([^"]+)">'
content = re.sub(sidebar_pattern, r'<a href="\1.html" class="nav-link" data-target="\1">', content)

# 2. Extract views
parts = content.split('<div id="view-')
base_top = parts[0]

views = {}
script_split = parts[-1].split('</main>')
parts[-1] = script_split[0]
base_bottom = '</main>\n' + script_split[1]

for i in range(1, len(parts)):
    part = parts[i]
    view_name = part.split('"')[0]
    view_html = '<div id="view-' + part
    views[view_name] = view_html

# Remove SPA logic.
spa_pattern = r'// ===.*?SPA NAVIGATION LOGIC.*?}\);'
base_bottom_cleaned = re.sub(spa_pattern, '', base_bottom, flags=re.DOTALL)

for name, view_html in views.items():
    view_html = view_html.replace('style="display: none;', 'style="display: block;')
    view_html = view_html.replace('class="view-section"', 'class="view-section active"')
    view_html = view_html.replace('class="view-section admin-only-view"', 'class="view-section active admin-only-view"')
    
    top = base_top
    top = re.sub(r'<li class="nav-item active">', r'<li class="nav-item">', top)
    target = f'data-target="{name}"'
    target_pattern = r'(<li class="nav-item">)(\s*<a href="[^"]+" class="nav-link" data-target="' + name + '">)'
    top = re.sub(target_pattern, r'<li class="nav-item active">\2', top)
    
    if name != 'dashboard':
        title = name.capitalize()
        if name == 'users': title = 'User Management'
        top = re.sub(r'<h1>Dashboard Admin</h1>', f'<h1>{title}</h1>', top)
        top = re.sub(r'<p>Ringkasan keuangan keseluruhan</p>', f'<p>Halaman fitur {title}</p>', top)
    
    full_html = top + view_html + base_bottom_cleaned
    
    out_file = f'{name}.html'
    with open(out_file, 'w', encoding='utf-8') as f:
        f.write(full_html)
    print(f'Created {out_file}')

print("Done generating pages.")
