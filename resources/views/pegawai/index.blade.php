<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="dash-style.css">
    @vite(['resources/css/app.css', 'resources/css/dashboard.css', 'resources/js/app.js', 'resources/js/profile.js', 'resources/js/sidebar.js'])
</head>
<body>


    <div class="container">
        <x-sidebar></x-sidebar>
        <main class="main-content">
            <header>
                <div class="header-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <h1>Selamat Datang, Admin</h1>
                </div>
                <div class="user-profile">
                    <div class="profile-trigger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Profil</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>
                    <div class="profile-dropdown">
                        <button type="button" class="open-profile-modal border-0 bg-transparent p-0 d-flex align-items-center gap-2 w-full text-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>Lihat Profil</span>
                        </button>
                        <hr>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <section class="stats">
                <div class="card">
                    <h3>Total User</h3>
                    <p>1,240</p>
                </div>
                <div class="card">
                    <h3>Penjualan</h3>
                    <p>Rp 5.200.000</p>
                </div>
                <div class="card">
                    <h3>Pesan Baru</h3>
                    <p>12</p>
                </div>
            </section>

            <section class="content-table">
                <h3>Aktivitas Terbaru</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Aktivitas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>10:00</td>
                            <td>Login Pengguna</td>
                            <td class="status-ok">Sukses</td>
                        </tr>
                        <tr>
                            <td>09:45</td>
                            <td>Update Profil</td>
                            <td class="status-ok">Sukses</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    <x-profile-modal></x-profile-modal>
</body>
</html>
