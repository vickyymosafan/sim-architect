<?php
require_once '../includes/session_manager.php';
require '../koneksi.php';

// Validasi session client
check_session_auth('client');

// Set page title
$page_title = "Dashboard Client";

// Get statistics
$total_tugas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas_proyek WHERE status_verifikasi = 'approved'"));
$total_files = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM file_gambar WHERE status_verifikasi = 'approved'"));
$tugas_selesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas_proyek WHERE status_verifikasi = 'approved' AND status = 'selesai'"));
$tugas_proses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas_proyek WHERE status_verifikasi = 'approved' AND status = 'proses'"));

// Include header
include 'includes/header/header.php';
?>

<?php include 'includes/sidebar/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

<?php include 'includes/topbar/topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Client</h1>
                        <div class="text-right">
                            <small class="text-muted">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</small>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Total Tugas Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Tugas Disetujui</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_tugas; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tugas Selesai Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Tugas Selesai</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tugas_selesai; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tugas Dalam Proses Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Tugas Dalam Proses</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tugas_proses; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total File Desain Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                File Desain Disetujui</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_files; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-image fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Progress Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Progress Proyek</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <?php if ($total_tugas > 0): ?>
                                            <div class="progress mb-3">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                     style="width: <?php echo ($tugas_selesai / $total_tugas) * 100; ?>%" 
                                                     aria-valuenow="<?php echo ($tugas_selesai / $total_tugas) * 100; ?>" 
                                                     aria-valuemin="0" aria-valuemax="100">
                                                    <?php echo round(($tugas_selesai / $total_tugas) * 100, 1); ?>% Selesai
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-muted">
                                                    <?php echo $tugas_selesai; ?> dari <?php echo $total_tugas; ?> tugas telah selesai
                                                </p>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-center py-4">
                                                <i class="fas fa-chart-line fa-3x text-gray-300 mb-3"></i>
                                                <h5 class="text-gray-600">Belum Ada Data Progress</h5>
                                                <p class="text-muted">Progress akan ditampilkan setelah ada tugas yang disetujui.</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Access -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Akses Cepat</h6>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <a href="progress_proyek.php" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><i class="fas fa-chart-gantt mr-2"></i>Lihat Progress Proyek</h6>
                                                <small class="text-muted">Timeline</small>
                                            </div>
                                            <p class="mb-1 text-muted">Lihat progress proyek dalam bentuk Gantt chart</p>
                                        </a>
                                        <a href="file_desain.php" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1"><i class="fas fa-file-image mr-2"></i>File Desain</h6>
                                                <small class="text-muted">Approved</small>
                                            </div>
                                            <p class="mb-1 text-muted">Lihat dan download file desain yang disetujui</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Recent Activities -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $recent_activities = mysqli_query($koneksi, "
                                        SELECT 'tugas' as type, nama_kegiatan as name, tanggal_verifikasi as date, status
                                        FROM tugas_proyek 
                                        WHERE status_verifikasi = 'approved' 
                                        UNION ALL
                                        SELECT 'file' as type, gambar as name, tanggal_verifikasi as date, 'approved' as status
                                        FROM file_gambar 
                                        WHERE status_verifikasi = 'approved'
                                        ORDER BY date DESC 
                                        LIMIT 5
                                    ");
                                    
                                    if (mysqli_num_rows($recent_activities) > 0):
                                    ?>
                                        <div class="timeline">
                                            <?php while ($activity = mysqli_fetch_array($recent_activities)): ?>
                                                <div class="timeline-item mb-3">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">
                                                            <?php if ($activity['type'] == 'tugas'): ?>
                                                                <i class="fas fa-tasks text-primary"></i>
                                                            <?php else: ?>
                                                                <i class="fas fa-file-image text-info"></i>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="flex-grow-1 ml-3">
                                                            <h6 class="mb-1">
                                                                <?php echo $activity['type'] == 'tugas' ? 'Tugas' : 'File'; ?> 
                                                                "<?php echo htmlspecialchars($activity['name']); ?>" disetujui
                                                            </h6>
                                                            <small class="text-muted">
                                                                <?php echo date('d M Y H:i', strtotime($activity['date'])); ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-4">
                                            <i class="fas fa-history fa-3x text-gray-300 mb-3"></i>
                                            <h5 class="text-gray-600">Belum Ada Aktivitas</h5>
                                            <p class="text-muted">Aktivitas terbaru akan ditampilkan di sini.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<?php include 'includes/footer/footer.php'; ?>
