<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');

$page_title = "Verifikasi";
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
                        <h1 class="h3 mb-0 text-gray-800">Verifikasi & Approval</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="proyek.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Verifikasi & Approval</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Info Alert -->
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Informasi:</strong> Halaman ini digunakan untuk memverifikasi tugas dan file yang disubmit. Klik tab untuk beralih antara verifikasi tugas dan file.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="verifikasiTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tugas-tab" data-toggle="tab" href="#tugas" role="tab" aria-controls="tugas" aria-selected="true">
                                <i class="fas fa-tasks mr-2"></i>Verifikasi Tugas
                                <span class="badge badge-warning ml-1" id="tugasCount">0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="file-tab" data-toggle="tab" href="#file" role="tab" aria-controls="file" aria-selected="false">
                                <i class="fas fa-file mr-2"></i>Verifikasi File
                                <span class="badge badge-warning ml-1" id="fileCount">0</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="verifikasiTabContent">
                        <!-- Tab Verifikasi Tugas -->
                        <div class="tab-pane fade show active" id="tugas" role="tabpanel" aria-labelledby="tugas-tab">
                            <div class="card shadow mb-4 mt-3">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-clipboard-check mr-2"></i>Daftar Tugas Menunggu Verifikasi
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
                                                    <th class="text-center">Tanggal Submit</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require '../koneksi.php';
                                                $sql_tugas = mysqli_query($koneksi, "SELECT * FROM tugas_proyek WHERE status_verifikasi = 'pending' ORDER BY tanggal_submit DESC");
                                                $no = 1;
                                                $count_tugas = mysqli_num_rows($sql_tugas);

                                                if ($count_tugas > 0) {
                                                    while ($tugas = mysqli_fetch_array($sql_tugas)) {
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td class="font-weight-bold"><?php echo htmlspecialchars($tugas['nama_kegiatan']); ?></td>
                                                    <td>
                                                        <div class="text-truncate" title="<?php echo htmlspecialchars($tugas['deskripsi']); ?>">
                                                            <?php echo htmlspecialchars($tugas['deskripsi']); ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <small class="text-muted">
                                                            <?php echo date('d M Y', strtotime($tugas['tgl'])); ?>
                                                        </small>
                                                    </td>
                                                    <td class="text-center">
                                                        <small class="text-muted">
                                                            <?php echo date('d M Y', strtotime($tugas['tanggal_submit'])); ?>
                                                            <br>
                                                            <?php echo date('H:i', strtotime($tugas['tanggal_submit'])); ?>
                                                        </small>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge badge-warning px-3 py-2">
                                                            <i class="fas fa-clock mr-1"></i>Menunggu
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-success btn-sm" onclick="verifikasiTugas(<?php echo $tugas['id']; ?>, 'approved')" title="Setujui Tugas">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="verifikasiTugas(<?php echo $tugas['id']; ?>, 'rejected')" title="Tolak Tugas">
                                                                <i class="fas fa-times"></i>
                                                            </button>
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
                                                            <i class="fas fa-clipboard-check fa-3x text-gray-300 mb-3"></i>
                                                            <h5 class="text-gray-600">Tidak Ada Tugas Menunggu Verifikasi</h5>
                                                            <p class="text-muted">Semua tugas telah diverifikasi atau belum ada tugas yang disubmit.</p>
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

                        <!-- Tab Verifikasi File -->
                        <div class="tab-pane fade" id="file" role="tabpanel" aria-labelledby="file-tab">
                            <div class="card shadow mb-4 mt-3">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-file-check mr-2"></i>Daftar File Menunggu Verifikasi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTableFile" width="100%" cellspacing="0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th>Nama File</th>
                                                    <th>Deskripsi</th>
                                                    <th class="text-center">Tanggal Submit</th>
                                                    <th class="text-center">Preview</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_file = mysqli_query($koneksi, "SELECT * FROM file_gambar WHERE status_verifikasi = 'pending' ORDER BY tanggal_submit DESC");
                                                $no = 1;
                                                $count_file = mysqli_num_rows($sql_file);

                                                if ($count_file > 0) {
                                                    while ($file = mysqli_fetch_array($sql_file)) {
                                                        // Get file extension for icon
                                                        $file_ext = strtolower(pathinfo($file['gambar'], PATHINFO_EXTENSION));
                                                        $file_icon = 'fas fa-file';
                                                        if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                            $file_icon = 'fas fa-file-image';
                                                        } elseif ($file_ext == 'pdf') {
                                                            $file_icon = 'fas fa-file-pdf';
                                                        } elseif (in_array($file_ext, ['dwg', 'obj', 'stl'])) {
                                                            $file_icon = 'fas fa-cube';
                                                        }
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class="<?php echo $file_icon; ?> text-primary mr-2"></i>
                                                            <span class="font-weight-bold"><?php echo htmlspecialchars($file['gambar']); ?></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-truncate" title="<?php echo htmlspecialchars($file['deskripsi']); ?>">
                                                            <?php echo htmlspecialchars($file['deskripsi']); ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <small class="text-muted">
                                                            <?php echo date('d M Y', strtotime($file['tanggal_submit'])); ?>
                                                            <br>
                                                            <?php echo date('H:i', strtotime($file['tanggal_submit'])); ?>
                                                        </small>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="../file_proyek/<?php echo $file['gambar']; ?>" target="_blank"
                                                           class="btn btn-info btn-sm" title="Lihat File">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge badge-warning px-3 py-2">
                                                            <i class="fas fa-clock mr-1"></i>Menunggu
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-success btn-sm" onclick="verifikasiFile(<?php echo $file['id']; ?>, 'approved')" title="Setujui File">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="verifikasiFile(<?php echo $file['id']; ?>, 'rejected')" title="Tolak File">
                                                                <i class="fas fa-times"></i>
                                                            </button>
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
                                                            <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                                                            <h5 class="text-gray-600">Tidak Ada File Menunggu Verifikasi</h5>
                                                            <p class="text-muted">Semua file telah diverifikasi atau belum ada file yang diupload.</p>
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
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<!-- Modal Verifikasi -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifikasiModalLabel">
                    <i class="fas fa-clipboard-check mr-2"></i>Verifikasi Item
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="verifikasiForm" method="POST" action="proses_verifikasi.php">
                <div class="modal-body">
                    <input type="hidden" id="item_id" name="item_id">
                    <input type="hidden" id="item_type" name="item_type">
                    <input type="hidden" id="status_verifikasi" name="status_verifikasi">

                    <div class="alert alert-info" id="verifikasiInfo">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span id="verifikasiInfoText">Silakan berikan catatan untuk keputusan verifikasi.</span>
                    </div>

                    <div class="form-group">
                        <label for="catatan" class="font-weight-bold">Catatan Verifikasi:</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="4"
                                  placeholder="Berikan catatan untuk keputusan verifikasi..." required></textarea>
                        <small class="form-text text-muted">Catatan ini akan disimpan sebagai alasan verifikasi</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Simpan Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Update badge count and initialize
$(document).ready(function() {
    // Update badge counts
    $('#tugasCount').text('<?php echo $count_tugas; ?>');
    $('#fileCount').text('<?php echo $count_file; ?>');

    // Hide badges if count is 0
    if (<?php echo $count_tugas; ?> === 0) {
        $('#tugasCount').hide();
    }
    if (<?php echo $count_file; ?> === 0) {
        $('#fileCount').hide();
    }
});

function verifikasiTugas(id, status) {
    document.getElementById('item_id').value = id;
    document.getElementById('item_type').value = 'tugas';
    document.getElementById('status_verifikasi').value = status;

    // Update modal content based on status
    const isApproved = status === 'approved';
    const modalTitle = isApproved ?
        '<i class="fas fa-check-circle mr-2 text-success"></i>Setujui Tugas' :
        '<i class="fas fa-times-circle mr-2 text-danger"></i>Tolak Tugas';

    document.getElementById('verifikasiModalLabel').innerHTML = modalTitle;

    // Update info text
    const infoText = isApproved ?
        'Anda akan menyetujui tugas ini. Berikan catatan persetujuan.' :
        'Anda akan menolak tugas ini. Berikan alasan penolakan.';
    document.getElementById('verifikasiInfoText').textContent = infoText;

    // Update alert class
    const alertDiv = document.getElementById('verifikasiInfo');
    alertDiv.className = isApproved ? 'alert alert-success' : 'alert alert-warning';

    // Clear previous input
    document.getElementById('catatan').value = '';

    $('#verifikasiModal').modal('show');
}

function verifikasiFile(id, status) {
    document.getElementById('item_id').value = id;
    document.getElementById('item_type').value = 'file';
    document.getElementById('status_verifikasi').value = status;

    // Update modal content based on status
    const isApproved = status === 'approved';
    const modalTitle = isApproved ?
        '<i class="fas fa-check-circle mr-2 text-success"></i>Setujui File' :
        '<i class="fas fa-times-circle mr-2 text-danger"></i>Tolak File';

    document.getElementById('verifikasiModalLabel').innerHTML = modalTitle;

    // Update info text
    const infoText = isApproved ?
        'Anda akan menyetujui file ini. Berikan catatan persetujuan.' :
        'Anda akan menolak file ini. Berikan alasan penolakan.';
    document.getElementById('verifikasiInfoText').textContent = infoText;

    // Update alert class
    const alertDiv = document.getElementById('verifikasiInfo');
    alertDiv.className = isApproved ? 'alert alert-success' : 'alert alert-warning';

    // Clear previous input
    document.getElementById('catatan').value = '';

    $('#verifikasiModal').modal('show');
}
</script>

<?php include 'includes/footer/footer.php'; ?>