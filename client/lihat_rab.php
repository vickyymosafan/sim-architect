<?php
require_once '../includes/session_manager.php';
check_session_auth('client');

$page_title = "Lihat RAB";
include 'includes/header/header.php';
require '../koneksi.php';

// Function to format file size
function formatFileSize($bytes) {
    if ($bytes === 0) return '0 Bytes';
    $k = 1024;
    $sizes = ['Bytes', 'KB', 'MB', 'GB'];
    $i = floor(log($bytes) / log($k));
    return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
}

// Get client ID from session
$client_id = $_SESSION['user_id'] ?? 1; // Default untuk testing
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
                        <h1 class="h3 mb-0 text-gray-800">Rencana Anggaran Biaya (RAB)</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="client.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Lihat RAB</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Welcome Alert -->
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading mb-1">Informasi RAB</h5>
                                <p class="mb-0">
                                    Berikut adalah daftar Rencana Anggaran Biaya (RAB) untuk proyek Anda. 
                                    Anda dapat melihat detail breakdown biaya dan mengunduh RAB dalam format PDF.
                                </p>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- RAB Statistics -->
                    <div class="row mb-4">
                        <?php
                        // Get RAB statistics
                        $stats_query = "SELECT
                                        COUNT(*) as total_rab,
                                        SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_rab,
                                        SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected_rab,
                                        SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft_rab
                                        FROM rab_proyek WHERE client_id = $client_id";
                        $stats_result = mysqli_query($koneksi, $stats_query);
                        $stats = mysqli_fetch_array($stats_result);
                        ?>
                        
                        <!-- Total RAB -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total RAB</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['total_rab']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Approved RAB -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                RAB Disetujui</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['approved_rab']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Draft RAB -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                RAB Draft</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['draft_rab']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rejected RAB -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                RAB Ditolak</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['rejected_rab']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RAB List -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-list mr-2"></i>Daftar RAB Proyek
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama Proyek</th>
                                            <th>File RAB</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Tanggal Upload</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rab_query = "SELECT rp.*, p.nama_petugas as verifikator_name
                                                     FROM rab_proyek rp
                                                     LEFT JOIN petugas p ON rp.verifikator_id = p.id_petugas
                                                     WHERE rp.client_id = $client_id
                                                     ORDER BY rp.tanggal_upload DESC";
                                        $rab_result = mysqli_query($koneksi, $rab_query);
                                        
                                        if ($rab_result && mysqli_num_rows($rab_result) > 0) {
                                            $no = 1;
                                            while ($rab = mysqli_fetch_array($rab_result)) {
                                                $status_class = '';
                                                $status_text = '';
                                                switch ($rab['status']) {
                                                    case 'draft':
                                                        $status_class = 'badge-secondary';
                                                        $status_text = 'Draft';
                                                        break;
                                                    case 'rejected':
                                                        $status_class = 'badge-danger';
                                                        $status_text = 'Ditolak';
                                                        break;
                                                    case 'approved':
                                                        $status_class = 'badge-success';
                                                        $status_text = 'Disetujui';
                                                        break;
                                                }

                                                // Get file extension for icon
                                                $file_ext = strtolower(pathinfo($rab['file_rab'], PATHINFO_EXTENSION));
                                                $file_icon = 'fas fa-file';
                                                $file_color = 'text-secondary';
                                                switch ($file_ext) {
                                                    case 'pdf':
                                                        $file_icon = 'fas fa-file-pdf';
                                                        $file_color = 'text-danger';
                                                        break;
                                                    case 'xlsx':
                                                    case 'xls':
                                                        $file_icon = 'fas fa-file-excel';
                                                        $file_color = 'text-success';
                                                        break;
                                                    case 'docx':
                                                    case 'doc':
                                                        $file_icon = 'fas fa-file-word';
                                                        $file_color = 'text-primary';
                                                        break;
                                                }
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td>
                                                <div class="font-weight-bold"><?php echo htmlspecialchars($rab['nama_proyek']); ?></div>
                                                <div class="small text-muted">
                                                    <?php echo htmlspecialchars($rab['deskripsi'] ?: 'Tidak ada deskripsi'); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="<?php echo $file_icon; ?> <?php echo $file_color; ?> mr-2"></i>
                                                    <div>
                                                        <div class="font-weight-bold"><?php echo htmlspecialchars($rab['file_rab']); ?></div>
                                                        <div class="small text-muted">
                                                            <?php echo formatFileSize($rab['file_size']); ?> •
                                                            <?php echo strtoupper($file_ext); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge <?php echo $status_class; ?> badge-pill">
                                                    <?php echo $status_text; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <small><?php echo date('d M Y', strtotime($rab['tanggal_upload'])); ?></small>
                                                <br>
                                                <small class="text-muted"><?php echo date('H:i', strtotime($rab['tanggal_upload'])); ?></small>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($rab['status'] === 'approved'): ?>
                                                <div class="btn-group" role="group">
                                                    <a href="../file_rab/<?php echo $rab['file_rab']; ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Lihat File">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="../file_rab/<?php echo $rab['file_rab']; ?>" download class="btn btn-sm btn-outline-success" title="Download">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                                <?php elseif ($rab['status'] === 'rejected'): ?>
                                                <span class="text-muted small">
                                                    <i class="fas fa-times-circle mr-1"></i>Ditolak
                                                    <?php if ($rab['catatan_verifikasi']): ?>
                                                    <br><small title="<?php echo htmlspecialchars($rab['catatan_verifikasi']); ?>">
                                                        Lihat catatan
                                                    </small>
                                                    <?php endif; ?>
                                                </span>
                                                <?php else: ?>
                                                <span class="text-muted small">
                                                    <i class="fas fa-clock mr-1"></i>Menunggu verifikasi
                                                </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-center">
                                                    <i class="fas fa-calculator fa-3x text-gray-300 mb-3"></i>
                                                    <h5 class="text-gray-600">Belum Ada RAB</h5>
                                                    <p class="text-muted">RAB proyek Anda akan ditampilkan di sini setelah dibuat oleh tim.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



<?php include 'includes/footer/footer.php'; ?>
