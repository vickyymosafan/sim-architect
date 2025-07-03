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

                <div class="container-fluid mt-4">

                    <!-- Judul Halaman -->
                    <h1 class="h3 mb-4 text-gray-800">Input proges</h1>

                    <!-- Nama Kegiatan -->
                    <form action="simpan_input.php" method="post" class="form-horizontal"
                        enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama_kegiatan">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan"
                            placeholder="Contoh: Pengecoran Lantai 2" required>
                    </div>

                    <!-- Deskripsi Kegiatan -->
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Pekerjaan</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                            placeholder="Deskripsikan progres pekerjaan di lapangan" required></textarea>
                    </div>

                    <!-- Tanggal -->
                    <div class="form-group">
                        <label for="tanggal">Tanggal Pengerjaan</label>
                        <input type="date" class="form-control" id="tgl" name="tgl" required>
                    </div>

                    <!-- Status Progres -->
                    <!-- <div class="form-group">
                        <label for="status">Status Progres</label>
                        <select class="form-control" id="status" name="status">
                            <option value="proses">proses</option>
                            <option value="selesai">selesai</option>
                            <option value="batal">batal</option>
                        </select>
                    </div> -->
                       <div class="form-group cols-sm-6">
                    <input type="submit" value="Simpan" class="btn btn-primary">
                    <input type="reset" value="Kosongkan" class="btn btn-warning">
                </div>
</form>
                </div>
            </div>
            <!-- End of Main Content -->

<?php include 'includes/footer/footer.php'; ?>