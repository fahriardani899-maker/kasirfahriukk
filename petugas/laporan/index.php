<?php 
session_start();
include '../../main/connect.php';
if($_SESSION['status'] != "login") header("location:../../auth/login.php");

$tgl_mulai   = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Penjualan - Kasir Pro</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body{
    background:#f4f6fb;
    font-size:15px;
}

/* Header */
.header-title{
    color:#0b1c2d;
    letter-spacing:.3px;
}

/* Button Print */
.btn-print{
    background:linear-gradient(90deg,#0b1c2d,#123a63);
    color:#fff;
    border-radius:12px;
}
.btn-print:hover{
    background:#0b1c2d;
    color:#fff;
}

/* Card */
.card-report{
    border-radius:18px;
    border:none;
    transition:.25s ease;
}
.card-report:hover{
    transform:translateY(-2px);
}

/* Filter */
.filter-card{
    border-radius:18px;
    border:none;
    box-shadow:0 8px 20px rgba(0,0,0,.06);
}

/* Summary */
.summary-success{ border-left:6px solid #198754; }
.summary-primary{ border-left:6px solid #0d6efd; }

/* Table */
.table{
    border-collapse:separate;
    border-spacing:0 8px;
}
.table thead th{
    background:#0b1c2d;
    color:#fff;
    border:none;
    padding:14px;
}
.table tbody tr{
    background:#fff;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
    border-radius:12px;
}
.table tbody td{
    border:none;
    padding:14px;
}
.table tbody tr:hover{
    background:#eef3ff;
}

/* Badge Total */
.badge-total{
    background:rgba(13,110,253,.12);
    color:#0d6efd;
    padding:6px 14px;
    border-radius:10px;
    font-weight:600;
}

/* Print */
@media print{
    .no-print,.sidebar,.btn{ display:none !important; }
    body{ background:#fff !important; }
    .card-report{ box-shadow:none !important; }
    .container-fluid{ padding:0 !important; }
}
</style>
</head>

<body>
<div class="d-flex">

    <div class="no-print">
        <?php include '../../template/sidebar.php'; ?>
    </div>

    <div class="container-fluid p-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h3 class="fw-bold header-title">
                <i class="fas fa-file-invoice-dollar me-2"></i>Laporan Transaksi
            </h3>
            <button class="btn btn-print fw-bold shadow-sm" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Cetak Laporan
            </button>
        </div>

        <!-- FILTER -->
        <div class="card filter-card mb-4 no-print">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">DARI TANGGAL</label>
                        <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">SAMPAI TANGGAL</label>
                        <input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai ?>">
                    </div>
                    <div class="col-md-6 d-flex gap-2">
                        <button type="submit" class="btn btn-primary fw-bold flex-grow-1">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                        <a href="index.php" class="btn btn-outline-secondary fw-bold px-4">
                            <i class="fas fa-rotate me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <?php
        $where = "";
        if($tgl_mulai != '' && $tgl_selesai != ''){
            $where = " WHERE TanggalPenjualan BETWEEN '$tgl_mulai 00:00:00' AND '$tgl_selesai 23:59:59'";
        }

        $summary = mysqli_query($conn,"SELECT SUM(TotalHarga) as total, COUNT(*) as jml FROM penjualan $where");
        $ds = mysqli_fetch_assoc($summary);
        ?>

        <!-- SUMMARY -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card card-report p-4 summary-success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted fw-bold">OMSET PERIODE</small>
                            <h2 class="fw-bold text-success mb-0">
                                Rp <?= number_format($ds['total'] ?? 0); ?>
                            </h2>
                        </div>
                        <i class="fas fa-wallet fa-2x text-success opacity-25"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card card-report p-4 summary-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted fw-bold">TOTAL TRANSAKSI</small>
                            <h2 class="fw-bold text-primary mb-0">
                                <?= $ds['jml']; ?> Transaksi
                            </h2>
                        </div>
                        <i class="fas fa-receipt fa-2x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card card-report shadow-sm">
            <div class="card-body p-4">

                <!-- PRINT HEADER -->
                <div class="text-center mb-4 d-none d-print-block">
                    <h2 class="fw-bold mb-1">LAPORAN PENJUALAN</h2>
                    <p class="fw-semibold">Kasir Fahri</p>
                    <?php if($tgl_mulai != ''): ?>
                        <p class="mb-0">
                            Periode <?= date('d/m/Y',strtotime($tgl_mulai)) ?>
                            s/d <?= date('d/m/Y',strtotime($tgl_selesai)) ?>
                        </p>
                    <?php endif; ?>
                    <p class="small text-muted">Dicetak: <?= date('d-m-Y H:i'); ?></p>
                    <hr>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>TANGGAL</th>
                                <th>PELANGGAN</th>
                                <th class="text-end">TOTAL BAYAR</th>
                                <th class="text-center no-print">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($conn,"
                            SELECT * FROM penjualan
                            JOIN pelanggan ON penjualan.PelangganID = pelanggan.PelangganID
                            $where ORDER BY TanggalPenjualan DESC
                        ");

                        if(mysqli_num_rows($query) == 0){
                            echo "<tr><td colspan='5' class='text-center py-5 text-muted'>
                                    Tidak ada data transaksi
                                  </td></tr>";
                        }

                        while($d = mysqli_fetch_array($query)){
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d/m/Y H:i',strtotime($d['TanggalPenjualan'])); ?></td>
                                <td class="fw-bold text-uppercase"><?= $d['NamaPelanggan']; ?></td>
                                <td class="text-end">
                                    <span class="badge-total">
                                        Rp <?= number_format($d['Totalharga']); ?>
                                    </span>
                                </td>
                                <td class="text-center no-print">
                                    <a href="detail.php?id=<?= $d['PenjualanID']; ?>"
                                       class="btn btn-sm btn-light border rounded-pill px-3 shadow-sm">
                                        <i class="fas fa-eye text-primary me-1"></i>Detail
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
</body>
</html>
