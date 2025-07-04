        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin Antosa</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'admin.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
          

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manajemen User
            </div>

            <!-- Nav Item - Manajemen User (Collapsible) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
                    aria-expanded="<?php echo (in_array(basename($_SERVER['PHP_SELF']), ['kelola_user_proyek.php', 'kelola_client.php'])) ? 'true' : 'false'; ?>"
                    aria-controls="collapseUser">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Manajemen User</span>
                </a>
                <div id="collapseUser" class="collapse <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['kelola_user_proyek.php', 'kelola_client.php'])) ? 'show' : ''; ?>"
                     aria-labelledby="headingUser" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Kelola User:</h6>
                        <a class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'kelola_user_proyek.php') ? 'active bg-primary text-white' : ''; ?>"
                           href="kelola_user_proyek.php">
                            <i class="fas fa-users mr-2"></i> User Proyek
                        </a>
                        <a class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'kelola_client.php') ? 'active bg-primary text-white' : ''; ?>"
                           href="kelola_client.php">
                            <i class="fas fa-user-tie mr-2"></i> Client
                        </a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manajemen Proyek
            </div>

            <!-- Nav Item - Verifikasi & Approval (Collapsible) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVerifikasi"
                    aria-expanded="<?php echo (in_array(basename($_SERVER['PHP_SELF']), ['kelola_tugas_proyek.php', 'kelola_file_gambar.php'])) ? 'true' : 'false'; ?>"
                    aria-controls="collapseVerifikasi">
                    <i class="fas fa-fw fa-clipboard-check"></i>
                    <span>Verifikasi & Approval</span>
                </a>
                <div id="collapseVerifikasi" class="collapse <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['kelola_tugas_proyek.php', 'kelola_file_gambar.php'])) ? 'show' : ''; ?>"
                     aria-labelledby="headingVerifikasi" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Verifikasi:</h6>
                        <a class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'kelola_tugas_proyek.php') ? 'active bg-primary text-white' : ''; ?>"
                           href="kelola_tugas_proyek.php">
                            <i class="fas fa-tasks mr-2"></i> Tugas Proyek
                        </a>
                        <a class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'kelola_file_gambar.php') ? 'active bg-primary text-white' : ''; ?>"
                           href="kelola_file_gambar.php">
                            <i class="fas fa-images mr-2"></i> File Gambar
                        </a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Manajemen RAB & Revisi (Collapsible) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRAB"
                    aria-expanded="<?php echo (in_array(basename($_SERVER['PHP_SELF']), ['kelola_rab_proyek.php', 'kelola_revisi_request.php'])) ? 'true' : 'false'; ?>"
                    aria-controls="collapseRAB">
                    <i class="fas fa-fw fa-folder-open"></i>
                    <span>RAB & Revisi</span>
                </a>
                <div id="collapseRAB" class="collapse <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['kelola_rab_proyek.php', 'kelola_revisi_request.php'])) ? 'show' : ''; ?>"
                     aria-labelledby="headingRAB" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Kelola:</h6>
                        <a class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'kelola_rab_proyek.php') ? 'active bg-primary text-white' : ''; ?>"
                           href="kelola_rab_proyek.php">
                            <i class="fas fa-file-invoice-dollar mr-2"></i> RAB Proyek
                        </a>
                        <a class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'kelola_revisi_request.php') ? 'active bg-primary text-white' : ''; ?>"
                           href="kelola_revisi_request.php">
                            <i class="fas fa-edit mr-2"></i> Revisi Request
                        </a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Heading -->
            <div class="sidebar-heading">
                Sistem
            </div>

            <!-- Nav Item - Logout -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
