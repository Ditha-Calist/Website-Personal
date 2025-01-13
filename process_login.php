<?php
session_start();

// Konfigurasi koneksi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'test';

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Debugging input data
    echo "Debug: Username: $user, Role: $role, Password: $pass<br>";

    // Query untuk memeriksa username dan role
    $sql = "SELECT * FROM users WHERE username = ? AND role = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param('ss', $user, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    // Debugging jumlah data ditemukan
    echo "Debug: Number of rows found: " . $result->num_rows . "<br>";

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Debugging data dari database
        echo "Debug: Data dari database:<br>";
        print_r($row);

        // Verifikasi password
        if (password_verify($pass, $row['password'])) {
            $_SESSION['username'] = $user;
            $_SESSION['role'] = $role;

            // Redirect berdasarkan role
            if ($role === 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } elseif ($role === 'user') {
                header("Location: simpan.php");
                exit();
            }
        } else {
            echo "<script>alert('Login gagal: Password salah.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Login gagal: Username atau role salah.'); window.history.back();</script>";
    }
}

$conn->close();
?>
