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

// Ambil data berdasarkan pencarian No Badge
$searchResult = null;
if (isset($_POST['search'])) {
    $noBadge = $_POST['noBadge'];
    $fullName = $_POST['fullName'];
    $sql = "SELECT * FROM service_requests1 WHERE noBadge = '$noBadge' AND firstName LIKE '%$fullName%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $searchResult = $result->fetch_assoc(); // Ambil hasil pertama
    } else {
        $searchResult = null;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Layanan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 700px;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
        }
        .back-button {
            font-size: 14px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Tombol Kembali -->
        <a href="halaman.html" class="btn btn-secondary back-button">Kembali</a>

        <h1>Cek Status Layanan</h1>

        <!-- Form untuk memasukkan Nama Lengkap dan No Badge -->
        <form method="post">
            <div class="form-group">
                <label for="fullName">Nama Lengkap:</label>
                <input type="text" class="form-control" id="fullName" name="fullName" required placeholder="Masukkan Nama Lengkap">
            </div>
            <div class="form-group">
                <label for="noBadge">No Badge:</label>
                <input type="text" class="form-control" id="noBadge" name="noBadge" required placeholder="Masukkan No Badge">
            </div>
            <button type="submit" name="search" class="btn btn-primary btn-block">Cari</button>
        </form>

        <?php if ($searchResult): ?>
            <h3 class="mt-4">Data yang Ditemukan</h3>
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
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $searchResult['id']; ?></td>
                        <td><?php echo $searchResult['firstName']; ?></td>
                        <td><?php echo $searchResult['noBadge']; ?></td>
                        <td><?php echo $searchResult['departemen']; ?></td>
                        <td><?php echo $searchResult['unitKerja']; ?></td>
                        <td><?php echo $searchResult['phoneNumber']; ?></td>
                        <td><?php echo $searchResult['jenisPerangkat']; ?></td>
                        <td><?php echo $searchResult['lokasiPerangkat']; ?></td>
                        <td><?php echo $searchResult['serviceType']; ?></td>
                        <td><?php echo $searchResult['status']; ?></td>
                    </tr>
                </tbody>
            </table>
        <?php elseif (isset($_POST['search'])): ?>
            <p class="text-danger">Tidak ada data yang ditemukan untuk No Badge atau Nama Lengkap tersebut.</p>
        <?php endif; ?>
    </div>
</body>
</html>
