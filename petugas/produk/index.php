<?php
session_start();
include '../../main/connect.php';
if ($_SESSION['status'] != "login") header("location:../../auth/login.php");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Stok Produk - Kasir Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6fb;
        }

        .card-header {
            background: linear-gradient(90deg, #0b1c2d, #123a63);
            color: white;
        }

        .table thead {
            background-color: #0b1c2d;
            color: white;
        }

        .badge-stock {
            padding: 6px 12px;
            font-size: 0.85rem;
            border-radius: 20px;
        }

        .table-hover tbody tr:hover {
            background-color: #eef3ff;
        }
    </style>
</head>

<body>

<div class="d-flex">
    <?php include '../../template/sidebar.php'; ?>

    <div class="container-fluid p-4">
        <div class="card shadow border-0 rounded-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold m-0">
                    <i class="fas fa-boxes-stacked me-2"></i> Data Stok Produk
                </h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok Tersisa</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = mysqli_query($conn, "SELECT * FROM produk");
                            while ($d = mysqli_fetch_array($sql)) {

                                if ($d['Stok'] == 0) {
                                    $status = "<span class='badge bg-danger badge-stock'>
                                        <i class='fas fa-times-circle me-1'></i> Habis
                                    </span>";
                                } elseif ($d['Stok'] < 5) {
                                    $status = "<span class='badge bg-warning text-dark badge-stock'>
                                        <i class='fas fa-exclamation-triangle me-1'></i> Hampir Habis
                                    </span>";
                                } else {
                                    $status = "<span class='badge bg-success badge-stock'>
                                        <i class='fas fa-check-circle me-1'></i> Tersedia
                                    </span>";
                                }
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td class="fw-bold"><?= $d['NamaProduk']; ?></td>
                                    <td>Rp <?= number_format($d['Harga']); ?></td>
                                    <td><?= $d['Stok']; ?></td>
                                    <td><?= $status; ?></td>
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
