<?php
    include 'db.php';
?>

<?php
    session_destroy();
    header('Location: login.php');
    exit;
?>

