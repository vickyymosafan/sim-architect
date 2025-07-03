                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Page Title & Breadcrumb -->
                    <div class="d-flex align-items-center">
                        <h1 class="h3 mb-0 text-gray-800 mr-3">
                            <?php echo isset($page_title) ? $page_title : 'Dashboard Proyek'; ?>
                        </h1>

                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item">
                                    <a href="proyek.php"><i class="fas fa-home"></i> Dashboard</a>
                                </li>
                                <?php
                                $current_page = basename($_SERVER['PHP_SELF'], '.php');
                                $breadcrumb_map = [
                                    'input_tugas' => ['Manajemen Tugas', 'Input Tugas'],
                                    'tugas_harian' => ['Manajemen Tugas', 'Daftar Tugas'],
                                    'upload_file' => ['Manajemen File', 'Upload File'],
                                    'file_approved' => ['Manajemen File', 'File Disetujui'],
                                    'verifikasi' => ['Verifikasi & Approval']
                                ];

                                if (isset($breadcrumb_map[$current_page])) {
                                    foreach ($breadcrumb_map[$current_page] as $index => $crumb) {
                                        $is_last = ($index == count($breadcrumb_map[$current_page]) - 1);
                                        if ($is_last) {
                                            echo '<li class="breadcrumb-item active">' . $crumb . '</li>';
                                        } else {
                                            echo '<li class="breadcrumb-item">' . $crumb . '</li>';
                                        }
                                    }
                                }
                                ?>
                            </ol>
                        </nav>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <?php
                                require_once '../koneksi.php';
                                $count_tugas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tugas_proyek WHERE status_verifikasi = 'pending'"));
                                $count_file = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM file_gambar WHERE status_verifikasi = 'pending'"));
                                $total_pending = $count_tugas + $count_file;
                                if ($total_pending > 0) {
                                    echo '<span class="badge badge-danger badge-counter">' . $total_pending . '</span>';
                                }
                                ?>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifikasi Verifikasi
                                </h6>
                                <?php if ($count_tugas > 0): ?>
                                <a class="dropdown-item d-flex align-items-center" href="verifikasi.php">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-tasks text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"><?php echo date('d M Y'); ?></div>
                                        <span class="font-weight-bold"><?php echo $count_tugas; ?> tugas menunggu verifikasi</span>
                                    </div>
                                </a>
                                <?php endif; ?>

                                <?php if ($count_file > 0): ?>
                                <a class="dropdown-item d-flex align-items-center" href="verifikasi.php">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-info">
                                            <i class="fas fa-file text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"><?php echo date('d M Y'); ?></div>
                                        <span class="font-weight-bold"><?php echo $count_file; ?> file menunggu verifikasi</span>
                                    </div>
                                </a>
                                <?php endif; ?>

                                <?php if ($total_pending == 0): ?>
                                <div class="dropdown-item text-center small text-gray-500">
                                    Tidak ada notifikasi baru
                                </div>
                                <?php endif; ?>

                                <a class="dropdown-item text-center small text-gray-500" href="verifikasi.php">
                                    Lihat Semua Verifikasi
                                </a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User'; ?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="../tmp/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Pengaturan
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
