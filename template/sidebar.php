<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ambil folder aktif
$current_dir = basename(dirname($_SERVER['PHP_SELF']));

// Cegah error jika session belum ada
$role = $_SESSION['role'] ?? '';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .sidebar-navy {
        background: linear-gradient(180deg, #0a1f44, #081a35);
        transition: all 0.3s ease;
        border-radius: 0 20px 20px 0;
    }

    .nav-pills .nav-link {
        transition: all 0.3s ease;
        border-radius: 12px;
        margin-bottom: 10px;
        padding: 12px 22px;
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: flex-start; /* Rata kiri */
    }

    .nav-pills .nav-link:hover:not(.active) {
        background-color: rgba(255, 255, 255, 0.12) !important;
        color: #fff !important;
        transform: translateX(6px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
    }

    .nav-pills .nav-link.active {
        background-color: #1d4ed8 !important;
        color: #fff !important;
        font-weight: bold;
        transform: scale(1.03);
        box-shadow: 0 6px 16px rgba(29, 78, 216, 0.7);
    }

    .nav-link i {
        margin-right: 12px;
        transition: transform 0.3s, color 0.3s;
        font-size: 1.1rem;
    }

    .nav-link:hover i {
        transform: rotate(15deg) scale(1.2);
        color: #fff;
    }

    .sidebar-logo {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #1d4ed8, #2563eb);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2.4rem;
        box-shadow: 0 0 25px rgba(37, 99, 235, 0.8);
        transition: transform 0.3s ease;
        cursor: pointer;
    }
    .sidebar-logo:hover {
        transform: scale(1.1) rotate(10deg);
    }

    hr {
        border-top: 1px solid rgba(255,255,255,0.2);
    }

    .logout-btn {
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.25s ease;
    }
    .logout-btn:hover {
        transform: translateX(4px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.25);
    }
</style>

<div class="sidebar-navy text-white p-3 shadow" style="min-height: 100vh; width: 240px; position: fixed; z-index: 1000;">
    <div class="sidebar-logo" title="Kasir Fahri">
        <i class="fas fa-coins"></i>
    </div>
    <div class="text-center mb-3">
        <h5 class="fw-bold text-white">KASIR FAHRI</h5>
        <small class="text-light text-uppercase"><?= $role; ?></small>
    </div>
    <hr class="mb-4">

    <ul class="nav nav-pills flex-column mb-auto">

        <li>
            <a href="../dashboard/index.php" class="nav-link <?= ($current_dir == 'dashboard') ? 'active' : ''; ?>">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
        </li>

        <li>
            <a href="../penjualan/index.php" class="nav-link <?= ($current_dir == 'penjualan') ? 'active' : ''; ?>">
                <i class="fas fa-cart-shopping"></i> Penjualan
            </a>
        </li>

        <li>
            <a href="../produk/index.php" class="nav-link <?= ($current_dir == 'produk') ? 'active' : ''; ?>">
                <i class="fas fa-box"></i> Data Produk
            </a>
        </li>

        <?php if ($role == 'admin' || $role == 'petugas'): ?>
            <li>
                <a href="../pelanggan/index.php" class="nav-link <?= ($current_dir == 'pelanggan') ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i> Data Pelanggan
                </a>
            </li>
        <?php endif; ?>

        <?php if ($role == 'admin'): ?>
            <li>
                <a href="../petugas/index.php" class="nav-link <?= ($current_dir == 'petugas') ? 'active' : ''; ?>">
                    <i class="fas fa-user-shield"></i> Registrasi
                </a>
            </li>
        <?php endif; ?>

        <li>
            <a href="../laporan/index.php" class="nav-link <?= ($current_dir == 'laporan') ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Laporan
            </a>
        </li>

    </ul>

    <div style="position: absolute; bottom: 20px; width: 85%;">
        <hr>
        <a href="../../auth/logout.php" class="btn btn-outline-danger w-100 border-0 logout-btn"
            onclick="return confirm('Yakin ingin keluar?')">
            <i class="fas fa-sign-out-alt me-2"></i> Keluar
        </a>
    </div>
</div>

<div class="d-none d-md-block" style="width: 240px; flex-shrink: 0;"></div>
