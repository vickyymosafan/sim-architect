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

                <div class="container-fluid mt-4">

                    <!-- Judul Halaman -->
                    <h1 class="h3 mb-4 text-gray-800">Verifikasi Tugas & File Desain</h1>

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="verifikasiTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tugas-tab" data-toggle="tab" href="#tugas" role="tab">
                                Verifikasi Tugas <span class="badge badge-warning ml-1" id="tugasCount">0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="file-tab" data-toggle="tab" href="#file" role="tab">
                                Verifikasi File <span class="badge badge-warning ml-1" id="fileCount">0</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="verifikasiTabContent">
                        <!-- Tab Verifikasi Tugas -->
                        <div class="tab-pane fade show active" id="tugas" role="tabpanel">
                            <div class="card shadow mb-4 mt-3">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Tugas Menunggu Verifikasi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Kegiatan</th>
                                                    <th>Deskripsi</th>
                                                    <th>Tanggal</th>
                                                    <th>Tanggal Submit</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
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
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($tugas['nama_kegiatan']); ?></td>
                                                    <td><?php echo htmlspecialchars($tugas['deskripsi']); ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($tugas['tgl'])); ?></td>
                                                    <td><?php echo date('d/m/Y H:i', strtotime($tugas['tanggal_submit'])); ?></td>
                                                    <td><span class="badge badge-warning">Menunggu</span></td>
                                                    <td>
                                                        <button class="btn btn-success btn-sm" onclick="verifikasiTugas(<?php echo $tugas['id']; ?>, 'approved')">
                                                            <i class="fas fa-check"></i> Setujui
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" onclick="verifikasiTugas(<?php echo $tugas['id']; ?>, 'rejected')">
                                                            <i class="fas fa-times"></i> Tolak
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                                    }
                                                } else {
                                                ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">Tidak ada tugas yang menunggu verifikasi</td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Verifikasi File -->
                        <div class="tab-pane fade" id="file" role="tabpanel">
                            <div class="card shadow mb-4 mt-3">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar File Menunggu Verifikasi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama File</th>
                                                    <th>Deskripsi</th>
                                                    <th>Tanggal Submit</th>
                                                    <th>Preview</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_file = mysqli_query($koneksi, "SELECT * FROM file_gambar WHERE status_verifikasi = 'pending' ORDER BY tanggal_submit DESC");
                                                $no = 1;
                                                $count_file = mysqli_num_rows($sql_file);

                                                if ($count_file > 0) {
                                                    while ($file = mysqli_fetch_array($sql_file)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($file['gambar']); ?></td>
                                                    <td><?php echo htmlspecialchars($file['deskripsi']); ?></td>
                                                    <td><?php echo date('d/m/Y H:i', strtotime($file['tanggal_submit'])); ?></td>
                                                    <td>
                                                        <a href="../file_proyek/<?php echo $file['gambar']; ?>" target="_blank" class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td><span class="badge badge-warning">Menunggu</span></td>
                                                    <td>
                                                        <button class="btn btn-success btn-sm" onclick="verifikasiFile(<?php echo $file['id']; ?>, 'approved')">
                                                            <i class="fas fa-check"></i> Setujui
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" onclick="verifikasiFile(<?php echo $file['id']; ?>, 'rejected')">
                                                            <i class="fas fa-times"></i> Tolak
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                                    }
                                                } else {
                                                ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">Tidak ada file yang menunggu verifikasi</td>
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
            </div>
            <!-- End of Main Content -->

<!-- Modal Verifikasi -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Item</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="verifikasiForm" method="POST" action="proses_verifikasi.php">
                <div class="modal-body">
                    <input type="hidden" id="item_id" name="item_id">
                    <input type="hidden" id="item_type" name="item_type">
                    <input type="hidden" id="status_verifikasi" name="status_verifikasi">

                    <div class="form-group">
                        <label for="catatan">Catatan Verifikasi:</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                  placeholder="Berikan catatan untuk keputusan verifikasi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Update badge count
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('tugasCount').textContent = '<?php echo $count_tugas; ?>';
    document.getElementById('fileCount').textContent = '<?php echo $count_file; ?>';
});

function verifikasiTugas(id, status) {
    document.getElementById('item_id').value = id;
    document.getElementById('item_type').value = 'tugas';
    document.getElementById('status_verifikasi').value = status;

    const modalTitle = status === 'approved' ? 'Setujui Tugas' : 'Tolak Tugas';
    document.getElementById('verifikasiModalLabel').textContent = modalTitle;

    $('#verifikasiModal').modal('show');
}

function verifikasiFile(id, status) {
    document.getElementById('item_id').value = id;
    document.getElementById('item_type').value = 'file';
    document.getElementById('status_verifikasi').value = status;

    const modalTitle = status === 'approved' ? 'Setujui File' : 'Tolak File';
    document.getElementById('verifikasiModalLabel').textContent = modalTitle;

    $('#verifikasiModal').modal('show');
}
</script>

<?php include 'includes/footer/footer.php'; ?>