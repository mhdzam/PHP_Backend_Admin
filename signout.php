<?php



require_once("../includes/connection.php");

setcookie("pd_admin_user_id", "", time() - 3600, '/');
setcookie("pd_admin_user_name", "", time() - 3600, '/');
setcookie("pd_admin_user_password", "", time() - 3600, '/');
header("Location: login.php");

?>