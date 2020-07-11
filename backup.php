<?php

require_once("template/page_start.php");
if ($logged_admin_control_type == 0 || $logged_admin_control_type == 1) {
//--------
    $id = @$_GET['id'];
    $tableact = @$_GET['tableact'];
    $clicked_btn = @$_POST['clicked_btn'];
//-------
    $lang_title = mysql_real_escape_string(@$_POST['lang_title']);
    $lang_code = mysql_real_escape_string(@$_POST['lang_code']);
    $lang_lang = mysql_real_escape_string(@$_POST['lang_lang']);
    $lang_dir = mysql_real_escape_string(@$_POST['lang_dir']);
    $lang_align_right = mysql_real_escape_string(@$_POST['lang_align_right']);
    $lang_align_left = mysql_real_escape_string(@$_POST['lang_align_left']);
    $lang_charset = mysql_real_escape_string(@$_POST['lang_charset']);
    $lang_icon = mysql_real_escape_string(@$_POST['lang_icon']);
    $file_del = mysql_real_escape_string(@$_POST['file_del']);

    $up_dir = "../uploads/backup/";
    $file_name = @$_FILES['myfile']['name'];
    $file_temp_name = @$_FILES['myfile']['tmp_name'];
    $file_size = $up_dir . @$_FILES['myfile']['size'];


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
        <link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2_<?php echo $site_lang_dir; ?>.css"/>
        <link rel="stylesheet" type="text/css"
              href="assets/plugins/select2/select2-metronic_<?php echo $site_lang_dir; ?>.css"/>
        <link rel="stylesheet" href="assets/plugins/data-tables/DT_bootstrap_<?php echo $site_lang_dir; ?>.css"/>
        <!-- END PAGE LEVEL STYLES -->
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="page-header-fixed">
    <!-- BEGIN HEADER -->
    <?php require_once("template/header.php"); ?>
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
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        <h3 class="page-title"><?php echo $lang_var_admin_60; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_58; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_60; ?></a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        //   ----------- PAGE START

                        if ($act == "delete" && $id != "") {

                            unlink("$up_dir" . "$id");
                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <?php echo $lang_var_admin_25; ?>
                            </div>
                            <?php
                            setcookie("update_status_cooki", 1, time() + 21600);
                        }


                        if ($act == "new") {

                            $ff_name = backup_tables($dbhost, $dbuname, $dbpass, $dbname);


                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong><?php echo $lang_var_admin_133; ?></strong><br/>
                                <?php echo $lang_var_admin_134; ?> <a href=' <?php echo $ff_name; ?>'
                                                                      target='_blank'> <?php echo $ff_name; ?></a>
                            </div>

                            <?php
                        }


                        if ($act == "restoreDB" && $id != "") {

                            $ff_name = backup_tables($dbhost, $dbuname, $dbpass, $dbname);

// Name of the file
                            $filename = "$up_dir" . "$id";

// Temporary variable, used to store current query
                            $templine = '';
// Read in entire file
                            $lines = file($filename);
// Loop through each line
                            foreach ($lines as $line) {
                                // Skip it if it's a comment
                                if (substr($line, 0, 2) == '--' || $line == '')
                                    continue;

                                // Add this line to the current segment
                                $templine .= $line;
                                // If it has a semicolon at the end, it's the end of the query
                                if (substr(trim($line), -1, 1) == ';') {
                                    // Perform the query
                                    mysql_query($templine) or print('An error occurred while running the following command : \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                                    // Reset temp variable to empty
                                    $templine = '';
                                }
                            }

                            ?>

                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <strong><?php echo $lang_var_admin_136; ?><?php echo $id; ?></strong>
                            </div>
                            <?php
                        }

                        if ($act == "restorefromfile") {

                            $file_name = @$_FILES['myfile']['name'];

                            $ext = strrchr($file_name, ".");
                            $ext = strtolower($ext);
                            if ($ext == ".sql") {
// Name of the file
                                $filename = $_FILES['myfile']['tmp_name'];

// Temporary variable, used to store current query
                                $templine = '';
// Read in entire file
                                $lines = file($filename);
// Loop through each line
                                foreach ($lines as $line) {
                                    // Skip it if it's a comment
                                    if (substr($line, 0, 2) == '--' || $line == '')
                                        continue;

                                    // Add this line to the current segment
                                    $templine .= $line;
                                    // If it has a semicolon at the end, it's the end of the query
                                    if (substr(trim($line), -1, 1) == ';') {
                                        // Perform the query
                                        mysql_query($templine) or print('An error occurred while running the following command : \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                                        // Reset temp variable to empty
                                        $templine = '';
                                    }
                                }
                                ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <?php echo $lang_var_admin_25; ?>
                                </div>
                                <?php
                            } else {

                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <?php echo $lang_var_admin_26; ?>
                                </div>
                                <?php

                            }

                        }
                        ?>
                        <div>

                            <div class="table-toolbar">
                                <div class="btn-group">
                                    <a href="?act=new"><span id="sample_editable_1_new" class="btn green">
									<?php echo $lang_var_admin_129; ?> <i class="fa fa-plus"></i>
									</span></a>
                                </div>
                            </div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 15%;text-align: center;"><?php echo $lang_var_admin_130; ?></th>
                                    <th><?php echo $lang_var_admin_131; ?></th>
                                    <th style="width: 15%;text-align: center;"><?php echo $lang_var_admin_5; ?></th>
                                </tr>
                                </thead>
                                <?php
                                $handle = opendir($up_dir);
                                $files_count = 0;
                                while (($file0 = readdir($handle)) !== false) {
                                    if ($file0 != "." && $file0 != "..") {
                                        $files_count++;
                                    }
                                }
                                closedir($handle);

                                if ($files_count > 0) {
                                    ?>
                                    <tbody>
                                    <?php

                                    $handle = opendir($up_dir);
                                    while (($file = readdir($handle)) !== false) {
                                        $flatdot = substr($file, -4, 4);
                                        if ($file != "." && $file != ".." && $flatdot == ".sql") {
                                            $file_date0 = substr($file, 7, 10);
                                            $file_date = date("d-m-Y", $file_date0);

                                            ?>
                                            <tr class="odd gradeX">
                                                <td style="width: 10%;text-align: center;">
                                                    <small><?php echo $file_date; ?></small>
                                                </td>
                                                <td>
                                                    <small><?php echo "<a href='$up_dir" . "$file' target='_blank'>$file </a>"; ?></small>
                                                </td>
                                                <td style="text-align: center;"><a href="javascript:;"
                                                                                   onclick="confirmation_box_backup_delete('?act=restoreDB&id=<?php echo $file; ?>')"
                                                                                   class="btn btn-sm default"> <?php echo $lang_var_admin_135; ?>
                                                        <i class="fa fa-edit"></i></a> &nbsp; <a href="javascript:;"
                                                                                                 onclick="confirmation_box_backup_delete('?act=delete&id=<?php echo $file; ?>')"
                                                                                                 class="btn btn-sm red"> <?php echo $lang_var_admin_19; ?>
                                                        <i class="fa fa-times"></i></a></td>
                                            </tr>
                                            <?php
                                        }
                                    }

                                    ?>
                                    </tbody>
                                    <?php
                                } else {
                                    ?>
                                    <tbody>
                                    <tr class="odd gradeX">
                                        <td colspan="3">
                                            <div style="text-align: center;">
                                                <small><?php echo $lang_var_admin_132; ?></small>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                <?php } ?>
                            </table>

                        </div>
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption" style="min-width: 200px;">
                                    <i class="fa fa-upload"></i> <?php echo $lang_var_admin_137; ?>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="?act=restorefromfile" id="form_sample_3" method="post"
                                      class="form-horizontal"
                                      enctype="multipart/form-data">
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-4"><?php echo $lang_var_admin_138; ?> </label>

                                            <div class="col-md-4">
                                                <input type="file" name="myfile" required="" class="form-control"/>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="submit"
                                                        class="btn blue"><?php echo $lang_var_admin_135; ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- END FORM-->
                            </div>
                            <!-- END VALIDATION STATES-->
                        </div>

                        <?php
                        // empty and export tables

                        $cat_multichkbx = @$_POST['cat_multichkbx'];
                        $multichkbx = @$_POST['multichkbx'];
                        $com_multichkbx = @$_POST['com_multichkbx'];
                        $inbox_multichkbx = @$_POST['inbox_multichkbx'];
                        $newsletter_multichkbx = @$_POST['newsletter_multichkbx'];
                        $banars_multichkbx = @$_POST['banars_multichkbx'];
                        $calendar_multichkbx = @$_POST['calendar_multichkbx'];
                        $actin_done = 0;

                        // empty cats
                        $all_multichkbx_cat = "";
                        if ($cat_multichkbx != "") {
                            while (list($key, $val) = @each($cat_multichkbx)) {
                                $all_multichkbx_cat .= "$val,";
                            }
                            $cat_multichkbx = substr($all_multichkbx_cat, 0, -1);
                            //-------------
                            if ($clicked_btn == "b_empty") {
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_sections where wm_section_id in ($cat_multichkbx)");
                                if ($sql_delete) {
                                    $actin_done = 1;
                                }
                            }
                        }

                        // empty topics
                        $all_multichkbx = "";
                        if ($multichkbx != "") {
                            while (list($key, $val) = @each($multichkbx)) {
                                $all_multichkbx .= "$val,";
                            }
                            $multichkbx = substr($all_multichkbx, 0, -1);
                            //-------------
                            if ($clicked_btn == "b_empty") {
                                $sql_delete0 = mysql_query("DELETE FROM  " . $prefix . "_topics_comments where wm_section_id in ($multichkbx)");
                                $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_topics WHERE in ($multichkbx)");
                                while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                    if ($data_delete_who['topic_image_file'] != "") {
                                        @unlink("../uploads/topics/$data_delete_who[topic_image_file]");
                                    }
                                    $sql_delete00 = mysql_query("DELETE FROM  " . $prefix . "_topics_files where topic_id ='$data_delete_who[topic_id]'");
                                    $sql_delete01 = mysql_query("DELETE FROM  " . $prefix . "_topics_maps where topic_id ='$data_delete_who[topic_id]'");
                                }

                                $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_topics where wm_section_id in ($multichkbx)");
                                if ($sql_delete) {
                                    $actin_done = 1;
                                }
                            }
                        }

                        // empty Comments
                        $all_multichkbx_com = "";
                        if ($com_multichkbx != "") {
                            while (list($key, $val) = @each($com_multichkbx)) {
                                $all_multichkbx_com .= "$val,";
                            }
                            $com_multichkbx = substr($all_multichkbx_com, 0, -1);
                            //-------------
                            if ($clicked_btn == "b_empty") {
                                echo $com_multichkbx;
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_topics_comments where wm_section_id in ($com_multichkbx)");
                                if ($sql_delete) {
                                    $actin_done = 1;
                                }
                            }
                        }


                        // empty Inbox
                        $all_multichkbx_inbox = "";
                        if ($inbox_multichkbx != "") {
                            while (list($key, $val) = @each($inbox_multichkbx)) {
                                $all_multichkbx_inbox .= "$val,";
                            }
                            $inbox_multichkbx = substr($all_multichkbx_inbox, 0, -1);
                            //-------------
                            if ($clicked_btn == "b_empty") {
                                echo $inbox_multichkbx;
                                $sql_delete0 = mysql_query("DELETE FROM  " . $prefix . "_webmail_files");
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_webmail");
                                if ($sql_delete) {
                                    $actin_done = 1;
                                }
                            }
                        }

                        // empty Newsletter Emails
                        $all_multichkbx_newsletter = "";
                        if ($newsletter_multichkbx != "") {
                            while (list($key, $val) = @each($newsletter_multichkbx)) {
                                $all_multichkbx_newsletter .= "$val,";
                            }
                            $newsletter_multichkbx = substr($all_multichkbx_newsletter, 0, -1);
                            //-------------
                            if ($clicked_btn == "b_empty") {
                                echo $newsletter_multichkbx;
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_newsletter");
                                if ($sql_delete) {
                                    $actin_done = 1;
                                }
                            }
                        }

                        // empty Banars
                        $all_multichkbx_banars = "";
                        if ($banars_multichkbx != "") {
                            while (list($key, $val) = @each($banars_multichkbx)) {
                                $all_multichkbx_banars .= "$val,";
                            }
                            $banars_multichkbx = substr($all_multichkbx_banars, 0, -1);
                            //-------------
                            if ($clicked_btn == "b_empty") {
                                echo $banars_multichkbx;
                                $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_banars");
                                while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                    if ($data_delete_who['banar_file_ar'] != "") {
                                        @unlink("../uploads/baners/$data_delete_who[banar_file_ar]");
                                    }
                                    if ($data_delete_who['banar_file_en'] != "") {
                                        @unlink("../uploads/baners/$data_delete_who[banar_file_en]");
                                    }
                                }
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_banars");
                                if ($sql_delete) {
                                    $actin_done = 1;
                                }
                            }
                        }

                        // empty Calender
                        $all_multichkbx_calendar = "";
                        if ($calendar_multichkbx != "") {
                            while (list($key, $val) = @each($calendar_multichkbx)) {
                                $all_multichkbx_calendar .= "$val,";
                            }
                            $calendar_multichkbx = substr($all_multichkbx_calendar, 0, -1);
                            //-------------
                            if ($clicked_btn == "b_empty") {
                                echo $calendar_multichkbx;
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_calendar");
                                if ($sql_delete) {
                                    $actin_done = 1;
                                }
                            }
                        }


                        if ($actin_done == 1) {
                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <?php echo $lang_var_admin_25; ?>
                            </div>
                            <?php
                        }

                        ?>
                        <div>
                            <form name="multicheckfrm" id="multicheckfrm" method="post" action="?tableact=empty">

                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th class="table-checkbox" style="width: 3%;">
                                            <input type="checkbox" class="checkall"/>
                                        </th>
                                        <th><?php echo $lang_var_admin_88; ?></th>
                                        <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_207; ?></th>
                                        <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_208; ?></th>
                                        <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_209; ?></th>
                                        <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_5; ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_webmaster_sections where ws_status=1 order by ws_id");
                                    while ($data_retrive = mysql_fetch_array($sql_retrive)) {

                                        if ($data_retrive['ws_sections_st'] != 0) {
                                            $sql_topics_count = mysql_query("SELECT * FROM " . $prefix . "_sections where wm_section_id='$data_retrive[ws_id]'");
                                            $records_topics_count = mysql_num_rows($sql_topics_count);

                                            $sql_topics_last = mysql_query("SELECT edit_date,edit_by,edit_from FROM " . $prefix . "_sections where wm_section_id='$data_retrive[ws_id]' order by edit_date desc limit 1");
                                            $data_topics_last = mysql_fetch_array($sql_topics_last);

                                            $edit_date = $data_topics_last['edit_date'];
                                            $edit_by = GetAdminUserName($data_topics_last['edit_by']);
                                            $edit_from = $data_topics_last['edit_from'];
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><input type="checkbox" name="cat_multichkbx[]" class="checkboxes"
                                                           value="<?php echo $data_retrive['ws_id']; ?>"/></td>
                                                <td>
                                                    <i class="fa fa-sitemap"></i> <?php echo $lang_var_admin_85 . " " . $$data_retrive['ws_title_var']; ?>
                                                </td>
                                                <td style="text-align: center;"><?php echo $records_topics_count; ?></td>
                                                <td style="text-align: center;"
                                                    title="<?php echo FormatDateTimeLong(stripslashes($edit_date)); ?>"><?php echo FormatDateTime(stripslashes($edit_date)); ?></td>
                                                <td style="text-align: center;"
                                                    title="IP: <?php echo $edit_from; ?>"><?php echo $edit_by; ?></td>
                                                <td style="text-align: center;">
                                                    <?php if ($records_topics_count > 0) { ?>
                                                        <a target="_blank"
                                                           href="template/export.php?act=sections&ws_id=<?php echo $data_retrive['ws_id']; ?>"
                                                           class="btn  btn-sm green"> <?php echo $lang_var_admin_210; ?>
                                                            <i
                                                                class="fa fa-floppy-o"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php

                                        }
                                        $mnu_icons_type = array("fa fa-folder-open-o", "fa fa-picture-o", "fa fa-film", "fa fa-volume-up");
                                        $sql_topics_count = mysql_query("SELECT * FROM " . $prefix . "_topics where wm_section_id='$data_retrive[ws_id]'");
                                        $records_topics_count = mysql_num_rows($sql_topics_count);

                                        $sql_topics_last = mysql_query("SELECT edit_date,edit_by,edit_from FROM " . $prefix . "_topics where wm_section_id='$data_retrive[ws_id]' order by edit_date desc limit 1");
                                        $data_topics_last = mysql_fetch_array($sql_topics_last);

                                        $edit_date = $data_topics_last['edit_date'];
                                        $edit_by = GetAdminUserName($data_topics_last['edit_by']);
                                        $edit_from = $data_topics_last['edit_from'];

                                        ?>
                                        <tr class="odd gradeX">
                                            <td><input type="checkbox" name="multichkbx[]" class="checkboxes"
                                                       value="<?php echo $data_retrive['ws_id']; ?>"/></td>
                                            <td>
                                                <i class="<?php echo $mnu_icons_type[$data_retrive['ws_type']]; ?>"></i> <?php echo $$data_retrive['ws_title_var']; ?>
                                            </td>
                                            <td style="text-align: center;"><?php echo $records_topics_count; ?></td>
                                            <td style="text-align: center;"
                                                title="<?php echo FormatDateTimeLong(stripslashes($edit_date)); ?>"><?php echo FormatDateTime(stripslashes($edit_date)); ?></td>
                                            <td style="text-align: center;"
                                                title="IP: <?php echo $edit_from; ?>"><?php echo $edit_by; ?></td>
                                            <td style="text-align: center;">
                                                <?php if ($records_topics_count > 0) { ?>
                                                    <a target="_blank"
                                                       href="template/export.php?act=topics&ws_id=<?php echo $data_retrive['ws_id']; ?>"
                                                       class="btn  btn-sm green"> <?php echo $lang_var_admin_210; ?> <i
                                                            class="fa fa-floppy-o"></i></a>
                                                <?php } ?>                         </td>
                                        </tr>
                                        <?php

                                        if ($data_retrive['ws_comments_st'] != 0) {

                                            $sql_topics_count = mysql_query("SELECT * FROM " . $prefix . "_topics_comments where wm_section_id='$data_retrive[ws_id]'");
                                            $records_topics_count = mysql_num_rows($sql_topics_count);

                                            $sql_topics_last = mysql_query("SELECT edit_date,edit_by,edit_from FROM " . $prefix . "_topics_comments where wm_section_id='$data_retrive[ws_id]' order by edit_date desc limit 1");
                                            $data_topics_last = mysql_fetch_array($sql_topics_last);

                                            $edit_date = $data_topics_last['edit_date'];
                                            $edit_by = GetAdminUserName($data_topics_last['edit_by']);
                                            $edit_from = $data_topics_last['edit_from'];
                                            ?>
                                            <tr class="odd gradeX">
                                                <td><input type="checkbox" name="com_multichkbx[]" class="checkboxes"
                                                           value="<?php echo $data_retrive['ws_id']; ?>"/></td>
                                                <td>
                                                    <i class="fa fa-users"></i> <?php echo $lang_var_admin_86 . " " . $$data_retrive['ws_title_var']; ?>
                                                </td>
                                                <td style="text-align: center;"><?php echo $records_topics_count; ?></td>
                                                <td style="text-align: center;"
                                                    title="<?php echo FormatDateTimeLong(stripslashes($edit_date)); ?>"><?php echo FormatDateTime(stripslashes($edit_date)); ?></td>
                                                <td style="text-align: center;"
                                                    title="IP: <?php echo $edit_from; ?>"><?php echo $edit_by; ?></td>
                                                <td style="text-align: center;">
                                                    <?php if ($records_topics_count > 0) { ?>
                                                        <a target="_blank"
                                                           href="template/export.php?act=comments&ws_id=<?php echo $data_retrive['ws_id']; ?>"
                                                           class="btn  btn-sm green"> <?php echo $lang_var_admin_210; ?>
                                                            <i
                                                                class="fa fa-floppy-o"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php

                                        }

                                    }

                                    $sql_topics_count = mysql_query("SELECT * FROM " . $prefix . "_webmail");
                                    $records_topics_count = mysql_num_rows($sql_topics_count);

                                    $sql_topics_last = mysql_query("SELECT edit_date,edit_by,edit_from FROM " . $prefix . "_webmail order by edit_date desc limit 1");
                                    $data_topics_last = mysql_fetch_array($sql_topics_last);

                                    $edit_date = $data_topics_last['edit_date'];
                                    $edit_by = GetAdminUserName($data_topics_last['edit_by']);
                                    $edit_from = $data_topics_last['edit_from'];
                                    ?>

                                    <tr class="odd gradeX">
                                        <td><input type="checkbox" name="inbox_multichkbx[]" class="checkboxes"
                                                   value="<?php echo $data_retrive['ws_id']; ?>"/></td>
                                        <td><i class="fa fa-envelope-o"></i> <?php echo $lang_var_admin_159; ?></td>
                                        <td style="text-align: center;"><?php echo $records_topics_count; ?></td>
                                        <td style="text-align: center;"
                                            title="<?php echo FormatDateTimeLong(stripslashes($edit_date)); ?>"><?php echo FormatDateTime(stripslashes($edit_date)); ?></td>
                                        <td style="text-align: center;"
                                            title="IP: <?php echo $edit_from; ?>"><?php echo $edit_by; ?></td>
                                        <td style="text-align: center;">
                                            <?php if ($records_topics_count > 0) { ?>
                                                <a target="_blank" href="template/export.php?act=inbox"
                                                   class="btn  btn-sm green"> <?php echo $lang_var_admin_210; ?> <i
                                                        class="fa fa-floppy-o"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    <?php
                                    $sql_topics_count = mysql_query("SELECT * FROM " . $prefix . "_newsletter");
                                    $records_topics_count = mysql_num_rows($sql_topics_count);
                                    ?>

                                    <tr class="odd gradeX">
                                        <td><input type="checkbox" name="newsletter_multichkbx[]" class="checkboxes"
                                                   value="<?php echo $data_retrive['ws_id']; ?>"/></td>
                                        <td><i class="fa fa fa-meh-o"></i> <?php echo $lang_var_admin_282; ?></td>
                                        <td style="text-align: center;"><?php echo $records_topics_count; ?></td>
                                        <td style="text-align: center;"
                                            title="">-
                                        </td>
                                        <td style="text-align: center;">-</td>
                                        <td style="text-align: center;">
                                            <?php if ($records_topics_count > 0) { ?>
                                                <a target="_blank" href="template/export.php?act=newsletter"
                                                   class="btn  btn-sm green"> <?php echo $lang_var_admin_210; ?> <i
                                                        class="fa fa-floppy-o"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php

                                    $sql_topics_count = mysql_query("SELECT * FROM " . $prefix . "_banars");
                                    $records_topics_count = mysql_num_rows($sql_topics_count);
                                    $sql_topics_last = mysql_query("SELECT edit_date,edit_by,edit_from FROM " . $prefix . "_banars order by edit_date desc limit 1");
                                    $data_topics_last = mysql_fetch_array($sql_topics_last);
                                    $edit_date = $data_topics_last['edit_date'];
                                    $edit_by = GetAdminUserName($data_topics_last['edit_by']);
                                    $edit_from = $data_topics_last['edit_from'];

                                    ?>

                                    <tr class="odd gradeX">
                                        <td><input type="checkbox" name="banars_multichkbx[]" class="checkboxes"
                                                   value="<?php echo $data_retrive['ws_id']; ?>"/></td>
                                        <td><i class="fa fa-bookmark-o"></i> <?php echo $lang_var_admin_153; ?></td>
                                        <td style="text-align: center;"><?php echo $records_topics_count; ?></td>
                                        <td style="text-align: center;"
                                            title="<?php echo FormatDateTimeLong(stripslashes($edit_date)); ?>"><?php echo FormatDateTime(stripslashes($edit_date)); ?></td>
                                        <td style="text-align: center;"
                                            title="IP: <?php echo $edit_from; ?>"><?php echo $edit_by; ?></td>
                                        <td style="text-align: center;">
                                            <?php if ($records_topics_count > 0) { ?>
                                                <a target="_blank" href="template/export.php?act=banars"
                                                   class="btn  btn-sm green"> <?php echo $lang_var_admin_210; ?> <i
                                                        class="fa fa-floppy-o"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php


                                    $sql_topics_count = mysql_query("SELECT * FROM " . $prefix . "_calendar");
                                    $records_topics_count = mysql_num_rows($sql_topics_count);
                                    $sql_topics_last = mysql_query("SELECT edit_date,edit_by,edit_from FROM " . $prefix . "_calendar order by edit_date desc limit 1");
                                    $data_topics_last = mysql_fetch_array($sql_topics_last);
                                    $edit_date = $data_topics_last['edit_date'];
                                    $edit_by = GetAdminUserName($data_topics_last['edit_by']);
                                    $edit_from = $data_topics_last['edit_from'];

                                    ?>

                                    <tr class="odd gradeX">
                                        <td><input type="checkbox" name="calendar_multichkbx[]" class="checkboxes"
                                                   value="<?php echo $data_retrive['ws_id']; ?>"/></td>
                                        <td><i class="fa fa-calendar"></i> <?php echo $lang_var_admin_195; ?></td>
                                        <td style="text-align: center;"><?php echo $records_topics_count; ?></td>
                                        <td style="text-align: center;"
                                            title="<?php echo FormatDateTimeLong(stripslashes($edit_date)); ?>"><?php echo FormatDateTime(stripslashes($edit_date)); ?></td>
                                        <td style="text-align: center;"
                                            title="IP: <?php echo $edit_from; ?>"><?php echo $edit_by; ?></td>
                                        <td style="text-align: center;">
                                            <?php if ($records_topics_count > 0) { ?>
                                                <a target="_blank" href="template/export.php?act=calendar"
                                                   class="btn  btn-sm green"> <?php echo $lang_var_admin_210; ?> <i
                                                        class="fa fa-floppy-o"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>


                                    </tbody>
                                </table>
                                <a href="javascript:;" class="btn btn-sm red" id="confirmation_box_for_delete"
                                   onclick="multicheckfrm.clicked_btn.value='b_empty';"><i
                                        class="fa fa-trash-o"></i> <?php echo $lang_var_admin_211; ?></a>
                                <input type="hidden" name="clicked_btn" size="78" value=""/>
                            </form>
                        </div>

                        <?php
                        //   ----------- PAGE END

                        ?>

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
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="assets/plugins/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/data-tables/DT_bootstrap.js"></script>

    <script type="text/javascript" src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
    <script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-markdown/lib/markdown.js"></script>

    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/scripts/core/app.js"></script>
    <script src="assets/scripts/custom/table-managed.js"></script>
    <script src="assets/scripts/custom/form-validation.js"></script>
    <script src="assets/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="assets/scripts/custom/ui-alert-dialog-api.js"></script>
    <script>
        jQuery(document).ready(function () {
            App.init();
            UIAlertDialogApi.init();
            TableManaged.init();
        });
    </script>
    </body>
    <!-- END BODY -->
    </html>
    <?php
} else {
    header("Location: 404.php");
    exit();
}
require_once("template/page_end.php");
?>