<?php 
session_start();
include '../../main/connect.php';
if($_SESSION['status'] != "login") header("location:../../auth/login.php");

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM produk WHERE ProdukID='$id'");
$d = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk - Kasir Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f4f6f9;
        }
        .card-custom {
            border-radius: 15px;
        }
        .bg-navy {
            background-color: #0b1c2d !important;
        }
        .text-navy {
            color: #0b1c2d;
        }
        .btn-navy {
            background-color: #0b1c2d;
            color: #fff;
            border-radius: 30px;
            transition: 0.3s;
        }
        .btn-navy:hover {
            background-color: #142f4c;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(11,28,45,0.4);
        }
        .form-control {
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <?php include '../../template/sidebar.php'; ?>

    <div class="container-fluid p-4">
        <div class="col-md-6 mx-auto">
            <div class="card shadow border-0 card-custom">
                
                <div class="card-header bg-navy text-white py-3 text-center rounded-top">
                    <h5 class="fw-bold m-0">
                        <i class="fas fa-edit me-2"></i>Edit Produk
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form id="formEdit" action="proses_edit.php" method="POST">
                        <input type="hidden" name="ProdukID" value="<?= $d['ProdukID']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold text-navy">Nama Produk</label>
                            <input type="text" name="NamaProduk" class="form-control" value="<?= $d['NamaProduk']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-navy">Harga (Rp)</label>
                            <input type="number" name="Harga" class="form-control" value="<?= $d['Harga']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-navy">Stok</label>
                            <input type="number" name="Stok" class="form-control" value="<?= $d['Stok']; ?>" required>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="button" onclick="confirmEdit()" class="btn btn-navy fw-bold p-2 shadow">
                                <i class="fas fa-save me-2"></i>Update Produk
                            </button>
                            <a href="index.php" class="btn btn-outline-secondary rounded-pill">
                                <i class="fas fa-arrow-left me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function confirmEdit() {
    Swal.fire({
        title: 'Update data?',
        text: "Data produk akan segera diperbarui",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0b1c2d',
        confirmButtonText: 'Ya, Update!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formEdit').submit();
        }
    })
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>
