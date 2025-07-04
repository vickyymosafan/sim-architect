<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');

$page_title = "Kelola RAB";
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
                        <h1 class="h3 mb-0 text-gray-800">Kelola RAB Proyek</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="proyek.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Kelola RAB</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-bolt mr-2"></i>Aksi Cepat
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <a href="upload_rab.php" class="btn btn-primary btn-block">
                                                <i class="fas fa-upload mr-2"></i>Upload RAB Baru
                                            </a>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <button class="btn btn-warning btn-block" onclick="filterRAB('draft')">
                                                <i class="fas fa-clock mr-2"></i>RAB Draft
                                            </button>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <button class="btn btn-success btn-block" onclick="filterRAB('approved')">
                                                <i class="fas fa-check-circle mr-2"></i>RAB Disetujui
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <?php
                        // Get RAB statistics
                        $stats_query = "SELECT
                                        COUNT(*) as total_rab,
                                        SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft_rab,
                                        SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected_rab,
                                        SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_rab
                                        FROM rab_proyek";
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

                        <!-- Draft RAB -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Draft RAB</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['draft_rab']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-edit fa-2x text-gray-300"></i>
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
                    </div>

                    <!-- RAB List -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-list mr-2"></i>Daftar RAB Proyek
                                </h6>
                                <div class="d-flex">
                                    <select class="form-control form-control-sm mr-2" id="statusFilter" onchange="filterTable()">
                                        <option value="">Semua Status</option>
                                        <option value="draft">Draft</option>
                                        <option value="rejected">Ditolak</option>
                                        <option value="approved">Disetujui</option>
                                    </select>
                                    <select class="form-control form-control-sm" id="clientFilter" onchange="filterTable()">
                                        <option value="">Semua Client</option>
                                        <?php
                                        $client_query = "SELECT DISTINCT u.id, u.first_name, u.last_name 
                                                        FROM users u 
                                                        INNER JOIN rab_proyek rp ON u.id = rp.client_id 
                                                        ORDER BY u.first_name";
                                        $client_result = mysqli_query($koneksi, $client_query);
                                        while ($client = mysqli_fetch_array($client_result)) {
                                            echo '<option value="' . $client['id'] . '">' . htmlspecialchars($client['first_name'] . ' ' . $client['last_name']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="rabTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Client</th>
                                            <th>Nama Proyek</th>
                                            <th>File RAB</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Tanggal Upload</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rab_query = "SELECT rp.*,
                                                     u.first_name, u.last_name, u.username,
                                                     p.nama_petugas as verifikator_name,
                                                     pc.nama_petugas as creator_name
                                                     FROM rab_proyek rp
                                                     LEFT JOIN users u ON rp.client_id = u.id
                                                     LEFT JOIN petugas p ON rp.verifikator_id = p.id_petugas
                                                     LEFT JOIN petugas pc ON rp.created_by = pc.id_petugas
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
                                        <tr data-status="<?php echo $rab['status']; ?>" data-client="<?php echo $rab['client_id']; ?>">
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3">
                                                        <div class="icon-circle bg-primary">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold"><?php echo htmlspecialchars($rab['first_name'] . ' ' . $rab['last_name']); ?></div>
                                                        <div class="small text-muted">@<?php echo htmlspecialchars($rab['username']); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold"><?php echo htmlspecialchars($rab['nama_proyek']); ?></div>
                                                <div class="small text-muted">
                                                    Upload oleh: <?php echo htmlspecialchars($rab['creator_name'] ?? 'N/A'); ?>
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
                                                <div class="btn-group" role="group">
                                                    <a href="../file_rab/<?php echo $rab['file_rab']; ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Lihat File">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if ($rab['status'] === 'draft'): ?>
                                                    <a href="verifikasi_rab.php?id=<?php echo $rab['id']; ?>" class="btn btn-sm btn-outline-success" title="Verifikasi">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                    <?php if ($rab['status'] === 'rejected'): ?>
                                                    <a href="verifikasi_rab.php?id=<?php echo $rab['id']; ?>" class="btn btn-sm btn-outline-warning" title="Review Ulang">
                                                        <i class="fas fa-redo"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                    <a href="../file_rab/<?php echo $rab['file_rab']; ?>" download class="btn btn-sm btn-outline-primary" title="Download">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
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
                                                    <p class="text-muted">RAB proyek akan ditampilkan di sini setelah dibuat.</p>
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

<script>
function filterTable() {
    const statusFilter = document.getElementById('statusFilter').value;
    const clientFilter = document.getElementById('clientFilter').value;
    const table = document.getElementById('rabTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const status = row.getAttribute('data-status');
        const client = row.getAttribute('data-client');
        
        let showRow = true;
        
        if (statusFilter && status !== statusFilter) {
            showRow = false;
        }
        
        if (clientFilter && client !== clientFilter) {
            showRow = false;
        }
        
        row.style.display = showRow ? '' : 'none';
    }
}

function filterRAB(status) {
    document.getElementById('statusFilter').value = status;
    filterTable();
}

// Icon circle style
const style = document.createElement('style');
style.textContent = `
.icon-circle {
    height: 2rem;
    width: 2rem;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
`;
document.head.appendChild(style);
</script>

<?php include 'includes/footer/footer.php'; ?>
