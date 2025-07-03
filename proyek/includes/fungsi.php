<?php
/**
 * Fungsi-fungsi utility untuk sistem manajemen proyek
 * Antosa Arsitek Project Management System
 */

/**
 * Fungsi untuk menghitung jumlah item pending verifikasi
 * Menghindari duplikasi query database
 * 
 * @return array Array dengan key: tugas, file, total
 */
function getPendingCounts() {
    global $koneksi;
    
    // Hitung tugas pending
    $query_tugas = "SELECT COUNT(*) as count FROM tugas_proyek WHERE status_verifikasi = 'pending'";
    $result_tugas = mysqli_query($koneksi, $query_tugas);
    $count_tugas = mysqli_fetch_assoc($result_tugas)['count'];
    
    // Hitung file pending
    $query_file = "SELECT COUNT(*) as count FROM file_gambar WHERE status_verifikasi = 'pending'";
    $result_file = mysqli_query($koneksi, $query_file);
    $count_file = mysqli_fetch_assoc($result_file)['count'];
    
    // Total pending
    $total_pending = $count_tugas + $count_file;

    return [
        'tugas' => $count_tugas,
        'file' => $count_file,
        'total' => $total_pending
    ];
}

/**
 * Fungsi untuk generate badge counter HTML
 * 
 * @param int $count Jumlah item
 * @param string $class CSS class tambahan
 * @return string HTML badge atau empty string jika count = 0
 */
function generateBadgeCounter($count, $class = 'badge-danger badge-counter') {
    if ($count > 0) {
        return '<span class="badge ' . $class . '">' . $count . '</span>';
    }
    return '';
}

/**
 * Fungsi untuk generate notification dropdown item
 * 
 * @param int $count Jumlah item
 * @param string $type Tipe notifikasi (tugas/file)
 * @param string $icon Icon class
 * @param string $bg_color Background color class
 * @return string HTML dropdown item atau empty string jika count = 0
 */
function generateNotificationItem($count, $type, $icon, $bg_color) {
    if ($count <= 0) return '';
    
    $text = $count . ' ' . $type . ' menunggu verifikasi';
    $current_time = date('d M Y, H:i');
    
    return '
    <a class="dropdown-item d-flex align-items-center py-3 border-bottom" href="verifikasi.php">
        <div class="mr-3">
            <div class="icon-circle ' . $bg_color . '">
                <i class="' . $icon . ' text-white"></i>
            </div>
        </div>
        <div class="flex-grow-1">
            <div class="small text-gray-500 mb-1">
                <i class="fas fa-clock mr-1"></i>' . $current_time . '
            </div>
            <span class="font-weight-bold text-dark">' . $text . '</span>
        </div>
        <div class="ml-2">
            <i class="fas fa-chevron-right text-gray-400"></i>
        </div>
    </a>';
}
?>
