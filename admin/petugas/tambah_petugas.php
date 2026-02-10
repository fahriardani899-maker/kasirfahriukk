<?php 
session_start();
include '../../main/connect.php';
if($_SESSION['status'] != "login") header("location:../../auth/login.php");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User - Kasir Pro</title>
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
        }
        .btn-navy:hover {
            background-color: #142f4c;
            color: #fff;
        }
        .form-control, .form-select {
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <?php include '../../template/sidebar.php'; ?>

    <div class="container-fluid p-4">
        <div class="col-md-5 mx-auto">
            <div class="card shadow border-0 mt-5 card-custom">
                <div class="card-header bg-navy text-white text-center py-3 rounded-top">
                    <h5 class="fw-bold m-0">
                        <i class="fas fa-user-plus me-2"></i> Registrasi User Baru
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="proses_tambah.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-navy">Username</label>
                            <input type="text" name="Username" class="form-control" placeholder="Masukkan username..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-navy">Password</label>
                            <input type="password" name="Password" class="form-control" placeholder="Masukkan password..." required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-navy">Role / Level</label>
                            <select name="Role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-navy fw-bold p-2 shadow">
                                <i class="fas fa-save me-2"></i> Daftarkan Akun
                            </button>
                            <a href="index.php" class="btn btn-outline-secondary rounded-pill">
                                <i class="fas fa-arrow-left me-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FontAwesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>
