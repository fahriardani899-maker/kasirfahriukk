<?php
session_start();
include '../../main/connect.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:../../auth/login.php");
    exit;
}

$id = $_GET['id'];

// Ambil data pelanggan
$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan WHERE PelangganID='$id'");
$dataP = mysqli_fetch_assoc($pelanggan);

// Ambil histori penjualan
$histori = mysqli_query($conn, "
    SELECT * FROM penjualan 
    WHERE PelangganID='$id'
    ORDER BY TanggalPenjualan DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Histori Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: #f8fafc; /* PUTIH */
            font-family: 'Segoe UI', sans-serif;
        }

        .card-main {
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,.2);
        }

        .header-box {
            background: linear-gradient(135deg, #0a1f44, #1d4ed8);
            color: white;
            border-radius: 18px 18px 0 0;
            padding: 20px;
        }

        .table thead {
            background-color: #0a1f44;
            color: white;
        }

        .btn-navy {
            background-color: #0a1f44;
            color: white;
            border: none;
        }

        .btn-navy:hover {
            background-color: #081a35;
            color: white;
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <div class="card card-main">

        <!-- HEADER -->
        <div class="header-box">
            <h4 class="mb-0">
                <i class="fas fa-user me-2"></i>
                Histori Transaksi: <?= $dataP['NamaPelanggan']; ?>
            </h4>
        </div>

        <!-- BODY -->
        <div class="card-body bg-white">

            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                <?php $no=1; while($h = mysqli_fetch_assoc($histori)) { ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($h['TanggalPenjualan'])); ?></td>
                    <td class="fw-bold">Rp <?= number_format($h['Totalharga'],0,',','.'); ?></td>
                    <td class="text-center">
                        <a href="../penjualan/detail.php?id=<?= $h['PenjualanID']; ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                <?php } ?>

                <?php if(mysqli_num_rows($histori) == 0): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada transaksi</td>
                </tr>
                <?php endif; ?>

                </tbody>
            </table>

            <a href="index.php" class="btn btn-navy mt-3">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>

        </div>
    </div>
</div>

</body>
</html>
