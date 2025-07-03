<?php
$page_title = "Tugas Harian";
include 'includes/header/header.php';
?>

<?php include 'includes/sidebar/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

<?php include 'includes/topbar/topbar.php'; ?>
                <div class="container mt-5">
                    <h2 class="mb-4">Lihat List Tugas Harian Proyek Arsitek</h2>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Tugas</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            require '../koneksi.php';
                            $sql = mysqli_query($koneksi, "select * from tugas_proyek");
                            while ($data = mysqli_fetch_array($sql)) {

                                ?>
                                <tr>
                                    <td><?php echo $data['id']; ?></td>
                                    <td><?php echo $data['nama_kegiatan']; ?></td>
                                    <td><?php echo $data['deskripsi']; ?></td>
                                    <td><?php echo $data['tgl']; ?></td>
                                    <td>
                                        <?php
                                        $status = $data['status'];
                                        $badgeClass = 'secondary';
                                        if ($status == 'proses')
                                            $badgeClass = 'warning';
                                        else if ($status == 'selesai')
                                            $badgeClass = 'success';
                                        else if ($status == 'batal')
                                            $badgeClass = 'danger';
                                        ?>

                                        <!-- Status Button with Modal Trigger -->
                                        <button type="button" class="btn btn-sm btn-<?php echo $badgeClass; ?>"
                                            data-toggle="modal" data-target="#updateStatusModal<?php echo $data['id']; ?>">
                                            <?php echo ucfirst($status); ?>
                                        </button>

                                        <!-- Modal Update Status -->
                                        <div class="modal fade" id="updateStatusModal<?php echo $data['id']; ?>"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="statusModalLabel<?php echo $data['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <form action="update_tugas.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ubah Status</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <select name="status" class="form-control" required>
                                                                <option value="proses" <?php if ($status == 'proses')
                                                                    echo 'selected'; ?>>Proses</option>
                                                                <option value="selesai" <?php if ($status == 'selesai')
                                                                    echo 'selected'; ?>>Selesai</option>
                                                                <option value="batal" <?php if ($status == 'batal')
                                                                    echo 'selected'; ?>>Batal</option>
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>




                                </tr>
                            </tbody> <?php } ?>
                    </table>
                </div>

            </div>
            <!-- End of Main Content -->

<?php include 'includes/footer/footer.php'; ?>