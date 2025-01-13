<?php
// Konfigurasi koneksi
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'test'; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari tabel service_requests1
$sql = "SELECT * FROM service_requests1";
$result = $conn->query($sql);

// Proses jika tombol Proses atau Selesai diklik
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];  // ID yang akan diupdate
    $action = $_POST['action'];  // Aksi yang dipilih (Proses atau Selesai)

    // Tentukan status baru berdasarkan aksi
    if ($action === 'proses') {
        $newStatus = 'Proses';
    } elseif ($action === 'selesai') {
        $newStatus = 'Selesai';
    }

    // Update status berdasarkan aksi
    if (isset($newStatus)) {
        $updateStatus = "UPDATE service_requests1 SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($updateStatus);
        $stmt->bind_param('si', $newStatus, $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Logout logic (optional)
// if (isset($_POST['logout'])) {
//     session_start();
//     session_destroy();
//     header('Location: halaman.html');
//     exit();
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        /* CSS untuk tombol logout di pojok kanan atas */
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 14px;
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Dashboard Admin</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>No Badge</th>
                    <th>Departemen</th>
                    <th>Unit Kerja</th>
                    <th>Phone Number</th>
                    <th>Jenis Perangkat</th>
                    <th>Lokasi</th>
                    <th>Jenis Layanan</th>
                    <th>Status</th> <!-- Kolom Status -->
                    <th>Proses</th>
                    <th>Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['firstName']; ?></td>
                            <td><?php echo $row['noBadge']; ?></td>
                            <td><?php echo $row['departemen']; ?></td>
                            <td><?php echo $row['unitKerja']; ?></td>
                            <td><?php echo $row['phoneNumber']; ?></td>
                            <td><?php echo $row['jenisPerangkat']; ?></td>
                            <td><?php echo $row['lokasiPerangkat']; ?></td>
                            <td><?php echo $row['serviceType']; ?></td>
                            <td><?php echo $row['status']; ?></td> <!-- Menampilkan status -->
                            <td>
                                <!-- Tombol Proses -->
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="action" value="proses" class="btn btn-warning btn-sm">Proses</button>
                                </form>
                            </td>
                            <td>
                                <!-- Tombol Selesai -->
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="action" value="selesai" class="btn btn-success btn-sm">Selesai</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Tombol Logout di pojok kanan atas -->
    <a href="halaman.html" class="logout-btn">Logout</a>
</body>
</html>
