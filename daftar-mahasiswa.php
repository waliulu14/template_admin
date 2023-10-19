<?php include 'assets/navbar.php' ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Mahasiswa</h1>
    
    <!-- DataTales Example -->
    <br>
    <br>
    <?php if (isset($_GET['success']) && $_GET['success'] == 'hapus') : ?>
        <div class="alert alert-success mt-3" role="alert">
            Mahasiswa berhasil dihapus.
        </div>
    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'hapus') : ?>
        <div class="alert alert-danger mt-3" role="alert">
            Terjadi kesalahan saat menghapus mahasiswa.
        </div>
    <?php endif; ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th> <!-- Tambahkan kolom nomor urutan -->
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Email</th>
                            <th>Prodi</th>
                            <th>No. Telp</th>
                            <th>Aksi</th> <!-- Tambahkan kolom aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Include the database configuration
                        require_once '../assets/config.php';

                        // Query to retrieve mahasiswa data with user information
                        $query = "SELECT m.id, m.nim, m.nama_mahasiswa, m.email, m.prodi, m.no_telp, u.username
                                  FROM mahasiswa m
                                  INNER JOIN user u ON m.user_id = u.id";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            $no = 1; // Inisialisasi nomor urutan
                            while ($row = $result->fetch_assoc()) {
                                $id = $row["id"];
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>"; // Tambahkan nomor urutan dan tingkatkan nilainya
                                echo "<td>" . $row["nim"] . "</td>";
                                echo "<td>" . $row["nama_mahasiswa"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["prodi"] . "</td>";
                                echo "<td>" . $row["no_telp"] . "</td>";
                                echo "<td>
                                    <a href='#' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#hapusMahasiswaModal$id'>Hapus</a>
                                </td>";
                                echo "</tr>";

                                // Buat modal konfirmasi penghapusan untuk setiap baris
                                echo "<div class='modal fade' id='hapusMahasiswaModal$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='exampleModalLabel'>Konfirmasi Hapus Mahasiswa</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                                Apakah Anda yakin ingin menghapus mahasiswa ini?
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Batal</button>
                                                <a href='proses/proses_hapus_mahasiswa.php?id=$id' class='btn btn-danger'>Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Tidak ada data mahasiswa.</td></tr>";
                        }

                        // Close the database connection
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/footer.php' ?>


