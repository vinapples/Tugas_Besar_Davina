<?php
require_once 'koneksi.php';

if (isset($_SESSION['role'])) {
    header("Location: dashboard.php");
} else {
    header("Location: login/login.php");
}
exit;
?>
