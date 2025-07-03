<?php
require 'koneksi.php';
session_start();

// Ambil input dari form
$user = trim($_POST['username']);
$pass = trim($_POST['password']);

// Debug: Tampilkan input user
echo "Username: " . htmlspecialchars($user) . "<br>";
echo "Password: " . htmlspecialchars($pass) . "<br>";

// Eksekusi query
$sql = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$user' AND password='$pass'");

// Debug: Cek error query
if (!$sql) {
    die("Query Error: " . mysqli_error($koneksi));
}

// Debug: Cek jumlah baris yang cocok
$cek = mysqli_num_rows($sql);
echo "Jumlah data cocok: $cek <br>";

if ($cek > 0) {
    $data = mysqli_fetch_array($sql);

    // Debug: Tampilkan data user yang ditemukan
    echo "Data ditemukan:<br>";
    echo "ID Petugas: " . $data['id_petugas'] . "<br>";
    echo "Nama: " . $data['nama_petugas'] . "<br>";
    echo "Level: " . $data['level'] . "<br>";

    // Simpan session
    $_SESSION['id_petugas'] = $data['id_petugas'];
    $_SESSION['user'] = $user;
    $_SESSION['nama'] = $data['nama_petugas'];
    $_SESSION['level'] = $data['level'];
 
    // Arahkan sesuai level user
    if ($data['level'] == "proyek") {
        header('Location:proyek/proyek.php');
    } elseif ($data['level'] == "admin") {
        header('Location:admin/admin.php');
  
    } else {
        echo "<script>alert('Level tidak dikenali!'); window.location='index.php';</script>";
    }
} else {
    echo "<script>alert('Username atau Password tidak ditemukan'); window.location='index.php';</script>";
}
?>
