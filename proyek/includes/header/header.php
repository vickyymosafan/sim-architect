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

        /* Enhanced Topbar Responsive Styles */
        .topbar {
            min-height: 4.375rem;
        }

        .topbar .navbar-nav .nav-item .nav-link {
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            transition: all 0.2s ease;
            border-radius: 0.35rem;
        }

        .topbar .navbar-nav .nav-item .nav-link:hover {
            background-color: rgba(0,0,0,0.05);
        }

        /* Perfect alignment for topbar items */
        .topbar .navbar-nav {
            align-items: center;
            height: 100%;
        }

        .topbar .navbar-nav .nav-item {
            display: flex;
            align-items: center;
            height: 100%;
        }

        /* Notification icon specific styling */
        .topbar .nav-item .nav-link i.fa-bell {
            font-size: 1.1rem;
            color: #5a5c69;
        }

        /* User dropdown specific styling */
        .topbar .nav-item .nav-link .img-profile {
            border: 2px solid #e3e6f0;
            transition: border-color 0.2s ease;
        }

        .topbar .nav-item .nav-link:hover .img-profile {
            border-color: #d1d3e2;
        }

        /* Responsive adjustments for small screens */
        @media (max-width: 575.98px) {
            .topbar {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            .topbar .navbar-nav .nav-item .nav-link {
                padding: 0.25rem;
                width: 2.5rem;
                height: 2.5rem;
            }

            .topbar .nav-item .nav-link i.fa-bell {
                font-size: 1rem;
            }

            .topbar .nav-item .nav-link .img-profile {
                width: 1.75rem;
                height: 1.75rem;
            }

            .topbar .dropdown-menu {
                max-width: calc(100vw - 2rem) !important;
                left: 1rem !important;
                right: 1rem !important;
                transform: none !important;
            }
        }

        /* Medium screens adjustments */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .topbar .dropdown-menu {
                max-width: 22rem;
            }
        }

        /* Ensure proper text truncation */
        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Responsive utilities for better mobile experience */
        .min-width-0 {
            min-width: 0;
        }

        .flex-shrink-1 {
            flex-shrink: 1;
        }

        /* Badge positioning fix for mobile */
        @media (max-width: 575.98px) {
            .position-absolute.badge {
                top: 4px !important;
                right: 4px !important;
                font-size: 0.6rem !important;
                min-width: 1rem !important;
                height: 1rem !important;
            }
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
