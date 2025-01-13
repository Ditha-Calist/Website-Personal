<?php
// Konfigurasi koneksi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'test'; // Ganti dengan nama database Anda

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Query untuk memeriksa username dan password
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika login berhasil, arahkan ke index.html
        header("Location: index.html");
        exit();
    } else {
        // Jika login gagal, tampilkan pesan error
        echo "<script>alert('Username atau password salah!'); window.history.back();</script>";
    }
}
?>
