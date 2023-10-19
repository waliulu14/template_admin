<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect to the login page
    header('Location: login.php');
    exit();
}

// Include the database configuration
require_once '../assets/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input from the profile update form
    $newUsername = $_POST['username'];
    $newNamaMahasiswa = $_POST['nama_mahasiswa'];
    $newEmail = $_POST['email'];
    $newProdi = $_POST['prodi'];
    $newNoTelp = $_POST['noTelp'];
    $newNim = $_POST['nim'];
    $newPassword = $_POST['password'];

    // Perform input validation and any other necessary checks here

    // Update data in the 'user' table
    $updateUserQuery = "UPDATE user SET username = ? WHERE username = ?";
    $stmtUpdateUser = $conn->prepare($updateUserQuery);
    $stmtUpdateUser->bind_param("ss", $newUsername, $_SESSION['username']);

    // Update data in the 'mahasiswa' table, including the 'nama_mahasiswa' field
    $updateMahasiswaQuery = "UPDATE mahasiswa SET email = ?, nama_mahasiswa = ?, prodi = ?, no_telp = ?, nim = ? WHERE user_id = ?";
    $stmtUpdateMahasiswa = $conn->prepare($updateMahasiswaQuery);
    $stmtUpdateMahasiswa->bind_param("sssssi", $newEmail, $newNamaMahasiswa, $newProdi, $newNoTelp, $newNim, $_SESSION['user_id']); // Assuming you have a 'user_id' session variable

    // Check if a new password is provided and update it
    if (!empty($newPassword)) {
        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
        $updatePasswordQuery = "UPDATE user SET password = ? WHERE username = ?";
        $stmtUpdatePassword = $conn->prepare($updatePasswordQuery);
        $stmtUpdatePassword->bind_param("ss", $hashed_password, $_SESSION['username']);
    }

    // Execute the updates
    if ($stmtUpdateUser->execute() && $stmtUpdateMahasiswa->execute()) {
        // If the password update query exists, execute it
        if (isset($stmtUpdatePassword)) {
            $stmtUpdatePassword->execute();
        }

        // Profile update successful; redirect to a success page
        header('Location: ../seting-profile.php');
        exit();
    } else {
        // Error updating profile data; redirect to a error page
        header('Location: ../seting-profile.php');
        exit();
    }
} else {
    // Redirect to the profile settings page if the request method is not POST
    header('Location: ../seting-profile.php');
    exit();
}
?>
