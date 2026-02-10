<?php 
session_start();
include '../../main/connect.php';

// Proteksi Halaman
if($_SESSION['status'] != "login") header("location:../../auth/login.php");
if($_SESSION['role'] != 'admin') header("location:../../petugas/dashboard/index.php");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penjualan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background: #f4f6fb;
        }
        .card-header {
            background: linear-gradient(135deg, #0b1f3a, #1d3557);
            color: white;
        }
        .btn-navy {
            background-color: #1d3557;
            color: white;
        }
        .btn-navy:hover {
            background-color: #0b1f3a;
            color: white;
        }
        table thead {
            background-color: #1d3557;
            color: white;
        }
        .badge-nota {
            background-color: #0b1f3a;
        }
        .total-text {
            color: #1d3557;
            font-weight: bold;
        }
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
        }
    </style>
</head>

<body>
<div class="d-flex">
    <div class="no-print">
        <?php include '../../template/sidebar.php'; ?>
    </div>

    <div class="container-fluid p-4">
        <div class="card border-0 shadow-lg rounded-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold m-0">
                    <i class="fas fa-file-invoice-dollar me-2"></i> Riwayat Transaksi
                </h5>
                <?php if(isset($_GET['tgl_mulai'])): ?>
                    <button onclick="window.print()" class="btn btn-sm btn-light no-print">
                        <i class="fas fa-print me-1"></i> Cetak Laporan
                    </button>
                <?php endif; ?>
            </div>

            <div class="card-body">

                <!-- FILTER -->
                <div class="card bg-light border-0 mb-4 no-print shadow-sm rounded-3">
                    <div class="card-body">
                        <form method="GET" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="small fw-bold text-muted">Mulai Tanggal</label>
                                <input type="date" name="tgl_mulai" class="form-control form-control-sm" value="<?= $_GET['tgl_mulai'] ?? ''; ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold text-muted">Sampai Tanggal</label>
                                <input type="date" name="tgl_selesai" class="form-control form-control-sm" value="<?= $_GET['tgl_selesai'] ?? ''; ?>" required>
                            </div>
                            <div class="col-md-4 d-flex gap-2">
                                <button type="submit" class="btn btn-sm btn-navy flex-grow-1">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <a href="index.php" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-sync"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <?php 
                $tgl_mulai = $_GET['tgl_mulai'] ?? '';
                $tgl_selesai = $_GET['tgl_selesai'] ?? '';

                if ($tgl_mulai != '' && $tgl_selesai != '') {
                    $query_str = "SELECT * FROM penjualan 
                                  JOIN pelanggan ON penjualan.PelangganID = pelanggan.PelangganID 
                                  WHERE TanggalPenjualan BETWEEN '$tgl_mulai 00:00:00' AND '$tgl_selesai 23:59:59'
                                  ORDER BY PenjualanID DESC";
                    echo "<div class='alert alert-info py-2 small no-print'>
                            <i class='fas fa-info-circle me-2'></i>
                            Menampilkan data dari <strong>$tgl_mulai</strong> sampai <strong>$tgl_selesai</strong>
                          </div>";
                } else {
                    $query_str = "SELECT * FROM penjualan 
                                  JOIN pelanggan ON penjualan.PelangganID = pelanggan.PelangganID 
                                  ORDER BY PenjualanID DESC";
                }
                $sql = mysqli_query($conn, $query_str);
                ?>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered">
                        <thead>
                            <tr>
                                <th>No. Nota</th>
                                <th>Tanggal & Waktu</th>
                                <th>Nama Pelanggan</th>
                                <th class="text-end">Total Bayar</th>
                                <th class="text-center no-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(mysqli_num_rows($sql) == 0){
                                echo "<tr><td colspan='5' class='text-center py-5 text-muted'>
                                        <i class='fas fa-search fa-2x mb-3'></i><br>
                                        Tidak ada transaksi ditemukan.
                                      </td></tr>";
                            }

                            while($d = mysqli_fetch_array($sql)){
                            ?>
                            <tr>
                                <td><span class="badge badge-nota">#<?= $d['PenjualanID']; ?></span></td>
                                <td><?= date('d/m/Y H:i', strtotime($d['TanggalPenjualan'])); ?></td>
                                <td class="fw-semibold"><?= strtoupper($d['NamaPelanggan']); ?></td>
                                <td class="total-text text-end">Rp <?= number_format($d['Totalharga'],0,',','.'); ?></td>
                                <td class="text-center no-print">
                                    <div class="btn-group">
                                        <a href="detail.php?id=<?= $d['PenjualanID']; ?>" class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="hapus.php?id=<?= $d['PenjualanID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Menghapus transaksi akan mengembalikan stok produk. Yakin?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
