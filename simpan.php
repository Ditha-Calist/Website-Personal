<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'test'; // Nama database Anda

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses form saat submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $firstName = $_POST['firstName'];
    $noBadge = $_POST['noBadge'];
    $departemen = $_POST['departemen'];
    $unitKerja = $_POST['unitKerja'];
    $phoneNumber = $_POST['phoneNumber'];
    $namaAtasan = $_POST['namaAtasan'];
    $badgeAtasan = $_POST['badgeAtasan'];
    $jenisPerangkat = $_POST['jenisPerangkat'];
    $serialNumber = $_POST['serialNumber'];
    $lokasiPerangkat = $_POST['lokasiPerangkat'];
    $serviceType = $_POST['serviceType'];
    $deskripsiRequest = $_POST['deskripsiRequest'];

    // Query untuk menyimpan data
    $sql = "INSERT INTO service_requests1 (firstName, noBadge, departemen, unitKerja, phoneNumber, namaAtasan, badgeAtasan, jenisPerangkat, serialNumber, lokasiPerangkat, serviceType, deskripsiRequest) VALUES ('$firstName', '$noBadge', '$departemen', '$unitKerja', '$phoneNumber', '$namaAtasan', '$badgeAtasan', '$jenisPerangkat', '$serialNumber', '$lokasiPerangkat', '$serviceType', '$deskripsiRequest')";

    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman selesai.html setelah berhasil menyimpan data
        header("Location: selesai.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>SERVICE REQUEST FORM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 24px;
            color: #007bff;
            text-decoration: none;
        }
        .back-btn:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Tombol Kembali -->
    <a href="halaman.html" class="back-btn">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">
                        <img src="logo.jpg" alt="Logo" class="logo-img">
                        <h1>SERVICE REQUEST FORM</h1>
                    </div>
                    <div class="panel-body">
                        <!-- Form untuk menyimpan data -->
                        <form action="simpan.php" method="post" id="serviceRequestForm">
                            <div class="form-group">
                                <label for="firstName">Nama Lengkap Pengguna</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required />
                            </div>
                            <div class="form-group">
                                <label for="noBadge">No Badge</label>
                                <input type="text" class="form-control" id="noBadge" name="noBadge" required />
                            </div>
                            <div class="form-group">
                                <label for="departemen">Departemen</label>
                                <input type="text" class="form-control" id="departemen" name="departemen" required />
                            </div>
                            <div class="form-group">
                                <label for="unitKerja">Unit Kerja</label>
                                <input type="text" class="form-control" id="unitKerja" name="unitKerja" required />
                            </div>
                            <div class="form-group">
                                <label for="phoneNumber">Phone Number</label>
                                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required />
                            </div>
                            <div class="form-group">
                                <label for="namaAtasan">Nama Atasan</label>
                                <input type="text" class="form-control" id="namaAtasan" name="namaAtasan" />
                            </div>
                            <div class="form-group">
                                <label for="badgeAtasan">Badge Atasan</label>
                                <input type="text" class="form-control" id="badgeAtasan" name="badgeAtasan" />
                            </div>
                            <div class="form-group">
                                <label for="jenisPerangkat">Jenis Perangkat</label>
                                <select class="form-control" id="jenisPerangkat" name="jenisPerangkat">
                                    <option value="desktop">Perangkat Desktop</option>
                                    <option value="laptop">Laptop</option>
                                    <option value="printer">Printer</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="serialNumber">No. Inventaris / Serial Number Perangkat</label>
                                <input type="text" class="form-control" id="serialNumber" name="serialNumber" />
                            </div>
                            <div class="form-group">
                                <label for="lokasiPerangkat">Lokasi Perangkat</label>
                                <input type="text" class="form-control" id="lokasiPerangkat" name="lokasiPerangkat" />
                            </div>
                            <div class="form-group">
                                <label for="serviceType">Jenis Layanan</label>
                                <div>
                                    <label for="repair" class="radio-inline">
                                        <input type="radio" name="serviceType" value="Repair" id="repair" />Repair
                                    </label>
                                    <label for="upgrade" class="radio-inline">
                                        <input type="radio" name="serviceType" value="Upgrade" id="upgrade" />Upgrade
                                    </label>
                                    <label for="hardwareSupport" class="radio-inline">
                                        <input type="radio" name="serviceType" value="Hardware Support" id="hardwareSupport" />Hardware Support
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="deskripsiRequest">Deskripsi Request</label>
                                <textarea class="form-control" id="deskripsiRequest" name="deskripsiRequest" rows="4"></textarea>
                            </div>
                            <!-- Tombol Simpan Data -->
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
