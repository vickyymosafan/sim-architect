<?php
require_once '../includes/session_manager.php';
check_session_auth('client');
require '../koneksi.php';

$rab_id = (int)($_GET['id'] ?? 0);
$client_id = $_SESSION['id_client'] ?? 1; // Default untuk testing

if ($rab_id <= 0) {
    echo "<script>alert('ID RAB tidak valid!'); window.close();</script>";
    exit;
}

// Get RAB detail
$rab_query = "SELECT rp.*, p.nama_petugas as verifikator_name
              FROM rab_proyek rp
              LEFT JOIN petugas p ON rp.verifikator_id = p.id_petugas
              WHERE rp.id = $rab_id AND rp.client_id = $client_id AND rp.status = 'approved'";
$rab_result = mysqli_query($koneksi, $rab_query);

if (!$rab_result || mysqli_num_rows($rab_result) === 0) {
    echo "<script>alert('RAB tidak ditemukan atau belum disetujui!'); window.close();</script>";
    exit;
}

$rab = mysqli_fetch_array($rab_result);

// Check if file exists
$file_path = "../file_rab/" . $rab['file_rab'];
if (!file_exists($file_path)) {
    echo "<script>alert('File RAB tidak ditemukan!'); window.close();</script>";
    exit;
}

// Redirect to file for direct download/view
header("Location: $file_path");
exit;
?>
