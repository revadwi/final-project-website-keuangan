@extends('layouts.app')
@section('title', 'Dashboard - FinanceHub')
@section('header-title', 'Transfer')

@section('content')
<!-- Header -->
            

            <!-- View Sections Container -->
            <div id="view-transfer" class="view-section active" style="display: block; padding: 20px; background: white; border-radius: 12px; margin-top: 20px;">
                <h2>Transfer Dana</h2>
                <p style="color: #64748b; margin-top: 5px;">Kirim dana ke rekening lain secara aman.</p>
                <form class="transfer-form" style="margin-top: 25px; display: flex; flex-direction: column; gap: 15px; max-width: 450px; background: #f8fafc; padding: 25px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <label style="font-size: 14px; font-weight: 500;">Pilih Rekening Sumber</label>
                        <select style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-family: inherit;">
                            <option>Kas Perusahaan (Rp 180.000.000)</option>
                            <option>Kas Kecil / Petty Cash (Rp 5.000.000)</option>
                        </select>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <label style="font-size: 14px; font-weight: 500;">Nomor Rekening Tujuan</label>
                        <input type="text" placeholder="Contoh: 1234567890" style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-family: inherit;">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <label style="font-size: 14px; font-weight: 500;">Nominal Transfer (Rp)</label>
                        <input type="number" placeholder="0" style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-family: inherit;">
                    </div>
                    <button type="button" class="action-btn" style="padding: 12px; background: #0f766e; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; margin-top: 10px;">Proses Transfer</button>
                </form>
            </div>

<!-- Chart Configuration Script -->
@endsection

@push('scripts')
<script>
        // Cashflow Chart (Line/Area)
        const cashflowEl = document.getElementById('cashflowChart');
        if (cashflowEl) {
        const ctxLine = cashflowEl.getContext('2d');
        
        // Gradient for Pemasukan
        const gradientBlue = ctxLine.createLinearGradient(0, 0, 0, 400);
        gradientBlue.addColorStop(0, 'rgba(29, 78, 216, 0.2)');
        gradientBlue.addColorStop(1, 'rgba(29, 78, 216, 0)');

        // Gradient for Pengeluaran
        const gradientCyan = ctxLine.createLinearGradient(0, 0, 0, 400);
        gradientCyan.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
        gradientCyan.addColorStop(1, 'rgba(16, 185, 129, 0)');

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: [32, 55, 49, 58, 75, 53, 56, 50, 75, 65, 82, 75], // sample data in millions
                        borderColor: '#1d4ed8', // Dark Toska
                        backgroundColor: gradientBlue,
                        borderWidth: 2,
                        pointBackgroundColor: '#1d4ed8',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Pengeluaran',
                        data: [12, 31, 40, 24, 32, 35, 25, 52, 27, 42, 49, 54], // sample data in millions
                        borderColor: '#10b981', // Toska
                        backgroundColor: gradientCyan,
                        borderWidth: 2,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'start',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            boxHeight: 8,
                            color: '#64748b',
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#1e293b',
                        titleFont: { family: "'Inter', sans-serif" },
                        bodyFont: { family: "'Inter', sans-serif" },
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#94a3b8', font: { family: "'Inter', sans-serif", size: 12 } }
                    },
                    y: {
                        grid: { color: '#f1f5f9', drawBorder: false, borderDash: [5, 5] },
                        ticks: {
                            color: '#94a3b8',
                            font: { family: "'Inter', sans-serif", size: 12 },
                            callback: function(value) {
                                return value + 'M';
                            },
                            stepSize: 25,
                            max: 100,
                            min: 0
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });

        }

        // Category Chart (Donut)
        const donutEl = document.getElementById('categoryChart');
        if (donutEl) {
        const ctxDonut = donutEl.getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Operasional', 'Gaji & Upah', 'Marketing', 'Lainnya'],
                datasets: [{
                    data: [40, 30, 15, 15],
                    backgroundColor: [
                        '#1d4ed8', // Blue
                        '#10b981', // Green
                        '#60a5fa', // Light Blue
                        '#34d399'  // Light Green
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%', // makes it a thin donut
                plugins: {
                    legend: {
                        display: false // We use custom HTML legend
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { family: "'Inter', sans-serif" },
                        bodyFont: { family: "'Inter', sans-serif" },
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                }
            }
        });

                }

        // Terapkan aturan tampilan berdasarkan Role dari localStorage
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
        });
    </script>
@endpush
