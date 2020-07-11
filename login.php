<?php


require_once("../includes/connection.php");
require_once("template/lang.php");
$site_lang_dir="ltr";

$do = @$_GET['do'];
$username = mysql_real_escape_string(@$_POST['username']);
$remember = mysql_real_escape_string(@$_POST['remember']);
$username_email = mysql_real_escape_string(@$_POST['email']);
$password = @base64_encode(mysql_real_escape_string(@$_POST['password']));
$ip = $_SERVER['REMOTE_ADDR'];
$error_msg = "";
if ($username != "" && $password != "") {
    $sql = mysql_query("SELECT * FROM " . $prefix . "_users WHERE user_name='$username' AND user_password='$password' and user_status=1");
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
        setcookie("pd_admin_user_id", base64_encode(base64_encode("$adminid")), $koki_tim, '/');
        setcookie("pd_admin_user_name", base64_encode(base64_encode("$admin_name")), $koki_tim, '/');
        setcookie("pd_admin_user_password", base64_encode(base64_encode("$admin_password")), $koki_tim, '/');
        mysql_query("UPDATE " . $prefix . "_users SET ipaddress='$ip', lastlogin=NOW() WHERE user_id='$adminid'") or
        die(mysql_error());
		mysql_query("insert into " . $prefix . "_login_history_admin  (user_id, date_time,ipaddress) 
		VALUES ('$adminid',NOW(),'$ip')")or
        die(mysql_error());
        header("Location: index.php");
        exit();
    } else {
        $error_msg = "<div class=\"app-alerts alert alert-danger fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\"></button> Please check your password, user name!!</div>";
    }

}


if ($do = "fpw" && $username_email != "") {
    $sql = mysql_query("SELECT * FROM " . $prefix . "_users WHERE user_email='$username_email' and user_status=1");
    $login_check = mysql_num_rows($sql);

    if ($login_check == 1) {

        $data00 = mysql_fetch_array($sql);
        $c_username = $data00['user_name'];
        $c_password = base64_decode($data00['user_password']);

        $message_title = "Your Login Information is:";
        $message_text = "
<center>
<h4>
	Username: <b>$c_username</b><br>
	Password: <b>$c_password</b>
</h4>
</center>		
		";

        /* END OF MESSAGE */

        $website_webmail = $noreplayemail;
        //    THIS EMAIL IS THE SENDER EMAIL ADDRESS
        $from = "$website_webmail";

        //    SET A SUBJECT OF YOUR CHOICE
        $subject = "Password Recover | $site_title ";

        //    SET UP THE EMAIL HEADERS
        $headers = "From: $website_webmail\r\n";
        $headers .= "Reply-To: " . $site_title . "<" . $website_webmail . ">" . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "Content-Transfer-Encoding: 8bit\r\n";
        /*    IN-CASE SOMEONE HAS TWO EMAIL ACCOUNTS SETUP ON THE SAME COMPUTER
           SOME EMAIL PROGRAMS LIKE OUTLOOK
           WILL ONLY SHOW ONE EMAIL AND DISCARD THE OTHER(S)
           SO WE GIVE THE (Message-ID:) A RANDOM NUMBER*/
        $headers .= "Message-ID: <" . time() . rand(1, 1000) . "@" . $_SERVER['SERVER_NAME'] . ">" . "\r\n";


        //   LETS SEND THE EMAIL
        $sndst = mail($username_email, $subject, $message_text, $headers, "-f $from");

        $error_msg = "<div class=\"app-alerts alert alert-success fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\"></button> Your Login Information has been sent to your e-mail <strong> successfully </strong> </div>";

    } else {
        $error_msg = "<div class=\"app-alerts alert alert-danger fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\"></button> Email you entered is not true!! </div>";
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
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2_ltr.css"/>
    <link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2-metronic_ltr.css"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="assets/css/pages/login.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
</head>
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
        <img src="assets/img/logo-big.png" alt=""/>

</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->

    <form class="login-form" action="" method="post">
        <h3 class="form-title">Login to your account</h3>
        <?php echo $error_msg; ?>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Username</label>

            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username"
                       name="username"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>

            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password"
                       name="password"/>
            </div>
        </div>

        <div class="form-actions">
            <label class="checkbox">
                <input type="checkbox" name="remember" value="1"/> Remember me </label>
            <button type="submit" class="btn green pull-right">
                Login <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>

        <div class="forget-password">
            <h4>Forgot your password ?</h4>

            <p>
                no worries, click
                <a href="javascript:;" id="forget-password">
                    here
                </a>
                to reset your password.
            </p>
        </div>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="?do=fpw" method="post">
        <h3>Forget Password ?</h3>

        <p>
            Enter your e-mail address below to reset your password.
        </p>

        <div class="form-group">
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email"
                       name="email"/>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn">
                <i class="m-icon-swapleft"></i> Back
            </button>
            <button type="submit" class="btn green pull-right">
                Submit <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
    <?php echo date('Y', $_SERVER['REQUEST_TIME']); ?> &copy; <a href="http://www.uaepd.net" target="_blank"
                                                                 style="color: #ccc;"> Professional Designer</a>
</div>
<!-- END COPYRIGHT -->
<?php require_once("template/include_footer.php"); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/scripts/core/app.js" type="text/javascript"></script>
<script src="assets/scripts/custom/login.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function () {
        App.init();
        Login.init();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>