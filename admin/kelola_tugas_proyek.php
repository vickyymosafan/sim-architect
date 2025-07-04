<?php
require_once '../includes/session_manager.php';
require '../koneksi.php';

// Validasi session admin
check_session_auth('admin');

// Set page title
$page_title = "Kelola Tugas Proyek";

// Handle form submission untuk verifikasi
if ($_POST) {
    $action = $_POST['action'];

    if ($action == 'verifikasi') {
        $id = $_POST['id'];
        $status_verifikasi = mysqli_real_escape_string($koneksi, $_POST['status_verifikasi']);
        $catatan_verifikasi = mysqli_real_escape_string($koneksi, $_POST['catatan_verifikasi']);
        $verifikator_id = $_SESSION['id_petugas']; // ID admin yang login

        // Update status verifikasi
        $sql = "UPDATE tugas_proyek SET 
                status_verifikasi='$status_verifikasi', 
                tanggal_verifikasi=NOW(), 
                verifikator_id='$verifikator_id', 
                catatan_verifikasi='$catatan_verifikasi' 
                WHERE id='$id'";
        
        if (mysqli_query($koneksi, $sql)) {
            // Log verifikasi
            $log_sql = "INSERT INTO verifikasi_log (tipe, item_id, status_baru, verifikator_id, catatan) 
                       VALUES ('tugas', '$id', '$status_verifikasi', '$verifikator_id', '$catatan_verifikasi')";
            mysqli_query($koneksi, $log_sql);
            
            echo "<script>alert('Status verifikasi berhasil diupdate!'); window.location='kelola_tugas_proyek.php';</script>";
        } else {
            echo "<script>alert('Gagal mengupdate status verifikasi!'); window.location='kelola_tugas_proyek.php';</script>";
        }
    }

    if ($action == 'hapus') {
        $id = $_POST['id'];
        $sql = "DELETE FROM tugas_proyek WHERE id='$id'";
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('Tugas proyek berhasil dihapus!'); window.location='kelola_tugas_proyek.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus tugas proyek!'); window.location='kelola_tugas_proyek.php';</script>";
        }
    }
}

// Get data for verification
$verify_data = null;
if (isset($_GET['verify'])) {
    $verify_id = $_GET['verify'];
    $verify_query = mysqli_query($koneksi, "SELECT * FROM tugas_proyek WHERE id='$verify_id'");
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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Tugas Proyek</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Kelola Tugas Proyek</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Statistik Cards -->
                    <div class="row mb-4">
                        <?php
                        $stats = [
                            ['label' => 'Total Tugas', 'query' => "SELECT COUNT(*) as count FROM tugas_proyek", 'color' => 'primary', 'icon' => 'tasks'],
                            ['label' => 'Pending', 'query' => "SELECT COUNT(*) as count FROM tugas_proyek WHERE status_verifikasi='pending'", 'color' => 'warning', 'icon' => 'clock'],
                            ['label' => 'Approved', 'query' => "SELECT COUNT(*) as count FROM tugas_proyek WHERE status_verifikasi='approved'", 'color' => 'success', 'icon' => 'check'],
                            ['label' => 'Rejected', 'query' => "SELECT COUNT(*) as count FROM tugas_proyek WHERE status_verifikasi='rejected'", 'color' => 'danger', 'icon' => 'times']
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
                                <i class="fas fa-check-circle mr-2"></i>Verifikasi Tugas Proyek
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Nama Kegiatan:</strong> <?php echo htmlspecialchars($verify_data['nama_kegiatan']); ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Tanggal:</strong> <?php echo date('d M Y', strtotime($verify_data['tgl'])); ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <strong>Deskripsi:</strong><br>
                                    <?php echo htmlspecialchars($verify_data['deskripsi']); ?>
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
                                    <a href="kelola_tugas_proyek.php" class="btn btn-secondary">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Tabel Daftar Tugas Proyek -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-list mr-2"></i>Daftar Tugas Proyek
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Deskripsi</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Verifikasi</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $query = mysqli_query($koneksi, "
                                            SELECT tp.*, p.nama_petugas as verifikator_nama 
                                            FROM tugas_proyek tp 
                                            LEFT JOIN petugas p ON tp.verifikator_id = p.id_petugas 
                                            ORDER BY tp.tanggal_submit DESC
                                        ");
                                        while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    <?php echo htmlspecialchars($data['nama_kegiatan']); ?>
                                                </div>
                                                <small class="text-muted">
                                                    Submit: <?php echo date('d M Y H:i', strtotime($data['tanggal_submit'])); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div style="max-width: 200px;">
                                                    <?php echo htmlspecialchars(substr($data['deskripsi'], 0, 100)); ?>
                                                    <?php if (strlen($data['deskripsi']) > 100) echo '...'; ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-info">
                                                    <?php echo date('d M Y', strtotime($data['tgl'])); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $status_class = '';
                                                switch($data['status']) {
                                                    case 'selesai': $status_class = 'success'; break;
                                                    case 'proses': $status_class = 'warning'; break;
                                                    case 'batal': $status_class = 'danger'; break;
                                                    default: $status_class = 'secondary';
                                                }
                                                ?>
                                                <span class="badge badge-<?php echo $status_class; ?>">
                                                    <?php echo ucfirst($data['status']); ?>
                                                </span>
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
                                                <?php if ($data['verifikator_nama']): ?>
                                                <br><small class="text-muted">oleh: <?php echo htmlspecialchars($data['verifikator_nama']); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="kelola_tugas_proyek.php?verify=<?php echo $data['id']; ?>"
                                                       class="btn btn-info btn-sm" title="Verifikasi">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <button onclick="hapusTugas(<?php echo $data['id']; ?>, '<?php echo htmlspecialchars($data['nama_kegiatan']); ?>')"
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
function hapusTugas(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus tugas "' + nama + '"?\n\nPerhatian: Tindakan ini tidak dapat dibatalkan!')) {
        document.getElementById('hapusId').value = id;
        document.getElementById('formHapus').submit();
    }
}
</script>

<?php include 'includes/footer/footer.php'; ?>
