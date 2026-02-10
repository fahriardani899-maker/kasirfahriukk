<?php 
session_start();
include '../../main/connect.php';
// Cek login
if($_SESSION['status'] != "login") header("location:../../auth/login.php");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Produk - Kasir</title>
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
.btn-navy{
    background:#1d3557;
    color:white;
}
.btn-navy:hover{
    background:#0b1f3a;
    color:white;
}
.table thead{
    background:#1d3557;
    color:white;
}
.badge-stock{
    min-width:45px;
}
tfoot{
    background:#f1f3f8;
    font-weight:bold;
}
</style>
</head>

<body>
<div class="d-flex">
    <?php include '../../template/sidebar.php'; ?>

    <div class="container-fluid p-4">
        <div class="card shadow-lg border-0 rounded-4">

            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h5 class="fw-bold m-0">
                    <i class="fas fa-box me-2"></i> Manajemen Stok Produk
                </h5>
                <a href="tambah.php" class="btn btn-light rounded-pill px-4">
                    <i class="fas fa-plus me-2"></i> Tambah Produk
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Produk</th>
                                <th>Harga Jual</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php 
                        $no = 1;
                        $total_aset = 0;
                        $query = mysqli_query($conn, "SELECT * FROM produk ORDER BY NamaProduk ASC");

                        if(mysqli_num_rows($query) == 0){
                            echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data produk.</td></tr>";
                        }

                        while($d = mysqli_fetch_array($query)){
                            $subtotal_produk = $d['Harga'] * $d['Stok'];
                            $total_aset += $subtotal_produk;
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-semibold"><?= $d['NamaProduk']; ?></td>
                                <td>Rp <?= number_format($d['Harga'],0,',','.'); ?></td>
                                <td class="text-center">
                                    <span class="badge rounded-pill badge-stock <?= $d['Stok'] < 10 ? 'bg-danger' : 'bg-success'; ?>">
                                        <?= $d['Stok']; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit.php?id=<?= $d['ProdukID']; ?>" class="btn btn-sm btn-warning text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="hapus.php?id=<?= $d['ProdukID']; ?>" class="btn btn-sm btn-danger" title="Hapus"
                                           onclick="return confirm('Menghapus produk akan berpengaruh pada data transaksi terkait. Yakin?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>

                        <?php if(mysqli_num_rows($query) > 0): ?>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-end">Total Nilai Inventaris (Aset):</th>
                                <th colspan="3" class="text-primary">Rp <?= number_format($total_aset,0,',','.'); ?></th>
                            </tr>
                        </tfoot>
                        <?php endif; ?>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
