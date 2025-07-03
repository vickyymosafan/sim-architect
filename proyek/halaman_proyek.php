<?php
if (isset($_GET['url']))
{
    $url=$_GET['url'];

    switch($url)
    {
        // case 'tulis_pengaduan';
        // include 'tulis_pengaduan.php';
        // break; 

        
// buat arah kembali tapi gajadi hehe
    }
}
else
{
    ?>
   <marquee><h3 style="color:maroon"> Selamat Datang di Tim Proyek antosa arsitek</h3></marquee> <br><br>
    Anda Login Sebagai: <?php echo $_SESSION['nama']; ?> <h2> tim proyek<b> <?php 
}
?>