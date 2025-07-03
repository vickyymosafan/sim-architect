<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');
require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = (int)$_POST['item_id'];
    $item_type = $_POST['item_type']; // 'tugas' atau 'file'
    $status_verifikasi = $_POST['status_verifikasi']; // 'approved' atau 'rejected'
    $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan']);
    $verifikator_id = $_SESSION['id_petugas']; // Ambil dari session
    
    // Validasi input
    if (!in_array($item_type, ['tugas', 'file']) || !in_array($status_verifikasi, ['approved', 'rejected'])) {
        echo "<script>alert('Data tidak valid!'); window.location.href='verifikasi.php';</script>";
        exit;
    }
    
    // Mulai transaction
    mysqli_begin_transaction($koneksi);
    
    try {
        if ($item_type == 'tugas') {
            // Update tabel tugas_proyek
            $sql_update = "UPDATE tugas_proyek SET 
                          status_verifikasi = '$status_verifikasi',
                          tanggal_verifikasi = NOW(),
                          verifikator_id = $verifikator_id,
                          catatan_verifikasi = '$catatan'
                          WHERE id = $item_id";
            
            $table_name = 'tugas_proyek';
        } else {
            // Update tabel file_gambar
            $sql_update = "UPDATE file_gambar SET 
                          status_verifikasi = '$status_verifikasi',
                          tanggal_verifikasi = NOW(),
                          verifikator_id = $verifikator_id,
                          catatan_verifikasi = '$catatan'
                          WHERE id = $item_id";
            
            $table_name = 'file_gambar';
        }
        
        // Eksekusi update
        if (!mysqli_query($koneksi, $sql_update)) {
            throw new Exception("Gagal update status verifikasi");
        }
        
        // Simpan ke log verifikasi
        $sql_log = "INSERT INTO verifikasi_log 
                   (tipe, item_id, status_lama, status_baru, verifikator_id, catatan, tanggal_verifikasi) 
                   VALUES 
                   ('$item_type', $item_id, 'pending', '$status_verifikasi', $verifikator_id, '$catatan', NOW())";
        
        if (!mysqli_query($koneksi, $sql_log)) {
            throw new Exception("Gagal simpan log verifikasi");
        }
        
        // Commit transaction
        mysqli_commit($koneksi);
        
        $status_text = ($status_verifikasi == 'approved') ? 'disetujui' : 'ditolak';
        $item_text = ($item_type == 'tugas') ? 'Tugas' : 'File';
        
        echo "<script>
                alert('$item_text berhasil $status_text!');
                window.location.href = 'verifikasi.php';
              </script>";
        
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($koneksi);
        
        echo "<script>
                alert('Terjadi kesalahan: " . $e->getMessage() . "');
                window.location.href = 'verifikasi.php';
              </script>";
    }
    
} else {
    // Jika bukan POST request, redirect ke verifikasi
    header("Location: verifikasi.php");
    exit;
}
?>
