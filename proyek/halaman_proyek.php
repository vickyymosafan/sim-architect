<?php
// Include koneksi database
require_once '../koneksi.php';

// Ambil statistik untuk dashboard
$stats = [];

// Hitung total tugas
$query_total_tugas = "SELECT COUNT(*) as total FROM tugas_proyek";
$result_total_tugas = mysqli_query($koneksi, $query_total_tugas);
$stats['total_tugas'] = mysqli_fetch_assoc($result_total_tugas)['total'];

// Hitung tugas pending verifikasi
$query_pending_tugas = "SELECT COUNT(*) as total FROM tugas_proyek WHERE status_verifikasi = 'pending'";
$result_pending_tugas = mysqli_query($koneksi, $query_pending_tugas);
$stats['pending_tugas'] = mysqli_fetch_assoc($result_pending_tugas)['total'];

// Hitung tugas approved
$query_approved_tugas = "SELECT COUNT(*) as total FROM tugas_proyek WHERE status_verifikasi = 'approved'";
$result_approved_tugas = mysqli_query($koneksi, $query_approved_tugas);
$stats['approved_tugas'] = mysqli_fetch_assoc($result_approved_tugas)['total'];

// Hitung total file
$query_total_file = "SELECT COUNT(*) as total FROM file_gambar";
$result_total_file = mysqli_query($koneksi, $query_total_file);
$stats['total_file'] = mysqli_fetch_assoc($result_total_file)['total'];

// Hitung file pending verifikasi
$query_pending_file = "SELECT COUNT(*) as total FROM file_gambar WHERE status_verifikasi = 'pending'";
$result_pending_file = mysqli_query($koneksi, $query_pending_file);
$stats['pending_file'] = mysqli_fetch_assoc($result_pending_file)['total'];

// Hitung file approved
$query_approved_file = "SELECT COUNT(*) as total FROM file_gambar WHERE status_verifikasi = 'approved'";
$result_approved_file = mysqli_query($koneksi, $query_approved_file);
$stats['approved_file'] = mysqli_fetch_assoc($result_approved_file)['total'];

if (isset($_GET['url'])) {
    $url = $_GET['url'];
    switch($url) {
        // Untuk pengembangan future features
        default:
            // Tampilkan dashboard default
            break;
    }
} else {
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard Proyek
    </h1>
    <div class="text-right">
        <small class="text-muted">
            <i class="fas fa-user mr-1"></i>Selamat datang, <strong><?php echo $_SESSION['nama']; ?></strong>
        </small>
    </div>
</div>

<!-- Welcome Alert -->
<div class="alert alert-primary alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
        <div class="mr-3">
            <i class="fas fa-info-circle fa-2x"></i>
        </div>
        <div>
            <h5 class="alert-heading mb-1">Selamat Datang di Sistem Manajemen Proyek</h5>
            <p class="mb-0">Antosa Arsitek - Tim Proyek. Kelola tugas harian dan file desain Anda dengan mudah.</p>
        </div>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- Content Row - Statistics Cards -->
<div class="row">

    <!-- Total Tugas Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Tugas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['total_tugas']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tasks fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tugas Pending Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Tugas Pending</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['pending_tugas']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total File Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total File</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['total_file']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-folder fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- File Pending Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            File Pending</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['pending_file']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row - Quick Actions & Recent Activity -->
<div class="row">

    <!-- Quick Actions Card -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt mr-2"></i>Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="input_tugas.php" class="btn btn-primary btn-block">
                            <i class="fas fa-plus-circle mr-2"></i>Input Tugas Baru
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="upload_file.php" class="btn btn-info btn-block">
                            <i class="fas fa-upload mr-2"></i>Upload File Desain
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="tugas_harian.php" class="btn btn-success btn-block">
                            <i class="fas fa-list mr-2"></i>Lihat Tugas Harian
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="verifikasi.php" class="btn btn-warning btn-block">
                            <i class="fas fa-clipboard-check mr-2"></i>Verifikasi & Approval
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Overview Card -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie mr-2"></i>Ringkasan Status
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-sm font-weight-bold">Tugas Disetujui</span>
                        <span class="text-sm"><?php echo $stats['approved_tugas']; ?>/<?php echo $stats['total_tugas']; ?></span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar"
                             style="width: <?php echo $stats['total_tugas'] > 0 ? ($stats['approved_tugas']/$stats['total_tugas']*100) : 0; ?>%">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-sm font-weight-bold">File Disetujui</span>
                        <span class="text-sm"><?php echo $stats['approved_file']; ?>/<?php echo $stats['total_file']; ?></span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-info" role="progressbar"
                             style="width: <?php echo $stats['total_file'] > 0 ? ($stats['approved_file']/$stats['total_file']*100) : 0; ?>%">
                        </div>
                    </div>
                </div>

                <?php if ($stats['pending_tugas'] > 0 || $stats['pending_file'] > 0): ?>
                <div class="alert alert-warning alert-sm mt-3 mb-0">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Perhatian:</strong> Ada <?php echo ($stats['pending_tugas'] + $stats['pending_file']); ?> item menunggu verifikasi.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<!-- Content Row - Recent Activity -->
<div class="row">

    <!-- Recent Tasks -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history mr-2"></i>Tugas Terbaru
                </h6>
                <a href="tugas_harian.php" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye mr-1"></i>Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <?php
                // Ambil 5 tugas terbaru
                $query_recent_tasks = "SELECT * FROM tugas_proyek ORDER BY tanggal_submit DESC LIMIT 5";
                $result_recent_tasks = mysqli_query($koneksi, $query_recent_tasks);

                if (mysqli_num_rows($result_recent_tasks) > 0):
                ?>
                <div class="list-group list-group-flush">
                    <?php while ($task = mysqli_fetch_assoc($result_recent_tasks)): ?>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 font-weight-bold"><?php echo htmlspecialchars($task['nama_kegiatan']); ?></h6>
                                <p class="mb-1 text-muted small"><?php echo htmlspecialchars(substr($task['deskripsi'], 0, 80)) . (strlen($task['deskripsi']) > 80 ? '...' : ''); ?></p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar mr-1"></i><?php echo date('d M Y', strtotime($task['tgl'])); ?>
                                </small>
                            </div>
                            <div class="ml-2">
                                <?php
                                $status_class = 'secondary';
                                $verif_class = 'secondary';

                                if ($task['status'] == 'proses') $status_class = 'warning';
                                elseif ($task['status'] == 'selesai') $status_class = 'success';
                                elseif ($task['status'] == 'batal') $status_class = 'danger';

                                if ($task['status_verifikasi'] == 'pending') $verif_class = 'warning';
                                elseif ($task['status_verifikasi'] == 'approved') $verif_class = 'success';
                                elseif ($task['status_verifikasi'] == 'rejected') $verif_class = 'danger';
                                ?>
                                <span class="badge badge-<?php echo $status_class; ?> d-block mb-1"><?php echo ucfirst($task['status']); ?></span>
                                <span class="badge badge-<?php echo $verif_class; ?> d-block"><?php echo ucfirst($task['status_verifikasi']); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-tasks fa-3x text-gray-300 mb-3"></i>
                    <p class="text-muted">Belum ada tugas yang diinput.</p>
                    <a href="input_tugas.php" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>Input Tugas Pertama
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Files -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-file mr-2"></i>File Terbaru
                </h6>
                <a href="file_approved.php" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye mr-1"></i>Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <?php
                // Ambil 5 file terbaru
                $query_recent_files = "SELECT * FROM file_gambar ORDER BY tanggal_submit DESC LIMIT 5";
                $result_recent_files = mysqli_query($koneksi, $query_recent_files);

                if (mysqli_num_rows($result_recent_files) > 0):
                ?>
                <div class="list-group list-group-flush">
                    <?php while ($file = mysqli_fetch_assoc($result_recent_files)): ?>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 font-weight-bold">
                                    <i class="fas fa-file-image mr-1 text-info"></i>
                                    <?php echo htmlspecialchars($file['gambar']); ?>
                                </h6>
                                <p class="mb-1 text-muted small"><?php echo htmlspecialchars(substr($file['deskripsi'], 0, 80)) . (strlen($file['deskripsi']) > 80 ? '...' : ''); ?></p>
                                <small class="text-muted">
                                    <i class="fas fa-clock mr-1"></i><?php echo date('d M Y H:i', strtotime($file['tanggal_submit'])); ?>
                                </small>
                            </div>
                            <div class="ml-2">
                                <?php
                                $verif_class = 'secondary';
                                if ($file['status_verifikasi'] == 'pending') $verif_class = 'warning';
                                elseif ($file['status_verifikasi'] == 'approved') $verif_class = 'success';
                                elseif ($file['status_verifikasi'] == 'rejected') $verif_class = 'danger';
                                ?>
                                <span class="badge badge-<?php echo $verif_class; ?>"><?php echo ucfirst($file['status_verifikasi']); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                    <p class="text-muted">Belum ada file yang diupload.</p>
                    <a href="upload_file.php" class="btn btn-info btn-sm">
                        <i class="fas fa-upload mr-1"></i>Upload File Pertama
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<!-- Tips & Information Row -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-lightbulb mr-2"></i>Tips & Informasi
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="border-left-primary pl-3">
                            <h6 class="font-weight-bold text-primary">
                                <i class="fas fa-tasks mr-2"></i>Manajemen Tugas
                            </h6>
                            <p class="text-sm text-muted mb-0">
                                Input tugas harian Anda secara rutin untuk tracking progres proyek yang lebih baik.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border-left-info pl-3">
                            <h6 class="font-weight-bold text-info">
                                <i class="fas fa-file-upload mr-2"></i>Upload File
                            </h6>
                            <p class="text-sm text-muted mb-0">
                                Upload file desain dan dokumentasi proyek untuk arsip dan verifikasi tim.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border-left-warning pl-3">
                            <h6 class="font-weight-bold text-warning">
                                <i class="fas fa-clipboard-check mr-2"></i>Verifikasi
                            </h6>
                            <p class="text-sm text-muted mb-0">
                                Semua tugas dan file akan melalui proses verifikasi sebelum disetujui.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}
?>