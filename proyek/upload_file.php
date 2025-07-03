<?php
$page_title = "Upload File Desain";
include 'includes/header/header.php';
?>

<?php include 'includes/sidebar/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

<?php include 'includes/topbar/topbar.php'; ?>

                <div class="container-fluid mt-4">
                    <h1 class="h3 mb-4 text-gray-800">Upload File Desain</h1>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="simpan_file.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi File</label>
                                    <input type="text" name="deskripsi" class="form-control"
                                        placeholder="Masukkan deskripsi..." required>
                                </div>

                                <div class="form-group">
                                    <label for="file">Pilih File Desain</label>
                                    <input type="file" name="gambar" class="form-control-file" required>
                                    <small class="form-text text-muted">File yang diperbolehkan: .jpg, .png, .pdf, .obj,
                                        .stl, .dwg</small>
                                </div>

                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->

<?php include 'includes/footer/footer.php'; ?>