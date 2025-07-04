<?php
require_once '../includes/session_manager.php';
require '../koneksi.php';

// Validasi session client
check_session_auth('client');

$page_title = "Progress Proyek";
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
                        <h1 class="h3 mb-0 text-gray-800">Progress Proyek</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="client.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Progress Proyek</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Info Alert -->
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Informasi:</strong> Timeline menampilkan progress tugas proyek yang telah disetujui dalam bentuk Gantt chart.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Progress Summary Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-line mr-2"></i>Ringkasan Progress
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php
                            $total_tugas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas_proyek WHERE status_verifikasi = 'approved'"));
                            $tugas_selesai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas_proyek WHERE status_verifikasi = 'approved' AND status = 'selesai'"));
                            $tugas_proses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas_proyek WHERE status_verifikasi = 'approved' AND status = 'proses'"));
                            $tugas_batal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas_proyek WHERE status_verifikasi = 'approved' AND status = 'batal'"));
                            
                            $progress_percentage = $total_tugas > 0 ? ($tugas_selesai / $total_tugas) * 100 : 0;
                            ?>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="mb-3">Progress Keseluruhan: <?php echo round($progress_percentage, 1); ?>%</h5>
                                    <div class="progress mb-3" style="height: 25px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: <?php echo $progress_percentage; ?>%" 
                                             aria-valuenow="<?php echo $progress_percentage; ?>" 
                                             aria-valuemin="0" aria-valuemax="100">
                                            <?php echo round($progress_percentage, 1); ?>%
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="text-success font-weight-bold h4"><?php echo $tugas_selesai; ?></div>
                                            <small class="text-muted">Selesai</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-warning font-weight-bold h4"><?php echo $tugas_proses; ?></div>
                                            <small class="text-muted">Proses</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-danger font-weight-bold h4"><?php echo $tugas_batal; ?></div>
                                            <small class="text-muted">Batal</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Gantt Chart -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-gantt mr-2"></i>Timeline Proyek
                            </h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Filter:</div>
                                    <a class="dropdown-item" href="#" onclick="filterStatus('all')">Semua Status</a>
                                    <a class="dropdown-item" href="#" onclick="filterStatus('selesai')">Selesai</a>
                                    <a class="dropdown-item" href="#" onclick="filterStatus('proses')">Dalam Proses</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            $sql = mysqli_query($koneksi, "SELECT * FROM tugas_proyek WHERE status_verifikasi = 'approved' ORDER BY tgl ASC");
                            
                            if (mysqli_num_rows($sql) > 0):
                            ?>
                                <div class="timeline-container">
                                    <div class="timeline-header mb-4">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Nama Tugas</strong>
                                            </div>
                                            <div class="col-md-2">
                                                <strong>Tanggal</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Timeline</strong>
                                            </div>
                                            <div class="col-md-2">
                                                <strong>Status</strong>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php
                                    // Get date range for timeline calculation
                                    $date_range_query = mysqli_query($koneksi, "SELECT MIN(tgl) as min_date, MAX(tgl) as max_date FROM tugas_proyek WHERE status_verifikasi = 'approved'");
                                    $date_range = mysqli_fetch_array($date_range_query);
                                    $min_date = strtotime($date_range['min_date']);
                                    $max_date = strtotime($date_range['max_date']);
                                    $total_days = ($max_date - $min_date) / (60 * 60 * 24) + 1;
                                    
                                    $no = 1;
                                    mysqli_data_seek($sql, 0); // Reset pointer
                                    while ($data = mysqli_fetch_array($sql)):
                                        $task_date = strtotime($data['tgl']);
                                        $days_from_start = ($task_date - $min_date) / (60 * 60 * 24);
                                        $position_percentage = $total_days > 1 ? ($days_from_start / ($total_days - 1)) * 100 : 0;
                                        
                                        $status_class = 'secondary';
                                        $status_text = 'Belum Diatur';
                                        if ($data['status'] == 'proses') {
                                            $status_class = 'warning';
                                            $status_text = 'Dalam Proses';
                                        } else if ($data['status'] == 'selesai') {
                                            $status_class = 'success';
                                            $status_text = 'Selesai';
                                        } else if ($data['status'] == 'batal') {
                                            $status_class = 'danger';
                                            $status_text = 'Dibatalkan';
                                        }
                                    ?>
                                        <div class="timeline-item mb-3 task-item" data-status="<?php echo $data['status']; ?>">
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    <div class="task-info">
                                                        <h6 class="mb-1 font-weight-bold">
                                                            <?php echo htmlspecialchars($data['nama_kegiatan']); ?>
                                                        </h6>
                                                        <small class="text-muted">
                                                            <?php echo htmlspecialchars(substr($data['deskripsi'], 0, 50)); ?>
                                                            <?php echo strlen($data['deskripsi']) > 50 ? '...' : ''; ?>
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <small class="text-muted">
                                                        <?php echo date('d M Y', strtotime($data['tgl'])); ?>
                                                    </small>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="timeline-bar-container position-relative">
                                                        <div class="timeline-background"></div>
                                                        <div class="timeline-bar bg-<?php echo $status_class; ?>" 
                                                             style="left: <?php echo $position_percentage; ?>%; width: 20px; height: 20px; border-radius: 50%; position: absolute; top: 50%; transform: translateY(-50%);">
                                                        </div>
                                                        <div class="timeline-line"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="badge badge-<?php echo $status_class; ?> px-2 py-1">
                                                        <?php echo $status_text; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                                
                                <!-- Timeline Legend -->
                                <div class="timeline-legend mt-4 pt-3 border-top">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6 class="font-weight-bold mb-2">Keterangan:</h6>
                                            <div class="d-flex flex-wrap">
                                                <div class="mr-4 mb-2">
                                                    <span class="badge badge-success mr-1">●</span>
                                                    <small>Selesai</small>
                                                </div>
                                                <div class="mr-4 mb-2">
                                                    <span class="badge badge-warning mr-1">●</span>
                                                    <small>Dalam Proses</small>
                                                </div>
                                                <div class="mr-4 mb-2">
                                                    <span class="badge badge-danger mr-1">●</span>
                                                    <small>Dibatalkan</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-chart-gantt fa-3x text-gray-300 mb-3"></i>
                                    <h5 class="text-gray-600">Belum Ada Data Timeline</h5>
                                    <p class="text-muted">Timeline akan ditampilkan setelah ada tugas yang disetujui.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<style>
.timeline-container {
    position: relative;
}

.timeline-bar-container {
    height: 30px;
    background-color: #f8f9fc;
    border-radius: 15px;
    border: 1px solid #e3e6f0;
}

.timeline-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, #e3e6f0 0%, #e3e6f0 100%);
    border-radius: 15px;
}

.timeline-line {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background-color: #d1d3e2;
    transform: translateY(-50%);
}

.task-item {
    padding: 15px;
    border: 1px solid #e3e6f0;
    border-radius: 10px;
    background-color: #fff;
    transition: all 0.3s ease;
}

.task-item:hover {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    transform: translateY(-2px);
}

.timeline-header {
    background-color: #f8f9fc;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #e3e6f0;
}

@media (max-width: 768px) {
    .timeline-container .col-md-4,
    .timeline-container .col-md-2 {
        margin-bottom: 10px;
    }
    
    .timeline-bar-container {
        height: 20px;
    }
}
</style>

<script>
function filterStatus(status) {
    const items = document.querySelectorAll('.task-item');
    
    items.forEach(item => {
        if (status === 'all' || item.dataset.status === status) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>

<?php include 'includes/footer/footer.php'; ?>
