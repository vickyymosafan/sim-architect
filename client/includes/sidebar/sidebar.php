        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="client.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Client Portal</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'client.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="client.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>         
            </li>
          
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Proyek
            </div>

            <!-- Nav Item - Progress Proyek -->
            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'progress_proyek.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="progress_proyek.php">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Progress Proyek</span></a>
            </li>

            <!-- Nav Item - File Desain -->
            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'file_desain.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="file_desain.php">
                    <i class="fas fa-fw fa-file-image"></i>
                    <span>File Desain</span></a>
            </li>

            <!-- Nav Item - Ajukan Revisi -->
            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'ajukan_revisi.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="ajukan_revisi.php">
                    <i class="fas fa-fw fa-edit"></i>
                    <span>Ajukan Revisi</span></a>
            </li>

            <!-- Nav Item - Lihat RAB -->
            <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'lihat_rab.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="lihat_rab.php">
                    <i class="fas fa-fw fa-calculator"></i>
                    <span>Lihat RAB</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Nav Item - Logout -->
            <li class="nav-item">
                <a class="nav-link" href="../logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span></a>
            </li>
            
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
