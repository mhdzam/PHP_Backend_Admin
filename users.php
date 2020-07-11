<?php

require_once("template/page_start.php");
//--------
$id = @$_GET['id'];
$clicked_btn = @$_POST['clicked_btn'];
//-------
$user_name = mysql_real_escape_string(@$_POST['user_name']);
$user_email = mysql_real_escape_string(@$_POST['user_email']);
$this_user_password = @base64_encode(mysql_real_escape_string(@$_POST['this_user_password']));
$lang_dir = mysql_real_escape_string(@$_POST['lang_dir']);
$user_fullname = mysql_real_escape_string(@$_POST['user_fullname']);
$user_photo = mysql_real_escape_string(@$_POST['this_user_photo']);
$file_del = mysql_real_escape_string(@$_POST['file_del']);
$control_type = mysql_real_escape_string(@$_POST['control_type']);

$up_dir = "../uploads/";
$file_name = @$_FILES['myfile']['name'];
$file_temp_name = @$_FILES['myfile']['tmp_name'];
$file_size = $up_dir . @$_FILES['myfile']['size'];

$control_filter = "";
if ($logged_admin_control_type != 0) {
    $control_filter = "and control_type!=0";
}
if ($logged_admin_control_type != 0 && $logged_admin_control_type != 1) {
    $control_type = $logged_admin_control_type;
    $control_filter = "and control_type!=0 and user_id='$pd_admin_user_id'";
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
                        <h3 class="page-title"><?php echo $lang_var_admin_33; ?> </h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_33; ?></a>
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
                        if ($multichkbx != "") {
                            while (list($key, $val) = @each($multichkbx)) {
                                $all_multichkbx .= "$val,";
                            }
                            $multichkbx = substr($all_multichkbx, 0, -1);
                            //-------------
                            $actin_done = 0;
                            if ($clicked_btn == "b_active") {
                                $sql_active = mysql_query("UPDATE " . $prefix .
                                    "_users SET user_status=1 WHERE user_id in ($multichkbx) and user_id not in (1,2) $control_filter") or die(mysql_error
                                ());
                                if ($sql_active) {
                                    $actin_done = 1;
                                }


                            } elseif ($clicked_btn == "b_block") {

                                $sql_block = mysql_query("UPDATE " . $prefix .
                                    "_users SET user_status=0 WHERE user_id in ($multichkbx) and user_id not in (1,2) $control_filter") or die(mysql_error
                                ());
                                if ($sql_block) {
                                    $actin_done = 1;
                                }

                            } elseif ($clicked_btn == "b_delete") {
                                $sql_delete_who = mysql_query("SELECT * FROM " . $prefix .
                                    "_users where user_id  in ($multichkbx) and user_id not in (1,2) $control_filter");
                                while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                    if ($data_delete_who['user_photo'] != "") {
                                        @unlink("$up_dir" . "$data_delete_who[user_photo]");
                                    }
                                }
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix .
                                    "_users where user_id in ($multichkbx) and user_id not in (1,2) $control_filter");
                                if ($sql_delete) {
                                    $actin_done = 1;
                                    // insert notification
                                    $note_title_ar = ($lang_var_admin_395);
                                    $note_title_en = ($lang_var_admin_396);
                                    $note_icon = mysql_real_escape_string("<div class='label label-sm label-default'>
                            <i class='fa fa-trash-o'></i>
                        </div>");
                                    $note_url = "";

                                    require_once("template/notifications_insert.php");
                                    // end of insert notification
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

                        if ($act == "insert" && $user_name != "") {

                            $sql_sam_var = mysql_query("SELECT user_id FROM " . $prefix . "_users where user_email ='$user_email'");
                            $sam_var_records_count = mysql_num_rows($sql_sam_var);
                            if ($sam_var_records_count > 0) {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <?php echo $lang_var_admin_28; ?>
                                </div>
                                <?php
                            } else {

                                // --- upload
                                $user_photo = "";
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
                                                $user_photo = $xrand . $ext;
                                            }
                                        }
                                    }
                                }

                                $sql_slct_max = mysql_query("select max(user_id)  from " . $prefix .
                                    "_users");
                                $data_slct_max = mysql_fetch_array($sql_slct_max);
                                $next_user_id = $data_slct_max[0] + 1;
                                $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_users (
  user_id,
  user_email,
  user_name,
  user_password,
  user_fullname,
  user_photo,
  user_status,
  control_type,
  edit_by,  
  edit_date,
  edit_from) VALUES ('$next_user_id','$user_email','$user_name','$this_user_password','$user_fullname','$user_photo','1','$control_type','$pd_admin_user_id',now(),'$pd_admin_ip')");

                                if ($sql_insert_new) {

                                    // insert notification
                                    $note_title_ar = ($lang_var_admin_393 . ": " . $user_name);
                                    $note_title_en = ($lang_var_admin_394 . ": " . $user_name);
                                    $note_icon = mysql_real_escape_string("<div class='label label-sm label-danger'>
                            <i class='fa fa-plus'></i>
                        </div>");
                                    $note_url = "";

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
                        }
                        if ($act == "saveupdate" && $user_name != "" && $id != "") {

                            $sql_sam_var = mysql_query("SELECT user_id FROM " . $prefix . "_users where user_email ='$user_email' and user_id!='$id'");
                            $sam_var_records_count = mysql_num_rows($sql_sam_var);
                            if ($sam_var_records_count > 0) {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <?php echo $lang_var_admin_28; ?>
                                </div>
                                <?php
                            } else {

                                // --- upload
                                if ($file_del == 1) {
                                    @unlink("$up_dir" . "$user_photo");
                                    $user_photo = "";
                                }
                                if ($file_name != "") {
                                    if ($user_photo != "") {
                                        @unlink("$up_dir" . "$user_photo");
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
                                                $user_photo = $xrand . $ext;
                                            }
                                        }
                                    }
                                }

                                $sql_update = mysql_query("UPDATE " . $prefix . "_users SET user_email='$user_email',user_name='$user_name',user_password='$this_user_password',user_fullname='$user_fullname',user_photo='$user_photo',control_type='$control_type',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip' WHERE user_id='$id' $control_filter") or
                                die(mysql_error());

                                if ($sql_update) {

                                    // insert notification
                                    $note_title_ar = ($lang_var_admin_391 . " " . $user_name);
                                    $note_title_en = ($lang_var_admin_392 . " " . $user_name);
                                    $note_icon = mysql_real_escape_string("<div class='label label-sm label-danger'>
                            <i class='fa fa-user'></i>
                        </div>");
                                    $note_url = "";

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

                                if ($logged_admin_control_type != 0 && $logged_admin_control_type != 1) {
                                    $act = "update";

                                }
                            }
                        }

                        if ($act == "update") {
                            $sql_modify = mysql_query("SELECT * FROM " . $prefix . "_users  WHERE user_id ='$id' $control_filter");
                            $data_modify = mysql_fetch_array($sql_modify);
                            $user_email = stripcslashes($data_modify['user_email']);
                            $user_name = stripcslashes($data_modify['user_name']);
                            $this_user_password = @base64_decode(stripcslashes($data_modify['user_password']));
                            $user_fullname = stripcslashes($data_modify['user_fullname']);
                            $this_user_photo = stripcslashes($data_modify['user_photo']);
                            $control_type = stripcslashes($data_modify['control_type']);

                            $edit_date = $data_modify['edit_date'];
                            $edit_by = GetAdminUserName($data_modify['edit_by']);
                            $edit_from = $data_modify['edit_from'];
                            ?>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_24; ?>
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="?id=<?php echo $id; ?>&act=saveupdate" id="form_sample_3"
                                          method="post" class="form-horizontal" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="alert alert-danger display-hide">
                                                <?php echo $lang_var_admin_12; ?>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_13; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="user_name" required autocomplete="off"
                                                           value="<?php echo $user_name; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_14; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="password" name="this_user_password" required autocomplete="off"
                                                           value="<?php echo $this_user_password; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_15; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="email" name="user_email" required
                                                           value="<?php echo $user_email; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_16; ?> </label>

                                                <div class="col-md-4">
                                                    <input type="text" name="user_fullname" required
                                                           value="<?php echo $user_fullname; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <?php if ($logged_admin_control_type == 0 || $logged_admin_control_type == 1) { ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_17; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <div class="radio-list"
                                                             data-error-container="#control_type_error">
                                                            <?php if ($logged_admin_control_type == 0) { ?>
                                                                <label><input type="radio" name="control_type"
                                                                              value="0" <?php if ($control_type == "0") {
                                                                        echo "checked";
                                                                    } ?>/><span
                                                                        class="label label-sm label-default"><?php echo $lang_var_admin_7; ?> </span>
                                                                </label>
                                                            <?php } ?>
                                                            <label><input type="radio" name="control_type"
                                                                          value="1" <?php if ($control_type == "1") {
                                                                    echo "checked";
                                                                } ?>/><span
                                                                    class="label label-sm label-info"><?php echo $lang_var_admin_8; ?>
                                                                    ( Full Features )</span></label>
                                                            <label><input type="radio" name="control_type"
                                                                          value="2" <?php if ($control_type == "2") {
                                                                    echo "checked";
                                                                } ?>/><span
                                                                    class="label label-sm label-success"><?php echo $lang_var_admin_9; ?>
                                                                    ( no delete )</span></label>
                                                            <label><input type="radio" name="control_type"
                                                                          value="3" <?php if ($control_type == "3") {
                                                                    echo "checked";
                                                                } ?>/><span
                                                                    class="label label-sm label-danger"><?php echo $lang_var_admin_10; ?>
                                                                    ( View Only )</span></label>
                                                        </div>
                                                        <div id="control_type_error"></div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_18; ?> </label>

                                                <div class="col-md-4">
                                                    <input type="file" name="myfile" class="form-control"/>
                                                    <input type="hidden" name="this_user_photo" id="file_hidden_var"
                                                           value="<?php echo $this_user_photo; ?>"/>
                                                    <input type="hidden" name="file_del" id="file_del_var" value="0"/>
                                                    <?php
                                                    if ($this_user_photo != "") {
                                                        ?>
                                                        <div id="file_show_div">
                                                            <div><img src="<?php echo "$up_dir" . "$this_user_photo"; ?>"
                                                                      style="max-width: 100%;margin: 5px 0;"/></div>
                                                            <a href="javascript:;" onclick="delete_file_onedit()"><span
                                                                    id="sample_editable_1_new" class="btn default"><i
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
                                                    <span class="help-block">e.g: .png, .jpeg, .jpg, .gif &nbsp; Size: 200x200 px</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit"
                                                        class="btn green"><?php echo $lang_var_admin_21; ?></button>
                                                <a href="?">
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
                        } elseif ($act == "new") {
                            ?>

                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-plus"></i> <?php echo $lang_var_admin_11; ?>
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="?act=insert" id="form_users_new" method="post" class="form-horizontal"
                                          enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="alert alert-danger display-hide">
                                                <?php echo $lang_var_admin_12; ?>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_13; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="user_name" autocomplete="off" required class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_14; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="password" name="this_user_password" autocomplete="off" required class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_15; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="email" name="user_email" required class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_16; ?> </label>

                                                <div class="col-md-4">
                                                    <input type="text" name="user_fullname" required class="form-control"/>
                                                </div>
                                            </div>
                                            <?php if ($logged_admin_control_type == 0 || $logged_admin_control_type == 1) { ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_17; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <div class="radio-list"
                                                             data-error-container="#control_type_error">
                                                            <label><input type="radio" name="control_type"
                                                                          value="0"/><span
                                                                    class="label label-sm label-default"><?php echo $lang_var_admin_7; ?>  </span></label>
                                                            <label><input type="radio" name="control_type" checked
                                                                          value="1"/><span
                                                                    class="label label-sm label-info"><?php echo $lang_var_admin_8; ?>
                                                                    ( Full Features )</span></label>
                                                            <label><input type="radio" name="control_type"
                                                                          value="2"/><span
                                                                    class="label label-sm label-success"><?php echo $lang_var_admin_9; ?>
                                                                    ( no delete )</span></label>
                                                            <label><input type="radio" name="control_type"
                                                                          value="3"/><span
                                                                    class="label label-sm label-danger"><?php echo $lang_var_admin_10; ?>
                                                                    ( View Only )</span> </label>
                                                        </div>
                                                        <div id="control_type_error"></div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_18; ?> </label>

                                                <div class="col-md-4">
                                                    <input type="file" name="myfile" class="form-control"/>
                                                    <span class="help-block">e.g: .png, .jpeg, .jpg, .gif &nbsp; Size: 200x200 px</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit"
                                                        class="btn green"><?php echo $lang_var_admin_23; ?></button>
                                                <a href="?">
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
                                <form name="multicheckfrm" id="multicheckfrm" method="post" action="?">
                                    <?php
                                    if ($logged_admin_control_type == 0 || $logged_admin_control_type == 1) {
                                        ?>
                                        <div class="table-toolbar">
                                            <div class="btn-group">
                                                <a href="?act=new"><span id="sample_editable_1_new" class="btn green">
									<?php echo $lang_var_admin_11; ?> <i class="fa fa-plus"></i>
									</span></a>
                                            </div>

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
                                                    <li><a href="javascript:;" id="confirmation_box_for_delete"
                                                           onclick="multicheckfrm.clicked_btn.value='b_delete';"><i
                                                                class="fa fa-trash-o"></i> <?php echo $lang_var_admin_32; ?>
                                                        </a></li>
                                                    <input type="hidden" name="clicked_btn" size="78" value=""/>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                                        <thead>
                                        <tr>
                                            <th class="table-checkbox">
                                                <input type="checkbox" class="group-checkable"
                                                       data-set="#sample_1 .checkboxes"/>
                                            </th>
                                            <th><?php echo $lang_var_admin_1; ?></th>
                                            <th><?php echo $lang_var_admin_2; ?></th>
                                            <th><?php echo $lang_var_admin_3; ?></th>
                                            <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_4; ?></th>
                                            <th style="width: 10%;"><?php echo $lang_var_admin_5; ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php


                                        $sql_retrive = mysql_query("SELECT * FROM " . $prefix .
                                            "_users where user_id!='' $control_filter order by user_id desc");
                                        while ($data_retrive = mysql_fetch_array($sql_retrive)) {
                                            if ($data_retrive['user_status'] == 1) {
                                                $active_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                            } else {
                                                $active_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                            }
                                            $user_photo = "";
                                            if ($data_retrive['user_photo'] != "") {
                                                $user_photo = "<div class='pull-right'><img src='$up_dir" . "$data_retrive[user_photo]' style='max-height:30px;margin:5px;border-radius: 50% !important;'></div>";
                                            }
                                            if ($data_retrive['control_type'] == 3) {
                                                $control_icn = "<span class='label label-sm label-danger'>$lang_var_admin_10</span>";
                                            } elseif ($data_retrive['control_type'] == 2) {
                                                $control_icn = "<span class='label label-sm label-success'>$lang_var_admin_9</span>";
                                            } elseif ($data_retrive['control_type'] == 1) {
                                                $control_icn = "<span class='label label-sm label-info'>$lang_var_admin_8</span>";
                                            } else {
                                                $control_icn = "<span class='label label-sm label-default'>$lang_var_admin_7</span>";
                                            }
                                            ?>
                                            <tr class="odd gradeX">
                                                <td>
                                                    <input type="checkbox" name="multichkbx[]" class="checkboxes"
                                                           value="<?php echo
                                                           $data_retrive['user_id']; ?>"/>
                                                </td>
                                                <td>
                                                    <small><?php echo $user_photo . stripslashes($data_retrive['user_name']); ?></small>
                                                </td>
                                                <td>
                                                    <small><?php echo stripslashes($data_retrive['user_email']); ?></small>
                                                </td>
                                                <td style="text-align: center;">
                                                    <small><?php echo $control_icn; ?></small>
                                                </td>
                                                <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                <td style="text-align: center;"><a
                                                        href="?id=<?php echo $data_retrive['user_id']; ?>&act=update"
                                                        class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?> <i
                                                            class="fa fa-edit"></i></a></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
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
            FormValidation.init();

        });
    </script>
    </body>
    <!-- END BODY -->
    </html>
<?php
require_once("template/page_end.php");
?>