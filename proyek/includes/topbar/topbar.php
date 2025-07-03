                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Page Title & Breadcrumb -->
                    <div class="d-flex align-items-center flex-grow-1 min-width-0">
                        <div class="mr-auto min-width-0 flex-shrink-1">
                            <!-- Page Title - Responsive sizing -->
                            <h1 class="h4 h-md-3 mb-0 text-gray-800 text-truncate">
                                <?php echo isset($page_title) ? $page_title : 'Dashboard Proyek'; ?>
                            </h1>

                            <!-- Breadcrumb - Hidden on small screens -->
                            <nav aria-label="breadcrumb" class="mt-1 d-none d-sm-block">
                                <ol class="breadcrumb mb-0 bg-transparent p-0 small">
                                <li class="breadcrumb-item">
                                    <a href="proyek.php" class="text-decoration-none">
                                        <i class="fas fa-home"></i>
                                        <span class="d-none d-md-inline">Dashboard</span>
                                    </a>
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
                                            echo '<li class="breadcrumb-item active text-truncate">' . $crumb . '</li>';
                                        } else {
                                            echo '<li class="breadcrumb-item text-truncate">' . $crumb . '</li>';
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
                            <a class="nav-link dropdown-toggle position-relative d-flex align-items-center justify-content-center"
                               href="#" id="alertsDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                               style="width: 3rem; height: 3rem; padding: 0;">
                                <i class="fas fa-bell fa-fw" style="font-size: 1.1rem;"></i>
                                <!-- Counter - Alerts -->
                                <?php
                                require_once '../koneksi.php';
                                $pending_counts = getPendingCounts();
                                if ($pending_counts['total'] > 0) {
                                    echo '<span class="badge badge-danger position-absolute" style="top: 4px; right: 4px; font-size: 0.6rem; min-width: 1rem; height: 1rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; line-height: 1; z-index: 10;">' . $pending_counts['total'] . '</span>';
                                }
                                ?>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown"
                                style="min-width: 18rem; max-width: 90vw; border: none; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);">
                                <h6 class="dropdown-header bg-primary text-white px-3 py-2">
                                    <i class="fas fa-bell mr-2"></i>
                                    <span class="d-none d-sm-inline">Notifikasi Verifikasi</span>
                                    <span class="d-inline d-sm-none">Notifikasi</span>
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
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle d-flex align-items-center justify-content-center"
                               href="#" id="userDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                               style="height: 3rem; padding: 0.5rem;">
                                <!-- User name - responsive visibility -->
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small text-truncate" style="max-width: 120px;">
                                    <?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User'; ?>
                                </span>
                                <!-- Profile image with consistent sizing -->
                                <img class="img-profile rounded-circle"
                                     src="../tmp/img/undraw_profile.svg"
                                     style="width: 2rem; height: 2rem; object-fit: cover;">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="userDropdown"
                                 style="min-width: 12rem; max-width: 90vw;">
                                <!-- User info header for mobile -->
                                <div class="dropdown-header d-lg-none px-3 py-2 bg-light">
                                    <div class="text-center">
                                        <img class="img-profile rounded-circle mb-2"
                                             src="../tmp/img/undraw_profile.svg"
                                             style="width: 3rem; height: 3rem; object-fit: cover;">
                                        <div class="small font-weight-bold text-gray-800">
                                            <?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User'; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider d-lg-none"></div>

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
