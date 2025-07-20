<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to Chief login page
header("Location: chief_login.html");
exit;
?>
