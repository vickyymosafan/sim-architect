<?php
function renderRevisiTable($status, $koneksi) {
    $query = "SELECT rr.*, 
              u.first_name, u.last_name, u.username,
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
              WHERE rr.status_revisi = '$status'
              ORDER BY rr.tanggal_request DESC";
    
    $result = mysqli_query($koneksi, $query);
    
    ob_start();
    ?>
    <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">No</th>
                    <th>Client</th>
                    <th>Jenis</th>
                    <th>Item</th>
                    <th>Alasan Revisi</th>
                    <th class="text-center">Tanggal Request</th>
                    <?php if ($status !== 'pending'): ?>
                    <th>Reviewer</th>
                    <th class="text-center">Tanggal Review</th>
                    <?php endif; ?>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($revisi = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="font-weight-bold"><?php echo htmlspecialchars($revisi['first_name'] . ' ' . $revisi['last_name']); ?></div>
                                <div class="small text-muted">@<?php echo htmlspecialchars($revisi['username']); ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-<?php echo ($revisi['item_type'] == 'file') ? 'info' : 'primary'; ?> badge-pill">
                            <i class="fas fa-<?php echo ($revisi['item_type'] == 'file') ? 'file' : 'tasks'; ?> mr-1"></i>
                            <?php echo ucfirst($revisi['item_type']); ?>
                        </span>
                    </td>
                    <td>
                        <div class="font-weight-bold"><?php echo htmlspecialchars($revisi['item_name']); ?></div>
                        <div class="small text-muted text-truncate" style="max-width: 200px;">
                            <?php echo htmlspecialchars($revisi['item_description']); ?>
                        </div>
                    </td>
                    <td>
                        <div class="text-truncate" style="max-width: 250px;" title="<?php echo htmlspecialchars($revisi['alasan_revisi']); ?>">
                            <?php echo htmlspecialchars($revisi['alasan_revisi']); ?>
                        </div>
                        <?php if (!empty($revisi['detail_perubahan'])): ?>
                        <div class="small text-muted mt-1">
                            <strong>Detail:</strong> <?php echo htmlspecialchars(substr($revisi['detail_perubahan'], 0, 50)); ?>...
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <small><?php echo date('d M Y', strtotime($revisi['tanggal_request'])); ?></small>
                        <br>
                        <small class="text-muted"><?php echo date('H:i', strtotime($revisi['tanggal_request'])); ?></small>
                    </td>
                    <?php if ($status !== 'pending'): ?>
                    <td>
                        <?php if ($revisi['reviewer_name']): ?>
                        <div class="font-weight-bold"><?php echo htmlspecialchars($revisi['reviewer_name']); ?></div>
                        <?php else: ?>
                        <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if ($revisi['tanggal_response']): ?>
                        <small><?php echo date('d M Y', strtotime($revisi['tanggal_response'])); ?></small>
                        <br>
                        <small class="text-muted"><?php echo date('H:i', strtotime($revisi['tanggal_response'])); ?></small>
                        <?php else: ?>
                        <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-info" onclick="viewDetail(<?php echo $revisi['id']; ?>)" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <?php if ($status === 'pending'): ?>
                            <button class="btn btn-sm btn-outline-success" onclick="reviewRevisi(<?php echo $revisi['id']; ?>, 'approved')" title="Setujui">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="reviewRevisi(<?php echo $revisi['id']; ?>, 'rejected')" title="Tolak">
                                <i class="fas fa-times"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php
                    }
                } else {
                ?>
                <tr>
                    <td colspan="<?php echo ($status !== 'pending') ? '9' : '7'; ?>" class="text-center py-4">
                        <div class="text-center">
                            <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-600">Tidak Ada Data</h5>
                            <p class="text-muted">
                                <?php 
                                switch($status) {
                                    case 'pending':
                                        echo 'Belum ada permintaan revisi yang menunggu review.';
                                        break;
                                    case 'approved':
                                        echo 'Belum ada permintaan revisi yang disetujui.';
                                        break;
                                    case 'rejected':
                                        echo 'Belum ada permintaan revisi yang ditolak.';
                                        break;
                                }
                                ?>
                            </p>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
    <style>
    .icon-circle {
        height: 2rem;
        width: 2rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    </style>
    <?php
    return ob_get_clean();
}
?>
