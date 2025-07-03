<?php
require '../koneksi.php';

$nama = $_POST['nama_kegiatan'];
$des = $_POST['deskripsi'];
$tgl = $_POST['tgl'];

// Insert dengan status_verifikasi default 'pending'
$sql = mysqli_query($koneksi, "INSERT INTO tugas_proyek(nama_kegiatan, deskripsi, tgl, status_verifikasi) VALUES('$nama','$des','$tgl', 'pending')");

if ($sql) {
    echo "<script>
        alert('Tugas berhasil disimpan dan akan masuk ke antrian verifikasi!');
        window.location.href = 'verifikasi.php';
    </script>";
} else {
    echo "Gagal menyimpan data: " . mysqli_error($koneksi);
}
?>
