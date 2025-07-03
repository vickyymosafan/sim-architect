<?php
require '../koneksi.php';

$nama = $_POST['nama_kegiatan'];
$des = $_POST['deskripsi'];
$tgl = $_POST['tgl'];

$sql = mysqli_query($koneksi, "INSERT INTO tugas_proyek(nama_kegiatan, deskripsi, tgl) VALUES('$nama','$des','$tgl')");

if ($sql) {
    echo "<script>
        alert('Data Berhasil Disimpan');
        window.location.href = 'input_tugas.php';
    </script>";
} else {
    echo "Gagal menyimpan data: " . mysqli_error($koneksi);
}
?>
