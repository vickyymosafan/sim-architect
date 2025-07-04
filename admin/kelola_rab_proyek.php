<?php
require_once '../includes/session_manager.php';
require '../koneksi.php';

// Validasi session admin
check_session_auth('admin');

// Set page title
$page_title = "Kelola RAB Proyek";

// Handle form submission
if ($_POST) {
    $action = $_POST['action'];

    if ($action == 'verifikasi') {
        $id = $_POST['id'];
        $status = mysqli_real_escape_string($koneksi, $_POST['status']);
        $catatan_verifikasi = mysqli_real_escape_string($koneksi, $_POST['catatan_verifikasi']);
        $verifikator_id = $_SESSION['id_petugas']; // ID admin yang login

        // Update status verifikasi
        $sql = "UPDATE rab_proyek SET 
                status='$status', 
                tanggal_verifikasi=NOW(), 
                verifikator_id='$verifikator_id', 
                catatan_verifikasi='$catatan_verifikasi' 
                WHERE id='$id'";
        
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('Status RAB berhasil diupdate!'); window.location='kelola_rab_proyek.php';</script>";
        } else {
            echo "<script>alert('Gagal mengupdate status RAB!'); window.location='kelola_rab_proyek.php';</script>";
        }
    }

    if ($action == 'hapus') {
        $id = $_POST['id'];
        
        // Get file info untuk hapus file fisik
        $file_query = mysqli_query($koneksi, "SELECT file_rab FROM rab_proyek WHERE id='$id'");
        $file_data = mysqli_fetch_array($file_query);
        
        if ($file_data) {
            $file_path = "../uploads/rab/" . $file_data['file_rab'];
            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file fisik
            }
        }
        
        $sql = "DELETE FROM rab_proyek WHERE id='$id'";
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('RAB proyek berhasil dihapus!'); window.location='kelola_rab_proyek.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus RAB proyek!'); window.location='kelola_rab_proyek.php';</script>";
        }
    }
}

// Get data for verification
$verify_data = null;
if (isset($_GET['verify'])) {
    $verify_id = $_GET['verify'];
    $verify_query = mysqli_query($koneksi, "
        SELECT rp.*, u.first_name, u.last_name, p.nama_petugas as creator_name 
        FROM rab_proyek rp 
        LEFT JOIN users u ON rp.client_id = u.id 
        LEFT JOIN petugas p ON rp.created_by = p.id_petugas 
        WHERE rp.id='$verify_id'
    ");
    $verify_data = mysqli_fetch_array($verify_query);
}

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
                        <h1 class="h3 mb-0 text-gray-800">Kelola RAB Proyek</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Kelola RAB Proyek</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Statistik Cards -->
                    <div class="row mb-4">
                        <?php
                        $stats = [
                            ['label' => 'Total RAB', 'query' => "SELECT COUNT(*) as count FROM rab_proyek", 'color' => 'primary', 'icon' => 'file-invoice-dollar'],
                            ['label' => 'Draft', 'query' => "SELECT COUNT(*) as count FROM rab_proyek WHERE status='draft'", 'color' => 'warning', 'icon' => 'edit'],
                            ['label' => 'Approved', 'query' => "SELECT COUNT(*) as count FROM rab_proyek WHERE status='approved'", 'color' => 'success', 'icon' => 'check'],
                            ['label' => 'Rejected', 'query' => "SELECT COUNT(*) as count FROM rab_proyek WHERE status='rejected'", 'color' => 'danger', 'icon' => 'times']
                        ];

                        foreach ($stats as $stat) {
                            $result = mysqli_query($koneksi, $stat['query']);
                            $count = mysqli_fetch_array($result)['count'];
                        ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-<?php echo $stat['color']; ?> shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-<?php echo $stat['color']; ?> text-uppercase mb-1">
                                                <?php echo $stat['label']; ?>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-<?php echo $stat['icon']; ?> fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <!-- Form Verifikasi (jika ada) -->
                    <?php if ($verify_data): ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-check-circle mr-2"></i>Verifikasi RAB Proyek
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Nama Proyek:</strong> <?php echo htmlspecialchars($verify_data['nama_proyek']); ?><br>
                                    <strong>Client:</strong> <?php echo htmlspecialchars($verify_data['first_name'] . ' ' . $verify_data['last_name']); ?><br>
                                    <strong>Dibuat oleh:</strong> <?php echo htmlspecialchars($verify_data['creator_name']); ?><br>
                                    <strong>Tanggal Upload:</strong> <?php echo date('d M Y H:i', strtotime($verify_data['tanggal_upload'])); ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>File RAB:</strong> <?php echo htmlspecialchars($verify_data['file_rab']); ?><br>
                                    <strong>Ukuran File:</strong> <?php echo number_format($verify_data['file_size']/1024, 2); ?> KB<br>
                                    <strong>Tipe File:</strong> <?php echo htmlspecialchars($verify_data['file_type']); ?><br>
                                    <div class="mt-2">
                                        <a href="../uploads/rab/<?php echo $verify_data['file_rab']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> Download RAB
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($verify_data['deskripsi']): ?>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <strong>Deskripsi:</strong><br>
                                    <?php echo nl2br(htmlspecialchars($verify_data['deskripsi'])); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <form method="POST" action="">
                                <input type="hidden" name="action" value="verifikasi">
                                <input type="hidden" name="id" value="<?php echo $verify_data['id']; ?>">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status RAB <span class="text-danger">*</span></label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="">Pilih Status</option>
                                                <option value="approved" <?php echo ($verify_data['status'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                                <option value="rejected" <?php echo ($verify_data['status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                                <option value="draft" <?php echo ($verify_data['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="catatan_verifikasi">Catatan Verifikasi</label>
                                    <textarea class="form-control" id="catatan_verifikasi" name="catatan_verifikasi" rows="3" 
                                              placeholder="Masukkan catatan verifikasi..."><?php echo htmlspecialchars($verify_data['catatan_verifikasi']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-2"></i>Update Status
                                    </button>
                                    <a href="kelola_rab_proyek.php" class="btn btn-secondary">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Tabel Daftar RAB Proyek -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-file-invoice-dollar mr-2"></i>Daftar RAB Proyek
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama Proyek</th>
                                            <th>Client</th>
                                            <th>File RAB</th>
                                            <th class="text-center">Tanggal Upload</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Verifikator</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $query = mysqli_query($koneksi, "
                                            SELECT rp.*, u.first_name, u.last_name, p.nama_petugas as verifikator_nama, 
                                                   pc.nama_petugas as creator_name
                                            FROM rab_proyek rp 
                                            LEFT JOIN users u ON rp.client_id = u.id 
                                            LEFT JOIN petugas p ON rp.verifikator_id = p.id_petugas 
                                            LEFT JOIN petugas pc ON rp.created_by = pc.id_petugas 
                                            ORDER BY rp.tanggal_upload DESC
                                        ");
                                        while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    <?php echo htmlspecialchars($data['nama_proyek']); ?>
                                                </div>
                                                <?php if ($data['deskripsi']): ?>
                                                <small class="text-muted">
                                                    <?php echo htmlspecialchars(substr($data['deskripsi'], 0, 50)); ?>
                                                    <?php if (strlen($data['deskripsi']) > 50) echo '...'; ?>
                                                </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    <?php echo htmlspecialchars($data['first_name'] . ' ' . $data['last_name']); ?>
                                                </div>
                                                <?php if ($data['creator_name']): ?>
                                                <small class="text-muted">Dibuat: <?php echo htmlspecialchars($data['creator_name']); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-2">
                                                        <i class="fas fa-file fa-2x text-muted"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold"><?php echo htmlspecialchars($data['file_rab']); ?></div>
                                                        <small class="text-muted">
                                                            <?php echo number_format($data['file_size']/1024, 2); ?> KB
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <small>
                                                    <?php echo date('d M Y', strtotime($data['tanggal_upload'])); ?><br>
                                                    <?php echo date('H:i', strtotime($data['tanggal_upload'])); ?>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $status_class = '';
                                                switch($data['status']) {
                                                    case 'approved': $status_class = 'success'; break;
                                                    case 'rejected': $status_class = 'danger'; break;
                                                    case 'draft': $status_class = 'warning'; break;
                                                    default: $status_class = 'secondary';
                                                }
                                                ?>
                                                <span class="badge badge-<?php echo $status_class; ?>">
                                                    <?php echo ucfirst($data['status']); ?>
                                                </span>
                                                <?php if ($data['tanggal_verifikasi']): ?>
                                                <br><small class="text-muted"><?php echo date('d M Y', strtotime($data['tanggal_verifikasi'])); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($data['verifikator_nama']): ?>
                                                    <small><?php echo htmlspecialchars($data['verifikator_nama']); ?></small>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="../uploads/rab/<?php echo $data['file_rab']; ?>" target="_blank" class="btn btn-info btn-sm" title="Download RAB">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <a href="kelola_rab_proyek.php?verify=<?php echo $data['id']; ?>"
                                                       class="btn btn-warning btn-sm" title="Verifikasi">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <button onclick="hapusRAB(<?php echo $data['id']; ?>, '<?php echo htmlspecialchars($data['nama_proyek']); ?>')"
                                                            class="btn btn-danger btn-sm" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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

<!-- Form Hidden untuk Hapus -->
<form id="formHapus" method="POST" style="display: none;">
    <input type="hidden" name="action" value="hapus">
    <input type="hidden" name="id" id="hapusId">
</form>

<script>
function hapusRAB(id, nama_proyek) {
    if (confirm('Apakah Anda yakin ingin menghapus RAB "' + nama_proyek + '"?\n\nPerhatian: File RAB akan dihapus permanen dan tidak dapat dikembalikan!')) {
        document.getElementById('hapusId').value = id;
        document.getElementById('formHapus').submit();
    }
}
</script>

<?php include 'includes/footer/footer.php'; ?>
