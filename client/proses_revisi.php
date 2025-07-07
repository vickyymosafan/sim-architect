<?php
require_once '../includes/session_manager.php';
check_session_auth('client');
require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ajukan_revisi.php');
    exit;
}

// Get client ID from session
$client_id = $_SESSION['id_client'] ?? 1; // Default untuk testing

// Get form data
$item_type = mysqli_real_escape_string($koneksi, $_POST['item_type']);
$item_id = (int)$_POST['item_id'];
$alasan_revisi = mysqli_real_escape_string($koneksi, $_POST['alasan_revisi']);
$detail_perubahan = mysqli_real_escape_string($koneksi, $_POST['detail_perubahan']);

// Validate input
if (!in_array($item_type, ['file', 'tugas']) || $item_id <= 0 || empty($alasan_revisi)) {
    echo "<script>alert('Data tidak valid!'); window.location.href='ajukan_revisi.php';</script>";
    exit;
}

// Check daily quota
$today = date('Y-m-d');
$quota_query = "SELECT jumlah_request FROM revisi_quota WHERE client_id = $client_id AND tanggal = '$today'";
$quota_result = mysqli_query($koneksi, $quota_query);
$current_quota = 0;

if ($quota_result && mysqli_num_rows($quota_result) > 0) {
    $quota_data = mysqli_fetch_array($quota_result);
    $current_quota = $quota_data['jumlah_request'];
}

if ($current_quota >= 4) {
    echo "<script>alert('Quota revisi harian sudah habis (4 revisi per hari)!'); window.location.href='ajukan_revisi.php';</script>";
    exit;
}

// Handle file upload
$file_referensi = null;
if (isset($_FILES['file_referensi']) && $_FILES['file_referensi']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../file_revisi/';
    
    // Create directory if not exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_tmp = $_FILES['file_referensi']['tmp_name'];
    $file_name = $_FILES['file_referensi']['name'];
    $file_size = $_FILES['file_referensi']['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Validate file
    $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf', 'dwg'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file_ext, $allowed_ext)) {
        echo "<script>alert('Format file tidak diizinkan! Gunakan: JPG, PNG, PDF, DWG'); window.location.href='ajukan_revisi.php';</script>";
        exit;
    }
    
    if ($file_size > $max_size) {
        echo "<script>alert('Ukuran file terlalu besar! Maksimal 5MB'); window.location.href='ajukan_revisi.php';</script>";
        exit;
    }
    
    // Generate unique filename
    $new_filename = 'revisi_' . $client_id . '_' . time() . '.' . $file_ext;
    $upload_path = $upload_dir . $new_filename;
    
    if (move_uploaded_file($file_tmp, $upload_path)) {
        $file_referensi = $new_filename;
    } else {
        echo "<script>alert('Gagal upload file referensi!'); window.location.href='ajukan_revisi.php';</script>";
        exit;
    }
}

// Start transaction
mysqli_begin_transaction($koneksi);

try {
    // Insert revisi request
    $insert_query = "INSERT INTO revisi_request 
                    (client_id, item_type, item_id, alasan_revisi, detail_perubahan, file_referensi, status_revisi, tanggal_request) 
                    VALUES 
                    ($client_id, '$item_type', $item_id, '$alasan_revisi', '$detail_perubahan', " . 
                    ($file_referensi ? "'$file_referensi'" : "NULL") . ", 'pending', NOW())";
    
    if (!mysqli_query($koneksi, $insert_query)) {
        throw new Exception("Gagal menyimpan permintaan revisi");
    }
    
    // Update or insert quota
    $update_quota_query = "INSERT INTO revisi_quota (client_id, tanggal, jumlah_request) 
                          VALUES ($client_id, '$today', 1)
                          ON DUPLICATE KEY UPDATE jumlah_request = jumlah_request + 1";
    
    if (!mysqli_query($koneksi, $update_quota_query)) {
        throw new Exception("Gagal update quota");
    }
    
    // Commit transaction
    mysqli_commit($koneksi);
    
    echo "<script>
            alert('Permintaan revisi berhasil diajukan! Tim akan segera meninjau permintaan Anda.');
            window.location.href = 'ajukan_revisi.php';
          </script>";
    
} catch (Exception $e) {
    // Rollback transaction
    mysqli_rollback($koneksi);
    
    // Delete uploaded file if exists
    if ($file_referensi && file_exists($upload_dir . $file_referensi)) {
        unlink($upload_dir . $file_referensi);
    }
    
    echo "<script>
            alert('Gagal mengajukan revisi: " . $e->getMessage() . "');
            window.location.href = 'ajukan_revisi.php';
          </script>";
}
?>
