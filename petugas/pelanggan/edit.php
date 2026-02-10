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

$id = $_GET['id'];

$query = mysqli_query($conn,"SELECT * FROM pelanggan WHERE PelangganID='$id'");
$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){
    $nama   = mysqli_real_escape_string($conn,$_POST['NamaPelanggan']);
    $telp   = mysqli_real_escape_string($conn,$_POST['NoTelp']);
    $alamat = mysqli_real_escape_string($conn,$_POST['Alamat']);

    mysqli_query($conn,"UPDATE pelanggan SET 
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
<title>Edit Data Pelanggan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body {
    background:#f1f4f9;
}
.header-box {
    background: linear-gradient(135deg,#0a1f44,#1d4ed8);
    color:white;
    padding:15px 20px;
    border-radius:15px;
}
.card {
    border-radius:15px;
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

<div class="card shadow border-0">
<div class="card-body">

<form method="POST">

<div class="mb-3">
<label class="fw-bold">Nama Pelanggan</label>
<input type="text" name="NamaPelanggan" class="form-control" required value="<?= $data['NamaPelanggan']; ?>">
</div>

<div class="mb-3">
<label class="fw-bold">Nomor Telepon</label>
<input type="text" name="NoTelp" class="form-control" required value="<?= $data['NomorTelepon']; ?>">
</div>

<div class="mb-3">
<label class="fw-bold">Alamat</label>
<textarea name="Alamat" class="form-control" rows="3" required><?= $data['Alamat']; ?></textarea>
</div>

<div class="d-flex gap-2">
<button type="submit" name="update" class="btn btn-primary">
    <i class="fas fa-save me-1"></i> Simpan
</button>
<a href="index.php" class="btn btn-secondary">
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
