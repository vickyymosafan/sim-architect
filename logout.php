<?php
require_once 'includes/session_manager.php';
destroy_session();
header('location:index.php');
?>