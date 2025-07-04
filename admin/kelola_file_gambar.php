<?php
require_once '../includes/session_manager.php';
require '../koneksi.php';

// Validasi session admin
check_session_auth('admin');

// Set page title
$page_title = "Kelola File Gambar";

// Handle form submission untuk verifikasi
if ($_POST) {
    $action = $_POST['action'];

    if ($action == 'verifikasi') {
        $id = $_POST['id'];
        $status_verifikasi = mysqli_real_escape_string($koneksi, $_POST['status_verifikasi']);
        $catatan_verifikasi = mysqli_real_escape_string($koneksi, $_POST['catatan_verifikasi']);
        $verifikator_id = $_SESSION['id_petugas']; // ID admin yang login

        // Update status verifikasi
        $sql = "UPDATE file_gambar SET 
                status_verifikasi='$status_verifikasi', 
                tanggal_verifikasi=NOW(), 
                verifikator_id='$verifikator_id', 
                catatan_verifikasi='$catatan_verifikasi' 
                WHERE id='$id'";
        
        if (mysqli_query($koneksi, $sql)) {
            // Log verifikasi
            $log_sql = "INSERT INTO verifikasi_log (tipe, item_id, status_baru, verifikator_id, catatan) 
                       VALUES ('file', '$id', '$status_verifikasi', '$verifikator_id', '$catatan_verifikasi')";
            mysqli_query($koneksi, $log_sql);
            
            echo "<script>alert('Status verifikasi berhasil diupdate!'); window.location='kelola_file_gambar.php';</script>";
        } else {
            echo "<script>alert('Gagal mengupdate status verifikasi!'); window.location='kelola_file_gambar.php';</script>";
        }
    }

    if ($action == 'hapus') {
        $id = $_POST['id'];
        
        // Get file info untuk hapus file fisik
        $file_query = mysqli_query($koneksi, "SELECT gambar FROM file_gambar WHERE id='$id'");
        $file_data = mysqli_fetch_array($file_query);
        
        if ($file_data) {
            $file_path = "../uploads/gambar/" . $file_data['gambar'];
            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file fisik
            }
        }
        
        $sql = "DELETE FROM file_gambar WHERE id='$id'";
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('File gambar berhasil dihapus!'); window.location='kelola_file_gambar.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus file gambar!'); window.location='kelola_file_gambar.php';</script>";
        }
    }
}

// Get data for verification
$verify_data = null;
if (isset($_GET['verify'])) {
    $verify_id = $_GET['verify'];
    $verify_query = mysqli_query($koneksi, "SELECT * FROM file_gambar WHERE id='$verify_id'");
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
                        <h1 class="h3 mb-0 text-gray-800">Kelola File Gambar</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Kelola File Gambar</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Statistik Cards -->
                    <div class="row mb-4">
                        <?php
                        $stats = [
                            ['label' => 'Total File', 'query' => "SELECT COUNT(*) as count FROM file_gambar", 'color' => 'primary', 'icon' => 'images'],
                            ['label' => 'Pending', 'query' => "SELECT COUNT(*) as count FROM file_gambar WHERE status_verifikasi='pending'", 'color' => 'warning', 'icon' => 'clock'],
                            ['label' => 'Approved', 'query' => "SELECT COUNT(*) as count FROM file_gambar WHERE status_verifikasi='approved'", 'color' => 'success', 'icon' => 'check'],
                            ['label' => 'Rejected', 'query' => "SELECT COUNT(*) as count FROM file_gambar WHERE status_verifikasi='rejected'", 'color' => 'danger', 'icon' => 'times']
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
                                <i class="fas fa-check-circle mr-2"></i>Verifikasi File Gambar
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <strong>Deskripsi:</strong> <?php echo htmlspecialchars($verify_data['deskripsi']); ?><br>
                                    <strong>Nama File:</strong> <?php echo htmlspecialchars($verify_data['gambar']); ?><br>
                                    <strong>Tanggal Submit:</strong> <?php echo date('d M Y H:i', strtotime($verify_data['tanggal_submit'])); ?>
                                </div>
                                <div class="col-md-4">
                                    <?php 
                                    $file_path = "../uploads/gambar/" . $verify_data['gambar'];
                                    $file_ext = strtolower(pathinfo($verify_data['gambar'], PATHINFO_EXTENSION));
                                    ?>
                                    <?php if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                        <img src="<?php echo $file_path; ?>" class="img-thumbnail" style="max-width: 200px;">
                                    <?php else: ?>
                                        <div class="text-center p-3 border">
                                            <i class="fas fa-file fa-3x text-muted"></i><br>
                                            <small><?php echo strtoupper($file_ext); ?> File</small>
                                        </div>
                                    <?php endif; ?>
                                    <div class="mt-2">
                                        <a href="<?php echo $file_path; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <form method="POST" action="">
                                <input type="hidden" name="action" value="verifikasi">
                                <input type="hidden" name="id" value="<?php echo $verify_data['id']; ?>">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status_verifikasi">Status Verifikasi <span class="text-danger">*</span></label>
                                            <select class="form-control" id="status_verifikasi" name="status_verifikasi" required>
                                                <option value="">Pilih Status</option>
                                                <option value="approved" <?php echo ($verify_data['status_verifikasi'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                                <option value="rejected" <?php echo ($verify_data['status_verifikasi'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                                <option value="pending" <?php echo ($verify_data['status_verifikasi'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
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
                                        <i class="fas fa-save mr-2"></i>Update Verifikasi
                                    </button>
                                    <a href="kelola_file_gambar.php" class="btn btn-secondary">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Tabel Daftar File Gambar -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-images mr-2"></i>Daftar File Gambar
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Deskripsi</th>
                                            <th>File</th>
                                            <th class="text-center">Tanggal Submit</th>
                                            <th class="text-center">Status Verifikasi</th>
                                            <th class="text-center">Verifikator</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $query = mysqli_query($koneksi, "
                                            SELECT fg.*, p.nama_petugas as verifikator_nama 
                                            FROM file_gambar fg 
                                            LEFT JOIN petugas p ON fg.verifikator_id = p.id_petugas 
                                            ORDER BY fg.tanggal_submit DESC
                                        ");
                                        while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    <?php echo htmlspecialchars($data['deskripsi']); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php 
                                                    $file_ext = strtolower(pathinfo($data['gambar'], PATHINFO_EXTENSION));
                                                    $file_path = "../uploads/gambar/" . $data['gambar'];
                                                    ?>
                                                    <?php if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                                        <img src="<?php echo $file_path; ?>" class="img-thumbnail mr-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="mr-2">
                                                            <i class="fas fa-file fa-2x text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <div class="font-weight-bold"><?php echo htmlspecialchars($data['gambar']); ?></div>
                                                        <small class="text-muted"><?php echo strtoupper($file_ext); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <small>
                                                    <?php echo date('d M Y', strtotime($data['tanggal_submit'])); ?><br>
                                                    <?php echo date('H:i', strtotime($data['tanggal_submit'])); ?>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $verify_class = '';
                                                switch($data['status_verifikasi']) {
                                                    case 'approved': $verify_class = 'success'; break;
                                                    case 'rejected': $verify_class = 'danger'; break;
                                                    case 'pending': $verify_class = 'warning'; break;
                                                    default: $verify_class = 'secondary';
                                                }
                                                ?>
                                                <span class="badge badge-<?php echo $verify_class; ?>">
                                                    <?php echo ucfirst($data['status_verifikasi']); ?>
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
                                                    <a href="<?php echo $file_path; ?>" target="_blank" class="btn btn-info btn-sm" title="Lihat File">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="kelola_file_gambar.php?verify=<?php echo $data['id']; ?>"
                                                       class="btn btn-warning btn-sm" title="Verifikasi">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <button onclick="hapusFile(<?php echo $data['id']; ?>, '<?php echo htmlspecialchars($data['deskripsi']); ?>')"
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
function hapusFile(id, deskripsi) {
    if (confirm('Apakah Anda yakin ingin menghapus file "' + deskripsi + '"?\n\nPerhatian: File akan dihapus permanen dan tidak dapat dikembalikan!')) {
        document.getElementById('hapusId').value = id;
        document.getElementById('formHapus').submit();
    }
}
</script>

<?php include 'includes/footer/footer.php'; ?>
