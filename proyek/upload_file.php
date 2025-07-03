<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');

$page_title = "Upload File Desain";
include 'includes/header/header.php';
?>

<?php include 'includes/sidebar/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

<?php include 'includes/topbar/topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Upload File Desain</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="proyek.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Manajemen File</a></li>
                                <li class="breadcrumb-item active">Upload File</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Upload Form -->
                    <div class="row">
                        <div class="col-lg-8 col-md-10 mx-auto">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-upload mr-2"></i>Form Upload File Desain
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Info Alert -->
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <strong>Informasi:</strong> File yang diupload akan masuk ke antrian verifikasi sebelum dapat diakses.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="simpan_file.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="deskripsi" class="font-weight-bold">Deskripsi File</label>
                                            <input type="text" name="deskripsi" id="deskripsi" class="form-control"
                                                placeholder="Contoh: Denah Lantai 1 - Revisi Final" required>
                                            <small class="form-text text-muted">Berikan deskripsi yang jelas untuk memudahkan identifikasi file</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="gambar" class="font-weight-bold">Pilih File Desain</label>
                                            <div class="custom-file">
                                                <input type="file" name="gambar" id="gambar" class="custom-file-input" required
                                                       accept=".jpg,.jpeg,.png,.gif,.pdf,.obj,.stl,.dwg">
                                                <label class="custom-file-label" for="gambar">Pilih file...</label>
                                            </div>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-file-alt mr-1"></i>
                                                <strong>Format yang didukung:</strong> JPG, PNG, GIF, PDF, OBJ, STL, DWG
                                                <br>
                                                <i class="fas fa-weight-hanging mr-1"></i>
                                                <strong>Ukuran maksimal:</strong> 10MB per file
                                            </small>
                                        </div>

                                        <div class="form-group mb-4">
                                            <div class="row">
                                                <div class="col-sm-6 mb-2">
                                                    <button type="submit" class="btn btn-primary btn-block">
                                                        <i class="fas fa-cloud-upload-alt mr-2"></i>Upload File
                                                    </button>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <a href="file_approved.php" class="btn btn-outline-secondary btn-block">
                                                        <i class="fas fa-list mr-2"></i>Lihat File Disetujui
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

<?php include 'includes/footer/footer.php'; ?>

<script>
// Bootstrap custom file input
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
});
</script>