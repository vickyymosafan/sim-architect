<?php
// Session is already started in header component
require '../koneksi.php';

// Session validation is already handled in admin.php
// No need to check again since this file is included through admin routing

// Handle form submission
if ($_POST) {
    $action = $_POST['action'];
    
    if ($action == 'tambah') {
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama_petugas']);
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);
        
        // Cek username sudah ada atau belum
        $cek_username = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$username'");
        if (mysqli_num_rows($cek_username) > 0) {
            echo "<script>alert('Username sudah digunakan!'); window.location='admin.php?url=kelola_user_proyek';</script>";
            exit;
        }
        
        $sql = "INSERT INTO petugas (nama_petugas, username, password, level) VALUES ('$nama', '$username', '$password', 'proyek')";
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('User proyek berhasil ditambahkan!'); window.location='admin.php?url=kelola_user_proyek';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan user proyek!'); window.location='admin.php?url=kelola_user_proyek';</script>";
        }
    }
    
    if ($action == 'edit') {
        $id = $_POST['id_petugas'];
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama_petugas']);
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);
        
        // Cek username sudah ada atau belum (kecuali untuk user yang sedang diedit)
        $cek_username = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$username' AND id_petugas != '$id'");
        if (mysqli_num_rows($cek_username) > 0) {
            echo "<script>alert('Username sudah digunakan!'); window.location='admin.php?url=kelola_user_proyek';</script>";
            exit;
        }
        
        $sql = "UPDATE petugas SET nama_petugas='$nama', username='$username', password='$password' WHERE id_petugas='$id'";
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('User proyek berhasil diupdate!'); window.location='admin.php?url=kelola_user_proyek';</script>";
        } else {
            echo "<script>alert('Gagal mengupdate user proyek!'); window.location='admin.php?url=kelola_user_proyek';</script>";
        }
    }
    
    if ($action == 'hapus') {
        $id = $_POST['id_petugas'];
        $sql = "DELETE FROM petugas WHERE id_petugas='$id'";
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('User proyek berhasil dihapus!'); window.location='admin.php?url=kelola_user_proyek';</script>";
        } else {
            echo "<script>alert('Gagal menghapus user proyek!'); window.location='admin.php?url=kelola_user_proyek';</script>";
        }
    }
}

// Get data for edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_query = mysqli_query($koneksi, "SELECT * FROM petugas WHERE id_petugas='$edit_id' AND level='proyek'");
    $edit_data = mysqli_fetch_array($edit_query);
}
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola User Proyek</h1>
    </div>

    <!-- Form Tambah/Edit User Proyek -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <?php echo $edit_data ? 'Edit User Proyek' : 'Tambah User Proyek'; ?>
            </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <input type="hidden" name="action" value="<?php echo $edit_data ? 'edit' : 'tambah'; ?>">
                <?php if ($edit_data): ?>
                    <input type="hidden" name="id_petugas" value="<?php echo $edit_data['id_petugas']; ?>">
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_petugas">Nama Petugas</label>
                            <input type="text" class="form-control" id="nama_petugas" name="nama_petugas" 
                                   value="<?php echo $edit_data ? $edit_data['nama_petugas'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?php echo $edit_data ? $edit_data['username'] : ''; ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   value="<?php echo $edit_data ? $edit_data['password'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="level">Level</label>
                            <input type="text" class="form-control" value="Proyek" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <?php echo $edit_data ? 'Update User' : 'Tambah User'; ?>
                    </button>
                    <?php if ($edit_data): ?>
                        <a href="admin.php?url=kelola_user_proyek" class="btn btn-secondary">Batal</a>
                    <?php else: ?>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar User Proyek -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar User Proyek</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Petugas</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM petugas WHERE level='proyek' ORDER BY nama_petugas ASC");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['nama_petugas']; ?></td>
                            <td><?php echo $data['username']; ?></td>
                            <td><?php echo str_repeat('*', strlen($data['password'])); ?></td>
                            <td><span class="badge badge-success"><?php echo ucfirst($data['level']); ?></span></td>
                            <td>
                                <a href="admin.php?url=kelola_user_proyek&edit=<?php echo $data['id_petugas']; ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button onclick="hapusUser(<?php echo $data['id_petugas']; ?>, '<?php echo $data['nama_petugas']; ?>')" 
                                        class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Form Hidden untuk Hapus -->
<form id="formHapus" method="POST" style="display: none;">
    <input type="hidden" name="action" value="hapus">
    <input type="hidden" name="id_petugas" id="hapusId">
</form>

<script>
function hapusUser(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus user "' + nama + '"?')) {
        document.getElementById('hapusId').value = id;
        document.getElementById('formHapus').submit();
    }
}
</script>
