<?php
$page_title = "Verifikasi";
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
                    <h1 class="h3 mb-4 text-gray-800">Verifikasi Desain -----BELUM SELESAI SISTEMNYA------</h1>

                    <!-- Tabel Verifikasi -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama File</th>
                                            <th>Deskripsi</th>
                                            <th>Preview</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Contoh Data 1 -->
                                        <tr>
                                            <td>1</td>
                                            <td>desain_poster1.pdf</td>
                                            <td>Poster promosi bulan ini</td>
                                            <td><a href="../uploads/desain_poster1.pdf" target="_blank"
                                                    class="btn btn-info btn-sm">Lihat</a></td>
                                            <td><span class="badge badge-warning">Menunggu</span></td>
                                            <td>
                                                <button class="btn btn-success btn-sm">Terima</button>
                                                <button class="btn btn-danger btn-sm">Tolak</button>
                                            </td>
                                        </tr>

                                        <!-- Contoh Data 2 -->
                                        <tr>
                                            <td>2</td>
                                            <td>logo_ukm.png</td>
                                            <td>Logo baru untuk UKM</td>
                                            <td><a href="../uploads/logo_ukm.png" target="_blank"
                                                    class="btn btn-info btn-sm">Lihat</a></td>
                                            <td><span class="badge badge-warning">Menunggu</span></td>
                                            <td>
                                                <button class="btn btn-success btn-sm">Terima</button>
                                                <button class="btn btn-danger btn-sm">Tolak</button>
                                            </td>
                                        </tr>

                                        <!-- Tambahkan baris lainnya sesuai kebutuhan -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End of Main Content -->

<?php include 'includes/footer/footer.php'; ?>