<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem Manajemen Proyek Arsitek - Antosa Arsitek">
    <meta name="author" content="Antosa Arsitek">
    <meta name="keywords" content="arsitek, proyek, manajemen, desain, konstruksi">
    <meta name="robots" content="noindex, nofollow">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../tmp/img/favicon.ico">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title : 'Dashboard Proyek'; ?> - Antosa Arsitek">
    <meta property="og:description" content="Sistem Manajemen Proyek Arsitek">
    <meta property="og:type" content="website">

    <title><?php echo isset($page_title) ? $page_title : 'Dashboard Proyek'; ?> - Antosa Arsitek</title>

    <!-- Custom fonts for this template-->
    <link href="../tmp/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../tmp/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom CSS removed - using SB Admin 2 default styles -->

    <!-- Include functions for reusable components -->
    <?php require_once 'includes/fungsi.php'; ?>

    <!-- Critical inline CSS for sidebar visibility - kept inline for highest priority -->
    <style>
        /* Critical sidebar text visibility fix - inline for highest priority */
        .sidebar-dark .navbar-nav .nav-item .nav-link,
        .sidebar-dark .navbar-nav .nav-item .nav-link span,
        .sidebar-dark .navbar-nav .nav-item .nav-link i,
        .sidebar .nav-item .nav-link,
        .sidebar .nav-item .nav-link span,
        .sidebar .nav-item .nav-link i {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .sidebar-dark .navbar-nav .nav-item .nav-link:hover,
        .sidebar-dark .navbar-nav .nav-item .nav-link:hover span,
        .sidebar-dark .navbar-nav .nav-item .nav-link:hover i,
        .sidebar .nav-item .nav-link:hover,
        .sidebar .nav-item .nav-link:hover span,
        .sidebar .nav-item .nav-link:hover i {
            color: #fff !important;
        }

        .sidebar-dark .navbar-nav .nav-item.active .nav-link,
        .sidebar-dark .navbar-nav .nav-item.active .nav-link span,
        .sidebar-dark .navbar-nav .nav-item.active .nav-link i,
        .sidebar .nav-item.active .nav-link,
        .sidebar .nav-item.active .nav-link span,
        .sidebar .nav-item.active .nav-link i {
            color: #fff !important;
        }

        /* Force visibility for all sidebar text elements */
        .sidebar * {
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
