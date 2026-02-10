<?php
session_start();
include '../../main/connect.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:../../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header("location:../../petugas/dashboard/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pelanggan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { background: #f1f4f9; }
        .header-box {
            background: linear-gradient(135deg, #0a1f44, #1d4ed8);
            color: white;
            padding: 15px 20px;
            border-radius: 15px;
        }
        .card { border-radius: 15px; }
        .btn-history {
            background-color: #0a1f44;
            color: #fff;
        }
        .btn-history:hover {
            background-color: #081a38;
            color: #fff;
        }
    </style>
</head>

<body>
<div class="d-flex">

<?php include '../../template/sidebar.php'; ?>

<div class="container-fluid p-4">

    <!-- HEADER -->
    <div class="header-box mb-4 shadow">
        <h4 class="mb-0">
            <i class="fas fa-users me-2"></i> Data Pelanggan (Admin)
        </h4>
    </div>

    <!-- TABLE -->
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

                if(mysqli_num_rows($query) > 0):
                    while ($p = mysqli_fetch_assoc($query)):
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($p['NamaPelanggan']); ?></td>
                    <td><?= htmlspecialchars($p['NomorTelepon']); ?></td>
                    <td><?= htmlspecialchars($p['Alamat']); ?></td>
                    <td class="text-center">

                        <!-- EDIT -->
                        <a href="edit.php?id=<?= $p['PelangganID']; ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>

                        <!-- HISTORI -->
                        <a href="histori.php?id=<?= $p['PelangganID']; ?>" class="btn btn-sm btn-history">
                            <i class="fas fa-clock-rotate-left me-1"></i> Histori
                        </a>

                        <!-- HAPUS -->
                        <button onclick="hapusData('<?= $p['PelangganID']; ?>')" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>

                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Data pelanggan belum tersedia</td>
                </tr>
                <?php endif; ?>

                </tbody>
            </table>

        </div>
    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function hapusData(id){
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data pelanggan akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1d4ed8',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'hapus.php?id=' + id;
        }
    })
}
</script>

</body>
</html>
