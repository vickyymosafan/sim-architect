<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');
require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kelola_rab.php');
    exit;
}

// Get form data
$client_id = (int)$_POST['client_id'];
$nama_proyek = mysqli_real_escape_string($koneksi, $_POST['nama_proyek']);
$deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
$created_by = $_SESSION['id_petugas'];

// Validate input
if ($client_id <= 0 || empty($nama_proyek)) {
    echo "<script>alert('Data tidak lengkap! Pastikan client dan nama proyek sudah diisi.'); window.history.back();</script>";
    exit;
}

// Validate client exists
$client_check = mysqli_query($koneksi, "SELECT id FROM users WHERE id = $client_id AND role = 'client'");
if (!$client_check || mysqli_num_rows($client_check) === 0) {
    echo "<script>alert('Client tidak ditemukan!'); window.history.back();</script>";
    exit;
}

// Validate file upload
if (!isset($_FILES['file_rab']) || $_FILES['file_rab']['error'] !== UPLOAD_ERR_OK) {
    $error_message = 'File tidak berhasil diupload';
    if (isset($_FILES['file_rab']['error'])) {
        switch ($_FILES['file_rab']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $error_message = 'Ukuran file terlalu besar (maksimal 10MB)';
                break;
            case UPLOAD_ERR_PARTIAL:
                $error_message = 'File hanya terupload sebagian';
                break;
            case UPLOAD_ERR_NO_FILE:
                $error_message = 'Tidak ada file yang dipilih';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $error_message = 'Folder temporary tidak ditemukan';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $error_message = 'Gagal menulis file ke disk';
                break;
        }
    }
    echo "<script>alert('$error_message'); window.history.back();</script>";
    exit;
}

$file = $_FILES['file_rab'];
$file_size = $file['size'];
$file_type = $file['type'];
$file_tmp = $file['tmp_name'];
$file_name = $file['name'];

// Validate file size (10MB max)
$max_size = 10 * 1024 * 1024; // 10MB
if ($file_size > $max_size) {
    echo "<script>alert('Ukuran file terlalu besar! Maksimal 10MB'); window.history.back();</script>";
    exit;
}

// Validate file type
$allowed_types = [
    'application/pdf',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
    'application/vnd.ms-excel', // .xls
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
    'application/msword' // .doc
];

if (!in_array($file_type, $allowed_types)) {
    echo "<script>alert('Format file tidak didukung! Gunakan PDF, Excel, atau Word'); window.history.back();</script>";
    exit;
}

// Get file extension
$file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
$allowed_extensions = ['pdf', 'xlsx', 'xls', 'docx', 'doc'];

if (!in_array($file_extension, $allowed_extensions)) {
    echo "<script>alert('Ekstensi file tidak didukung!'); window.history.back();</script>";
    exit;
}

// Generate unique filename
$timestamp = time();
$new_filename = "rab_{$client_id}_{$timestamp}.{$file_extension}";
$upload_path = "../file_rab/" . $new_filename;

// Create directory if not exists
if (!is_dir('../file_rab')) {
    if (!mkdir('../file_rab', 0755, true)) {
        echo "<script>alert('Gagal membuat folder upload!'); window.history.back();</script>";
        exit;
    }
}

// Start transaction
mysqli_begin_transaction($koneksi);

try {
    // Move uploaded file
    if (!move_uploaded_file($file_tmp, $upload_path)) {
        throw new Exception("Gagal menyimpan file RAB");
    }
    
    // Insert RAB record
    $insert_query = "INSERT INTO rab_proyek 
                    (client_id, nama_proyek, deskripsi, file_rab, file_size, file_type, status, created_by, tanggal_upload) 
                    VALUES 
                    ($client_id, '$nama_proyek', '$deskripsi', '$new_filename', $file_size, '$file_type', 'draft', $created_by, NOW())";
    
    if (!mysqli_query($koneksi, $insert_query)) {
        // Delete uploaded file if database insert fails
        if (file_exists($upload_path)) {
            unlink($upload_path);
        }
        throw new Exception("Gagal menyimpan data RAB: " . mysqli_error($koneksi));
    }
    
    // Commit transaction
    mysqli_commit($koneksi);
    
    $file_size_formatted = formatFileSize($file_size);
    
    echo "<script>
            alert('RAB berhasil diupload!\\n\\nDetail:\\n- File: $file_name\\n- Ukuran: $file_size_formatted\\n- Status: Draft (Menunggu Verifikasi)');
            window.location.href = 'kelola_rab.php';
          </script>";
    
} catch (Exception $e) {
    // Rollback transaction
    mysqli_rollback($koneksi);
    
    // Delete uploaded file if exists
    if (file_exists($upload_path)) {
        unlink($upload_path);
    }
    
    echo "<script>
            alert('Gagal mengupload RAB: " . addslashes($e->getMessage()) . "');
            window.history.back();
          </script>";
}

function formatFileSize($bytes) {
    if ($bytes === 0) return '0 Bytes';
    $k = 1024;
    $sizes = ['Bytes', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));
    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
}
?>
