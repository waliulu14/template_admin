<?php
// Include the database configuration
require_once '../../assets/config.php';

if (isset($_GET['id'])) {
    // Ambil ID dosen yang akan dihapus
    $id = $_GET['id'];

    // Mulai transaksi
    $conn->begin_transaction();

    // Query untuk menghapus data dosen dari tabel 'dosen' berdasarkan ID
    $queryDosen = "DELETE FROM dosen WHERE id = $id";

    // Dapatkan user_id dari tabel 'dosen' berdasarkan ID dosen
    $getUserIDQuery = "SELECT user_id FROM dosen WHERE id = $id";
    $user_id = $conn->query($getUserIDQuery)->fetch_assoc()['user_id'];

    // Query untuk menghapus data user dari tabel 'user' berdasarkan user_id yang sesuai
    $queryUser = "DELETE FROM user WHERE id = $user_id";

    if ($conn->query($queryDosen) === TRUE && $conn->query($queryUser) === TRUE) {
        // Jika kedua query berhasil, commit transaksi dan kembalikan ke halaman daftar-dosen.php dengan pesan sukses
        $conn->commit();
        header("Location: ../daftar-dosen.php");
        exit();
    } else {
        // Jika terjadi kesalahan saat penghapusan, rollback transaksi dan kembalikan ke halaman daftar-dosen.php dengan pesan error
        $conn->rollback();
        header("Location: ../daftar-dosen.php");
        exit();
    }
} else {
    // Jika tidak ada ID yang diterima, kembalikan ke halaman daftar-dosen.php
    header("Location: ../daftar-dosen.php");
    exit();
}

// Tutup koneksi database
$conn->close();
?>
