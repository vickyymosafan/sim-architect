            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="copyright text-left my-auto">
                                <span>&copy; <?php echo date('Y'); ?> <strong>Antosa Arsitek</strong>. Sistem Manajemen Proyek</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right my-auto">
                                <small class="text-muted">
                                    Versi 2.0 |
                                    <i class="fas fa-user"></i> <?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User'; ?> |
                                    <i class="fas fa-clock"></i> <?php echo date('d M Y, H:i'); ?>
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

    <!-- Optional: Chart plugin -->
    <script src="../tmp/vendor/chart.js/Chart.min.js"></script>
    <script src="../tmp/js/demo/chart-area-demo.js"></script>
    <script src="../tmp/js/demo/chart-pie-demo.js"></script>

</body>
</html>
