<?php
/**
 * Halaman Admin - Dashboard Content
 *
 * Note: Session validation is handled by admin.php that includes this file.
 * This file assumes session is already validated and $_SESSION data is available.
 */

if (isset($_GET['url']))
{
    $url=$_GET['url'];

    switch($url)
    {
        // Kelola User Proyek sekarang sudah menjadi file standalone
        // case 'kelola_user_proyek':
        // include 'kelola_user_proyek.php';
        // break;

        // case 'tulis_pengaduan';
        // include 'tulis_pengaduan.php';
        // break;

        default:
            // Redirect ke dashboard jika URL tidak dikenali
            echo "<script>window.location='admin.php';</script>";
            break;
    }
}
else
{
    ?>
    <!-- Dashboard Content -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Selamat Datang
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                // Safety check for session data
                                echo isset($_SESSION['nama']) && !empty($_SESSION['nama']) ? $_SESSION['nama'] : 'Admin';
                                ?> - Admin Antosa Arsitek
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Dashboard -->
    <div class="row mb-4">
        <?php
        require '../koneksi.php';

        $stats = [
            ['label' => 'Total Client', 'query' => "SELECT COUNT(*) as count FROM users WHERE role='client'", 'color' => 'primary', 'icon' => 'user-tie'],
            ['label' => 'Tugas Pending', 'query' => "SELECT COUNT(*) as count FROM tugas_proyek WHERE status_verifikasi='pending'", 'color' => 'warning', 'icon' => 'clock'],
            ['label' => 'File Approved', 'query' => "SELECT COUNT(*) as count FROM file_gambar WHERE status_verifikasi='approved'", 'color' => 'success', 'icon' => 'check'],
            ['label' => 'RAB Draft', 'query' => "SELECT COUNT(*) as count FROM rab_proyek WHERE status='draft'", 'color' => 'info', 'icon' => 'file-invoice-dollar']
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

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Kelola User Proyek
                            </div>
                            <div class="text-gray-600">
                                Tambah, edit, atau hapus user proyek
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="kelola_user_proyek.php" class="btn btn-info btn-sm">
                                <i class="fas fa-users"></i> Kelola
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Kelola Client
                            </div>
                            <div class="text-gray-600">
                                Tambah, edit, atau hapus client
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="kelola_client.php" class="btn btn-success btn-sm">
                                <i class="fas fa-user-tie"></i> Kelola
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Verifikasi Tugas
                            </div>
                            <div class="text-gray-600">
                                Verifikasi tugas proyek yang pending
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="kelola_tugas_proyek.php" class="btn btn-warning btn-sm">
                                <i class="fas fa-tasks"></i> Verifikasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row 2 -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Kelola File Gambar
                            </div>
                            <div class="text-gray-600">
                                Verifikasi file gambar/desain
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="kelola_file_gambar.php" class="btn btn-primary btn-sm">
                                <i class="fas fa-images"></i> Kelola
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Kelola RAB Proyek
                            </div>
                            <div class="text-gray-600">
                                Approve/reject RAB proyek
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="kelola_rab_proyek.php" class="btn btn-secondary btn-sm">
                                <i class="fas fa-file-invoice-dollar"></i> Kelola
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Revisi Request
                            </div>
                            <div class="text-gray-600">
                                Response permintaan revisi client
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="kelola_revisi_request.php" class="btn btn-danger btn-sm">
                                <i class="fas fa-edit"></i> Response
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>