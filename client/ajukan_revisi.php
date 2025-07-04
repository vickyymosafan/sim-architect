<?php
require_once '../includes/session_manager.php';
check_session_auth('client');

$page_title = "Ajukan Revisi";
include 'includes/header/header.php';
require '../koneksi.php';

// Get client ID from session
$client_id = $_SESSION['user_id'] ?? 1; // Default untuk testing

// Check daily quota
$today = date('Y-m-d');
$quota_query = "SELECT jumlah_request FROM revisi_quota WHERE client_id = $client_id AND tanggal = '$today'";
$quota_result = mysqli_query($koneksi, $quota_query);
$current_quota = 0;
if ($quota_result && mysqli_num_rows($quota_result) > 0) {
    $quota_data = mysqli_fetch_array($quota_result);
    $current_quota = $quota_data['jumlah_request'];
}
$remaining_quota = 4 - $current_quota;
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
                        <h1 class="h3 mb-0 text-gray-800">Ajukan Revisi</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="client.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Ajukan Revisi</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Quota Info Alert -->
                    <div class="alert <?php echo ($remaining_quota > 0) ? 'alert-info' : 'alert-warning'; ?> alert-dismissible fade show mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading mb-1">Quota Revisi Harian</h5>
                                <p class="mb-0">
                                    Anda telah menggunakan <strong><?php echo $current_quota; ?></strong> dari <strong>4</strong> quota revisi hari ini.
                                    <?php if ($remaining_quota > 0): ?>
                                        Sisa quota: <strong><?php echo $remaining_quota; ?></strong> revisi.
                                    <?php else: ?>
                                        <strong>Quota hari ini sudah habis.</strong> Silakan coba lagi besok.
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <?php if ($remaining_quota > 0): ?>
                    <!-- Form Ajukan Revisi -->
                    <div class="row">
                        <div class="col-lg-8 col-md-10 mx-auto">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-edit mr-2"></i>Form Ajukan Revisi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form action="proses_revisi.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="item_type" class="font-weight-bold">Jenis Item</label>
                                            <select class="form-control" id="item_type" name="item_type" required onchange="loadItems()">
                                                <option value="">Pilih Jenis Item</option>
                                                <option value="file">File Desain</option>
                                                <option value="tugas">Tugas Proyek</option>
                                            </select>
                                            <small class="form-text text-muted">Pilih jenis item yang ingin direvisi</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="item_id" class="font-weight-bold">Item yang Direvisi</label>
                                            <select class="form-control" id="item_id" name="item_id" required disabled>
                                                <option value="">Pilih jenis item terlebih dahulu</option>
                                            </select>
                                            <small class="form-text text-muted">Pilih item spesifik yang ingin direvisi</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="alasan_revisi" class="font-weight-bold">Alasan Revisi <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="alasan_revisi" name="alasan_revisi" rows="4" 
                                                placeholder="Jelaskan alasan mengapa perlu revisi..." required></textarea>
                                            <small class="form-text text-muted">Berikan alasan yang jelas untuk permintaan revisi</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="detail_perubahan" class="font-weight-bold">Detail Perubahan</label>
                                            <textarea class="form-control" id="detail_perubahan" name="detail_perubahan" rows="4" 
                                                placeholder="Jelaskan detail perubahan yang diinginkan..."></textarea>
                                            <small class="form-text text-muted">Opsional: Berikan detail spesifik perubahan yang diinginkan</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="file_referensi" class="font-weight-bold">File Referensi</label>
                                            <input type="file" class="form-control-file" id="file_referensi" name="file_referensi" 
                                                accept=".jpg,.jpeg,.png,.pdf,.dwg">
                                            <small class="form-text text-muted">
                                                Opsional: Upload file referensi (JPG, PNG, PDF, DWG - Max 5MB)
                                            </small>
                                        </div>

                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                                <i class="fas fa-paper-plane mr-2"></i>Ajukan Revisi
                                            </button>
                                            <a href="client.php" class="btn btn-secondary btn-lg px-5 ml-3">
                                                <i class="fas fa-times mr-2"></i>Batal
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Status Revisi Terbaru -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-history mr-2"></i>Status Revisi Terbaru
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Jenis</th>
                                            <th>Item</th>
                                            <th>Alasan Revisi</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Tanggal Request</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $revisi_query = "SELECT rr.*, 
                                                        CASE 
                                                            WHEN rr.item_type = 'file' THEN fg.gambar
                                                            WHEN rr.item_type = 'tugas' THEN tp.nama_kegiatan
                                                        END as item_name
                                                        FROM revisi_request rr
                                                        LEFT JOIN file_gambar fg ON rr.item_type = 'file' AND rr.item_id = fg.id
                                                        LEFT JOIN tugas_proyek tp ON rr.item_type = 'tugas' AND rr.item_id = tp.id
                                                        WHERE rr.client_id = $client_id
                                                        ORDER BY rr.tanggal_request DESC
                                                        LIMIT 10";
                                        $revisi_result = mysqli_query($koneksi, $revisi_query);
                                        
                                        if ($revisi_result && mysqli_num_rows($revisi_result) > 0) {
                                            $no = 1;
                                            while ($revisi = mysqli_fetch_array($revisi_result)) {
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
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo ($revisi['item_type'] == 'file') ? 'info' : 'primary'; ?>">
                                                    <?php echo ucfirst($revisi['item_type']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($revisi['item_name']); ?></td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;" title="<?php echo htmlspecialchars($revisi['alasan_revisi']); ?>">
                                                    <?php echo htmlspecialchars($revisi['alasan_revisi']); ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <small><?php echo date('d M Y H:i', strtotime($revisi['tanggal_request'])); ?></small>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-info" onclick="viewDetail(<?php echo $revisi['id']; ?>)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-center">
                                                    <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                                    <h5 class="text-gray-600">Belum Ada Revisi yang Diajukan</h5>
                                                    <p class="text-muted">Revisi yang Anda ajukan akan ditampilkan di sini.</p>
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

<script>
function loadItems() {
    const itemType = document.getElementById('item_type').value;
    const itemSelect = document.getElementById('item_id');
    
    if (!itemType) {
        itemSelect.innerHTML = '<option value="">Pilih jenis item terlebih dahulu</option>';
        itemSelect.disabled = true;
        return;
    }
    
    // Show loading
    itemSelect.innerHTML = '<option value="">Loading...</option>';
    itemSelect.disabled = false;
    
    // AJAX request to get items
    fetch(`get_approved_items.php?type=${itemType}`)
        .then(response => response.json())
        .then(data => {
            let options = '<option value="">Pilih item yang ingin direvisi</option>';
            data.forEach(item => {
                const itemName = itemType === 'file' ? item.gambar : item.nama_kegiatan;
                options += `<option value="${item.id}">${itemName}</option>`;
            });
            itemSelect.innerHTML = options;
        })
        .catch(error => {
            console.error('Error:', error);
            itemSelect.innerHTML = '<option value="">Error loading items</option>';
        });
}

function viewDetail(revisiId) {
    // Implement view detail modal
    alert('Detail revisi ID: ' + revisiId + ' (akan diimplementasi)');
}
</script>

<?php include 'includes/footer/footer.php'; ?>
