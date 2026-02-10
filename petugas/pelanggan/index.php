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
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: #f1f4f9;
        }

        .header-box {
            background: linear-gradient(135deg, #0a1f44, #1d4ed8);
            color: white;
            padding: 15px 20px;
            border-radius: 15px;
        }

        .card {
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <?php include '../../template/sidebar.php'; ?>

        <div class="container-fluid p-4">

            <div class="header-box mb-4 shadow">
                <h4 class="mb-0">
                    <i class="fas fa-users me-2"></i> Data Pelanggan
                </h4>
            </div>

            <div class="card shadow border-0">
                <div class="card-body table-responsive">

                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Nomor Telepon</th>
                                <th>Alamat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $no = 1;
                            $query = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY PelangganID DESC");
                            while ($p = mysqli_fetch_assoc($query)) {
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $p['NamaPelanggan']; ?></td>
                                    <td><?= $p['NomorTelepon']; ?></td>
                                    <td><?= $p['Alamat']; ?></td>
                                    <td class="text-center">
                                        <a href="edit.php?id=<?= $p['PelangganID']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <a href="histori.php?id=<?= $p['PelangganID']; ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-history me-1"></i> History
                                        </a>
                                    </td>

                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>