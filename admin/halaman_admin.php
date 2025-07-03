<?php
if (isset($_GET['url']))
{
    $url=$_GET['url'];

    switch($url)
    {
        case 'kelola_user_proyek':
        include 'kelola_user_proyek.php';
        break;

        // case 'tulis_pengaduan';
        // include 'tulis_pengaduan.php';
        // break;


// buat arah kembali tapi gajadi hehe
    }
}
else
{
    ?>
   <marquee><h3 style="color:maroon"> Selamat Datang admin di antosa arsitek</h3></marquee> <br><br>
    Anda Login Sebagai: <?php echo $_SESSION['nama']; ?> <h2> admin<b> <?php 
}
?>