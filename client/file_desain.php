<?php
require_once '../includes/session_manager.php';
require '../koneksi.php';

// Validasi session client
check_session_auth('client');

$page_title = "File Desain";
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
                                <li class="breadcrumb-item"><a href="client.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">File Desain</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Info Alert -->
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>Informasi:</strong> Halaman ini menampilkan file desain yang sudah melalui proses verifikasi dan disetujui untuk proyek Anda.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- File Statistics -->
                    <div class="row mb-4">
                        <?php
                        $total_files = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM file_gambar WHERE status_verifikasi = 'approved'"));
                        $recent_files = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM file_gambar WHERE status_verifikasi = 'approved' AND DATE(tanggal_verifikasi) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)"));
                        ?>
                        
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total File Disetujui</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_files; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-image fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                File Baru (7 Hari Terakhir)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $recent_files; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File Gallery -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-images mr-2"></i>Galeri File Desain
                            </h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Tampilan:</div>
                                    <a class="dropdown-item" href="#" onclick="toggleView('grid')">
                                        <i class="fas fa-th mr-2"></i>Grid View
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="toggleView('list')">
                                        <i class="fas fa-list mr-2"></i>List View
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            $sql = mysqli_query($koneksi, "
                                SELECT fg.*, p.nama_petugas
                                FROM file_gambar fg
                                LEFT JOIN petugas p ON fg.verifikator_id = p.id_petugas
                                WHERE fg.status_verifikasi = 'approved'
                                ORDER BY fg.tanggal_verifikasi DESC
                            ");

                            if (mysqli_num_rows($sql) > 0):
                            ?>
                                <!-- Grid View -->
                                <div id="gridView" class="file-grid">
                                    <div class="row">
                                        <?php
                                        mysqli_data_seek($sql, 0);
                                        while ($data = mysqli_fetch_array($sql)):
                                            $file_ext = strtolower(pathinfo($data['gambar'], PATHINFO_EXTENSION));
                                            $file_icon = 'fas fa-file';
                                            $is_image = false;
                                            
                                            if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                $file_icon = 'fas fa-file-image';
                                                $is_image = true;
                                            } elseif ($file_ext == 'pdf') {
                                                $file_icon = 'fas fa-file-pdf';
                                            } elseif (in_array($file_ext, ['dwg', 'obj', 'stl'])) {
                                                $file_icon = 'fas fa-cube';
                                            }
                                        ?>
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                                <div class="card file-card h-100">
                                                    <div class="card-body text-center">
                                                        <?php if ($is_image): ?>
                                                            <div class="file-preview mb-3">
                                                                <img src="../file_proyek/<?php echo $data['gambar']; ?>" 
                                                                     class="img-fluid rounded" 
                                                                     style="max-height: 150px; object-fit: cover;"
                                                                     alt="<?php echo htmlspecialchars($data['deskripsi']); ?>">
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="file-icon mb-3">
                                                                <i class="<?php echo $file_icon; ?> fa-4x text-primary"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <h6 class="card-title font-weight-bold">
                                                            <?php echo htmlspecialchars($data['gambar']); ?>
                                                        </h6>
                                                        <p class="card-text text-muted small">
                                                            <?php echo htmlspecialchars(substr($data['deskripsi'], 0, 80)); ?>
                                                            <?php echo strlen($data['deskripsi']) > 80 ? '...' : ''; ?>
                                                        </p>
                                                        
                                                        <div class="file-meta mb-3">
                                                            <small class="text-success d-block">
                                                                <i class="fas fa-check-circle mr-1"></i>
                                                                Disetujui: <?php echo date('d M Y', strtotime($data['tanggal_verifikasi'])); ?>
                                                            </small>
                                                            <small class="text-muted">
                                                                Oleh: <?php echo htmlspecialchars($data['nama_petugas'] ?? 'Admin'); ?>
                                                            </small>
                                                        </div>
                                                        
                                                        <div class="btn-group w-100" role="group">
                                                            <a href="../file_proyek/<?php echo $data['gambar']; ?>" target="_blank"
                                                               class="btn btn-outline-primary btn-sm">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                            <a href="../file_proyek/<?php echo $data['gambar']; ?>" download
                                                               class="btn btn-outline-success btn-sm">
                                                                <i class="fas fa-download"></i> Download
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>

                                <!-- List View -->
                                <div id="listView" class="file-list" style="display: none;">
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
                                                mysqli_data_seek($sql, 0);
                                                $no = 1;
                                                while ($data = mysqli_fetch_array($sql)):
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
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                                    <h5 class="text-gray-600">Belum Ada File yang Disetujui</h5>
                                    <p class="text-muted">File desain yang disetujui akan ditampilkan di sini.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<style>
.file-card {
    transition: all 0.3s ease;
    border: 1px solid #e3e6f0;
}

.file-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.file-preview img {
    transition: transform 0.3s ease;
}

.file-card:hover .file-preview img {
    transform: scale(1.05);
}

.file-icon {
    opacity: 0.8;
}

.file-card:hover .file-icon {
    opacity: 1;
}

.file-meta {
    border-top: 1px solid #e3e6f0;
    padding-top: 10px;
}

@media (max-width: 768px) {
    .file-grid .col-xl-3,
    .file-grid .col-lg-4,
    .file-grid .col-md-6 {
        margin-bottom: 20px;
    }
}
</style>

<script>
function toggleView(viewType) {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    
    if (viewType === 'grid') {
        gridView.style.display = 'block';
        listView.style.display = 'none';
    } else {
        gridView.style.display = 'none';
        listView.style.display = 'block';
    }
}
</script>

<?php include 'includes/footer/footer.php'; ?>
