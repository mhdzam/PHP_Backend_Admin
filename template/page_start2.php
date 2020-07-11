<?php

// make it or break it
error_reporting(E_ALL);

// begin output buffering
ob_start();

require_once("../../includes/connection.php");
require_once("functions.php");
require_once("lang.php");

// check login

$pd_admin_user_id = @base64_decode( base64_decode($_COOKIE["pd_admin_user_id"]));
$pd_admin_user_name = @base64_decode( base64_decode($_COOKIE["pd_admin_user_name"]));
$pd_admin_user_password = @base64_decode( base64_decode($_COOKIE["pd_admin_user_password"]));

$sql_adminlog_check = mysql_query("SELECT * FROM " . $prefix .
    "_users  where user_id='$pd_admin_user_id' and user_password='$pd_admin_user_password' and user_status=1");
$row_check_adminlog = mysql_num_rows($sql_adminlog_check);

$sql_adminlog_check2 = mysql_query("SELECT * FROM " . $prefix .
    "_users  where user_id='$pd_admin_user_id' and user_status=1");
$row_check_adminlog2 = mysql_num_rows($sql_adminlog_check2);

if ($row_check_adminlog != 0) {
    $data_adminlog_check = mysql_fetch_array($sql_adminlog_check);
    $logged_admin_user_name = mysql_real_escape_string($data_adminlog_check['user_name']);
    $logged_admin_control_type = mysql_real_escape_string($data_adminlog_check['control_type']);
    $logged_admin_user_photo = mysql_real_escape_string($data_adminlog_check['user_photo']);
    $logged_admin_user_fullname = mysql_real_escape_string($data_adminlog_check['user_fullname']);
    if ($logged_admin_user_fullname == "") {
        $logged_admin_user_fullname = $logged_admin_user_name;
    }
    $logged_admin_user_email = mysql_real_escape_string($data_adminlog_check['user_email']);

    if ($logged_admin_control_type == 0) { //  webmaster
        $logged_full_control_status = 1;
        $logged_allow_add_status = 1;
        $logged_allow_edit_status = 1;
        $logged_allow_delete_status = 1;
        $logged_allow_view_status = 1;
    } elseif ($logged_admin_control_type == 1) { //  site manager
        $logged_full_control_status = 0;
        $logged_allow_add_status = 1;
        $logged_allow_edit_status = 1;
        $logged_allow_delete_status = 1;
        $logged_allow_view_status = 1;
    } elseif ($logged_admin_control_type == 2) { //  normal user
        $logged_full_control_status = 0;
        $logged_allow_add_status = 1;
        $logged_allow_edit_status = 1;
        $logged_allow_delete_status = 0;
        $logged_allow_view_status = 1;
    } else { //  view only
        $logged_full_control_status = 0;
        $logged_allow_add_status = 0;
        $logged_allow_edit_status = 0;
        $logged_allow_delete_status = 0;
        $logged_allow_view_status = 1;
    }


} else if ($row_check_adminlog2 != 0 && $pd_admin_user_password == "") {
    $data_adminlog_check = mysql_fetch_array($sql_adminlog_check2);
    $logged_admin_user_name = mysql_real_escape_string($data_adminlog_check['user_name']);
    $logged_admin_control_type = mysql_real_escape_string($data_adminlog_check['control_type']);
    $logged_admin_user_photo = mysql_real_escape_string($data_adminlog_check['user_photo']);
    $logged_admin_user_fullname = mysql_real_escape_string($data_adminlog_check['user_fullname']);
    if ($logged_admin_user_fullname == "") {
        $logged_admin_user_fullname = $logged_admin_user_name;
    }
    $logged_admin_user_email = mysql_real_escape_string($data_adminlog_check['user_email']);

    if ($pd_current_page_php != "lock.php") {
        header("Location: ../lock.php?act=lock");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
// End of check login

$wm_section = @$_GET['wm_section'];

?>