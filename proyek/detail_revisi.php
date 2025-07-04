<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');
require '../koneksi.php';

$revisi_id = (int)($_GET['id'] ?? 0);

if ($revisi_id <= 0) {
    echo "<script>alert('ID revisi tidak valid!'); window.close();</script>";
    exit;
}

// Get revisi detail
$query = "SELECT rr.*, 
          u.first_name, u.last_name, u.username, u.email,
          CASE 
              WHEN rr.item_type = 'file' THEN fg.gambar
              WHEN rr.item_type = 'tugas' THEN tp.nama_kegiatan
          END as item_name,
          CASE 
              WHEN rr.item_type = 'file' THEN fg.deskripsi
              WHEN rr.item_type = 'tugas' THEN tp.deskripsi
          END as item_description,
          p.nama_petugas as reviewer_name
          FROM revisi_request rr
          LEFT JOIN users u ON rr.client_id = u.id
          LEFT JOIN file_gambar fg ON rr.item_type = 'file' AND rr.item_id = fg.id
          LEFT JOIN tugas_proyek tp ON rr.item_type = 'tugas' AND rr.item_id = tp.id
          LEFT JOIN petugas p ON rr.reviewer_id = p.id_petugas
          WHERE rr.id = $revisi_id";

$result = mysqli_query($koneksi, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<script>alert('Data revisi tidak ditemukan!'); window.close();</script>";
    exit;
}

$revisi = mysqli_fetch_array($result);

// Status styling
$status_class = '';
$status_text = '';
switch ($revisi['status_revisi']) {
    case 'pending':
        $status_class = 'badge-warning';
        $status_text = 'Menunggu Review';
        break;
    case 'approved':
        $status_class = 'badge-success';
        $status_text = 'Disetujui';
        break;
    case 'rejected':
        $status_class = 'badge-danger';
        $status_text = 'Ditolak';
        break;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Revisi #<?php echo $revisi_id; ?> - Antosa Arsitek</title>
    
    <!-- Custom fonts for this template-->
    <link href="../tmp/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Custom styles for this template-->
    <link href="../tmp/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-edit mr-2"></i>Detail Permintaan Revisi #<?php echo $revisi_id; ?>
                        </h6>
                        <span class="badge <?php echo $status_class; ?> badge-pill px-3 py-2">
                            <?php echo $status_text; ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Client Info -->
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-primary mb-3">Informasi Client</h6>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="30%"><strong>Nama:</strong></td>
                                        <td><?php echo htmlspecialchars($revisi['first_name'] . ' ' . $revisi['last_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Username:</strong></td>
                                        <td>@<?php echo htmlspecialchars($revisi['username']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td><?php echo htmlspecialchars($revisi['email']); ?></td>
                                    </tr>
                                </table>
                            </div>
                            
                            <!-- Request Info -->
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-primary mb-3">Informasi Request</h6>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%"><strong>Tanggal Request:</strong></td>
                                        <td><?php echo date('d M Y H:i', strtotime($revisi['tanggal_request'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis Item:</strong></td>
                                        <td>
                                            <span class="badge badge-<?php echo ($revisi['item_type'] == 'file') ? 'info' : 'primary'; ?>">
                                                <?php echo ucfirst($revisi['item_type']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td><span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item Details -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-<?php echo ($revisi['item_type'] == 'file') ? 'file' : 'tasks'; ?> mr-2"></i>
                            Detail Item yang Direvisi
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold"><?php echo htmlspecialchars($revisi['item_name']); ?></h5>
                                <p class="text-muted"><?php echo htmlspecialchars($revisi['item_description']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revisi Details -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-comment-alt mr-2"></i>Detail Permintaan Revisi
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="font-weight-bold">Alasan Revisi:</h6>
                            <div class="bg-light p-3 rounded">
                                <?php echo nl2br(htmlspecialchars($revisi['alasan_revisi'])); ?>
                            </div>
                        </div>
                        
                        <?php if (!empty($revisi['detail_perubahan'])): ?>
                        <div class="mb-4">
                            <h6 class="font-weight-bold">Detail Perubahan:</h6>
                            <div class="bg-light p-3 rounded">
                                <?php echo nl2br(htmlspecialchars($revisi['detail_perubahan'])); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($revisi['file_referensi'])): ?>
                        <div class="mb-4">
                            <h6 class="font-weight-bold">File Referensi:</h6>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file fa-2x text-primary mr-3"></i>
                                <div>
                                    <div class="font-weight-bold"><?php echo htmlspecialchars($revisi['file_referensi']); ?></div>
                                    <a href="../file_revisi/<?php echo $revisi['file_referensi']; ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                        <i class="fas fa-download mr-1"></i>Download
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Review Details (if reviewed) -->
                <?php if ($revisi['status_revisi'] !== 'pending'): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-clipboard-check mr-2"></i>Detail Review
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%"><strong>Reviewer:</strong></td>
                                        <td><?php echo htmlspecialchars($revisi['reviewer_name'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Review:</strong></td>
                                        <td><?php echo $revisi['tanggal_response'] ? date('d M Y H:i', strtotime($revisi['tanggal_response'])) : 'N/A'; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <?php if (!empty($revisi['catatan_reviewer'])): ?>
                        <div class="mt-3">
                            <h6 class="font-weight-bold">Catatan Reviewer:</h6>
                            <div class="bg-light p-3 rounded">
                                <?php echo nl2br(htmlspecialchars($revisi['catatan_reviewer'])); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Actions -->
                <div class="text-center mb-4">
                    <button type="button" class="btn btn-secondary" onclick="window.close()">
                        <i class="fas fa-times mr-2"></i>Tutup
                    </button>
                    <button type="button" class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print mr-2"></i>Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../tmp/vendor/jquery/jquery.min.js"></script>
    <script src="../tmp/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- Core plugin JavaScript-->
    <script src="../tmp/vendor/jquery-easing/jquery.easing.min.js"></script>
    
    <!-- Custom scripts for all pages-->
    <script src="../tmp/js/sb-admin-2.min.js"></script>
</body>
</html>
