<?php
/**
 * Topbar Component - SB Admin 2 Template
 *
 * Note: Session management is handled by the parent file that includes this component.
 * This component assumes session is already started and validated.
 *
 * Required variables:
 * - $page_title (optional): Page title to display
 * - $_SESSION['nama']: User name from session (should be validated by parent)
 */
?>
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Page Title -->
                    <div class="d-flex align-items-center flex-grow-1">
                        <h1 class="h3 mb-0 text-gray-800 mr-auto">
                            <?php echo isset($page_title) ? $page_title : 'Dashboard Admin'; ?>
                        </h1>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php
                                    // Safety check for session data
                                    echo isset($_SESSION['nama']) && !empty($_SESSION['nama']) ? $_SESSION['nama'] : 'User';
                                    ?>
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
