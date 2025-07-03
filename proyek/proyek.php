<?php
session_start();

if (!isset($_SESSION['nama'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SESSION['level'] != "proyek") {
    echo "<script>alert('Anda tidak memiliki akses ke halaman ini!'); window.location='../index.php';</script>";
    exit;
}

$page_title = "Dashboard Proyek";
include 'includes/header/header.php';
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
                   <?php include 'halaman_proyek.php';?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

<?php include 'includes/footer/footer.php'; ?>
