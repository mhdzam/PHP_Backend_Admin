<?php
require_once("template/page_start.php");
if ($logged_full_control_status == 1) {
//--------
    $id = @$_GET['id'];
    $clicked_btn = @$_POST['clicked_btn'];
//-------
    $ws_title_var = mysql_real_escape_string(@$_POST['ws_title_var']);
    $ws_type = mysql_real_escape_string(@$_POST['ws_type']);
    $ws_comments_st = mysql_real_escape_string(@$_POST['ws_comments_st']);
    $ws_sections_st = mysql_real_escape_string(@$_POST['ws_sections_st']);
    $ws_extra1_title_var = mysql_real_escape_string(@$_POST['ws_extra1_title_var']);
    $ws_extra2_title_var = mysql_real_escape_string(@$_POST['ws_extra2_title_var']);
    $ws_extra3_title_var = mysql_real_escape_string(@$_POST['ws_extra3_title_var']);
    $ws_extra4_title_var = mysql_real_escape_string(@$_POST['ws_extra4_title_var']);
    $ws_extra5_title_var = mysql_real_escape_string(@$_POST['ws_extra5_title_var']);
    $ws_extra6_title_var = mysql_real_escape_string(@$_POST['ws_extra6_title_var']);

    $ws_date_status = mysql_real_escape_string(@$_POST['ws_date_status']);
    $ws_longtext_status = mysql_real_escape_string(@$_POST['ws_longtext_status']);
    $ws_editor_status = mysql_real_escape_string(@$_POST['ws_editor_status']);
    $ws_attachfile_status = mysql_real_escape_string(@$_POST['ws_attachfile_status']);
    $ws_multiimages_status = mysql_real_escape_string(@$_POST['ws_multiimages_status']);
    $ws_maps_status = mysql_real_escape_string(@$_POST['ws_maps_status']);


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
                        <h3 class="page-title"><?php echo $lang_var_admin_57; ?>
                            <small><?php echo $lang_var_admin_61; ?></small>
                        </h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_37; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_57; ?></a>
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
                                    "_webmaster_sections SET ws_status=1 WHERE ws_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_active) {
                                    $actin_done = 1;
                                }


                            } elseif ($clicked_btn == "b_block") {

                                $sql_block = mysql_query("UPDATE " . $prefix .
                                    "_webmaster_sections SET ws_status=0 WHERE ws_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_block) {
                                    $actin_done = 1;
                                }

                            } elseif ($clicked_btn == "b_delete") {
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix .
                                    "_webmaster_sections where ws_id in ($multichkbx) and ws_id not in (1,2,3,4,5,6,7,8)");
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

                        if ($act == "insert" && $ws_title_var != "") {


                            $sql_slct_max = mysql_query("select max(ws_id)  from " . $prefix .
                                "_webmaster_sections");
                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                            $next_ws_id = $data_slct_max[0] + 1;
                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_webmaster_sections (
  ws_id,
  ws_type,
  ws_title_var,
  ws_comments_st,
  ws_sections_st,
  ws_extra1_title_var,
  ws_extra2_title_var,
  ws_extra3_title_var,
  ws_extra4_title_var,
  ws_extra5_title_var,
  ws_extra6_title_var,
  ws_status,
  edit_by,  
  edit_date,
  edit_from,
  ws_date_status,
  ws_longtext_status,
  ws_editor_status,
  ws_attachfile_status,
  ws_multiimages_status,
  ws_maps_status) VALUES ('$next_ws_id','$ws_type','$ws_title_var','$ws_comments_st','$ws_sections_st','$ws_extra1_title_var','$ws_extra2_title_var','$ws_extra3_title_var','$ws_extra4_title_var','$ws_extra5_title_var','$ws_extra6_title_var','1','$pd_admin_user_id',now(),'$pd_admin_ip','$ws_date_status','$ws_longtext_status','$ws_editor_status','$ws_attachfile_status','$ws_multiimages_status','$ws_maps_status')");

                            if ($sql_insert_new) {
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
                        if ($act == "saveupdate" && $ws_title_var != "" && $id != "") {


                            $sql_update = mysql_query("UPDATE " . $prefix . "_webmaster_sections SET ws_type='$ws_type',ws_title_var='$ws_title_var',ws_comments_st='$ws_comments_st',ws_sections_st='$ws_sections_st',ws_extra1_title_var='$ws_extra1_title_var',ws_extra2_title_var='$ws_extra2_title_var',ws_extra3_title_var='$ws_extra3_title_var',ws_extra4_title_var='$ws_extra4_title_var',ws_extra5_title_var='$ws_extra5_title_var',ws_extra6_title_var='$ws_extra6_title_var',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip',ws_date_status='$ws_date_status',ws_longtext_status='$ws_longtext_status',ws_editor_status='$ws_editor_status',ws_attachfile_status='$ws_attachfile_status',ws_multiimages_status='$ws_multiimages_status',ws_maps_status='$ws_maps_status' WHERE ws_id='$id'") or
                            die(mysql_error());

                            if ($sql_update) {
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
                            $sql_modify = mysql_query("SELECT * FROM " . $prefix .
                                "_webmaster_sections  WHERE ws_id ='$id' ");
                            $data_modify = mysql_fetch_array($sql_modify);
                            $ws_type = stripcslashes($data_modify['ws_type']);
                            $ws_title_var = stripcslashes($data_modify['ws_title_var']);
                            $ws_comments_st = stripcslashes($data_modify['ws_comments_st']);
                            $ws_sections_st = stripcslashes($data_modify['ws_sections_st']);

                            $ws_extra1_title_var = stripcslashes($data_modify['ws_extra1_title_var']);
                            $ws_extra2_title_var = stripcslashes($data_modify['ws_extra2_title_var']);
                            $ws_extra3_title_var = stripcslashes($data_modify['ws_extra3_title_var']);
                            $ws_extra4_title_var = stripcslashes($data_modify['ws_extra4_title_var']);
                            $ws_extra5_title_var = stripcslashes($data_modify['ws_extra5_title_var']);
                            $ws_extra6_title_var = stripcslashes($data_modify['ws_extra6_title_var']);

                            $ws_date_status = stripcslashes($data_modify['ws_date_status']);
                            $ws_longtext_status = stripcslashes($data_modify['ws_longtext_status']);
                            $ws_editor_status = stripcslashes($data_modify['ws_editor_status']);
                            $ws_attachfile_status = stripcslashes($data_modify['ws_attachfile_status']);
                            $ws_multiimages_status = stripcslashes($data_modify['ws_multiimages_status']);
                            $ws_maps_status = stripcslashes($data_modify['ws_maps_status']);

                            $edit_date = $data_modify['edit_date'];
                            $edit_by = GetAdminUserName($data_modify['edit_by']);
                            $edit_from = $data_modify['edit_from'];
                            ?>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_152; ?>
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="?id=<?php echo $id; ?>&act=saveupdate" id="form_site_sections_new"
                                          method="post"
                                          class="form-horizontal" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="alert alert-danger display-hide">
                                                <?php echo $lang_var_admin_12; ?>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_62; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="ws_title_var"
                                                           value="<?php echo $ws_title_var; ?>"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_63; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list" data-error-container="#ws_type_error">
                                                        <label><input type="radio" name="ws_type"
                                                                      value="0" <?php if ($ws_type == 0) {
                                                                echo "checked";
                                                            } ?>/><span class="label label-sm label-default"><i
                                                                    class="<?php echo $mnu_icons_type[0]; ?>"></i>&nbsp; <?php echo $lang_var_admin_66; ?>  </span>
                                                        </label>
                                                        <label><input type="radio" name="ws_type"
                                                                      value="1" <?php if ($ws_type == 1) {
                                                                echo "checked";
                                                            } ?>/><span class="label label-sm label-info"><i
                                                                    class="<?php echo $mnu_icons_type[1]; ?>"></i>&nbsp; <?php echo $lang_var_admin_67; ?></span>
                                                        </label>
                                                        <label><input type="radio" name="ws_type"
                                                                      value="2" <?php if ($ws_type == 2) {
                                                                echo "checked";
                                                            } ?>/><span class="label label-sm label-danger"><i
                                                                    class="<?php echo $mnu_icons_type[2]; ?>"></i>&nbsp; <?php echo $lang_var_admin_68; ?></span>
                                                        </label>
                                                        <label><input type="radio" name="ws_type"
                                                                      value="3" <?php if ($ws_type == 3) {
                                                                echo "checked";
                                                            } ?>/><span class="label label-sm label-success"><i
                                                                    class="<?php echo $mnu_icons_type[3]; ?>"></i>&nbsp; <?php echo $lang_var_admin_69; ?></span>
                                                        </label>
                                                    </div>
                                                    <div id="ws_type_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_64; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list"
                                                         data-error-container="#ws_sections_st_error">
                                                        <label><input type="radio" name="ws_sections_st"
                                                                      value="0" <?php if ($ws_sections_st == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_70; ?> </label>
                                                        <label><input type="radio" name="ws_sections_st"
                                                                      value="1" <?php if ($ws_sections_st == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_71; ?> </label>
                                                        <label><input type="radio" name="ws_sections_st"
                                                                      value="2" <?php if ($ws_sections_st == 2) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_72; ?> </label>
                                                    </div>
                                                    <div id="ws_sections_st_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_74; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list"
                                                         data-error-container="#ws_comments_st_error">
                                                        <label><input type="radio" name="ws_comments_st"
                                                                      value="1" <?php if ($ws_comments_st == 1) {
                                                                echo "checked";
                                                            } ?> /><?php echo $lang_var_admin_75; ?> </label>
                                                        <label><input type="radio" name="ws_comments_st"
                                                                      value="0" <?php if ($ws_comments_st == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                    </div>
                                                    <div id="ws_comments_st_error"></div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_95; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="ws_date_status"
                                                                      value="1" <?php if ($ws_date_status == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                        <label><input type="radio" name="ws_date_status"
                                                                      value="0" <?php if ($ws_date_status == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_96; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="ws_longtext_status"
                                                                      value="1" <?php if ($ws_longtext_status == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                        <label><input type="radio" name="ws_longtext_status"
                                                                      value="0" <?php if ($ws_longtext_status == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_97; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="ws_editor_status"
                                                                      value="1" <?php if ($ws_editor_status == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                        <label><input type="radio" name="ws_editor_status"
                                                                      value="0" <?php if ($ws_editor_status == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_98; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="ws_attachfile_status"
                                                                      value="1" <?php if ($ws_attachfile_status == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                        <label><input type="radio" name="ws_attachfile_status"
                                                                      value="0" <?php if ($ws_attachfile_status == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_184; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="ws_multiimages_status"
                                                                      value="1" <?php if ($ws_multiimages_status == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                        <label><input type="radio" name="ws_multiimages_status"
                                                                      value="0" <?php if ($ws_multiimages_status == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_185; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="ws_maps_status"
                                                                      value="1" <?php if ($ws_maps_status == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                        <label><input type="radio" name="ws_maps_status"
                                                                      value="0" <?php if ($ws_maps_status == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_73; ?> </label>

                                                <div class="col-md-4">
                                                    <input type="text" name="ws_extra1_title_var"
                                                           value="<?php echo $ws_extra1_title_var; ?>"
                                                           class="form-control"
                                                           placeholder="1"/>
                                                    <input type="text" name="ws_extra2_title_var"
                                                           value="<?php echo $ws_extra2_title_var; ?>"
                                                           class="form-control"
                                                           placeholder="2"/>
                                                    <input type="text" name="ws_extra3_title_var"
                                                           value="<?php echo $ws_extra3_title_var; ?>"
                                                           class="form-control"
                                                           placeholder="3"/>
                                                    <input type="text" name="ws_extra4_title_var"
                                                           value="<?php echo $ws_extra4_title_var; ?>"
                                                           class="form-control"
                                                           placeholder="4"/>
                                                    <input type="text" name="ws_extra5_title_var"
                                                           value="<?php echo $ws_extra5_title_var; ?>"
                                                           class="form-control"
                                                           placeholder="5"/>
                                                    <input type="text" name="ws_extra6_title_var"
                                                           value="<?php echo $ws_extra6_title_var; ?>"
                                                           class="form-control"
                                                           placeholder="6"/>
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
                                        <i class="fa fa-plus"></i> <?php echo $lang_var_admin_65; ?>
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="?act=insert" id="form_site_sections_new" method="post"
                                          class="form-horizontal"
                                          enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="alert alert-danger display-hide">
                                                <?php echo $lang_var_admin_12; ?>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_62; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="ws_title_var" class="form-control"
                                                           required=""/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_63; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list" data-error-container="#ws_type_error">
                                                        <label><input type="radio" name="ws_type" value="0"
                                                                      checked="checked"/><span
                                                                class="label label-sm label-default"><i
                                                                    class="<?php echo $mnu_icons_type[0]; ?>"></i>&nbsp; <?php echo $lang_var_admin_66; ?>  </span>
                                                        </label>
                                                        <label><input type="radio" name="ws_type" value="1"/><span
                                                                class="label label-sm label-info"><i
                                                                    class="<?php echo $mnu_icons_type[1]; ?>"></i>&nbsp; <?php echo $lang_var_admin_67; ?></span>
                                                        </label>
                                                        <label><input type="radio" name="ws_type" value="2"/><span
                                                                class="label label-sm label-danger"><i
                                                                    class="<?php echo $mnu_icons_type[2]; ?>"></i>&nbsp; <?php echo $lang_var_admin_68; ?></span>
                                                        </label>
                                                        <label><input type="radio" name="ws_type" value="3"/><span
                                                                class="label label-sm label-success"><i
                                                                    class="<?php echo $mnu_icons_type[3]; ?>"></i>&nbsp; <?php echo $lang_var_admin_69; ?></span>
                                                        </label>
                                                    </div>
                                                    <div id="ws_type_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_64; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list"
                                                         data-error-container="#ws_sections_st_error">
                                                        <label><input type="radio" name="ws_sections_st" value="0"
                                                                      checked="checked"/><?php echo $lang_var_admin_70; ?>
                                                        </label>
                                                        <label><input type="radio" name="ws_sections_st"
                                                                      value="1"/><?php echo $lang_var_admin_71; ?>
                                                        </label>
                                                        <label><input type="radio" name="ws_sections_st"
                                                                      value="2"/><?php echo $lang_var_admin_72; ?>
                                                        </label>
                                                    </div>
                                                    <div id="ws_sections_st_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_74; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list"
                                                         data-error-container="#ws_comments_st_error">
                                                        <label><input type="radio" name="ws_comments_st"
                                                                      value="1"/><?php echo $lang_var_admin_75; ?>
                                                        </label>
                                                        <label><input type="radio" name="ws_comments_st" value="0"
                                                                      checked="checked"/><?php echo $lang_var_admin_76; ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_95; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="ws_date_status"
                                                                      value="1"/><?php echo $lang_var_admin_75; ?>
                                                        </label>
                                                        <label><input type="radio" name="ws_date_status" value="0"
                                                                      checked="checked"/><?php echo $lang_var_admin_76; ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_96; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="ws_longtext_status"
                                                                      value="1"/><?php echo $lang_var_admin_75; ?>
                                                        </label>
                                                        <label><input type="radio" name="ws_longtext_status" value="0"
                                                                      checked="checked"/><?php echo $lang_var_admin_76; ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_97; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="ws_editor_status"
                                                                      value="1"/><?php echo $lang_var_admin_75; ?>
                                                        </label>
                                                        <label><input type="radio" name="ws_editor_status" value="0"
                                                                      checked="checked"/><?php echo $lang_var_admin_76; ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_98; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="ws_attachfile_status"
                                                                      value="1"/><?php echo $lang_var_admin_75; ?>
                                                        </label>
                                                        <label><input type="radio" name="ws_attachfile_status" value="0"
                                                                      checked="checked"/><?php echo $lang_var_admin_76; ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_184; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="ws_multiimages_status"
                                                                      value="1"/><?php echo $lang_var_admin_75; ?>
                                                        </label>
                                                        <label><input type="radio" name="ws_multiimages_status"
                                                                      value="0"
                                                                      checked="checked"/><?php echo $lang_var_admin_76; ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_185; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="ws_maps_status"
                                                                      value="1"/><?php echo $lang_var_admin_75; ?>
                                                        </label>
                                                        <label><input type="radio" name="ws_maps_status" value="0"
                                                                      checked="checked"/><?php echo $lang_var_admin_76; ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_73; ?> </label>

                                                <div class="col-md-4">
                                                    <input type="text" name="ws_extra1_title_var" class="form-control"
                                                           placeholder="1"/>
                                                    <input type="text" name="ws_extra2_title_var" class="form-control"
                                                           placeholder="2"/>
                                                    <input type="text" name="ws_extra3_title_var" class="form-control"
                                                           placeholder="3"/>
                                                    <input type="text" name="ws_extra4_title_var" class="form-control"
                                                           placeholder="4"/>
                                                    <input type="text" name="ws_extra5_title_var" class="form-control"
                                                           placeholder="5"/>
                                                    <input type="text" name="ws_extra6_title_var" class="form-control"
                                                           placeholder="6"/>
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
                                    <div class="table-toolbar">
                                        <div class="btn-group">
                                            <a href="?act=new"><span id="sample_editable_1_new" class="btn green">
									<?php echo $lang_var_admin_65; ?> <i class="fa fa-plus"></i>
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
                                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                                        <thead>
                                        <tr>
                                            <th class="table-checkbox">
                                                <input type="checkbox" class="group-checkable"
                                                       data-set="#sample_1 .checkboxes"/>
                                            </th>
                                            <th><?php echo $lang_var_admin_62; ?></th>
                                            <th><?php echo $lang_var_admin_63; ?></th>
                                            <th><?php echo $lang_var_admin_64; ?></th>
                                            <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_4; ?></th>
                                            <th style="width: 10%;"><?php echo $lang_var_admin_5; ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_webmaster_sections order by ws_status desc,  ws_id");
                                        while ($data_retrive = mysql_fetch_array($sql_retrive)) {
                                            if ($data_retrive['ws_status'] == 1) {
                                                $active_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                            } else {
                                                $active_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                            }

                                            if ($data_retrive['ws_type'] == 3) {
                                                $section_type_icn = "<span class='label label-sm label-success'><i class='$mnu_icons_type[3]'></i>&nbsp; $lang_var_admin_69</span>";
                                            } elseif ($data_retrive['ws_type'] == 2) {
                                                $section_type_icn = "<span class='label label-sm label-danger'><i class='$mnu_icons_type[2]'></i>&nbsp; $lang_var_admin_68</span>";
                                            } elseif ($data_retrive['ws_type'] == 1) {
                                                $section_type_icn = "<span class='label label-sm label-info'><i class='$mnu_icons_type[1]'></i>&nbsp; $lang_var_admin_67</span>";
                                            } else {
                                                $section_type_icn = "<span class='label label-sm label-default'><i class='$mnu_icons_type[0]'></i>&nbsp; $lang_var_admin_66</span>";
                                            }

                                            if ($data_retrive['ws_sections_st'] == 2) {
                                                $ws_sections_st_icn = "<i class='fa fa-check'></i> &nbsp;$lang_var_admin_72";
                                            } elseif ($data_retrive['ws_sections_st'] == 1) {
                                                $ws_sections_st_icn = "<i class='fa fa-check'></i> &nbsp;$lang_var_admin_71";
                                            } else {
                                                $ws_sections_st_icn = "<i class='fa fa-times'></i> &nbsp;$lang_var_admin_70";
                                            }

                                            ?>
                                            <tr class="odd gradeX">
                                                <td>
                                                    <input type="checkbox" name="multichkbx[]" class="checkboxes"
                                                           value="<?php echo
                                                           $data_retrive['ws_id']; ?>"/>
                                                </td>
                                                <td><?php echo $$data_retrive['ws_title_var']; ?></td>
                                                <td>
                                                    <small><?php echo $section_type_icn; ?></small>
                                                </td>
                                                <td>
                                                    <small><?php echo $ws_sections_st_icn; ?></small>
                                                </td>
                                                <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                <td style="text-align: center;"><a
                                                        href="?id=<?php echo $data_retrive['ws_id']; ?>&act=update"
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
} else {
    header("Location: 404.php");
    exit();
}
require_once("template/page_end.php");
?>