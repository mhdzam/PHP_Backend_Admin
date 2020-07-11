<?php

require_once("template/page_start.php");
if ($site_banars_status == 1) {
//--------
    $id = @$_GET['id'];
    $bs_id = @$_GET['bs_id'];
//$lang = @$_GET['lang'];
    $clicked_btn = @$_POST['clicked_btn'];
//-------
    $banar_title_en = mysql_real_escape_string(@$_POST['banar_title_en']);
    $banar_title_ar = mysql_real_escape_string(@$_POST['banar_title_ar']);

    $banar_details_ar = mysql_real_escape_string(@$_POST['banar_details_ar']);
    $banar_details_en = mysql_real_escape_string(@$_POST['banar_details_en']);
    $banar_video_type = mysql_real_escape_string(@$_POST['banar_video_type']);
    $banar_youtube_link = mysql_real_escape_string(@$_POST['banar_youtube_link']);
    $banar_url = mysql_real_escape_string(@$_POST['banar_url']);
    $banar_code = mysql_real_escape_string(@$_POST['banar_code']);

    $father_id = mysql_real_escape_string(@$_POST['father_id']);
    $banar_file_ar = mysql_real_escape_string(@$_POST['banar_file_ar']);
    $banar_file_en = mysql_real_escape_string(@$_POST['banar_file_en']);
    $file_del = mysql_real_escape_string(@$_POST['file_del']);
    $file_del2 = mysql_real_escape_string(@$_POST['file_del2']);


    $up_dir = "../uploads/baners/";
    $file_name = @$_FILES['myfile']['name'];
    $file_temp_name = @$_FILES['myfile']['tmp_name'];
    $file_size = $up_dir . @$_FILES['myfile']['size'];

    $file_name2 = @$_FILES['myfile2']['name'];
    $file_temp_name2 = @$_FILES['myfile2']['tmp_name'];
    $file_size2 = $up_dir . @$_FILES['myfile2']['size'];

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
                        <h3 class="page-title"><?php echo $lang_var_admin_153; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_153; ?></a>
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


                        ?>

                        <?php
                        $multichkbx = @$_POST['multichkbx'];
                        $all_multichkbx = "";
                        if ($clicked_btn == "b_saveorder") {
                            $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_banars");
                            while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                $inm = "row_no" . "$data_delete_who[banar_id]";
                                $row_no = @$_POST[$inm];
                                $sql_sveorder = mysql_query("UPDATE " . $prefix . "_banars SET row_no='$row_no' WHERE banar_id='$data_delete_who[banar_id]'") or die (mysql_error());
                                if ($sql_sveorder) {
                                    $actin_done = 1;
                                }
                            }


                        }
                        if ($multichkbx != "") {
                            while (list($key, $val) = @each($multichkbx)) {
                                $all_multichkbx .= "$val,";
                            }
                            $multichkbx = substr($all_multichkbx, 0, -1);
                            //-------------
                            $actin_done = 0;
                            if ($clicked_btn == "b_active") {
                                $sql_active = mysql_query("UPDATE " . $prefix .
                                    "_banars SET banar_status=1 WHERE banar_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_active) {
                                    $actin_done = 1;
                                }


                            } elseif ($clicked_btn == "b_block") {

                                $sql_block = mysql_query("UPDATE " . $prefix .
                                    "_banars SET banar_status=0 WHERE banar_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_block) {
                                    $actin_done = 1;
                                }

                            } elseif ($clicked_btn == "b_delete") {
                                $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_banars where banar_id  in ($multichkbx)");
                                while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                    if ($data_delete_who['banar_file_ar'] != "") {
                                        @unlink("$up_dir" . "$data_delete_who[banar_file_ar]");
                                    }
                                    if ($data_delete_who['banar_file_en'] != "") {
                                        @unlink("$up_dir" . "$data_delete_who[banar_file_en]");
                                    }
                                }
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix .
                                    "_banars where banar_id in ($multichkbx)");
                                if ($sql_delete) {
                                    $actin_done = 1;
                                }

                            }
                            if ($actin_done == 1) {
                                ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <?php echo $lang_var_admin_25; ?>
                                </div>
                                <?php
                            }

                        }

                        if ($act == "insert" && $banar_title_en != "") {

                            // --- upload
                            $banar_file_ar = "";
                            if ($file_name != "") {
                                $ext = strrchr($file_name, ".");
                                $ext = strtolower($ext);
                                $xrand = time() . rand(1111, 9999);
                                $file_name = $up_dir . $xrand . $ext;
                                if (!in_array($ext, $allowed_imgs_type)) {
                                    ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true"></button>
                                        [ <?php echo $ext; ?> ] <?php echo $lang_var_admin_27; ?>
                                    </div>
                                    <?php
                                } else {
                                    list($tmp_file_width, $tmp_file_height) = @getimagesize($file_temp_name);
                                    if ($tmp_file_width > 0 && $tmp_file_height > 0) {
                                        if (move_uploaded_file($file_temp_name, $file_name)) {
                                            $banar_file_ar = $xrand . $ext;
                                        }
                                    }
                                }
                            }
                            // --- upload 2
                            $banar_file_en = "";
                            if ($file_name2 != "") {
                                $ext2 = strrchr($file_name2, ".");
                                $ext2 = strtolower($ext2);
                                $xrand2 = time() . rand(1111, 9999);
                                $file_name2 = $up_dir . $xrand2 . $ext2;
                                if (!in_array($ext2, $allowed_imgs_type)) {
                                    ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true"></button>
                                        [ <?php echo $ext2; ?> ] <?php echo $lang_var_admin_27; ?>
                                    </div>
                                    <?php
                                } else {
                                    list($tmp_file_width2, $tmp_file_height2) = @getimagesize($file_temp_name2);
                                    if ($tmp_file_width2 > 0 && $tmp_file_height2 > 0) {
                                        if (move_uploaded_file($file_temp_name2, $file_name2)) {
                                            $banar_file_en = $xrand2 . $ext2;
                                        }
                                    }
                                }
                            }
                            $r = "select max(row_no)  from " . $prefix . "_banars";
                            $sqlr = mysql_query($r);
                            $rr = mysql_fetch_array($sqlr);
                            $row = $rr[0] + 1;

                            $sql_slct_max = mysql_query("select max(banar_id)  from " . $prefix .
                                "_banars");
                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                            $next_banar_id = $data_slct_max[0] + 1;
                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_banars (
  banar_id,
  banar_title_ar,
  banar_title_en,
  banar_details_ar,
  banar_details_en,
  bs_id,
  banar_file_ar,
  banar_file_en,  
  banar_status,
  banar_video_type,
  banar_youtube_link,
  banar_url,
  banar_code,
  edit_by,  
  edit_date,
  edit_from,
  row_no,
  visits) VALUES ('$next_banar_id','$banar_title_ar','$banar_title_en','$banar_details_ar','$banar_details_en','$bs_id','$banar_file_ar','$banar_file_en','1','$banar_video_type','$banar_youtube_link','$banar_url','$banar_code','$pd_admin_user_id',now(),'$pd_admin_ip','$row','0')");

                            if ($sql_insert_new) {

                                // insert notification
                                $note_title_ar = ($lang_var_admin_397 . ": " . $banar_title_ar);
                                $note_title_en = ($lang_var_admin_398 . ": " . $banar_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-success'>
                            <i class='fa fa-tags'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("banars.php?id=$next_banar_id&act=update");

                                require_once("template/notifications_insert.php");
                                // end of insert notification

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
                        if ($act == "saveupdate" && $banar_title_en != "" && $id != "") {

                            // --- upload
                            if ($file_del == 1) {
                                @unlink("$up_dir" . "$banar_file_ar");
                                $banar_file_ar = "";
                            }
                            if ($file_name != "") {
                                if ($banar_file_ar != "") {
                                    @unlink("$up_dir" . "$banar_file_ar");
                                }
                                $ext = strrchr($file_name, ".");
                                $ext = strtolower($ext);
                                $xrand = time() . rand(1111, 9999);
                                $file_name = $up_dir . $xrand . $ext;
                                if (!in_array($ext, $allowed_imgs_type)) {
                                    ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true"></button>
                                        [ <?php echo $ext; ?> ] <?php echo $lang_var_admin_27; ?>
                                    </div>
                                    <?php
                                } else {
                                    list($tmp_file_width, $tmp_file_height) = @getimagesize($file_temp_name);
                                    if ($tmp_file_width > 0 && $tmp_file_height > 0) {
                                        if (move_uploaded_file($file_temp_name, $file_name)) {
                                            $banar_file_ar = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            // --- upload
                            if ($file_del2 == 1) {
                                @unlink("$up_dir" . "$banar_file_en");
                                $banar_file_en = "";
                            }
                            if ($file_name2 != "") {
                                $ext2 = strrchr($file_name2, ".");
                                $ext2 = strtolower($ext2);
                                $xrand2 = time() . rand(1111, 9999);
                                $file_name2 = $up_dir . $xrand2 . $ext2;
                                if (!in_array($ext2, $allowed_imgs_type)) {
                                    ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true"></button>
                                        [ <?php echo $ext2; ?> ] <?php echo $lang_var_admin_27; ?>
                                    </div>
                                    <?php
                                } else {
                                    list($tmp_file_width2, $tmp_file_height2) = @getimagesize($file_temp_name2);
                                    if ($tmp_file_width2 > 0 && $tmp_file_height2 > 0) {
                                        if (move_uploaded_file($file_temp_name2, $file_name2)) {
                                            $banar_file_en = $xrand2 . $ext2;
                                        }
                                    }
                                }
                            }

                            $sql_update = mysql_query("UPDATE " . $prefix . "_banars SET banar_title_ar='$banar_title_ar',banar_title_en='$banar_title_en',banar_details_ar='$banar_details_ar',banar_details_en='$banar_details_en',bs_id='$bs_id',banar_file_ar='$banar_file_ar',banar_file_en='$banar_file_en',banar_youtube_link='$banar_youtube_link',banar_url='$banar_url',banar_code='$banar_code',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip' WHERE banar_id='$id'") or
                            die(mysql_error());

                            if ($sql_update) {

                                // insert notification
                                $note_title_ar = ($lang_var_admin_399 . ": " . $banar_title_ar);
                                $note_title_en = ($lang_var_admin_400 . ": " . $banar_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-info'>
                            <i class='fa fa-tags'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("banars.php?id=$id&act=update");
                                require_once("template/notifications_insert.php");
                                // end of insert notification
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

                        if ($act == "update") {
                            $sql_modify = mysql_query("SELECT * FROM " . $prefix . "_banars  WHERE banar_id ='$id' ");
                            $data_modify = mysql_fetch_array($sql_modify);
                            $banar_title_ar = stripcslashes($data_modify['banar_title_ar']);
                            $banar_title_en = stripcslashes($data_modify['banar_title_en']);
                            $banar_details_ar = stripcslashes($data_modify['banar_details_ar']);
                            $banar_details_en = stripcslashes($data_modify['banar_details_en']);
                            $banar_file_ar = stripcslashes($data_modify['banar_file_ar']);
                            $banar_file_en = stripcslashes($data_modify['banar_file_en']);
                            $bs_id = stripcslashes($data_modify['bs_id']);
                            $banar_url = stripcslashes($data_modify['banar_url']);
                            $banar_code = stripcslashes($data_modify['banar_code']);

                            $edit_date = $data_modify['edit_date'];
                            $edit_by = GetAdminUserName($data_modify['edit_by']);
                            $edit_from = $data_modify['edit_from'];


                            $sql_get_sections = mysql_query("SELECT * FROM " . $prefix . "_banars_sections  WHERE bs_status=1 and bs_id ='$bs_id'");
                            $data_get_sections = mysql_fetch_array($sql_get_sections);
                            $bs_name_var = stripcslashes($data_get_sections['bs_name_var']);
                            $bs_name_var = @$$bs_name_var;
                            $bs_height = stripcslashes($data_get_sections['bs_height']);
                            $bs_width = stripcslashes($data_get_sections['bs_width']);
                            $bs_period = stripcslashes($data_get_sections['bs_period']);
                            $bs_desc_status = stripcslashes($data_get_sections['bs_desc_status']);
                            $bs_link_status = stripcslashes($data_get_sections['bs_link_status']);
                            $bs_type = stripcslashes($data_get_sections['bs_type']);

                            ?>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_6; ?>
                                        : <?php echo $bs_name_var; ?>
                                        ( <?php echo $lang_var_admin_145; ?>: <?php echo $bs_width; ?>
                                        * <?php echo $bs_height; ?> PX )
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="?bs_id=<?php echo $bs_id; ?>&id=<?php echo $id; ?>&act=saveupdate"
                                          method="post"
                                          class="form-horizontal" enctype="multipart/form-data">
                                        <div class="form-body">

                                            <?php if ($site_ar_box_status != 0) { ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_88; ?>  <?php echo $ar_lang_icon; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <input type="text" name="banar_title_ar" required=""
                                                               value="<?php echo $banar_title_ar; ?>"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <?php if ($site_en_box_status != 0) { ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_88; ?> <?php echo $en_lang_icon; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <input type="text" name="banar_title_en" required=""
                                                               value="<?php echo $banar_title_en; ?>"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($bs_type == 1) {
                                                ?>
                                                <?php if ($site_ar_box_status != 0) { ?>
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-3"><?php echo $lang_var_admin_146; ?><?php echo $ar_lang_icon; ?></label>

                                                        <div class="col-md-4">
                                                            <input type="file" name="myfile" class="form-control"/>
                                                            <input type="hidden" name="banar_file_ar"
                                                                   id="file_hidden_var"
                                                                   value="<?php echo $banar_file_ar; ?>"/>
                                                            <input type="hidden" name="file_del" id="file_del_var"
                                                                   value="0"/>
                                                            <?php
                                                            if ($banar_file_ar != "") {
                                                                ?>
                                                                <div id="file_show_div">
                                                                    <div><img
                                                                            src="<?php echo "$up_dir" . "$banar_file_ar"; ?>"
                                                                            style="max-width: 100%;margin: 5px 0;"/>
                                                                    </div>
                                                                    <a href="javascript:;"
                                                                       onclick="delete_file_onedit()"><span
                                                                            id="sample_editable_1_new"
                                                                            class="btn default"><i
                                                                                class="fa fa-times"></i> <?php echo $lang_var_admin_19; ?> </span></a>
                                                                </div>
                                                                <div id="file_undo_div" style="display: none;">
                                                                    <a href="javascript:;"
                                                                       onclick="undo_delete_file_onedit()"><i
                                                                            class="fa fa-undo"></i> <?php echo $lang_var_admin_20; ?>
                                                                    </a>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <span class="help-block">e.g: .png, .jpeg, .jpg, .gif</span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php if ($site_en_box_status != 0) { ?>
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-3"><?php echo $lang_var_admin_146; ?><?php echo $en_lang_icon; ?></label>

                                                        <div class="col-md-4">
                                                            <input type="file" name="myfile2" class="form-control"/>
                                                            <input type="hidden" name="banar_file_en"
                                                                   id="file_hidden_var2"
                                                                   value="<?php echo $banar_file_en; ?>"/>
                                                            <input type="hidden" name="file_del2" id="file_del_var2"
                                                                   value="0"/>
                                                            <?php
                                                            if ($banar_file_en != "") {
                                                                ?>
                                                                <div id="file_show_div2">
                                                                    <div><img
                                                                            src="<?php echo "$up_dir" . "$banar_file_en"; ?>"
                                                                            style="max-width: 100%;margin: 5px 0;"/>
                                                                    </div>
                                                                    <a href="javascript:;"
                                                                       onclick="delete_file_onedit2()"><span
                                                                            id="sample_editable_1_new"
                                                                            class="btn default"><i
                                                                                class="fa fa-times"></i> <?php echo $lang_var_admin_19; ?> </span></a>
                                                                </div>
                                                                <div id="file_undo_div2" style="display: none;">
                                                                    <a href="javascript:;"
                                                                       onclick="undo_delete_file_onedit2()"><i
                                                                            class="fa fa-undo"></i> <?php echo $lang_var_admin_20; ?>
                                                                    </a>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <span class="help-block">e.g: .png, .jpeg, .jpg, .gif</span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                            } elseif ($bs_type == 0) {
                                                /*  ?>
                                                  <div class="form-group">
                                                      <label
                                                          class="control-label col-md-3"><?php echo $lang_var_admin_103; ?>
                                                          <span
                                                              class="required">*</span></label>

                                                      <div class="col-md-7" dir="rtl">
                                  <textarea name="banar_code" rows="5"
                                            class="form-control"><?php echo $banar_code; ?></textarea>
                                                      </div>
                                                  </div>
                                                  <?php */
                                            } else {
                                                ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_157; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-7">
                                                        <div class="radio-list">
                                                            <label><input type="radio" name="a_type" value="0"
                                                                          checked="checked"
                                                                          onclick="document.getElementById('tbodyid1').style.display = 'block';document.getElementById('tbodyid2').style.display = 'none';"/> <?php echo $lang_var_admin_120; ?>
                                                            </label>
                                                            <label><input type="radio" name="a_type" value="1"
                                                                          onclick="document.getElementById('tbodyid1').style.display = 'none';document.getElementById('tbodyid2').style.display = 'block';"/> <?php echo $lang_var_admin_121; ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="tbodyid1">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_158; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-7">
                                                        <input type="text" dir="ltr" name="youtube_links"
                                                               class="form-control"/>

                                                    </div>
                                                </div>

                                                <div class="form-group" id="tbodyid2" style="display: none;">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_117; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-7">
                                                        <div class="input-append">
                                                            <input type="text" name="topic_video_file" dir="ltr"
                                                                   id="topic_video_file"
                                                                   class="form-control">
                                                            <a href="javascript:;"
                                                               onclick="moxman.browse({fields: 'topic_video_file', extensions:'mp4,ogv,webm', no_host: true});"
                                                               class="btn">Pick file</a>
                                                        </div>
                                                        <span class="help-block">e.g: .mp4, .ogv, .webm</span>
                                                    </div>
                                                </div>

                                                <?php
                                            }
                                            if ($bs_link_status == 1) {
                                                ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_156; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-7">
                                                        <input type="text" name="banar_url"
                                                               value="<?php echo $banar_url; ?>"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            if ($bs_desc_status == 1) {
                                                ?>
                                                <?php if ($site_ar_box_status != 0) { ?>
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-3"><?php echo $lang_var_admin_103; ?>  <?php echo $ar_lang_icon; ?>
                                                            <span class="required">*</span></label>

                                                        <div class="col-md-7" dir="rtl">
                                <textarea name="banar_details_ar" rows="3"
                                          class="form-control"><?php echo $banar_details_ar; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php if ($site_en_box_status != 0) { ?>
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-3"><?php echo $lang_var_admin_103; ?> <?php echo $en_lang_icon; ?>
                                                            <span class="required">*</span></label>

                                                        <div class="col-md-7" dir="ltr">
                                <textarea name="banar_details_en" rows="3"
                                          class="form-control"><?php echo $banar_details_en; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                            }
                                            ?>


                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit"
                                                        class="btn green"><?php echo $lang_var_admin_21; ?></button>
                                                &nbsp;
                                                <a href="?wm_section=<?php echo $wm_section; ?>">
                                                    <button type="button"
                                                            class="btn default"><?php echo $lang_var_admin_22; ?></button>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END FORM-->
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>

                            <?php
                        } elseif ($act == "new" && $bs_id != "" && $bs_id != 0) {

                            $sql_get_sections = mysql_query("SELECT * FROM " . $prefix . "_banars_sections  WHERE bs_status=1 and bs_id ='$bs_id'");
                            $data_get_sections = mysql_fetch_array($sql_get_sections);
                            $bs_name_var = stripcslashes($data_get_sections['bs_name_var']);
                            $bs_name_var = @$$bs_name_var;
                            $bs_height = stripcslashes($data_get_sections['bs_height']);
                            $bs_width = stripcslashes($data_get_sections['bs_width']);
                            $bs_period = stripcslashes($data_get_sections['bs_period']);
                            $bs_desc_status = stripcslashes($data_get_sections['bs_desc_status']);
                            $bs_link_status = stripcslashes($data_get_sections['bs_link_status']);
                            $bs_type = stripcslashes($data_get_sections['bs_type']);

                            ?>

                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-plus"></i> <?php echo $lang_var_admin_154; ?>
                                        : <?php echo $bs_name_var; ?>
                                        ( <?php echo $lang_var_admin_145; ?>: <?php echo $bs_width; ?>
                                        * <?php echo $bs_height; ?> PX )
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="?bs_id=<?php echo $bs_id; ?>&act=insert" method="post"
                                          class="form-horizontal"
                                          enctype="multipart/form-data">
                                        <div class="form-body">

                                            <?php if ($site_ar_box_status != 0) { ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_155; ?>  <?php echo $ar_lang_icon; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-7">
                                                        <input type="text" name="banar_title_ar" required=""
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <?php if ($site_en_box_status != 0) { ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_155; ?> <?php echo $en_lang_icon; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-7">
                                                        <input type="text" name="banar_title_en" required=""
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($bs_type == 1) {
                                                ?>
                                                <?php if ($site_ar_box_status != 0) { ?>
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-3"><?php echo $lang_var_admin_146; ?><?php echo $ar_lang_icon; ?></label>

                                                        <div class="col-md-7">
                                                            <input type="file" name="myfile" class="form-control"/>
                                                            <span class="help-block">e.g: .png, .jpeg, .jpg, .gif</span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php if ($site_en_box_status != 0) { ?>
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-3"><?php echo $lang_var_admin_146; ?><?php echo $en_lang_icon; ?></label>

                                                        <div class="col-md-7">
                                                            <input type="file" name="myfile2" class="form-control"/>
                                                            <span class="help-block">e.g: .png, .jpeg, .jpg, .gif</span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                            } elseif ($bs_type == 0) {
                                                /* ?>
                                                 <div class="form-group">
                                                     <label
                                                         class="control-label col-md-3"><?php echo $lang_var_admin_103; ?>
                                                         <span
                                                             class="required">*</span></label>

                                                     <div class="col-md-7" dir="rtl">
                                                         <textarea name="banar_code" rows="5"
                                                                   class="form-control"></textarea>
                                                     </div>
                                                 </div>
                                                 <?php */
                                            } else {
                                                ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_157; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-7">
                                                        <div class="radio-list">
                                                            <label><input type="radio" name="a_type" value="0"
                                                                          checked="checked"
                                                                          onclick="document.getElementById('tbodyid1').style.display = 'block';document.getElementById('tbodyid2').style.display = 'none';"/> <?php echo $lang_var_admin_120; ?>
                                                            </label>
                                                            <label><input type="radio" name="a_type" value="1"
                                                                          onclick="document.getElementById('tbodyid1').style.display = 'none';document.getElementById('tbodyid2').style.display = 'block';"/> <?php echo $lang_var_admin_121; ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="tbodyid1">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_158; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-7">
                                                        <input type="text" dir="ltr" name="youtube_links"
                                                               class="form-control"/>

                                                    </div>
                                                </div>

                                                <div class="form-group" id="tbodyid2" style="display: none;">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_117; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-7">
                                                        <div class="input-append">
                                                            <input type="text" name="topic_video_file" dir="ltr"
                                                                   id="topic_video_file"
                                                                   class="form-control">
                                                            <a href="javascript:;"
                                                               onclick="moxman.browse({fields: 'topic_video_file', extensions:'mp4,ogv,webm', no_host: true});"
                                                               class="btn">Pick file</a>
                                                        </div>
                                                        <span class="help-block">e.g: .mp4, .ogv, .webm</span>
                                                    </div>
                                                </div>

                                                <?php
                                            }
                                            if ($bs_link_status == 1) {
                                                ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_156; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-7">
                                                        <input type="text" name="banar_url" dir="ltr"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            if ($bs_desc_status == 1) {
                                                ?>
                                                <?php if ($site_ar_box_status != 0) { ?>
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-3"><?php echo $lang_var_admin_103; ?>  <?php echo $ar_lang_icon; ?>
                                                            <span class="required">*</span></label>

                                                        <div class="col-md-7" dir="rtl">
                                                        <textarea name="banar_details_ar" rows="3"
                                                                  class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php if ($site_en_box_status != 0) { ?>
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label col-md-3"><?php echo $lang_var_admin_103; ?> <?php echo $en_lang_icon; ?>
                                                            <span class="required">*</span></label>

                                                        <div class="col-md-7" dir="ltr">
                                                        <textarea name="banar_details_en" rows="3"
                                                                  class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit"
                                                        class="btn green"><?php echo $lang_var_admin_23; ?></button>
                                                &nbsp;
                                                <a href="?wm_section=<?php echo $wm_section; ?>">
                                                    <button type="button"
                                                            class="btn default"><?php echo $lang_var_admin_22; ?></button>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END FORM-->
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>

                            <?php
                        } else {
                            ?>
                            <div>
                                <form name="multicheckfrm" id="multicheckfrm" method="post"
                                      action="?wm_section=<?php echo $wm_section; ?>">
                                    <div class="table-toolbar">
                                        <?php
                                        if ($logged_allow_add_status == 1) {
                                            ?>
                                            <div class="btn-group">
                                                <?php
                                                $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_banars_sections where bs_status=1 order by bs_id");
                                                $page_father_count = mysql_num_rows($sql_father_retrive);
                                                if ($page_father_count > 0) {
                                                    ?>
                                                    <button class="btn dropdown-toggle green" data-toggle="dropdown"
                                                            style="min-width: 182px;">
                                                        <i class="fa fa-plus"></i> <?php echo $lang_var_admin_94; ?> <i
                                                            class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul class="dropdown-menu pull-right" style="min-width: 182px;">
                                                        <?php

                                                        while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                            ?>
                                                            <li>
                                                                <a href="?bs_id=<?php echo $data_father_retrive['bs_id']; ?>&act=new"><?php echo $$data_father_retrive['bs_name_var']; ?>
                                                                    <small>
                                                                        (<?php echo $data_father_retrive['bs_width']; ?>
                                                                        * <?php echo $data_father_retrive['bs_height']; ?>
                                                                        )
                                                                    </small>
                                                                </a></li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($logged_allow_edit_status == 1) {
                                            ?>
                                            <div class="btn-group pull-right">
                                                <button class="btn dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fa fa-th-large"></i> <?php echo $lang_var_admin_29; ?> <i
                                                        class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu pull-right">
                                                    <li><a href="javascript:;"
                                                           onclick="multicheckfrm.clicked_btn.value='b_active';document.getElementById('multicheckfrm').submit();"><i
                                                                class="fa fa-check"></i> <?php echo $lang_var_admin_30; ?>
                                                        </a></li>
                                                    <li><a href="javascript:;"
                                                           onclick="multicheckfrm.clicked_btn.value='b_block';document.getElementById('multicheckfrm').submit();"><i
                                                                class="fa fa-times"></i> <?php echo $lang_var_admin_31; ?>
                                                        </a></li>
                                                    <?php
                                                    if ($logged_allow_delete_status == 1) {
                                                        ?>
                                                        <li><a href="javascript:;" id="confirmation_box_for_delete"
                                                               onclick="multicheckfrm.clicked_btn.value='b_delete';"><i
                                                                    class="fa fa-trash-o"></i> <?php echo $lang_var_admin_32; ?>
                                                            </a></li>
                                                        <?php
                                                    }
                                                    ?>
                                                    <input type="hidden" name="clicked_btn" size="78" value=""/>
                                                </ul>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th class="table-checkbox" style="width: 3%;">
                                                <input type="checkbox" class="checkall"/>
                                            </th>
                                            <th><?php echo $lang_var_admin_213; ?></th>
                                            <th style="width: 7%;text-align: center;"><?php echo $lang_var_admin_89; ?></th>
                                            <th style="width: 5%;text-align: center;"><?php echo $lang_var_admin_4; ?></th>
                                            <?php
                                            if ($logged_allow_edit_status == 1) {
                                                ?>
                                                <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_5; ?></th>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_banars order by row_no, banar_id");
                                        $page_records_count = mysql_num_rows($sql_retrive);
                                        if ($page_records_count == 0) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td colspan="5" style="text-align: center;">
                                                    <small><?php echo $lang_var_admin_93; ?></small>
                                                </td>

                                            </tr>
                                            <?php
                                        } else {

                                            while ($data_retrive = mysql_fetch_array($sql_retrive)) {
                                                if ($data_retrive['banar_status'] == 1) {
                                                    $active_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                                } else {
                                                    $active_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                                }
                                                $banar_file_ar = "";
                                                if ($data_retrive['banar_file_ar'] != "") {
                                                    $banar_file_ar = "<div class='pull-right'><img src='$up_dir" . "$data_retrive[banar_file_ar]' style='width:70px;height:40px;margin:5px'></div>";
                                                } elseif ($data_retrive['banar_file_en'] != "") {
                                                    $banar_file_ar = "<div class='pull-right'><img src='$up_dir" . "$data_retrive[banar_file_en]' style='width:70px;height:40px;margin:5px'></div>";
                                                }

                                                $sql_get_sections = mysql_query("SELECT * FROM " . $prefix . "_banars_sections  WHERE bs_status=1 and bs_id ='$data_retrive[bs_id]'");
                                                $data_get_sections = mysql_fetch_array($sql_get_sections);
                                                $bs_name_var = stripcslashes($data_get_sections['bs_name_var']);
                                                $bs_name_var = @$$bs_name_var;
                                                $bs_height = stripcslashes($data_get_sections['bs_height']);
                                                $bs_width = stripcslashes($data_get_sections['bs_width']);
                                                $bs_period = stripcslashes($data_get_sections['bs_period']);
                                                $bs_desc_status = stripcslashes($data_get_sections['bs_desc_status']);
                                                $bs_link_status = stripcslashes($data_get_sections['bs_link_status']);
                                                $bs_type = stripcslashes($data_get_sections['bs_type']);

                                                ?>
                                                <tr class="odd gradeX">
                                                    <td>
                                                        <input type="checkbox" name="multichkbx[]" class="checkboxes"
                                                               value="<?php echo
                                                               $data_retrive['banar_id']; ?>"/>
                                                    </td>
                                                    <td><input type="text"
                                                               name="row_no<?php echo $data_retrive['banar_id'] ?>"
                                                               style="width: 30px;text-align: center;font-size: 11px;"
                                                               value="<?php echo $data_retrive['row_no'] ?>">
                                                        &nbsp;<strong><?php echo $banar_file_ar . stripslashes($data_retrive['banar_title_ar']); ?></strong>

                                                        <div>
                                                            <small><?php echo $bs_name_var; ?>
                                                                ( <?php echo $lang_var_admin_145; ?>
                                                                : <?php echo $bs_width; ?> * <?php echo $bs_height; ?>
                                                                PX )
                                                            </small>
                                                        </div>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <small><?php echo stripslashes($data_retrive['visits']); ?></small>
                                                    </td>
                                                    <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                    <?php
                                                    if ($logged_allow_edit_status == 1) {
                                                        ?>
                                                        <td style="text-align: center;"><a
                                                                href="?wm_section=<?php echo $wm_section; ?>&id=<?php echo $data_retrive['banar_id']; ?>&act=update"
                                                                class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?>
                                                                <i
                                                                    class="fa fa-edit"></i></a></td>
                                                        <?php
                                                    }
                                                    ?>
                                                </tr>
                                                <?php

                                            }

                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    if ($logged_allow_edit_status == 1) {
                                        ?>
                                        <?php
                                        if ($page_records_count > 0) {
                                            ?>
                                            <a href="javascript:;" class="btn btn-sm default"
                                               onclick="multicheckfrm.clicked_btn.value='b_saveorder';document.getElementById('multicheckfrm').submit();"><?php echo $lang_var_admin_92; ?></a>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    }
                                    ?>
                                </form>
                            </div>
                            <?php
                        }
                        ?>

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


    <link type="text/css" rel="stylesheet"
          href="assets/plugins/tinymce/plugins/moxiemanager/skins/lightgray/skin.min.css"/>
    <script src="assets/plugins/tinymce/plugins/moxiemanager/js/moxman.api.min.js"></script>
    <script src="assets/plugins/tinymce/plugins/moxiemanager/api.php?action=PluginJs"></script>


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
    header("Location: index.php");
}
require_once("template/page_end.php");
?>