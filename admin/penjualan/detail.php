<?php 
session_start();
include '../../main/connect.php';

// Proteksi: Hanya Admin yang boleh masuk
if($_SESSION['status'] != "login") header("location:../../auth/login.php");
if($_SESSION['role'] != 'admin') header("location:../../petugas/dashboard/index.php");

$id = $_GET['id'];

// Ambil data penjualan & pelanggan
$query = mysqli_query($conn, "SELECT * FROM penjualan 
         JOIN pelanggan ON penjualan.PelangganID = pelanggan.PelangganID 
         WHERE PenjualanID = '$id'");
$data = mysqli_fetch_array($query);

// Jika ID tidak ditemukan
if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Transaksi #<?= $id; ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body{
    background:#f4f6fb;
}
.card-header{
    background:linear-gradient(135deg,#0b1f3a,#1d3557);
    color:white;
}
.badge-nota{
    background:#1d3557;
}
.table thead{
    background:#1d3557;
    color:white;
}
.total-text{
    color:#1d3557;
    font-weight:bold;
}
.btn-navy{
    background:#1d3557;
    color:white;
}
.btn-navy:hover{
    background:#0b1f3a;
    color:white;
}

@media print {
    .no-print { display:none !important; }
    body { background:white !important; }
    .card { box-shadow:none !important; border:none !important; }
}
</style>
</head>

<body>
<div class="d-flex">
    <div class="no-print">
        <?php include '../../template/sidebar.php'; ?>
    </div>

    <div class="container-fluid p-4">
        <div class="card shadow-lg border-0 col-md-8 mx-auto rounded-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center no-print">
                <h5 class="fw-bold m-0">
                    <i class="fas fa-receipt me-2"></i> Detail Transaksi #<?= $id; ?>
                </h5>
                <a href="index.php" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card-body">

                <!-- HEADER STRUK -->
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-0">KASIR FAHRI</h3>
                    <small class="text-muted text-uppercase">Bukti Transaksi Penjualan</small>
                    <hr>
                </div>

                <!-- INFO -->
                <div class="row mb-4">
                    <div class="col-6">
                        <small class="text-muted">Nama Pelanggan</small>
                        <p class="fw-bold mb-0"><?= $data['NamaPelanggan']; ?></p>
                    </div>
                    <div class="col-6 text-end">
                        <small class="text-muted">Tanggal Transaksi</small>
                        <p class="fw-bold mb-0"><?= date('d F Y H:i', strtotime($data['TanggalPenjualan'])); ?></p>
                    </div>
                </div>

                <!-- TABLE DETAIL -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $detail = mysqli_query($conn, "SELECT * FROM detailpenjualan 
                                      JOIN produk ON detailpenjualan.ProdukID = produk.ProdukID 
                                      WHERE PenjualanID = '$id'");
                            while($d = mysqli_fetch_array($detail)){
                            ?>
                            <tr>
                                <td><?= $d['NamaProduk']; ?></td>
                                <td class="text-center">Rp <?= number_format($d['Harga'],0,',','.'); ?></td>
                                <td class="text-center"><?= $d['JumlahProduk']; ?></td>
                                <td class="text-end">Rp <?= number_format($d['Subtotal'],0,',','.'); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end py-3">TOTAL</th>
                                <th class="text-end py-3 total-text h5">Rp <?= number_format($data['Totalharga'],0,',','.'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- BUTTON -->
                <div class="text-center mt-4 no-print">
                    <hr>
                    <button onclick="window.print()" class="btn btn-navy px-4">
                        <i class="fas fa-print me-2"></i> Cetak Nota
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>
