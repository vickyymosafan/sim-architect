<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');

$page_title = "Tugas Harian";
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
                        <h1 class="h3 mb-0 text-gray-800">Daftar Tugas Harian</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="proyek.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Manajemen Tugas</a></li>
                                <li class="breadcrumb-item active">Daftar Tugas</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Info Alert -->
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Informasi:</strong> Halaman ini menampilkan tugas yang sudah melalui proses verifikasi dan disetujui.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Tugas Harian Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-tasks mr-2"></i>Tugas yang Disetujui
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center" style="width: 5%;">No</th>
                                            <th style="width: 25%;">Nama Tugas</th>
                                            <th style="width: 35%;">Deskripsi</th>
                                            <th class="text-center" style="width: 15%;">Tanggal</th>
                                            <th class="text-center" style="width: 15%;">Status</th>
                                            <th class="text-center" style="width: 5%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                            <?php
                            require '../koneksi.php';
                            // Hanya tampilkan tugas yang sudah disetujui (approved)
                            $sql = mysqli_query($koneksi, "SELECT * FROM tugas_proyek WHERE status_verifikasi = 'approved' ORDER BY tgl DESC");

                            if (mysqli_num_rows($sql) > 0) {
                                $no = 1;
                                while ($data = mysqli_fetch_array($sql)) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no++; ?></td>
                                    <td class="font-weight-bold"><?php echo htmlspecialchars($data['nama_kegiatan']); ?></td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 300px;" title="<?php echo htmlspecialchars($data['deskripsi']); ?>">
                                            <?php echo htmlspecialchars($data['deskripsi']); ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">
                                            <?php echo date('d M Y', strtotime($data['tgl'])); ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $status = $data['status'];
                                        $badgeClass = 'secondary';
                                        $statusText = 'Belum Diatur';

                                        if ($status == 'proses') {
                                            $badgeClass = 'warning';
                                            $statusText = 'Dalam Proses';
                                        } else if ($status == 'selesai') {
                                            $badgeClass = 'success';
                                            $statusText = 'Selesai';
                                        } else if ($status == 'batal') {
                                            $badgeClass = 'danger';
                                            $statusText = 'Dibatalkan';
                                        }
                                        ?>
                                        <span class="badge badge-<?php echo $badgeClass; ?> px-3 py-2">
                                            <?php echo $statusText; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-toggle="modal" data-target="#updateStatusModal<?php echo $data['id']; ?>"
                                                title="Ubah Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>

                                        <!-- Modal Update Status -->
                                        <div class="modal fade" id="updateStatusModal<?php echo $data['id']; ?>"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="statusModalLabel<?php echo $data['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <form action="update_tugas.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Status</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <select name="status" class="form-control" required>
                                                                <option value="proses" <?php if ($status == 'proses')
                                                                    echo 'selected'; ?>>Proses</option>
                                                                <option value="selesai" <?php if ($status == 'selesai')
                                                                    echo 'selected'; ?>>Selesai</option>
                                                                <option value="batal" <?php if ($status == 'batal')
                                                                    echo 'selected'; ?>>Batal</option>
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>




                                </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-center">
                                            <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                            <h5 class="text-gray-600">Belum Ada Tugas yang Disetujui</h5>
                                            <p class="text-muted">Silakan tunggu proses verifikasi atau <a href="input_tugas.php">tambah tugas baru</a>.</p>
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