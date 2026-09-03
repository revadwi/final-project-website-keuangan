import glob
import re

files = glob.glob('*.html')
# We want to remove the broken JS from all files EXCEPT index.html
files = [f for f in files if f != 'index.html']

for f in files:
    with open(f, 'r', encoding='utf-8') as file:
        content = file.read()
    
    # We need to find the start of the broken code.
    # It seems to be right after:
    #             } else {
    #                 // Set default tampilan ke Administrator
    #                 document.querySelector('.user-role').textContent = 'Administrator';
    #                 document.querySelector('.header-titles h1').textContent = 'Dashboard Admin';
    #             }
    
    # Let's use a regex to match from the end of the role logic to the end of the DOMContentLoaded block
    # Actually, the block that is broken starts with `// Ubah header title agar sesuai dengan menu`
    # Let's just replace the whole DOMContentLoaded block with a clean one.
    
    clean_script = """        // Terapkan aturan tampilan berdasarkan Role dari localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const userRole = localStorage.getItem('userRole');
            const userEmail = localStorage.getItem('userEmail');
            
            // Set nama user dari email
            if (userEmail) {
                const nameDisplay = userEmail.split('@')[0];
                document.querySelector('.user-name').textContent = nameDisplay;
            }

            if (userRole === 'viewer') {
                // Ubah role pengguna
                document.querySelector('.user-role').textContent = 'Viewer';
                
                // Sembunyikan menu-menu Admin (User Management & Pengaturan)
                const navItems = document.querySelectorAll('.nav-item');
                navItems.forEach(item => {
                    const text = item.textContent.trim();
                    if (text.includes('User Management') || text.includes('Pengaturan')) {
                        item.style.display = 'none';
                    }
                });
                
                // Sembunyikan tombol-tombol atau aksi yang tidak boleh diakses viewer
                const actionLinks = document.querySelectorAll('a.btn-outline, button.action-btn');
                actionLinks.forEach(link => {
                    link.style.display = 'none'; 
                });

                // Disable forms
                document.querySelectorAll('input, select').forEach(inp => {
                    inp.disabled = true;
                });
            } else {
                // Set default tampilan ke Administrator
                document.querySelector('.user-role').textContent = 'Administrator';
            }
        });"""

    # We need to replace everything from `// Terapkan aturan tampilan berdasarkan Role dari localStorage`
    # to the `        });\n    </script>`
    
    pattern = r'// Terapkan aturan tampilan berdasarkan Role dari localStorage.*?}\);[\s\n]*}\);'
    
    # Let's just find the start and end manually to be safe
    start_idx = content.find('// Terapkan aturan tampilan berdasarkan Role dari localStorage')
    end_idx = content.find('</script>', start_idx)
    
    if start_idx != -1 and end_idx != -1:
        # The script we replace is from start_idx to the line before </script>
        # Let's find the closing }); before </script>
        content_before = content[:start_idx]
        content_after = '\n    </script>' + content[end_idx+9:]
        new_content = content_before + clean_script + content_after
        
        with open(f, 'w', encoding='utf-8') as file:
            file.write(new_content)
        print(f"Fixed {f}")
    else:
        print(f"Could not find script block in {f}")

print("Done fixing JS.")
