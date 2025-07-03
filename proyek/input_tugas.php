<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');

$page_title = "Input Tugas Harian";
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
                        <h1 class="h3 mb-0 text-gray-800">Input Progres Tugas</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="proyek.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Manajemen Tugas</a></li>
                                <li class="breadcrumb-item active">Input Tugas</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Form Input Tugas -->
                    <div class="row">
                        <div class="col-lg-8 col-md-10 mx-auto">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-plus-circle mr-2"></i>Form Input Tugas Harian
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form action="simpan_input.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="nama_kegiatan" class="font-weight-bold">Nama Kegiatan</label>
                                            <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan"
                                                placeholder="Contoh: Pengecoran Lantai 2" required>
                                            <small class="form-text text-muted">Masukkan nama kegiatan yang akan dikerjakan</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="deskripsi" class="font-weight-bold">Deskripsi Pekerjaan</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"
                                                placeholder="Deskripsikan progres pekerjaan di lapangan secara detail..." required></textarea>
                                            <small class="form-text text-muted">Jelaskan detail pekerjaan yang akan atau telah dilakukan</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="tgl" class="font-weight-bold">Tanggal Pengerjaan</label>
                                            <input type="date" class="form-control" id="tgl" name="tgl" required>
                                            <small class="form-text text-muted">Pilih tanggal pelaksanaan tugas</small>
                                        </div>

                                        <div class="form-group mb-4">
                                            <div class="row">
                                                <div class="col-sm-6 mb-2">
                                                    <button type="submit" class="btn btn-primary btn-block">
                                                        <i class="fas fa-save mr-2"></i>Simpan Tugas
                                                    </button>
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <button type="reset" class="btn btn-warning btn-block">
                                                        <i class="fas fa-undo mr-2"></i>Reset Form
                                                    </button>
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