<?php

require_once("template/page_start.php");

if ($act == "lock") {
    setcookie("pd_admin_user_password", "", time() - 3600);
}

$lock_screen_password = @base64_encode(mysql_real_escape_string(@$_POST['lock_screen_password']));
$error_msg = "";
if (@$_POST['lock_screen_password'] != "") {
    $sql = mysql_query("SELECT * FROM " . $prefix . "_users WHERE user_name='$pd_admin_user_name' AND user_password='$lock_screen_password' and user_status=1");
    $login_check = mysql_num_rows($sql);

    if ($login_check == 1) {

        $row = mysql_fetch_array($sql);
        $adminid = $row['user_id'];
        $admin_name = $row['user_name'];
        $admin_password = $row['user_password'];
        if ($remember == 1) {
            $koki_tim = time() + 864000;
        } else {
            $koki_tim = time() + 21600;
        }
        setcookie("pd_admin_user_id",base64_encode( base64_encode("$adminid")), $koki_tim, '/');
        setcookie("pd_admin_user_name", base64_encode(base64_encode("$admin_name")), $koki_tim, '/');
        setcookie("pd_admin_user_password",base64_encode( base64_encode("$admin_password")), $koki_tim, '/');
        mysql_query("UPDATE " . $prefix . "_users SET ipaddress='$ip', lastlogin=NOW() WHERE user_id='$adminid'") or
        die(mysql_error());
        header("Location: index.php");
        exit();
    } else {
        $error_msg = "<div class=\"app-alerts alert alert-danger fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\"></button> Please check your password!!</div>";
    }

}
?>

    <!DOCTYPE html>
    <!--[if IE 8]>
    <html lang="en" class="ie8 no-js"> <![endif]-->
    <!--[if IE 9]>
    <html lang="en" class="ie9 no-js"> <![endif]-->
    <!--[if !IE]><!-->
    <html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <?php require_once("template/include_header.php"); ?>
        <link href="assets/css/pages/lock_<?php echo $site_lang_dir; ?>.css" rel="stylesheet" type="text/css"/>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body>
    <div class="page-lock">
        <div class="page-logo">
            <a class="brand" href="index.html">
                <img src="assets/img/logo-big.png" alt="logo"/>
            </a>
        </div>
        <?php echo $error_msg; ?>
        <div class="page-body">
            <?php
            $av_usr_img = "assets/img/profile.jpg";
            if ($logged_admin_user_photo != "") {
                $av_usr_img = "../uploads/$logged_admin_user_photo";
            }
            ?>
            <img class="page-lock-img" src="<?php echo $av_usr_img; ?>"/>

            <div class="page-lock-info">
                <h1><?php echo $logged_admin_user_fullname; ?></h1>
			<span class="email">
				 <?php echo $logged_admin_user_email; ?>
			</span>
			<span class="locked">
				 Locked
			</span>

                <form class="form-inline" action="?" method="post">
                    <div class="input-group input-medium">
                        <input type="password" name="lock_screen_password" class="form-control" placeholder="Password">
					<span class="input-group-btn">
						<button type="submit" class="btn blue icn-only"><i class="m-icon-swapright m-icon-white"></i>
                        </button>
					</span>
                    </div>
                    <!-- /input-group -->
                    <div class="relogin">
                        <a href="login.php">
                            <?php echo $lang_var_admin_275; ?><?php echo $logged_admin_user_fullname; ?><?php echo $lang_var_admin_276; ?>
                        </a>
                    </div>
                </form>

            </div>
        </div>
        <div class="page-footer">
            <?php echo date('Y', $_SERVER['REQUEST_TIME']); ?> &copy; <a href="http://www.uaepd.net"
                                                                         target="_blank" style="color: #ccc;">Professional Designer</a>
        </div>
    </div>
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <?php require_once("template/include_footer.php"); ?>
    <!-- END JAVASCRIPTS -->
    <script src="assets/scripts/core/app.js"></script>
    <script>
        jQuery(document).ready(function () {
            App.init();
        });
    </script>
    </body>
    <!-- END BODY -->
    </html>
<?php
require_once("template/page_end.php");
?>