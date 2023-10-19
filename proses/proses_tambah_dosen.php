<?php
// Include the database configuration
require_once '../../assets/config.php';

// Periksa apakah ada data yang dikirimkan melalui form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nid = $_POST["nid"];
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"]; // Ambil password yang belum dienkripsi

    // Lakukan validasi atau sanitasi data sesuai kebutuhan
    // ...

    // Enkripsi password menggunakan password_hash()
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert data ke dalam tabel "user" untuk membuat user baru
    $insertUserQuery = "INSERT INTO user (username, password, level) VALUES ('$username', '$hashedPassword', 'dosen')";
    if ($conn->query($insertUserQuery) === TRUE) {
        // Dapatkan ID user yang baru saja ditambahkan
        $user_id = $conn->insert_id;

        // Insert data dosen dengan user ID yang sesuai ke dalam tabel "dosen"
        $insertDosenQuery = "INSERT INTO dosen (user_id, nid, nama, email) VALUES ($user_id, '$nid', '$nama', '$email')";
        if ($conn->query($insertDosenQuery) === TRUE) {
            // Redirect kembali ke halaman daftar dosen dengan pesan sukses
            header("Location: ../daftar-dosen.php");
            exit();
        } else {
            // Jika gagal menyimpan data dosen, maka hapus juga user yang sudah dibuat sebelumnya
            $conn->query("DELETE FROM user WHERE id = $user_id");
            header("Location: ../daftar-dosen.php");
            exit();
        }
    } else {
        // Jika gagal membuat user baru, beri tahu pengguna
        header("Location: ../daftar-dosen.php");
        exit();
    }
}

// Tutup koneksi database
$conn->close();
?>
