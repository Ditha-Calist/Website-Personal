<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dari form dan sanitasi input
    $firstName = trim($_POST['firstName'] ?? '');
    $noBadge = trim($_POST['NoBadge'] ?? '');
    $departemen = trim($_POST['Departemen'] ?? '');
    $unitKerja = trim($_POST['UnitKerja'] ?? '');
    $phoneNumber = trim($_POST['PhoneNumber'] ?? '');
    $namaAtasan = trim($_POST['NamaAtasan'] ?? '');
    $badgeAtasan = trim($_POST['BadgeAtasan'] ?? '');
    $jenisPerangkat = trim($_POST['perangkat'] ?? '');
    $serialNumber = trim($_POST['serialNumber'] ?? '');
    $lokasiPerangkat = trim($_POST['lokasiPerangkat'] ?? '');
    $serviceType = trim($_POST['serviceType'] ?? '');
    $deskripsiRequest = trim($_POST['deskripsiRequest'] ?? '');

    // Validasi input (opsional, sesuaikan kebutuhan)
    if (empty($firstName) || empty($noBadge) || empty($departemen) || empty($unitKerja) || empty($phoneNumber)) {
        die("Harap lengkapi semua data yang wajib diisi.");
    }

    // Koneksi ke database
    $conn = new mysqli('localhost', 'root', '', 'test');

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk menyimpan data
    $sql = "INSERT INTO service_requests1 (
        firstName, noBadge, departemen, unitKerja, phoneNumber, namaAtasan, badgeAtasan, 
        jenisPerangkat, serialNumber, lokasiPerangkat, serviceType, deskripsiRequest
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Gagal mempersiapkan statement: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssssssssss",
        $firstName,
        $noBadge,
        $departemen,
        $unitKerja,
        $phoneNumber,
        $namaAtasan,
        $badgeAtasan,
        $jenisPerangkat,
        $serialNumber,
        $lokasiPerangkat,
        $serviceType,
        $deskripsiRequest
    );

    if (!$stmt->execute()) {
        die("Gagal menyimpan data: " . $stmt->error);
    }

    // Tutup koneksi
    $stmt->close();
    $conn->close();

    // Redirect ke print.php dengan query string
    $queryString = http_build_query([
        'firstName' => $firstName,
        'noBadge' => $noBadge,
        'departemen' => $departemen,
        'unitKerja' => $unitKerja,
        'phoneNumber' => $phoneNumber,
        'namaAtasan' => $namaAtasan,
        'badgeAtasan' => $badgeAtasan,
        'jenisPerangkat' => $jenisPerangkat,
        'serialNumber' => $serialNumber,
        'lokasiPerangkat' => $lokasiPerangkat,
        'serviceType' => $serviceType,
        'deskripsiRequest' => $deskripsiRequest,
    ]);

    header("Location: print.php?$queryString");
    exit();
} else {
    die("Invalid request method.");
}
?>
