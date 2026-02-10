<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../../auth/login.php?pesan=belum_login");
    exit;
}
include '../../main/connect.php';

date_default_timezone_set('Asia/Jakarta');
$tgl = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: #f1f4f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h1 {
            font-weight: 700;
            color: #0a1f44;
            margin-bottom: 0;
        }

        /* Menggunakan Gradient Navy asli Anda */
        .bg-navy {
            background: linear-gradient(135deg, #0a1f44, #1d4ed8);
        }

        .bg-green {
            background: linear-gradient(135deg, #16a34a, #22c55e);
        }

        .bg-orange {
            background: linear-gradient(135deg, #f59e0b, #f97316);
        }

        .bg-red {
            background: linear-gradient(135deg, #dc2626, #ef4444);
        }

        .dashboard-card {
            border-radius: 15px;
            border: none;
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .welcome-box {
            background: linear-gradient(135deg, #0a1f44, #1d4ed8);
            color: white;
            border-radius: 15px;
            padding: 25px;
            border: none;
        }

        .clock {
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 1px;
            background: rgba(255,255,255,0.1);
            padding: 8px 15px;
            border-radius: 10px;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
        }

        .badge-low {
            background-color: #fee2e2;
            color: #dc2626;
            font-weight: 600;
            padding: 0.5em 0.8em;
        }

        .card-header-custom {
            background: #0a1f44;
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <?php include '../../template/sidebar.php'; ?>

        <div class="container-fluid p-4">

            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h1>Dashboard Admin</h1>
                <div class="text-secondary">
                    Administrator: <span class="fw-bold text-dark"><?= $_SESSION['username']; ?></span>
                </div>
            </div>

            <div class="welcome-box mb-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1">Selamat Datang di Sistem Kasir</h5>
                        <p class="mb-0 text-white-50">Laporan ringkasan data dan aktivitas penjualan hari ini.</p>
                    </div>
                    <div class="clock" id="clock"></div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card text-white dashboard-card bg-navy shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa fa-boxes fa-3x opacity-50 me-3"></i>
                            <div>
                                <div class="small opacity-75">Total Produk</div>
                                <?php
                                $ambil_produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM produk"));
                                echo "<h3 class='fw-bold mb-0'>" . $ambil_produk['total'] . "</h3>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white dashboard-card bg-green shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa fa-shopping-cart fa-3x opacity-50 me-3"></i>
                            <div>
                                <div class="small opacity-75">Penjualan Hari Ini</div>
                                <?php
                                $hari_ini = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM penjualan WHERE DATE(TanggalPenjualan)='$tgl'"));
                                echo "<h3 class='fw-bold mb-0'>" . $hari_ini['total'] . "</h3>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white dashboard-card bg-orange shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa fa-users fa-3x opacity-50 me-3"></i>
                            <div>
                                <div class="small opacity-75">Total Pelanggan</div>
                                <?php
                                $query_plg = mysqli_query($conn, "SELECT DISTINCT PelangganID FROM penjualan");
                                echo "<h3 class='fw-bold mb-0'>" . mysqli_num_rows($query_plg) . "</h3>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white dashboard-card bg-red shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa fa-user-shield fa-3x opacity-50 me-3"></i>
                            <div>
                                <div class="small opacity-75">Total User</div>
                                <?php
                                $hitung_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM user"));
                                echo "<h3 class='fw-bold mb-0'>" . $hitung_user['total'] . "</h3>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container shadow-sm border-0">
                <div class="card-header-custom d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i> 
                    <span>Stok Barang Hampir Habis</span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">ID Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stok_low = mysqli_query($conn, "SELECT * FROM produk WHERE Stok < 10 ORDER BY Stok ASC");
                                while ($d = mysqli_fetch_assoc($stok_low)) {
                                ?>
                                    <tr>
                                        <td class="ps-4 text-secondary"><?= $d['ProdukID']; ?></td>
                                        <td class="fw-bold"><?= $d['NamaProduk']; ?></td>
                                        <td>Rp <?= number_format($d['Harga'], 0, ',', '.'); ?></td>
                                        <td><span class="badge badge-low rounded-pill"><?= $d['Stok']; ?> Unit</span></td>
                                        <td class="text-center">
                                            <a href="../produk/edit.php?id=<?= $d['ProdukID']; ?>" class="btn btn-sm btn-outline-primary px-3">
                                                Update
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            document.getElementById("clock").innerHTML = '<i class="far fa-clock me-2"></i>' + time;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>