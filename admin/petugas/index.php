<?php 
session_start();
include '../../main/connect.php';
if($_SESSION['status'] != "login") header("location:../../auth/login.php");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Registrasi Petugas - Kasir Pro</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body{
    background:#f4f6fb;
}

/* Card Header Navy */
.card-header{
    background:linear-gradient(135deg,#0b1f3a,#1d3557);
    color:white;
}

/* Button */
.btn-navy{
    background:#1d3557;
    color:white;
}
.btn-navy:hover{
    background:#0b1f3a;
    color:white;
}

/* Table Header */
.table thead{
    background:#1d3557;
    color:white;
}

/* Button Action */
.btn-action{
    transition: all 0.3s;
    border-radius: 10px;
}
.btn-action:hover{
    transform: scale(1.1);
}

/* Badge Role */
.badge-admin{
    background:#dc3545;
}
.badge-petugas{
    background:#0dcaf0;
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
                    <i class="fas fa-user-shield me-2"></i> Manajemen User
                </h5>
                <a href="tambah_petugas.php" class="btn btn-light rounded-pill px-4">
                    <i class="fas fa-plus me-2"></i> Tambah User
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Role / Hak Akses</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php 
                        $no = 1;
                        $query = mysqli_query($conn, "SELECT * FROM user");
                        while($d = mysqli_fetch_array($query)){
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-semibold"><?= $d['Username']; ?></td>
                                <td>
                                    <span class="badge <?= $d['Role']=='admin' ? 'badge-admin' : 'badge-petugas'; ?>">
                                        <?= strtoupper($d['Role']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="edit_petugas.php?id=<?= $d['UserID']; ?>" 
                                       class="btn btn-sm btn-outline-warning btn-action me-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button onclick="confirmDelete(<?= $d['UserID']; ?>)" 
                                            class="btn btn-sm btn-outline-danger btn-action" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
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

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus User?',
        text: "User ini tidak akan bisa login lagi!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1d3557',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "hapus.php?id=" + id;
        }
    })
}
</script>

<?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'sukses'): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'User baru telah didaftarkan.',
    confirmButtonColor: '#1d3557'
});
</script>
<?php endif; ?>

</body>
</html>
