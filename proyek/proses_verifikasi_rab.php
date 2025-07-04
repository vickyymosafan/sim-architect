<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');
require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kelola_rab.php');
    exit;
}

// Get form data
$rab_id = (int)$_POST['rab_id'];
$keputusan = $_POST['keputusan']; // 'approved' or 'rejected'
$catatan = mysqli_real_escape_string($koneksi, $_POST['catatan']);
$verifikator_id = $_SESSION['id_petugas'];

// Validate input
if ($rab_id <= 0 || !in_array($keputusan, ['approved', 'rejected'])) {
    echo "<script>alert('Data tidak valid!'); window.history.back();</script>";
    exit;
}

// Validate catatan for rejection
if ($keputusan === 'rejected' && empty(trim($catatan))) {
    echo "<script>alert('Catatan wajib diisi untuk penolakan RAB!'); window.history.back();</script>";
    exit;
}

// Check if RAB exists and can be verified
$check_query = "SELECT * FROM rab_proyek WHERE id = $rab_id AND status IN ('draft', 'rejected')";
$check_result = mysqli_query($koneksi, $check_query);

if (!$check_result || mysqli_num_rows($check_result) === 0) {
    echo "<script>alert('RAB tidak ditemukan atau tidak dapat diverifikasi!'); window.location.href='kelola_rab.php';</script>";
    exit;
}

// Start transaction
mysqli_begin_transaction($koneksi);

try {
    // Update RAB status
    $update_query = "UPDATE rab_proyek SET 
                    status = '$keputusan',
                    tanggal_verifikasi = NOW(),
                    verifikator_id = $verifikator_id,
                    catatan_verifikasi = '$catatan'
                    WHERE id = $rab_id";
    
    if (!mysqli_query($koneksi, $update_query)) {
        throw new Exception("Gagal update status RAB: " . mysqli_error($koneksi));
    }
    
    // Commit transaction
    mysqli_commit($koneksi);
    
    $status_text = ($keputusan === 'approved') ? 'disetujui' : 'ditolak';
    $message = "RAB berhasil $status_text!";
    
    if ($keputusan === 'approved') {
        $message .= "\\n\\nClient sekarang dapat melihat dan mengunduh file RAB.";
    } else {
        $message .= "\\n\\nTim proyek dapat mengupload ulang RAB yang sudah diperbaiki.";
    }
    
    echo "<script>
            alert('$message');
            window.location.href = 'kelola_rab.php';
          </script>";
    
} catch (Exception $e) {
    // Rollback transaction
    mysqli_rollback($koneksi);
    
    echo "<script>
            alert('Gagal memproses verifikasi: " . addslashes($e->getMessage()) . "');
            window.history.back();
          </script>";
}
?>
