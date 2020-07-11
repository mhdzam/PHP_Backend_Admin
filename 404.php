<?php


require_once("template/page_start.php");
$q_search_word = mysql_real_escape_string(@$_POST['q']);
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
        <link href="assets/css/pages/error.css" rel="stylesheet" type="text/css"/>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="page-404-3">
    <div class="page-inner">
        <img src="assets/img/pages/earth.jpg" class="img-responsive" alt="">
    </div>
    <div class="container error-404">
        <h1>404</h1>

        <h2><?php echo $lang_var_admin_431; ?></h2>

        <p>
            <?php echo $lang_var_admin_432; ?>
        </p>

        <p>
            <a href="index.php">
                <?php echo $lang_var_admin_433; ?>
            </a>
            <br>
        </p>
    </div>
    <?php require_once("template/include_footer.php"); ?>
    <!-- END JAVASCRIPTS -->
    <script src="assets/scripts/core/app.js"></script>
    <script>
        jQuery(document).ready(function () {
            App.init();
        });
    </script>
    <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
    </html>
<?php
require_once("template/page_end.php");
?>