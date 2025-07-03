                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Page Title & Breadcrumb -->
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="mr-auto">
                            <h1 class="h3 mb-0 text-gray-800">
                                <?php echo isset($page_title) ? $page_title : 'Dashboard Proyek'; ?>
                            </h1>

                            <!-- Breadcrumb -->
                            <nav aria-label="breadcrumb" class="mt-1">
                                <ol class="breadcrumb mb-0 bg-transparent p-0 small">
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
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle position-relative"
                               href="#" id="alertsDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <?php
                                require_once '../koneksi.php';
                                $pending_counts = getPendingCounts();
                                if ($pending_counts['total'] > 0) {
                                    echo '<span class="badge badge-danger position-absolute" style="top: 8px; right: 8px; font-size: 0.7rem; min-width: 1.2rem; height: 1.2rem; border-radius: 50%; display: flex; align-items: center; justify-content: center;">' . $pending_counts['total'] . '</span>';
                                }
                                ?>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown" style="min-width: 20rem; max-width: 20rem; border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);">
                                <h6 class="dropdown-header bg-primary text-white">
                                    <i class="fas fa-bell mr-2"></i>Notifikasi Verifikasi
                                </h6>
                                <?php
                                // Generate notification items using functions
                                echo generateNotificationItem($pending_counts['tugas'], 'tugas', 'fas fa-tasks', 'bg-warning');
                                echo generateNotificationItem($pending_counts['file'], 'file', 'fas fa-file', 'bg-info');
                                ?>

                                <?php if ($pending_counts['total'] == 0): ?>
                                <div class="dropdown-item text-center py-4">
                                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                    <div class="small text-gray-500">Tidak ada notifikasi baru</div>
                                </div>
                                <?php endif; ?>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-center py-3 bg-light" href="verifikasi.php">
                                    <i class="fas fa-eye mr-2"></i>
                                    <span class="font-weight-bold">Lihat Semua Verifikasi</span>
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
