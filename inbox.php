<?php

require_once("template/page_start.php");
if ($site_inbox_status == 1) {
    $pp_a = @$_GET['a'];
    if ($pp_a == "") {
        $pp_a = @$_POST['a'];
    }
    $pp_p = @$_GET['p'];
    $pp_q = @$_GET['q'];
    $pp_msgid = @$_GET['msgid'];
    $pp_msgid = @$_GET['msgid'];
    $msgstatus = @$_GET['msgstatus'];
    $clicked_btn = @$_POST['clicked_btn'];
    $wm_to_email = mysql_real_escape_string(@$_POST['to']);
    $wm_to_cc = mysql_real_escape_string(@$_POST['cc']);
    $wm_to_bcc = mysql_real_escape_string(@$_POST['bcc']);
    $wm_member_id = mysql_real_escape_string(@$_POST['member_id']);
    $wm_title = mysql_real_escape_string(@$_POST['subject']);
    $wm_details = mysql_real_escape_string(@$_POST['message']);
    $files = @$_POST['files'];

    $sql_get_site_settings = mysql_query("SELECT * FROM " . $prefix . "_settings  WHERE settings_id ='1' ");
    $data_get_site_settings = mysql_fetch_array($sql_get_site_settings);
    $site_title_x = stripcslashes($data_get_site_settings['site_title_'.$lang]);
    $site_webmails = stripcslashes($data_get_site_settings['site_webmails']);
    $wm_from = $site_webmails;
    $wm_from_name = $site_title_x;

    $up_dir = "../uploads/mail/";

    $sql_inbox_new = mysql_query("SELECT * FROM " . $prefix . "_webmail where cat_id='0' and wm_status='0'");
    $inbox_new_count = mysql_num_rows($sql_inbox_new);
    $sql_drafts = mysql_query("SELECT * FROM " . $prefix . "_webmail where cat_id='2'");
    $drafts_count = mysql_num_rows($sql_drafts);
    $sql_archive_new = mysql_query("SELECT * FROM " . $prefix . "_webmail where cat_id='3' and wm_status='0'");
    $archive_new_count = mysql_num_rows($sql_archive_new);
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
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="page-header-fixed">
    <!-- BEGIN HEADER -->
    <?php require_once("template/header.php"); ?>
    <link href="assets/css/pages/inbox_<?php echo $site_lang_dir; ?>.css" rel="stylesheet" type="text/css"/>
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet"/>
    <!-- BEGIN:File Upload Plugin CSS files-->
    <link href="assets/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet"/>
    <link href="assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet"/>
    <link href="assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"/>
    <!-- END:File Upload Plugin CSS files-->

    <!-- END HEADER -->
    <div class="clearfix">
    </div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <?php require_once("template/menu.php"); ?>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN STYLE CUSTOMIZER -->
                <?php require_once("template/settings.php"); ?>
                <!-- END STYLE CUSTOMIZER -->
                <!-- BEGIN PAGE HEADER-->
                <br/>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <br>

                <div class="row inbox">
                    <div class="col-md-2">
                        <ul class="inbox-nav margin-bottom-10">
                            <?php
                            if ($logged_allow_add_status == 1) {
                                ?>
                                <li class="compose-btn">
                                    <a href="javascript:;" data-title="<?php echo $lang_var_admin_164; ?>"
                                       class="btn green">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_164; ?>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <li class="inbox active">
                                <a href="javascript:;" class="btn" data-title="<?php echo $lang_var_admin_160; ?>">
                                    <?php echo $lang_var_admin_160; ?>
                                    <?php
                                    if ($inbox_new_count > 0) {
                                        echo " ($inbox_new_count)";
                                    }
                                    ?>
                                </a>
                                <b></b>
                            </li>
                            <li class="sent">
                                <a class="btn" href="javascript:;" data-title="<?php echo $lang_var_admin_161; ?>">
                                    <?php echo $lang_var_admin_161; ?>
                                </a>
                                <b></b>
                            </li>
                            <li class="draft">
                                <a class="btn" href="javascript:;" data-title="<?php echo $lang_var_admin_162; ?>">
                                    <?php echo $lang_var_admin_162; ?>
                                    <?php
                                    if ($drafts_count > 0) {
                                        echo " ($drafts_count)";
                                    }
                                    ?>
                                </a>
                                <b></b>
                            </li>
                            <li class="trash">
                                <a class="btn" href="javascript:;" data-title="<?php echo $lang_var_admin_163; ?>">
                                    <?php echo $lang_var_admin_163; ?>
                                    <?php
                                    if ($archive_new_count > 0) {
                                        echo " ($archive_new_count)";
                                    }
                                    ?>
                                </a>
                                <b></b>
                            </li>
                            <?php
                            if ($pp_a == "search") {
                                ?>
                                <li class="search">
                                    <a class="btn" href="?a=<?php echo $pp_a; ?>&q=<?php echo $pp_q; ?>"
                                       data-title="<?php echo $lang_var_admin_169; ?>">
                                        <?php echo $lang_var_admin_169; ?> ..
                                    </a>
                                    <b></b>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-md-10">
                        <?php
                        if ($act == "send" && $wm_to_email != "") {
                            $cat_id = 1;
                            if ($pp_a == "draft") {
                                $cat_id = 2;
                            }
                            $filesarytosend = array();
                            $filesarytosendfilenames = array();

                            $sql_slct_max = mysql_query("select max(wm_id)  from " . $prefix . "_webmail");
                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                            $next_wm_id = $data_slct_max[0] + 1;
                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_webmail (
  wm_id,
  cat_id,
  wm_title,
  wm_details,
  wm_date,
  wm_from,
  wm_from_name, 
  wm_to_email,
  wm_to_name,
  wm_ip,
  wm_to_cc,
  wm_to_bcc,
  wm_status,
  edit_by,  
  edit_date,
  edit_from,
  member_id) VALUES ('$next_wm_id','$cat_id','$wm_title','$wm_details',now(),'$wm_from','$wm_from_name','$wm_to_email','','$pd_admin_ip','$wm_to_cc','$wm_to_bcc','0','$pd_admin_user_id',now(),'$pd_admin_ip','$wm_member_id')");

                            if ($sql_insert_new) {


                                if (isset($_FILES['filesnames']) && $pp_a != "draft") {
                                    $files_ipd_count = 0;
                                    foreach ($_FILES['filesnames']['tmp_name'] as $key => $tmp_name) {
                                        $file_name = $_FILES["filesnames"]['name'][$key];
                                        $file_temp_name = $_FILES["filesnames"]['tmp_name'][$key];

                                        if ($file_name != "") {
                                            $ext = strrchr($file_name, ".");
                                            $ext = strtolower($ext);
                                            $xrand = time() . rand(11, 99);
                                            $new_file_name = $up_dir . $xrand . $ext;

                                            if (move_uploaded_file($file_temp_name, $new_file_name)) {
                                                $topic_image_file = $xrand . $ext;

                                                $sql_insert_new2 = mysql_query("INSERT INTO " . $prefix . "_webmail_files (
  wf_title,
  wf_file,
  wm_id) VALUES ('$file_name','$topic_image_file','$next_wm_id')");

                                                if ($sql_insert_new2) {
                                                    $files_ipd_count++;
                                                    $filesarytosend[] = $new_file_name;
                                                    $filesarytosendfilenames[] = $file_name;
                                                }
                                            }

                                        }

                                    }
                                }

                                if ($msgstatus == "dr" && $pp_msgid != "" && $pp_msgid != 0) {
                                    $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_webmail where wm_id = '$pp_msgid'");
                                }

//----- SENDING EMAIl With ATTCH-----------

                                $website_webmail = $noreplayemail;
                                $headers = "From: $wm_from";
                                $subject = $wm_title;
                                $message_html = $wm_details;
                                if ($files_ipd_count > 0) {
                                    // boundary
                                    $time = md5(time());
                                    $boundary = "==Multipart_Boundary_x{$time}x";
                                    // headers used for send attachment with email
                                    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$boundary}\"";
                                    $headers .= "Message-ID: <" . time() . rand(1, 1000) . "@" . $_SERVER['SERVER_NAME'] . ">" . "\r\n";


                                    // multipart boundary
                                    $message = "--{$boundary}\n" . "Content-Type: text/html; charset=\"utf-8\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message_html . "\n\n";
                                    $message .= "--{$boundary}\n";
                                    // attach the attachments to the message
                                    for ($x = 0; $x < count($filesarytosend); $x++) {
                                        $file = fopen($filesarytosend[$x], "r");
                                        $content = fread($file, filesize($filesarytosend[$x]));
                                        fclose($file);
                                        $content = chunk_split(base64_encode($content));
                                        $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$filesarytosend[$x]\"\n" .
                                            "Content-Disposition: attachment;\n" . " filename=\"$filesarytosendfilenames[$x]\"\n" .
                                            "Content-Transfer-Encoding: base64\n\n" . $content . "\n\n";
                                        $message .= "--{$boundary}\n";
                                    }
                                    // sending mail
                                    $sndst = mail($wm_to_email, $subject, $message, $headers, "-f $wm_from");

                                } else {
                                    $headers .= "Reply-To: " . $wm_from_name . "<" . $wm_from . ">" . "\r\n";
                                    $headers .= "Content-type: text/html; charset=utf-8\r\n";
                                    $headers .= "Content-Transfer-Encoding: 8bit\r\n";
                                    $headers .= "Message-ID: <" . time() . rand(1, 1000) . "@" . $_SERVER['SERVER_NAME'] . ">" . "\r\n";
                                    $sndst = mail($wm_to_email, $subject, $message_html, $headers, "-f $wm_from");
                                }
//---- end of sending       
                            }


                            header("Location: inbox.php?a=$pp_a");
                        }

                        if ($act == "moveToArchive" && $pp_msgid != "" && $pp_msgid != 0) {
                            $sql_block = mysql_query("UPDATE " . $prefix . "_webmail SET cat_id='3' WHERE wm_id = '$pp_msgid'") or die(mysql_error());
                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <?php echo $lang_var_admin_25; ?>
                            </div>
                            <?php
//header("Location: inbox.php?a=$pp_a&p=$pp_p");     
                        }


                        if ($act == "delete" && $pp_msgid != "" && $pp_msgid != 0) {
                            $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_webmail_files where wm_id = '$pp_msgid'");
                            while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                if ($data_delete_who['wf_file'] != "") {
                                    @unlink("$up_dir" . "$data_delete_who[wf_file]");
                                }
                            }
                            $sql_delete0 = mysql_query("DELETE FROM  " . $prefix . "_webmail_files where wm_id = '$pp_msgid'");
                            $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_webmail where wm_id = '$pp_msgid'");
                            if ($sql_delete) {
                                $actin_done = 1;
                            }
                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <?php echo $lang_var_admin_25; ?>
                            </div>
                            <?php
//header("Location: inbox.php?a=$pp_a&p=$pp_p");     
                        }


                        $multichkbx = @$_POST['multichkbx'];
                        $all_multichkbx = "";
                        if ($multichkbx != "") {
                            while (list($key, $val) = @each($multichkbx)) {
                                $all_multichkbx .= "$val,";
                            }
                            $multichkbx = substr($all_multichkbx, 0, -1);
                            //-------------
                            $actin_done = 0;
                            if ($clicked_btn == "b_active") {
                                $sql_active = mysql_query("UPDATE " . $prefix . "_webmail SET wm_status=1 WHERE wm_id in ($multichkbx)") or die(mysql_error());
                                if ($sql_active) {
                                    $actin_done = 1;
                                }


                            } elseif ($clicked_btn == "b_block") {

                                $sql_block = mysql_query("UPDATE " . $prefix . "_webmail SET wm_status=0 WHERE wm_id in ($multichkbx)") or die(mysql_error());
                                if ($sql_block) {
                                    $actin_done = 1;
                                }

                            } elseif ($clicked_btn == "b_archive") {

                                $sql_block = mysql_query("UPDATE " . $prefix . "_webmail SET cat_id='3' WHERE wm_id in ($multichkbx)") or die(mysql_error());
                                if ($sql_block) {
                                    $actin_done = 1;
                                }

                            } elseif ($clicked_btn == "b_delete") {
                                $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_webmail_files where wm_id in (SELECT wm_id FROM " . $prefix .
                                    "_webmail where wm_id  in ($multichkbx))");
                                while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                    if ($data_delete_who['wf_file'] != "") {
                                        @unlink("$up_dir" . "$data_delete_who[wf_file]");
                                    }
                                }
                                $sql_delete0 = mysql_query("DELETE FROM  " . $prefix . "_webmail_files where  wm_id in ($multichkbx)");
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_webmail where wm_id in ($multichkbx)");
                                if ($sql_delete) {
                                    $actin_done = 1;
                                }

                            }
                            if ($actin_done == 1) {
                                header("Location: inbox.php?a=$pp_a&p=$pp_p");
                            }

                        }
                        ?>
                        <div class="inbox-header">
                            <h1 class="pull-left"><?php echo $lang_var_admin_160; ?></h1>

                            <form class="form-inline pull-right" method="get" action="?">
                                <input type="hidden" name="a" value="search"/>

                                <div class="input-group input-medium">
                                    <input type="text" name="q" value="<?php echo $pp_q; ?>" required=""
                                           class="form-control"
                                           placeholder="<?php echo $lang_var_admin_111; ?>">
								<span class="input-group-btn">
									<button type="submit" class="btn green"><i class="fa fa-search"></i></button>
								</span>
                                </div>
                            </form>
                        </div>
                        <div class="inbox-loading">
                            Loading...
                        </div>
                        <div class="inbox-content">
                        </div>
                    </div>
                </div>
                <!-- END PAGE CONTENT-->
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <?php require_once("template/footer.php"); ?>
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <?php require_once("template/include_footer.php"); ?>
    <!-- END JAVASCRIPTS -->
    <!-- BEGIN: Page level plugins -->
    <script src="assets/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
    <!-- BEGIN:File Upload Plugin JS files-->
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="assets/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="assets/plugins/jquery-file-upload/js/vendor/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="assets/plugins/jquery-file-upload/js/vendor/load-image.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="assets/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js"></script>
    <!-- blueimp Gallery script -->
    <script src="assets/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="assets/plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="assets/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="assets/plugins/jquery-file-upload/js/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="assets/plugins/jquery-file-upload/js/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="assets/plugins/jquery-file-upload/js/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="assets/plugins/jquery-file-upload/js/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="assets/plugins/jquery-file-upload/js/jquery.fileupload-validate.js"></script>
    <!-- The File Upload user interface plugin -->
    <script src="assets/plugins/jquery-file-upload/js/jquery.fileupload-ui.js"></script>
    <!-- The main application script -->
    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
    <script src="assets/plugins/jquery-file-upload/js/cors/jquery.xdr-transport.js"></script>
    <![endif]-->
    <!-- END:File Upload Plugin JS files-->
    <!-- END: Page level plugins -->
    <script src="assets/scripts/core/app.js"></script>
    <script src="assets/scripts/custom/inbox.js"></script>
    <script>
        jQuery(document).ready(function () {
            // initiate layout and plugins
            App.init();
            Inbox.init();
        });
    </script>

    </body>
    <!-- END BODY -->
    </html>
    <?php
} else {
    header("Location: index.php");
}
require_once("template/page_end.php");
?>