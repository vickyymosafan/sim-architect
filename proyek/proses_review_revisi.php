<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');
require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: review_revisi.php');
    exit;
}

// Get form data
$revisi_id = (int)$_POST['revisi_id'];
$review_status = $_POST['review_status'];
$catatan_reviewer = mysqli_real_escape_string($koneksi, $_POST['catatan_reviewer']);
$reviewer_id = $_SESSION['id_petugas'];

// Validate input
if ($revisi_id <= 0 || !in_array($review_status, ['approved', 'rejected']) || empty($catatan_reviewer)) {
    echo "<script>alert('Data tidak valid!'); window.location.href='review_revisi.php';</script>";
    exit;
}

// Check if revisi exists and is pending
$check_query = "SELECT * FROM revisi_request WHERE id = $revisi_id AND status_revisi = 'pending'";
$check_result = mysqli_query($koneksi, $check_query);

if (!$check_result || mysqli_num_rows($check_result) === 0) {
    echo "<script>alert('Permintaan revisi tidak ditemukan atau sudah diproses!'); window.location.href='review_revisi.php';</script>";
    exit;
}

// Start transaction
mysqli_begin_transaction($koneksi);

try {
    // Update revisi request
    $update_query = "UPDATE revisi_request SET 
                    status_revisi = '$review_status',
                    tanggal_response = NOW(),
                    reviewer_id = $reviewer_id,
                    catatan_reviewer = '$catatan_reviewer'
                    WHERE id = $revisi_id";
    
    if (!mysqli_query($koneksi, $update_query)) {
        throw new Exception("Gagal update status revisi");
    }
    
    // Commit transaction
    mysqli_commit($koneksi);
    
    $status_text = ($review_status === 'approved') ? 'disetujui' : 'ditolak';
    
    echo "<script>
            alert('Permintaan revisi berhasil $status_text!');
            window.location.href = 'review_revisi.php';
          </script>";
    
} catch (Exception $e) {
    // Rollback transaction
    mysqli_rollback($koneksi);
    
    echo "<script>
            alert('Gagal memproses review: " . $e->getMessage() . "');
            window.location.href = 'review_revisi.php';
          </script>";
}
?>
