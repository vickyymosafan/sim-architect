<?php
require_once '../includes/session_manager.php';
require '../koneksi.php';

// Validasi session admin
check_session_auth('admin');

// Set page title
$page_title = "Kelola Revisi Request";

// Handle form submission
if ($_POST) {
    $action = $_POST['action'];

    if ($action == 'response') {
        $id = $_POST['id'];
        $status_revisi = mysqli_real_escape_string($koneksi, $_POST['status_revisi']);
        $catatan_reviewer = mysqli_real_escape_string($koneksi, $_POST['catatan_reviewer']);
        $reviewer_id = $_SESSION['id_petugas']; // ID admin yang login

        // Update status revisi
        $sql = "UPDATE revisi_request SET 
                status_revisi='$status_revisi', 
                tanggal_response=NOW(), 
                reviewer_id='$reviewer_id', 
                catatan_reviewer='$catatan_reviewer' 
                WHERE id='$id'";
        
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('Response revisi berhasil disimpan!'); window.location='kelola_revisi_request.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan response revisi!'); window.location='kelola_revisi_request.php';</script>";
        }
    }

    if ($action == 'hapus') {
        $id = $_POST['id'];
        
        // Get file info untuk hapus file referensi jika ada
        $file_query = mysqli_query($koneksi, "SELECT file_referensi FROM revisi_request WHERE id='$id'");
        $file_data = mysqli_fetch_array($file_query);
        
        if ($file_data && $file_data['file_referensi']) {
            $file_path = "../uploads/revisi/" . $file_data['file_referensi'];
            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file fisik
            }
        }
        
        $sql = "DELETE FROM revisi_request WHERE id='$id'";
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('Revisi request berhasil dihapus!'); window.location='kelola_revisi_request.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus revisi request!'); window.location='kelola_revisi_request.php';</script>";
        }
    }
}

// Get data for response
$response_data = null;
if (isset($_GET['response'])) {
    $response_id = $_GET['response'];
    $response_query = mysqli_query($koneksi, "
        SELECT rr.*, u.first_name, u.last_name,
               CASE 
                   WHEN rr.item_type = 'tugas' THEN tp.nama_kegiatan
                   WHEN rr.item_type = 'file' THEN fg.deskripsi
               END as item_name
        FROM revisi_request rr 
        LEFT JOIN users u ON rr.client_id = u.id 
        LEFT JOIN tugas_proyek tp ON rr.item_type = 'tugas' AND rr.item_id = tp.id
        LEFT JOIN file_gambar fg ON rr.item_type = 'file' AND rr.item_id = fg.id
        WHERE rr.id='$response_id'
    ");
    $response_data = mysqli_fetch_array($response_query);
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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Revisi Request</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Kelola Revisi Request</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Statistik Cards -->
                    <div class="row mb-4">
                        <?php
                        $stats = [
                            ['label' => 'Total Request', 'query' => "SELECT COUNT(*) as count FROM revisi_request", 'color' => 'primary', 'icon' => 'edit'],
                            ['label' => 'Pending', 'query' => "SELECT COUNT(*) as count FROM revisi_request WHERE status_revisi='pending'", 'color' => 'warning', 'icon' => 'clock'],
                            ['label' => 'Approved', 'query' => "SELECT COUNT(*) as count FROM revisi_request WHERE status_revisi='approved'", 'color' => 'success', 'icon' => 'check'],
                            ['label' => 'Rejected', 'query' => "SELECT COUNT(*) as count FROM revisi_request WHERE status_revisi='rejected'", 'color' => 'danger', 'icon' => 'times']
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

                    <!-- Form Response (jika ada) -->
                    <?php if ($response_data): ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-reply mr-2"></i>Response Revisi Request
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Client:</strong> <?php echo htmlspecialchars($response_data['first_name'] . ' ' . $response_data['last_name']); ?><br>
                                    <strong>Tipe Item:</strong> <?php echo ucfirst($response_data['item_type']); ?><br>
                                    <strong>Nama Item:</strong> <?php echo htmlspecialchars($response_data['item_name']); ?><br>
                                    <strong>Tanggal Request:</strong> <?php echo date('d M Y H:i', strtotime($response_data['tanggal_request'])); ?>
                                </div>
                                <div class="col-md-6">
                                    <?php if ($response_data['file_referensi']): ?>
                                    <strong>File Referensi:</strong><br>
                                    <a href="../uploads/revisi/<?php echo $response_data['file_referensi']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i> <?php echo htmlspecialchars($response_data['file_referensi']); ?>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <strong>Alasan Revisi:</strong><br>
                                    <div class="p-2 bg-light border rounded">
                                        <?php echo nl2br(htmlspecialchars($response_data['alasan_revisi'])); ?>
                                    </div>
                                </div>
                            </div>

                            <?php if ($response_data['detail_perubahan']): ?>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <strong>Detail Perubahan:</strong><br>
                                    <div class="p-2 bg-light border rounded">
                                        <?php echo nl2br(htmlspecialchars($response_data['detail_perubahan'])); ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <form method="POST" action="">
                                <input type="hidden" name="action" value="response">
                                <input type="hidden" name="id" value="<?php echo $response_data['id']; ?>">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status_revisi">Status Revisi <span class="text-danger">*</span></label>
                                            <select class="form-control" id="status_revisi" name="status_revisi" required>
                                                <option value="">Pilih Status</option>
                                                <option value="approved" <?php echo ($response_data['status_revisi'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                                <option value="rejected" <?php echo ($response_data['status_revisi'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                                <option value="pending" <?php echo ($response_data['status_revisi'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="catatan_reviewer">Catatan Reviewer</label>
                                    <textarea class="form-control" id="catatan_reviewer" name="catatan_reviewer" rows="3" 
                                              placeholder="Masukkan catatan response..."><?php echo htmlspecialchars($response_data['catatan_reviewer']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-2"></i>Simpan Response
                                    </button>
                                    <a href="kelola_revisi_request.php" class="btn btn-secondary">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Tabel Daftar Revisi Request -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-edit mr-2"></i>Daftar Revisi Request
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Client</th>
                                            <th>Item</th>
                                            <th>Alasan Revisi</th>
                                            <th class="text-center">Tanggal Request</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Reviewer</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $query = mysqli_query($koneksi, "
                                            SELECT rr.*, u.first_name, u.last_name, p.nama_petugas as reviewer_nama,
                                                   CASE 
                                                       WHEN rr.item_type = 'tugas' THEN tp.nama_kegiatan
                                                       WHEN rr.item_type = 'file' THEN fg.deskripsi
                                                   END as item_name
                                            FROM revisi_request rr 
                                            LEFT JOIN users u ON rr.client_id = u.id 
                                            LEFT JOIN petugas p ON rr.reviewer_id = p.id_petugas 
                                            LEFT JOIN tugas_proyek tp ON rr.item_type = 'tugas' AND rr.item_id = tp.id
                                            LEFT JOIN file_gambar fg ON rr.item_type = 'file' AND rr.item_id = fg.id
                                            ORDER BY rr.tanggal_request DESC
                                        ");
                                        while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    <?php echo htmlspecialchars($data['first_name'] . ' ' . $data['last_name']); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    <?php echo ucfirst($data['item_type']); ?>: <?php echo htmlspecialchars($data['item_name']); ?>
                                                </div>
                                                <?php if ($data['file_referensi']): ?>
                                                <small class="text-muted">
                                                    <i class="fas fa-paperclip"></i> File referensi tersedia
                                                </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div style="max-width: 200px;">
                                                    <?php echo htmlspecialchars(substr($data['alasan_revisi'], 0, 100)); ?>
                                                    <?php if (strlen($data['alasan_revisi']) > 100) echo '...'; ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <small>
                                                    <?php echo date('d M Y', strtotime($data['tanggal_request'])); ?><br>
                                                    <?php echo date('H:i', strtotime($data['tanggal_request'])); ?>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $status_class = '';
                                                switch($data['status_revisi']) {
                                                    case 'approved': $status_class = 'success'; break;
                                                    case 'rejected': $status_class = 'danger'; break;
                                                    case 'pending': $status_class = 'warning'; break;
                                                    default: $status_class = 'secondary';
                                                }
                                                ?>
                                                <span class="badge badge-<?php echo $status_class; ?>">
                                                    <?php echo ucfirst($data['status_revisi']); ?>
                                                </span>
                                                <?php if ($data['tanggal_response']): ?>
                                                <br><small class="text-muted"><?php echo date('d M Y', strtotime($data['tanggal_response'])); ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($data['reviewer_nama']): ?>
                                                    <small><?php echo htmlspecialchars($data['reviewer_nama']); ?></small>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="kelola_revisi_request.php?response=<?php echo $data['id']; ?>"
                                                       class="btn btn-info btn-sm" title="Response">
                                                        <i class="fas fa-reply"></i>
                                                    </a>
                                                    <?php if ($data['file_referensi']): ?>
                                                    <a href="../uploads/revisi/<?php echo $data['file_referensi']; ?>" target="_blank" 
                                                       class="btn btn-warning btn-sm" title="Download File">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                    <button onclick="hapusRevisi(<?php echo $data['id']; ?>, '<?php echo htmlspecialchars($data['item_name']); ?>')"
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
function hapusRevisi(id, item_name) {
    if (confirm('Apakah Anda yakin ingin menghapus revisi request untuk "' + item_name + '"?\n\nPerhatian: Tindakan ini tidak dapat dibatalkan!')) {
        document.getElementById('hapusId').value = id;
        document.getElementById('formHapus').submit();
    }
}
</script>

<?php include 'includes/footer/footer.php'; ?>
