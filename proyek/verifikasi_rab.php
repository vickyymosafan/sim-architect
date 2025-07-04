<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');

$page_title = "Verifikasi RAB";
include 'includes/header/header.php';
require '../koneksi.php';

$rab_id = (int)($_GET['id'] ?? 0);

if ($rab_id <= 0) {
    echo "<script>alert('ID RAB tidak valid!'); window.location.href='kelola_rab.php';</script>";
    exit;
}

// Get RAB data
$rab_query = "SELECT rp.*, u.first_name, u.last_name, u.username, pc.nama_petugas as creator_name
              FROM rab_proyek rp
              LEFT JOIN users u ON rp.client_id = u.id
              LEFT JOIN petugas pc ON rp.created_by = pc.id_petugas
              WHERE rp.id = $rab_id AND rp.status IN ('draft', 'rejected')";
$rab_result = mysqli_query($koneksi, $rab_query);

if (!$rab_result || mysqli_num_rows($rab_result) === 0) {
    echo "<script>alert('RAB tidak ditemukan atau tidak dapat diverifikasi!'); window.location.href='kelola_rab.php';</script>";
    exit;
}

$rab = mysqli_fetch_array($rab_result);

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
                        <h1 class="h3 mb-0 text-gray-800">Verifikasi RAB</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="proyek.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="kelola_rab.php">Kelola RAB</a></li>
                                <li class="breadcrumb-item active">Verifikasi RAB</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- RAB Information -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-info-circle mr-2"></i>Informasi RAB
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Client:</label>
                                                <p class="mb-1"><?php echo htmlspecialchars($rab['first_name'] . ' ' . $rab['last_name']); ?></p>
                                                <small class="text-muted">@<?php echo htmlspecialchars($rab['username']); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Nama Proyek:</label>
                                                <p class="mb-0"><?php echo htmlspecialchars($rab['nama_proyek']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Deskripsi:</label>
                                        <p class="mb-0"><?php echo htmlspecialchars($rab['deskripsi'] ?: 'Tidak ada deskripsi'); ?></p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Tanggal Upload:</label>
                                                <p class="mb-0"><?php echo date('d M Y H:i', strtotime($rab['tanggal_upload'])); ?> WIB</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Upload oleh:</label>
                                                <p class="mb-0"><?php echo htmlspecialchars($rab['creator_name'] ?? 'N/A'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- File Preview -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="<?php echo $file_icon; ?> mr-2"></i>File RAB
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="<?php echo $file_icon; ?> <?php echo $file_color; ?> fa-3x mr-3"></i>
                                        <div>
                                            <h5 class="mb-1"><?php echo htmlspecialchars($rab['file_rab']); ?></h5>
                                            <p class="text-muted mb-0">
                                                <?php echo formatFileSize($rab['file_size']); ?> • 
                                                <?php echo strtoupper($file_ext); ?> • 
                                                <?php echo $rab['file_type']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <a href="../file_rab/<?php echo $rab['file_rab']; ?>" target="_blank" class="btn btn-primary btn-lg mr-3">
                                            <i class="fas fa-eye mr-2"></i>Buka File
                                        </a>
                                        <a href="../file_rab/<?php echo $rab['file_rab']; ?>" download class="btn btn-secondary btn-lg">
                                            <i class="fas fa-download mr-2"></i>Download
                                        </a>
                                    </div>
                                    
                                    <?php if ($file_ext === 'pdf'): ?>
                                    <div class="mt-4">
                                        <h6 class="font-weight-bold">Preview PDF:</h6>
                                        <div class="embed-responsive embed-responsive-4by3">
                                            <iframe class="embed-responsive-item" src="../file_rab/<?php echo $rab['file_rab']; ?>" 
                                                style="border: 1px solid #ddd;"></iframe>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <!-- Status Current -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-flag mr-2"></i>Status Saat Ini
                                    </h6>
                                </div>
                                <div class="card-body text-center">
                                    <?php if ($rab['status'] === 'draft'): ?>
                                    <i class="fas fa-clock fa-3x text-secondary mb-3"></i>
                                    <h5 class="text-secondary">Draft</h5>
                                    <p class="text-muted">Menunggu verifikasi</p>
                                    <?php elseif ($rab['status'] === 'rejected'): ?>
                                    <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                                    <h5 class="text-danger">Ditolak</h5>
                                    <p class="text-muted">Perlu perbaikan</p>
                                    <?php if ($rab['catatan_verifikasi']): ?>
                                    <div class="alert alert-danger text-left">
                                        <strong>Catatan:</strong><br>
                                        <?php echo htmlspecialchars($rab['catatan_verifikasi']); ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Verifikasi Form -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-check-circle mr-2"></i>Verifikasi RAB
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form action="proses_verifikasi_rab.php" method="post" id="verifikasiForm">
                                        <input type="hidden" name="rab_id" value="<?php echo $rab_id; ?>">
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">Keputusan Verifikasi:</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="keputusan" id="approve" value="approved" required>
                                                <label class="form-check-label text-success font-weight-bold" for="approve">
                                                    <i class="fas fa-check mr-1"></i>Setujui RAB
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="keputusan" id="reject" value="rejected" required>
                                                <label class="form-check-label text-danger font-weight-bold" for="reject">
                                                    <i class="fas fa-times mr-1"></i>Tolak RAB
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="catatan" class="font-weight-bold">Catatan Verifikasi:</label>
                                            <textarea class="form-control" id="catatan" name="catatan" rows="4" 
                                                placeholder="Berikan catatan untuk keputusan verifikasi..."></textarea>
                                            <small class="form-text text-muted">
                                                Catatan akan dilihat oleh tim proyek dan client (jika disetujui)
                                            </small>
                                        </div>

                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                                <i class="fas fa-save mr-2"></i>Simpan Verifikasi
                                            </button>
                                            <a href="kelola_rab.php" class="btn btn-secondary btn-lg btn-block mt-2">
                                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<script>
// Form validation and confirmation
document.getElementById('verifikasiForm').addEventListener('submit', function(e) {
    const keputusan = document.querySelector('input[name="keputusan"]:checked');
    const catatan = document.getElementById('catatan').value.trim();
    
    if (!keputusan) {
        e.preventDefault();
        alert('Harap pilih keputusan verifikasi!');
        return false;
    }
    
    const keputusanText = keputusan.value === 'approved' ? 'menyetujui' : 'menolak';
    
    if (keputusan.value === 'rejected' && catatan === '') {
        e.preventDefault();
        alert('Harap berikan catatan untuk penolakan RAB!');
        return false;
    }
    
    if (!confirm(`Apakah Anda yakin ingin ${keputusanText} RAB ini?`)) {
        e.preventDefault();
        return false;
    }
    
    // Show loading
    const submitBtn = e.target.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    submitBtn.disabled = true;
});

// Auto-require catatan for rejection
document.getElementById('reject').addEventListener('change', function() {
    const catatan = document.getElementById('catatan');
    if (this.checked) {
        catatan.required = true;
        catatan.placeholder = 'Catatan wajib diisi untuk penolakan RAB...';
    }
});

document.getElementById('approve').addEventListener('change', function() {
    const catatan = document.getElementById('catatan');
    if (this.checked) {
        catatan.required = false;
        catatan.placeholder = 'Berikan catatan untuk keputusan verifikasi...';
    }
});
</script>

<?php include 'includes/footer/footer.php'; ?>
