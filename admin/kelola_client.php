<?php
require_once '../includes/session_manager.php';
require '../koneksi.php';

// Validasi session admin
check_session_auth('admin');

// Set page title
$page_title = "Kelola Client";

// Handle form submission
if ($_POST) {
    $action = $_POST['action'];

    if ($action == 'tambah') {
        $first_name = mysqli_real_escape_string($koneksi, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($koneksi, $_POST['last_name']);
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);

        // Cek username sudah ada atau belum di tabel users
        $cek_username = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($cek_username) > 0) {
            echo "<script>alert('Username sudah digunakan!'); window.location='kelola_client.php';</script>";
            exit;
        }

        // Hash password untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (first_name, last_name, username, password, role) VALUES ('$first_name', '$last_name', '$username', '$hashed_password', 'client')";
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('Client berhasil ditambahkan!'); window.location='kelola_client.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan client!'); window.location='kelola_client.php';</script>";
        }
    }

    if ($action == 'edit') {
        $id = $_POST['id'];
        $first_name = mysqli_real_escape_string($koneksi, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($koneksi, $_POST['last_name']);
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);

        // Cek username sudah ada atau belum (kecuali untuk user yang sedang diedit)
        $cek_username = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND id != '$id'");
        if (mysqli_num_rows($cek_username) > 0) {
            echo "<script>alert('Username sudah digunakan!'); window.location='kelola_client.php';</script>";
            exit;
        }

        // Update dengan atau tanpa password baru
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', username='$username', password='$hashed_password' WHERE id='$id'";
        } else {
            $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', username='$username' WHERE id='$id'";
        }

        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('Client berhasil diupdate!'); window.location='kelola_client.php';</script>";
        } else {
            echo "<script>alert('Gagal mengupdate client!'); window.location='kelola_client.php';</script>";
        }
    }

    if ($action == 'hapus') {
        $id = $_POST['id'];
        $sql = "DELETE FROM users WHERE id='$id' AND role='client'";
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('Client berhasil dihapus!'); window.location='kelola_client.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus client!'); window.location='kelola_client.php';</script>";
        }
    }
}

// Get data for edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_query = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$edit_id' AND role='client'");
    $edit_data = mysqli_fetch_array($edit_query);
}

// Include header
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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Client</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Kelola Client</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Form Tambah/Edit Client -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user-plus mr-2"></i>
                                <?php echo $edit_data ? 'Edit Client' : 'Tambah Client'; ?>
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <input type="hidden" name="action" value="<?php echo $edit_data ? 'edit' : 'tambah'; ?>">
                                <?php if ($edit_data): ?>
                                    <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">Nama Depan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['first_name']) : ''; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Nama Belakang <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['last_name']) : ''; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                   value="<?php echo $edit_data ? htmlspecialchars($edit_data['username']) : ''; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">
                                                Password 
                                                <?php echo $edit_data ? '<small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small>' : '<span class="text-danger">*</span>'; ?>
                                            </label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                   <?php echo !$edit_data ? 'required' : ''; ?>>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <input type="text" class="form-control" value="Client" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-2"></i>
                                        <?php echo $edit_data ? 'Update Client' : 'Tambah Client'; ?>
                                    </button>
                                    <?php if ($edit_data): ?>
                                        <a href="kelola_client.php" class="btn btn-secondary">
                                            <i class="fas fa-times mr-2"></i>Batal
                                        </a>
                                    <?php else: ?>
                                        <button type="reset" class="btn btn-secondary">
                                            <i class="fas fa-undo mr-2"></i>Reset
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabel Daftar Client -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-users mr-2"></i>Daftar Client
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama Lengkap</th>
                                            <th>Username</th>
                                            <th class="text-center">Tanggal Dibuat</th>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $query = mysqli_query($koneksi, "SELECT * FROM users WHERE role='client' ORDER BY first_name ASC");
                                        while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3">
                                                        <div class="icon-circle bg-info">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold">
                                                            <?php echo htmlspecialchars($data['first_name'] . ' ' . $data['last_name']); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary px-2 py-1">
                                                    <?php echo htmlspecialchars($data['username']); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <small class="text-muted">
                                                    <?php echo date('d M Y', strtotime($data['created_at'])); ?>
                                                    <br>
                                                    <?php echo date('H:i', strtotime($data['created_at'])); ?>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-info px-2 py-1">
                                                    <?php echo ucfirst($data['role']); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="kelola_client.php?edit=<?php echo $data['id']; ?>"
                                                       class="btn btn-warning btn-sm" title="Edit Client">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button onclick="hapusClient(<?php echo $data['id']; ?>, '<?php echo htmlspecialchars($data['first_name'] . ' ' . $data['last_name']); ?>')"
                                                            class="btn btn-danger btn-sm" title="Hapus Client">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<!-- Form Hidden untuk Hapus -->
<form id="formHapus" method="POST" style="display: none;">
    <input type="hidden" name="action" value="hapus">
    <input type="hidden" name="id" id="hapusId">
</form>

<script>
function hapusClient(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus client "' + nama + '"?\n\nPerhatian: Tindakan ini tidak dapat dibatalkan!')) {
        document.getElementById('hapusId').value = id;
        document.getElementById('formHapus').submit();
    }
}
</script>

<?php include 'includes/footer/footer.php'; ?>
