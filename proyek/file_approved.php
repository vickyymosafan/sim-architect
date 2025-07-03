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

                <div class="container mt-5">
                    <h2 class="mb-4">Daftar File Desain yang Disetujui</h2>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        Halaman ini menampilkan file desain yang sudah melalui proses verifikasi dan disetujui.
                    </div>
                    
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama File</th>
                                            <th>Deskripsi</th>
                                            <th>Tanggal Upload</th>
                                            <th>Tanggal Disetujui</th>
                                            <th>Disetujui Oleh</th>
                                            <th>File</th>
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
                                        ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($data['gambar']); ?></td>
                                            <td><?php echo htmlspecialchars($data['deskripsi']); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($data['tanggal_submit'])); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($data['tanggal_verifikasi'])); ?></td>
                                            <td><?php echo htmlspecialchars($data['nama_petugas'] ?? 'N/A'); ?></td>
                                            <td>
                                                <a href="../file_proyek/<?php echo $data['gambar']; ?>" target="_blank" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                                <a href="../file_proyek/<?php echo $data['gambar']; ?>" target="_blank" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Preview
                                                </a>
                                            </td>
                                        </tr>
                                        <?php 
                                            }
                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="alert alert-info">
                                                    Belum ada file desain yang disetujui. Silakan tunggu proses verifikasi.
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
            <!-- End of Main Content -->

<?php include 'includes/footer/footer.php'; ?>
