<?php
session_start();
session_unset();
session_destroy();

// Redirect the user to the login page
header("Location: admin_login.php");
exit();
?>
