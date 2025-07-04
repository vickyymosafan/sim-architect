        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="proyek.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-drafting-compass"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Antosa Arsitek</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'proyek.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="proyek.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manajemen Proyek
            </div>

            <!-- Nav Item - Manajemen Tugas (Collapsible) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTugas"
                    aria-expanded="<?php echo (in_array(basename($_SERVER['PHP_SELF']), ['input_tugas.php', 'tugas_harian.php'])) ? 'true' : 'false'; ?>"
                    aria-controls="collapseTugas">
                    <i class="fas fa-fw fa-folder-open"></i>
                    <span>Manajemen Tugas</span>
                </a>
                <div id="collapseTugas" class="collapse <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['input_tugas.php', 'tugas_harian.php'])) ? 'show' : ''; ?>"
                     aria-labelledby="headingTugas" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Kelola Tugas:</h6>
                        <a class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'input_tugas.php') ? 'active bg-primary text-white' : ''; ?>"
                           href="input_tugas.php">
                            <i class="fas fa-plus-circle mr-2"></i> Input Tugas Harian
                        </a>
                        <a class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'tugas_harian.php') ? 'active bg-primary text-white' : ''; ?>"
                           href="tugas_harian.php">
                            <i class="fas fa-tasks mr-2"></i> Daftar Tugas Harian
                        </a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Manajemen File (Collapsible) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFile"
                    aria-expanded="<?php echo (in_array(basename($_SERVER['PHP_SELF']), ['upload_file.php', 'file_approved.php'])) ? 'true' : 'false'; ?>"
                    aria-controls="collapseFile">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Manajemen File</span>
                </a>
                <div id="collapseFile" class="collapse <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['upload_file.php', 'file_approved.php'])) ? 'show' : ''; ?>"
                     aria-labelledby="headingFile" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Kelola File:</h6>
                        <a class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'upload_file.php') ? 'active bg-primary text-white' : ''; ?>"
                           href="upload_file.php">
                            <i class="fas fa-upload mr-2"></i> Upload File Desain
                        </a>
                        <a class="dropdown-item <?php echo (basename($_SERVER['PHP_SELF']) == 'file_approved.php') ? 'active bg-primary text-white' : ''; ?>"
                           href="file_approved.php">
                            <i class="fas fa-check-circle mr-2"></i> File Disetujui
                        </a>
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Verifikasi & Approval -->
            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'verifikasi.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="verifikasi.php">
                    <i class="fas fa-fw fa-clipboard-check"></i>
                    <span>Verifikasi & Approval</span>
                </a>
            </li>

            <!-- Nav Item - Review Revisi -->
            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'review_revisi.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="review_revisi.php">
                    <i class="fas fa-fw fa-edit"></i>
                    <span>Review Revisi</span>
                </a>
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
