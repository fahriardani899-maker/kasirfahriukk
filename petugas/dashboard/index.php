<?php
session_start();
include '../../main/connect.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:../../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'petugas') {
    header("location:../../admin/dashboard/index.php");
    exit;
}

$username = $_SESSION['username'];

date_default_timezone_set('Asia/Jakarta');
$tgl_hari_ini = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Petugas - Kasir Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: #f1f4f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .welcome-box {
            background: linear-gradient(135deg, #0a1f44, #1d4ed8);
            color: white;
            border-radius: 20px;
        }

        .card-stats {
            border-radius: 18px;
            transition: 0.3s;
        }

        .card-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .15);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .clock {
            font-size: 1.1rem;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="d-flex">
<?php include '../../template/sidebar.php'; ?>

<div class="container-fluid p-4">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
    <h2 class="fw-bold text-primary">
        <i class="fas fa-gauge-high me-2"></i> Dashboard Petugas
    </h2>
    <div class="text-muted">
        Halo, <strong><?= strtoupper($username); ?></strong>
    </div>
</div>

<!-- WELCOME -->
<div class="welcome-box p-4 mb-4 shadow d-flex justify-content-between align-items-center">
    <div>
        <h4>
            <i class="fas fa-user-check me-2"></i> Selamat Bekerja
        </h4>
        <p class="mb-0">Layani pelanggan dengan sepenuh hati hari ini</p>
    </div>
    <div class="clock" id="clock"></div>
</div>

<!-- STAT CARDS -->
<div class="row g-4 mb-4">

<!-- TRANSAKSI HARI INI -->
<div class="col-md-6">
<div class="card card-stats shadow border-0 p-3 bg-white">
<div class="d-flex align-items-center">
    <div class="icon-box bg-primary text-white rounded-circle me-3">
        <i class="fas fa-receipt fa-2x"></i>
    </div>
    <div>
        <small class="text-muted fw-bold">TRANSAKSI HARI INI</small>
        <?php
        $query_trx = mysqli_query($conn, "SELECT COUNT(*) total FROM penjualan WHERE DATE(TanggalPenjualan)='$tgl_hari_ini'");
        $data_trx = mysqli_fetch_assoc($query_trx);
        ?>
        <h3 class="fw-bold mb-0"><?= $data_trx['total']; ?> Nota</h3>
    </div>
</div>
</div>
</div>

<!-- TOTAL PENJUALAN -->
<div class="col-md-6">
<div class="card card-stats shadow border-0 p-3 bg-white">
    <small class="text-muted fw-bold">
        <i class="fas fa-money-bill-wave me-1"></i> TOTAL PENJUALAN
    </small>

    <?php
    $query_total = mysqli_query($conn, "SELECT SUM(TotalHarga) total_all FROM penjualan");
    $data_total = mysqli_fetch_assoc($query_total);
    $total_all = $data_total['total_all'] ?? 0;

    $query_today = mysqli_query($conn, "SELECT SUM(TotalHarga) total_today FROM penjualan WHERE DATE(TanggalPenjualan)='$tgl_hari_ini'");
    $data_today = mysqli_fetch_assoc($query_today);
    $total_today = $data_today['total_today'] ?? 0;
    ?>

    <h3 class="fw-bold mb-1">Rp <?= number_format($total_all, 0, ',', '.'); ?></h3>

    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
        <i class="fas fa-arrow-up me-1"></i>
        Hari ini: Rp <?= number_format($total_today, 0, ',', '.'); ?>
    </span>
</div>
</div>

</div>

<!-- TRANSAKSI TERAKHIR -->
<div class="card shadow border-0">
<div class="card-header bg-white py-3">
    <h5 class="fw-bold m-0">
        <i class="fas fa-history me-2"></i> Transaksi Terakhir
    </h5>
</div>

<div class="card-body">
<table class="table table-hover align-middle">
<thead>
<tr>
    <th>Waktu</th>
    <th>Pelanggan</th>
    <th>Total</th>
    <th class="text-center">Aksi</th>
</tr>
</thead>
<tbody>

<?php
$log = mysqli_query($conn, "
    SELECT penjualan.*, pelanggan.NamaPelanggan 
    FROM penjualan 
    JOIN pelanggan ON penjualan.PelangganID = pelanggan.PelangganID 
    ORDER BY PenjualanID DESC 
    LIMIT 5
");

while ($l = mysqli_fetch_assoc($log)) {
?>
<tr>
    <td><?= date('H:i', strtotime($l['TanggalPenjualan'])); ?></td>
    <td><?= $l['NamaPelanggan']; ?></td>
    <td class="fw-bold">Rp <?= number_format($l['Totalharga'], 0, ',', '.'); ?></td>
    <td class="text-center">
        <a href="../penjualan/detail.php?id=<?= $l['PenjualanID']; ?>" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-eye me-1"></i> Detail
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

<script>
function updateClock() {
    const now = new Date();
    document.getElementById("clock").innerHTML =
        '<i class="fas fa-clock me-1"></i>' + now.toLocaleTimeString('id-ID');
}
setInterval(updateClock, 1000);
updateClock();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
