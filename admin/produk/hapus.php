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
    <title>Hapus Produk</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #f8f9fa; }
    </style>
</head>
<body>

<?php 
if(isset($_GET['id']) && !isset($_GET['confirm'])) {
    $id = $_GET['id'];
    ?>

    <script>
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Produk ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0b1c2d',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "hapus.php?confirm=yes&id=<?= $id ?>";
            } else {
                window.location.href = "index.php";
            }
        });
    </script>

<?php
}
elseif(isset($_GET['id']) && isset($_GET['confirm'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // CEK apakah produk pernah terjual
    $cek_transaksi = mysqli_query($conn, "SELECT * FROM detailpenjualan WHERE ProdukID='$id'");

    if (mysqli_num_rows($cek_transaksi) > 0) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Tidak Bisa Dihapus!',
                text: 'Produk ini sudah memiliki riwayat transaksi. Gunakan fitur edit untuk mengubah stok.',
                confirmButtonColor: '#0b1c2d'
            }).then(() => { window.location.href = 'index.php'; });
        </script>";
    } else {

        $query = mysqli_query($conn, "DELETE FROM produk WHERE ProdukID='$id'");

        if ($query) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data produk berhasil dihapus.',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => { window.location.href = 'index.php'; });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menghapus data.',
                    confirmButtonColor: '#0b1c2d'
                }).then(() => { window.location.href = 'index.php'; });
            </script>";
        }
    }
}
else {
    header("location:index.php");
}
?>

</body>
</html>
