<?php 
session_start();
include '../../main/connect.php';
if($_SESSION['status'] != "login") header("location:../../auth/login.php");

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM user WHERE UserID='$id'");
$d = mysqli_fetch_array($data);

/* Proses Update */
if(isset($_POST['update'])){
    $username = $_POST['username'];
    $role     = $_POST['role'];
    $password = $_POST['password'];

    if(empty($password)){
        mysqli_query($conn,"UPDATE user SET Username='$username', Role='$role' WHERE UserID='$id'");
    }else{
        mysqli_query($conn,"UPDATE user SET Username='$username', Role='$role', Password='$password' WHERE UserID='$id'");
    }
    header("location:index.php?pesan=update_sukses");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit User - Kasir Pro</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body{
    background:#f4f6fb;
}

/* Card */
.card-edit{
    border:none;
    border-radius:18px;
    box-shadow:0 8px 24px rgba(0,0,0,.08);
}

/* Header */
.card-header{
    background:#fff;
    border-bottom:1px solid #eef1f7;
    border-radius:18px 18px 0 0;
}
.header-title{
    color:#0b1c2d;
}

/* Form */
.form-label{
    font-weight:600;
    color:#0b1c2d;
}
.form-control, .form-select{
    border-radius:12px;
}
.form-control:focus, .form-select:focus{
    border-color:#0b1c2d;
    box-shadow:0 0 0 .2rem rgba(11,28,45,.15);
}

/* Button */
.btn-navy{
    background:#0b1c2d;
    color:#fff;
    border-radius:999px;
    padding:8px 26px;
}
.btn-navy:hover{
    background:#06121f;
    color:#fff;
}

.btn-cancel{
    border-radius:999px;
    padding:8px 26px;
}

/* Info text */
.text-hint{
    font-size:13px;
}
</style>
</head>

<body>
<div class="d-flex">

    <?php include '../../template/sidebar.php'; ?>

    <div class="container-fluid p-4">

        <div class="card card-edit mx-auto" style="max-width:520px;">
            <div class="card-header py-3">
                <h5 class="fw-bold m-0 header-title">
                    <i class="fas fa-user-edit me-2"></i>Edit Data User
                </h5>
            </div>

            <div class="card-body p-4">
                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text"
                               name="username"
                               class="form-control"
                               value="<?= $d['Username']; ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role / Hak Akses</label>
                        <select name="role" class="form-select">
                            <option value="admin" <?= $d['Role']=='admin'?'selected':''; ?>>Admin</option>
                            <option value="petugas" <?= $d['Role']=='petugas'?'selected':''; ?>>Petugas</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            Ganti Password
                            <span class="text-danger text-hint">(kosongkan jika tidak diubah)</span>
                        </label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Password baru...">
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="index.php" class="btn btn-light btn-cancel">
                            Batal
                        </a>
                        <button type="submit" name="update" class="btn btn-navy">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
</body>
</html>
