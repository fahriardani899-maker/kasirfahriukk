<?php
session_start();
include '../../main/connect.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:../../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas') {
    header("location:../../admin/dashboard/index.php");
    exit;
}

$id = $_GET['id'];

// Ambil data pelanggan
$query = mysqli_query($conn, "SELECT * FROM pelanggan WHERE PelangganID='$id'");
$data = mysqli_fetch_assoc($query);

// Proses update
if(isset($_POST['update'])){
    $nama   = mysqli_real_escape_string($conn, $_POST['NamaPelanggan']);
    $telp   = mysqli_real_escape_string($conn, $_POST['NomorTelepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['Alamat']);

    mysqli_query($conn, "UPDATE pelanggan SET 
        NamaPelanggan='$nama',
        NomorTelepon='$telp',
        Alamat='$alamat'
        WHERE PelangganID='$id'
    ");

    header("location:index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pelanggan</title>
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
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
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
<div class="d-flex">
    <?php include '../../template/sidebar.php'; ?>

    <div class="container-fluid p-4">

        <div class="header-box mb-4 shadow">
            <h4 class="mb-0">
                <i class="fas fa-user-edit me-2"></i> Edit Data Pelanggan
            </h4>
        </div>

        <div class="card border-0">
            <div class="card-body">

                <form method="post">

                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" name="NamaPelanggan" class="form-control"
                               value="<?= $data['NamaPelanggan']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="NomorTelepon" class="form-control"
                               value="<?= $data['NomorTelepon']; ?>" required>
                        <small class="text-muted">Gunakan format: 08xxxxxxxxxx</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="Alamat" class="form-control" rows="3" required><?= $data['Alamat']; ?></textarea>
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="update" class="btn btn-navy">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>

                        <a href="index.php" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
