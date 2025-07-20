<?php
session_start();
session_unset();
session_destroy();
header("Location: mp_login.html");
exit;
