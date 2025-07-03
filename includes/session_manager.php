<?php
/**
 * Session Manager - Prevents duplicate session_start() calls
 * Use this instead of calling session_start() directly
 */

function safe_session_start() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function check_session_auth($required_level = null) {
    safe_session_start();
    
    if (!isset($_SESSION['nama'])) {
        header("Location: ../index.php");
        exit;
    }
    
    if ($required_level && $_SESSION['level'] != $required_level) {
        echo "<script>alert('Anda tidak memiliki akses ke halaman ini!'); window.location='../index.php';</script>";
        exit;
    }
}

function destroy_session() {
    safe_session_start();
    unset($_SESSION['nama']);
    session_destroy();
}
?>
