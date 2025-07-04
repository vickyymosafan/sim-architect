<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');

$page_title = "Upload RAB";
include 'includes/header/header.php';
require '../koneksi.php';

// Get list of clients
$clients_query = "SELECT id, first_name, last_name, username FROM users WHERE role = 'client' ORDER BY first_name";
$clients_result = mysqli_query($koneksi, $clients_query);
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
                        <h1 class="h3 mb-0 text-gray-800">Upload RAB</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="proyek.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="kelola_rab.php">Kelola RAB</a></li>
                                <li class="breadcrumb-item active">Upload RAB</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Info Alert -->
                    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading mb-1">Upload File RAB</h5>
                                <p class="mb-0">
                                    Upload file RAB dalam format PDF, Excel, atau Word. File akan masuk status draft dan perlu diverifikasi sebelum client dapat melihatnya.
                                </p>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Upload Form -->
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-upload mr-2"></i>Form Upload RAB
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form action="proses_upload_rab.php" method="post" enctype="multipart/form-data" id="uploadForm">
                                        <div class="form-group">
                                            <label for="client_id" class="font-weight-bold">Client <span class="text-danger">*</span></label>
                                            <select class="form-control" id="client_id" name="client_id" required>
                                                <option value="">Pilih Client</option>
                                                <?php while ($client = mysqli_fetch_array($clients_result)): ?>
                                                <option value="<?php echo $client['id']; ?>">
                                                    <?php echo htmlspecialchars($client['first_name'] . ' ' . $client['last_name']); ?> 
                                                    (@<?php echo htmlspecialchars($client['username']); ?>)
                                                </option>
                                                <?php endwhile; ?>
                                            </select>
                                            <small class="form-text text-muted">Pilih client yang akan menerima RAB ini</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="nama_proyek" class="font-weight-bold">Nama Proyek <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" 
                                                placeholder="Contoh: Rumah Minimalis 2 Lantai" required>
                                            <small class="form-text text-muted">Nama proyek yang akan ditampilkan pada RAB</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="deskripsi" class="font-weight-bold">Deskripsi Proyek</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" 
                                                placeholder="Deskripsi detail tentang proyek dan RAB ini..."></textarea>
                                            <small class="form-text text-muted">Deskripsi opsional untuk memberikan informasi tambahan</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="file_rab" class="font-weight-bold">File RAB <span class="text-danger">*</span></label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="file_rab" name="file_rab" 
                                                    accept=".pdf,.xlsx,.xls,.docx,.doc" required onchange="validateFile()">
                                                <label class="custom-file-label" for="file_rab">Pilih file RAB...</label>
                                            </div>
                                            <small class="form-text text-muted">
                                                Format yang didukung: PDF, Excel (.xlsx, .xls), Word (.docx, .doc) - Maksimal 10MB
                                            </small>
                                            <div id="fileInfo" class="mt-2" style="display: none;">
                                                <div class="alert alert-success">
                                                    <i class="fas fa-file mr-2"></i>
                                                    <span id="fileName"></span>
                                                    <span id="fileSize" class="ml-2 text-muted"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                                <i class="fas fa-upload mr-2"></i>Upload RAB
                                            </button>
                                            <a href="kelola_rab.php" class="btn btn-secondary btn-lg px-5 ml-3">
                                                <i class="fas fa-times mr-2"></i>Batal
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File Format Info -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-question-circle mr-2"></i>Informasi Format File
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="text-center mb-3">
                                                <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                                <h6 class="font-weight-bold">PDF</h6>
                                                <p class="text-muted small">Format terbaik untuk RAB final yang siap dibaca client</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center mb-3">
                                                <i class="fas fa-file-excel fa-3x text-success mb-2"></i>
                                                <h6 class="font-weight-bold">Excel</h6>
                                                <p class="text-muted small">Untuk RAB dengan perhitungan detail dan formula</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center mb-3">
                                                <i class="fas fa-file-word fa-3x text-primary mb-2"></i>
                                                <h6 class="font-weight-bold">Word</h6>
                                                <p class="text-muted small">Untuk RAB dalam format dokumen dengan penjelasan</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        <strong>Catatan:</strong> Pastikan file RAB sudah final dan siap untuk ditinjau. 
                                        File yang diupload akan masuk status draft dan perlu diverifikasi sebelum client dapat mengaksesnya.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<script>
function validateFile() {
    const fileInput = document.getElementById('file_rab');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const label = document.querySelector('.custom-file-label');
    
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        // Update label
        label.textContent = file.name;
        
        // Validate file size
        if (file.size > maxSize) {
            alert('Ukuran file terlalu besar! Maksimal 10MB');
            fileInput.value = '';
            label.textContent = 'Pilih file RAB...';
            fileInfo.style.display = 'none';
            return false;
        }
        
        // Validate file type
        const allowedTypes = [
            'application/pdf',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/msword'
        ];
        
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung! Gunakan PDF, Excel, atau Word');
            fileInput.value = '';
            label.textContent = 'Pilih file RAB...';
            fileInfo.style.display = 'none';
            return false;
        }
        
        // Show file info
        fileName.textContent = file.name;
        fileSize.textContent = `(${formatFileSize(file.size)})`;
        fileInfo.style.display = 'block';
        
        return true;
    } else {
        fileInfo.style.display = 'none';
        label.textContent = 'Pilih file RAB...';
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Form validation
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('file_rab');
    
    if (fileInput.files.length === 0) {
        e.preventDefault();
        alert('Harap pilih file RAB yang akan diupload!');
        return false;
    }
    
    if (!validateFile()) {
        e.preventDefault();
        return false;
    }
    
    // Confirm upload
    if (!confirm('Apakah Anda yakin ingin mengupload file RAB ini?')) {
        e.preventDefault();
        return false;
    }
    
    // Show loading
    const submitBtn = e.target.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengupload...';
    submitBtn.disabled = true;
});

// Initialize file input label
document.addEventListener('DOMContentLoaded', function() {
    // Add Bootstrap file input behavior
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
});
</script>

<?php include 'includes/footer/footer.php'; ?>
