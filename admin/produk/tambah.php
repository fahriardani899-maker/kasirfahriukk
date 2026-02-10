<?php 
session_start();
include '../../main/connect.php';
// Proteksi halaman
if($_SESSION['status'] != "login") header("location:../../auth/login.php");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - Kasir Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f4f6f9;
        }
        .bg-navy {
            background-color: #0b1c2d !important;
        }
        .text-navy {
            color: #0b1c2d;
        }
        .card-custom {
            border-radius: 15px;
        }
        .form-control, .input-group-text {
            border-radius: 10px;
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
    </style>
</head>
<body>
<div class="d-flex">
    <?php include '../../template/sidebar.php'; ?>
    
    <div class="container-fluid p-4">
        <div class="col-md-6 mx-auto">

            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-navy fw-bold">Data Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Produk</li>
              </ol>
            </nav>

            <div class="card shadow border-0 card-custom">
                <div class="card-header bg-navy text-white py-3 text-center rounded-top">
                    <h5 class="fw-bold m-0">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Produk Baru
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form id="formTambah" action="proses_tambah.php" method="POST">

                        <div class="mb-3">
                            <label class="form-label fw-bold text-navy">Nama Produk</label>
                            <input type="text" name="NamaProduk" class="form-control shadow-sm" placeholder="Contoh: Sabun Cuci" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-navy">Harga Jual</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-navy text-white">Rp</span>
                                <input type="number" name="Harga" class="form-control" placeholder="0" min="0" required>
                            </div>
                            <div class="form-text">Pastikan harga tidak bernilai negatif.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-navy">Stok Awal</label>
                            <input type="number" name="Stok" class="form-control shadow-sm" placeholder="0" min="0" required>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="button" onclick="confirmAdd()" class="btn btn-navy fw-bold py-2 shadow-sm">
                                <i class="fas fa-save me-2"></i>Simpan Produk
                            </button>
                            <a href="index.php" class="btn btn-outline-secondary py-2 fw-bold rounded-pill">
                                <i class="fas fa-arrow-left me-2"></i>Batal & Kembali
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function confirmAdd() {
    const form = document.getElementById('formTambah');
    const nama = form.NamaProduk.value;
    const harga = form.Harga.value;
    const stok = form.Stok.value;

    if(!nama || !harga || !stok) {
        Swal.fire({
            icon: 'warning',
            title: 'Data Belum Lengkap',
            text: 'Harap isi semua kolom sebelum menyimpan!',
            confirmButtonColor: '#0b1c2d'
        });
        return;
    }

    if(harga < 0 || stok < 0) {
        Swal.fire({
            icon: 'error',
            title: 'Input Tidak Valid',
            text: 'Harga dan Stok tidak boleh bernilai negatif!',
            confirmButtonColor: '#0b1c2d'
        });
        return;
    }

    Swal.fire({
        title: 'Simpan Produk?',
        text: "Data " + nama + " akan ditambahkan ke sistem.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0b1c2d',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Cek Kembali'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    })
}
</script>
</body>
</html>
