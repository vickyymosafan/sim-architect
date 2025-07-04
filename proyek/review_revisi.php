<?php
require_once '../includes/session_manager.php';
check_session_auth('proyek');

$page_title = "Review Revisi";
include 'includes/header/header.php';
require '../koneksi.php';
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
                        <h1 class="h3 mb-0 text-gray-800">Review Permintaan Revisi</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="proyek.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Review Revisi</li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <?php
                        // Get statistics
                        $stats_query = "SELECT 
                                        COUNT(*) as total_revisi,
                                        SUM(CASE WHEN status_revisi = 'pending' THEN 1 ELSE 0 END) as pending_revisi,
                                        SUM(CASE WHEN status_revisi = 'approved' THEN 1 ELSE 0 END) as approved_revisi,
                                        SUM(CASE WHEN status_revisi = 'rejected' THEN 1 ELSE 0 END) as rejected_revisi
                                        FROM revisi_request";
                        $stats_result = mysqli_query($koneksi, $stats_query);
                        $stats = mysqli_fetch_array($stats_result);
                        ?>
                        
                        <!-- Total Revisi -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Revisi</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['total_revisi']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-edit fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Revisi -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Menunggu Review</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['pending_revisi']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Approved Revisi -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Disetujui</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['approved_revisi']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rejected Revisi -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Ditolak</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['rejected_revisi']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <ul class="nav nav-tabs card-header-tabs" id="revisiTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab">
                                        <i class="fas fa-clock mr-1"></i>Menunggu Review (<?php echo $stats['pending_revisi']; ?>)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="approved-tab" data-toggle="tab" href="#approved" role="tab">
                                        <i class="fas fa-check-circle mr-1"></i>Disetujui (<?php echo $stats['approved_revisi']; ?>)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="rejected-tab" data-toggle="tab" href="#rejected" role="tab">
                                        <i class="fas fa-times-circle mr-1"></i>Ditolak (<?php echo $stats['rejected_revisi']; ?>)
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="revisiTabsContent">
                                <!-- Pending Tab -->
                                <div class="tab-pane fade show active" id="pending" role="tabpanel">
                                    <?php include 'includes/revisi_table.php'; echo renderRevisiTable('pending', $koneksi); ?>
                                </div>
                                
                                <!-- Approved Tab -->
                                <div class="tab-pane fade" id="approved" role="tabpanel">
                                    <?php echo renderRevisiTable('approved', $koneksi); ?>
                                </div>
                                
                                <!-- Rejected Tab -->
                                <div class="tab-pane fade" id="rejected" role="tabpanel">
                                    <?php echo renderRevisiTable('rejected', $koneksi); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Review Permintaan Revisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="proses_review_revisi.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="revisi_id" name="revisi_id">
                    <input type="hidden" id="review_status" name="review_status">
                    
                    <div id="reviewInfo" class="alert">
                        <p id="reviewInfoText"></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="catatan_reviewer" class="font-weight-bold">Catatan Review</label>
                        <textarea class="form-control" id="catatan_reviewer" name="catatan_reviewer" rows="4" 
                            placeholder="Berikan catatan untuk client..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="reviewSubmitBtn">Simpan Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function reviewRevisi(id, status) {
    document.getElementById('revisi_id').value = id;
    document.getElementById('review_status').value = status;

    // Update modal content based on status
    const isApproved = status === 'approved';
    const modalTitle = isApproved ?
        '<i class="fas fa-check-circle mr-2 text-success"></i>Setujui Permintaan Revisi' :
        '<i class="fas fa-times-circle mr-2 text-danger"></i>Tolak Permintaan Revisi';

    document.getElementById('reviewModalLabel').innerHTML = modalTitle;

    // Update info text
    const infoText = isApproved ?
        'Anda akan menyetujui permintaan revisi ini. Berikan catatan persetujuan.' :
        'Anda akan menolak permintaan revisi ini. Berikan alasan penolakan.';
    document.getElementById('reviewInfoText').textContent = infoText;

    // Update alert class
    const alertDiv = document.getElementById('reviewInfo');
    alertDiv.className = isApproved ? 'alert alert-success' : 'alert alert-warning';

    // Update button
    const submitBtn = document.getElementById('reviewSubmitBtn');
    submitBtn.className = isApproved ? 'btn btn-success' : 'btn btn-danger';
    submitBtn.innerHTML = isApproved ? 
        '<i class="fas fa-check mr-1"></i>Setujui' : 
        '<i class="fas fa-times mr-1"></i>Tolak';

    // Clear previous input
    document.getElementById('catatan_reviewer').value = '';

    $('#reviewModal').modal('show');
}

function viewDetail(revisiId) {
    // Implement view detail functionality
    window.open('detail_revisi.php?id=' + revisiId, '_blank', 'width=800,height=600');
}
</script>

<?php include 'includes/footer/footer.php'; ?>
