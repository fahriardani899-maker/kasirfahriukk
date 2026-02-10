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

if (!isset($_GET['id'])) {
    header("location:index.php");
    exit;
}

$id = $_GET['id'];

// cek histori penjualan
$cek = mysqli_query($conn, "SELECT COUNT(*) AS total FROM penjualan WHERE PelangganID = '$id'");
$data = mysqli_fetch_assoc($cek);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Hapus Pelanggan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
if ($data['total'] > 0) {
    // tidak bisa hapus
    echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Pelanggan tidak bisa dihapus karena memiliki histori transaksi!',
            confirmButtonColor: '#1d4ed8'
        }).then(() => {
            window.location = 'index.php';
        });
    </script>
    ";
    exit;
}

// hapus pelanggan
$hapus = mysqli_query($conn, "DELETE FROM pelanggan WHERE PelangganID = '$id'");

if ($hapus) {
    echo "
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data pelanggan berhasil dihapus.',
            confirmButtonColor: '#1d4ed8'
        }).then(() => {
            window.location = 'index.php';
        });
    </script>
    ";
} else {
    echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Data pelanggan gagal dihapus.',
            confirmButtonColor: '#1d4ed8'
        }).then(() => {
            window.location = 'index.php';
        });
    </script>
    ";
}
?>

</body>
</html>
