            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container-fluid py-2 px-3">
                    <div class="row align-items-center">
                        <div class="col-12 col-sm-6 col-md-6">
                            <div class="copyright text-center text-sm-left">
                                <span>&copy; <?php echo date('Y'); ?> <strong>Antosa Arsitek</strong>. Sistem Manajemen Proyek</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6">
                            <div class="text-center text-sm-right">
                                <small class="text-muted">
                                    <span class="d-block d-sm-inline">
                                        <i class="fas fa-user"></i> <?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User'; ?>
                                    </span>
                                    <span class="d-none d-lg-inline"> | </span>
                                    <span class="d-block d-lg-inline">
                                        <i class="fas fa-clock"></i> <?php echo date('d M Y, H:i'); ?>
                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-sign-out-alt"></i> Konfirmasi Keluar
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-question-circle fa-3x text-warning mb-3"></i>
                        <p>Apakah Anda yakin ingin keluar dari sistem?</p>
                        <small class="text-muted">Sesi Anda akan berakhir dan Anda perlu login kembali.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <a class="btn btn-danger" href="../logout.php">
                        <i class="fas fa-sign-out-alt"></i> Ya, Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="../tmp/vendor/jquery/jquery.min.js"></script>
    <script src="../tmp/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript -->
    <script src="../tmp/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages -->
    <script src="../tmp/js/sb-admin-2.min.js"></script>

    <!-- Enhanced Footer Responsive Styles -->
    <style>
        /* Enhanced responsive footer styles */
        .sticky-footer {
            border-top: 1px solid #e3e6f0;
            min-height: auto !important;
            height: auto !important;
            padding: 0 !important;
        }

        .sticky-footer .container-fluid {
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
        }

        @media (max-width: 575.98px) {
            .sticky-footer .container-fluid {
                padding-top: 0.5rem !important;
                padding-bottom: 0.5rem !important;
            }

            .sticky-footer .copyright {
                margin-bottom: 0.25rem;
                font-size: 0.8rem;
            }

            .sticky-footer .text-muted {
                font-size: 0.7rem !important;
                line-height: 1.2;
            }

            .sticky-footer .row {
                margin: 0;
            }

            .sticky-footer .col-12 {
                padding: 0.1rem 0;
            }
        }

        @media (min-width: 576px) and (max-width: 767.98px) {
            .sticky-footer .text-muted {
                font-size: 0.75rem;
            }

            .sticky-footer .copyright {
                font-size: 0.85rem;
            }
        }

        @media (min-width: 768px) {
            .sticky-footer .text-muted {
                font-size: 0.8rem;
            }

            .sticky-footer .copyright {
                font-size: 0.9rem;
            }
        }

        /* Ensure footer content doesn't overflow */
        .sticky-footer .text-muted span {
            white-space: nowrap;
        }

        @media (max-width: 575.98px) {
            .sticky-footer .text-muted span {
                white-space: normal;
                word-break: break-word;
            }

            .sticky-footer .copyright span {
                display: block !important;
                text-align: center;
            }

            .sticky-footer .text-center.text-sm-right {
                text-align: center !important;
            }
        }
    </style>

    <!-- Enhanced Responsive Topbar and Footer Script -->
    <script>
        $(document).ready(function() {
            // Enhanced responsive footer handling
            function adjustFooterResponsiveness() {
                var $footer = $('.sticky-footer');
                var windowWidth = $(window).width();

                // Ensure footer stays compact
                $footer.css({
                    'min-height': 'auto',
                    'height': 'auto'
                });

                // Adjust footer padding and spacing based on screen size
                if (windowWidth <= 575) {
                    // Extra small devices - more compact
                    $footer.find('.container-fluid').css({
                        'padding-top': '0.5rem',
                        'padding-bottom': '0.5rem'
                    });
                } else if (windowWidth <= 767) {
                    // Small devices
                    $footer.find('.container-fluid').css({
                        'padding-top': '0.6rem',
                        'padding-bottom': '0.6rem'
                    });
                } else {
                    // Medium and larger devices
                    $footer.find('.container-fluid').css({
                        'padding-top': '0.75rem',
                        'padding-bottom': '0.75rem'
                    });
                }
            }

            // Enhanced responsive dropdown positioning
            function adjustDropdownPosition() {
                $('.dropdown-menu').each(function() {
                    var $dropdown = $(this);
                    var $toggle = $dropdown.prev('.dropdown-toggle');

                    // Reset positioning
                    $dropdown.removeClass('dropdown-menu-left').addClass('dropdown-menu-right');

                    // Check if dropdown goes off screen on mobile
                    if ($(window).width() <= 575) {
                        var toggleOffset = $toggle.offset();
                        var dropdownWidth = $dropdown.outerWidth();
                        var windowWidth = $(window).width();

                        // If dropdown would go off right edge, adjust
                        if (toggleOffset.left + dropdownWidth > windowWidth - 20) {
                            $dropdown.removeClass('dropdown-menu-right').addClass('dropdown-menu-left');
                        }
                    }
                });
            }

            // Adjust on dropdown show
            $('.dropdown').on('show.bs.dropdown', function() {
                setTimeout(adjustDropdownPosition, 10);
            });

            // Adjust on window resize
            $(window).on('resize', function() {
                if ($('.dropdown-menu.show').length > 0) {
                    adjustDropdownPosition();
                }
            });

            // Enhanced mobile touch handling for dropdowns
            if ('ontouchstart' in window) {
                $('.dropdown-toggle').on('touchstart', function(e) {
                    e.stopPropagation();
                });
            }

            // Auto-hide dropdowns when clicking outside on mobile
            $(document).on('touchstart click', function(e) {
                if ($(window).width() <= 767) {
                    if (!$(e.target).closest('.dropdown').length) {
                        $('.dropdown-menu.show').dropdown('hide');
                    }
                }
            });

            // Improve notification badge visibility
            function updateNotificationBadge() {
                $('.badge.position-absolute').each(function() {
                    var $badge = $(this);
                    var count = parseInt($badge.text());

                    if (count > 99) {
                        $badge.text('99+');
                    }

                    // Ensure badge is visible
                    if (count > 0) {
                        $badge.show();
                    } else {
                        $badge.hide();
                    }
                });
            }

            updateNotificationBadge();

            // Responsive breadcrumb handling
            function handleBreadcrumbOverflow() {
                var $breadcrumb = $('.breadcrumb');
                if ($breadcrumb.length && $(window).width() <= 576) {
                    $breadcrumb.find('.breadcrumb-item:not(:last-child):not(:first-child)').addClass('d-none');
                } else {
                    $breadcrumb.find('.breadcrumb-item').removeClass('d-none');
                }
            }

            handleBreadcrumbOverflow();
            $(window).on('resize', handleBreadcrumbOverflow);

            // Initialize footer responsiveness
            adjustFooterResponsiveness();

            // Handle window resize for footer
            $(window).on('resize', function() {
                adjustFooterResponsiveness();
                if ($('.dropdown-menu.show').length > 0) {
                    adjustDropdownPosition();
                }
            });
        });
    </script>

    <!-- Optional: Chart plugin -->
    <script src="../tmp/vendor/chart.js/Chart.min.js"></script>
    <script src="../tmp/js/demo/chart-area-demo.js"></script>
    <script src="../tmp/js/demo/chart-pie-demo.js"></script>

</body>
</html>
