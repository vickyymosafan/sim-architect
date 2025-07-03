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

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
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
    </div>
    <?php
}
?>