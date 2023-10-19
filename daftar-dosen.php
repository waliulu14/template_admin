<?php include 'assets/navbar.php' ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Dosen</h1>
    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#tambahDosenModal">
        Tambah Dosen
    </button>
    <!-- DataTales Example -->
    <br>
    <br>
    <?php if (isset($_GET['success']) && $_GET['success'] == 'hapus') : ?>
        <div class="alert alert-success mt-3" role="alert">
            Dosen berhasil dihapus.
        </div>
    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'hapus') : ?>
        <div class="alert alert-danger mt-3" role="alert">
            Terjadi kesalahan saat menghapus dosen.
        </div>
    <?php endif; ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th> <!-- Tambahkan kolom nomor urutan -->
                            <th>NID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Aksi</th> <!-- Tambahkan kolom aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Include the database configuration
                        require_once '../assets/config.php';

                        // Query to retrieve dosen data with user information
                        $query = "SELECT d.id, d.nid, d.nama, d.email, u.username, u.level
                                  FROM dosen d
                                  INNER JOIN user u ON d.user_id = u.id";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            $no = 1; // Inisialisasi nomor urutan
                            while ($row = $result->fetch_assoc()) {
                                $id = $row["id"];
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>"; // Tambahkan nomor urutan dan tingkatkan nilainya
                                echo "<td>" . $row["nid"] . "</td>";
                                echo "<td>" . $row["nama"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . "******" . "</td>";
                                echo "<td>
                                    <a href='#' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#hapusDosenModal$id'>Hapus</a>
                                </td>";
                                echo "</tr>";

                                // Buat modal konfirmasi penghapusan untuk setiap baris
                                echo "<div class='modal fade' id='hapusDosenModal$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='exampleModalLabel'>Konfirmasi Hapus Dosen</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                                Apakah Anda yakin ingin menghapus dosen ini?
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Batal</button>
                                                <a href='proses/proses_hapus_dosen.php?id=$id' class='btn btn-danger'>Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Tidak ada data dosen.</td></tr>";
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


<!-- Modal Tambah Dosen -->
<div class="modal fade" id="tambahDosenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Dosen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menambahkan dosen -->
                <form method="POST" action="proses/proses_tambah_dosen.php">
                    <div class="form-group">
                        <label for="nid">NID</label>
                        <input type="number" class="form-control" id="nid" name="nid" inputmode="numeric" required>
                    </div>


                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <!-- Input untuk Username -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <!-- Input untuk Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <!-- ... -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>