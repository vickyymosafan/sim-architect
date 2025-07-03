<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');

$page_title = "File Desain Disetujui";
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
                        <h1 class="h3 mb-0 text-gray-800">File Desain Disetujui</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="proyek.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Manajemen File</a></li>
                                <li class="breadcrumb-item active">File Disetujui</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Info Alert -->
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Informasi:</strong> Halaman ini menampilkan file desain yang sudah melalui proses verifikasi dan disetujui.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- File Approved Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-check-circle mr-2"></i>Daftar File yang Disetujui
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama File</th>
                                            <th>Deskripsi</th>
                                            <th class="text-center">Tanggal Upload</th>
                                            <th class="text-center">Tanggal Disetujui</th>
                                            <th class="text-center">Disetujui Oleh</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require '../koneksi.php';
                                        // Join dengan tabel petugas untuk mendapatkan nama verifikator
                                        $sql = mysqli_query($koneksi, "
                                            SELECT fg.*, p.nama_petugas
                                            FROM file_gambar fg
                                            LEFT JOIN petugas p ON fg.verifikator_id = p.id_petugas
                                            WHERE fg.status_verifikasi = 'approved'
                                            ORDER BY fg.tanggal_verifikasi DESC
                                        ");

                                        if (mysqli_num_rows($sql) > 0) {
                                            $no = 1;
                                            while ($data = mysqli_fetch_array($sql)) {
                                                // Get file extension for icon
                                                $file_ext = strtolower(pathinfo($data['gambar'], PATHINFO_EXTENSION));
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
                                                    <span class="font-weight-bold"><?php echo htmlspecialchars($data['gambar']); ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-truncate" title="<?php echo htmlspecialchars($data['deskripsi']); ?>">
                                                    <?php echo htmlspecialchars($data['deskripsi']); ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <small class="text-muted">
                                                    <?php echo date('d M Y', strtotime($data['tanggal_submit'])); ?>
                                                    <br>
                                                    <?php echo date('H:i', strtotime($data['tanggal_submit'])); ?>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <small class="text-success">
                                                    <?php echo date('d M Y', strtotime($data['tanggal_verifikasi'])); ?>
                                                    <br>
                                                    <?php echo date('H:i', strtotime($data['tanggal_verifikasi'])); ?>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-success px-2 py-1">
                                                    <?php echo htmlspecialchars($data['nama_petugas'] ?? 'Admin'); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="../file_proyek/<?php echo $data['gambar']; ?>" target="_blank"
                                                       class="btn btn-sm btn-outline-primary" title="Lihat File">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="../file_proyek/<?php echo $data['gambar']; ?>" download
                                                       class="btn btn-sm btn-outline-success" title="Download File">
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
                                                    <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                                                    <h5 class="text-gray-600">Belum Ada File yang Disetujui</h5>
                                                    <p class="text-muted">Silakan tunggu proses verifikasi atau <a href="upload_file.php">upload file baru</a>.</p>
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
