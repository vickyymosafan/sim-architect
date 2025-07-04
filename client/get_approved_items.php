<?php
require_once '../includes/session_manager.php';
check_session_auth('client');
require '../koneksi.php';

header('Content-Type: application/json');

$type = $_GET['type'] ?? '';

if (!in_array($type, ['file', 'tugas'])) {
    echo json_encode([]);
    exit;
}

$items = [];

if ($type === 'file') {
    // Get approved files
    $query = "SELECT id, gambar, deskripsi FROM file_gambar WHERE status_verifikasi = 'approved' ORDER BY tanggal_verifikasi DESC";
    $result = mysqli_query($koneksi, $query);
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }
    }
} elseif ($type === 'tugas') {
    // Get approved tasks
    $query = "SELECT id, nama_kegiatan, deskripsi FROM tugas_proyek WHERE status_verifikasi = 'approved' ORDER BY tanggal_verifikasi DESC";
    $result = mysqli_query($koneksi, $query);
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }
    }
}

echo json_encode($items);
?>
