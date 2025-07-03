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

    <!-- Custom CSS for enhanced styling -->
    <link href="includes/custom-styles.css" rel="stylesheet">

    <!-- Sidebar text visibility fix -->
    <link href="includes/sidebar-fix.css" rel="stylesheet">

    <!-- Additional Custom CSS -->
    <style>
        .sidebar-brand-text {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .collapse-item {
            padding: 0.5rem 1rem;
            margin: 0.1rem 0;
            border-radius: 0.35rem;
            transition: all 0.3s;
        }

        .collapse-item:hover {
            background-color: #f8f9fc;
            transform: translateX(5px);
        }

        .collapse-item.active {
            background-color: #4e73df;
            color: white;
        }

        .collapse-item.active:hover {
            background-color: #375a7f;
            color: white;
        }

        .badge-counter {
            font-size: 0.7rem;
            position: absolute;
            top: -2px;
            right: -6px;
        }

        .breadcrumb {
            font-size: 0.85rem;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            font-weight: bold;
        }

        .icon-circle {
            height: 2.5rem;
            width: 2.5rem;
            border-radius: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-list {
            max-width: 20rem;
        }

        .nav-item.active .nav-link {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.35rem;
            color: #fff !important;
        }

        .nav-item.active .nav-link span {
            color: #fff !important;
        }

        .nav-item.active .nav-link i {
            color: #fff !important;
        }

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
