<?php
// Include the database configuration
require_once '../../assets/config.php';

if (isset($_GET['id'])) {
    // Ambil ID mahasiswa yang akan dihapus
    $id = $_GET['id'];

    // Mulai transaksi
    $conn->begin_transaction();

    // Query untuk menghapus data mahasiswa dari tabel 'mahasiswa' berdasarkan ID
    $queryMahasiswa = "DELETE FROM mahasiswa WHERE id = $id";
    
    // Query untuk menghapus data user dengan user_id yang sesuai dari tabel 'user'
    $queryUser = "DELETE FROM user WHERE id = (SELECT user_id FROM mahasiswa WHERE id = $id)";

    if ($conn->query($queryMahasiswa) === TRUE && $conn->query($queryUser) === TRUE) {
        // Jika kedua query berhasil, commit transaksi dan kembalikan ke halaman daftar-mahasiswa.php dengan pesan sukses
        $conn->commit();
        header("Location: ../daftar-mahasiswa.php");
        exit();
    } else {
        // Jika terjadi kesalahan saat penghapusan, rollback transaksi dan kembalikan ke halaman daftar-mahasiswa.php dengan pesan error
        $conn->rollback();
        header("Location: ../daftar-mahasiswa.php");
        exit();
    }
} else {
    // Jika tidak ada ID yang diterima, kembalikan ke halaman daftar-mahasiswa.php
    header("Location: ../daftar-mahasiswa.php");
    exit();
}

// Tutup koneksi database
$conn->close();
?>
