<?php
require_once("template/page_start.php");
//--------
$id = @$_GET['id'];
$clicked_btn = @$_POST['clicked_btn'];
//-------
$host_title_en = mysql_real_escape_string(@$_POST['host_title_en']);
$host_title_ar = mysql_real_escape_string(@$_POST['host_title_ar']);
$file_del = mysql_real_escape_string(@$_POST['file_del']);
$host_price = mysql_real_escape_string(@$_POST['host_price']);

$host_ar_desc_1 = mysql_real_escape_string(@$_POST['host_ar_desc_1']);
$host_en_desc_1 = mysql_real_escape_string(@$_POST['host_en_desc_1']);
$host_ar_desc_2 = mysql_real_escape_string(@$_POST['host_ar_desc_2']);
$host_en_desc_2 = mysql_real_escape_string(@$_POST['host_en_desc_2']);
$host_ar_desc_3 = mysql_real_escape_string(@$_POST['host_ar_desc_3']);
$host_en_desc_3 = mysql_real_escape_string(@$_POST['host_en_desc_3']);
$host_ar_desc_4 = mysql_real_escape_string(@$_POST['host_ar_desc_4']);
$host_en_desc_4 = mysql_real_escape_string(@$_POST['host_en_desc_4']);
$host_ar_desc_5 = mysql_real_escape_string(@$_POST['host_ar_desc_5']);
$host_en_desc_5 = mysql_real_escape_string(@$_POST['host_en_desc_5']);

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
                        <h3 class="page-title"><?php echo $lang_var_admin_441; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-<?php echo $site_lang_align_right; ?>"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_58; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_441; ?></a>
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
                            $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_hosting");
                            while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                $inm = "row_no" . "$data_delete_who[host_id]";
                                $row_no = @$_POST[$inm];
                                $sql_sveorder = mysql_query("UPDATE " . $prefix . "_hosting SET row_no='$row_no' WHERE host_id='$data_delete_who[host_id]'") or die (mysql_error());
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
                                    "_hosting SET host_status=1 WHERE host_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_active) {
                                    $actin_done = 1;
                                }


                            } elseif ($clicked_btn == "b_block") {

                                $sql_block = mysql_query("UPDATE " . $prefix .
                                    "_hosting SET host_status=0 WHERE host_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_block) {
                                    $actin_done = 1;
                                }

                            } elseif ($clicked_btn == "b_delete") {
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix .
                                    "_hosting where host_id in ($multichkbx)");
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

                        if ($act == "insert" && $host_title_en != "") {


                            $r = "select max(row_no)  from " . $prefix . "_hosting";
                            $sqlr = mysql_query($r);
                            $rr = mysql_fetch_array($sqlr);
                            $row = $rr[0] + 1;

                            $sql_slct_max = mysql_query("select max(host_id)  from " . $prefix .
                                "_hosting");
                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                            $next_host_id = $data_slct_max[0] + 1;
                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_hosting (
  host_id,
  host_title_ar,
  host_title_en,
  host_status,
  host_price,
  host_ar_desc_1,
  host_en_desc_1,
  host_ar_desc_2,
  host_en_desc_2,
  host_ar_desc_3,
  host_en_desc_3,
  host_ar_desc_4,
  host_en_desc_4,
  host_ar_desc_5,
  host_en_desc_5,
  edit_by,  
  edit_date,
  edit_from,
  row_no) VALUES ('$next_host_id','$host_title_ar','$host_title_en','1','$host_price','$host_ar_desc_1','$host_en_desc_1','$host_ar_desc_2','$host_en_desc_2','$host_ar_desc_3','$host_en_desc_3','$host_ar_desc_4','$host_en_desc_4','$host_ar_desc_5','$host_en_desc_5' ,'$pd_admin_user_id',now(),'$pd_admin_ip','$row')");

                            if ($sql_insert_new) {


                                // insert notification
                                $note_title_ar = ($lang_var_admin_381 . ": " . $host_title_ar);
                                $note_title_en = ($lang_var_admin_382 . ": " . $host_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-success'>
                            <i class='fa fa-sitemap'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("packages.php?id=$next_host_id&act=update");

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
                        if ($act == "saveupdate" && $host_title_en != "" && $id != "") {

                            $sql_update = mysql_query("UPDATE " . $prefix . "_hosting SET host_title_ar='$host_title_ar',host_title_en='$host_title_en',host_price='$host_price',host_ar_desc_1='$host_ar_desc_1',host_en_desc_1='$host_en_desc_1',host_ar_desc_2='$host_ar_desc_2',host_en_desc_2='$host_en_desc_2',host_ar_desc_3='$host_ar_desc_3',host_en_desc_3='$host_en_desc_3',host_ar_desc_4='$host_ar_desc_4',host_en_desc_4='$host_en_desc_4',host_ar_desc_5='$host_ar_desc_5',host_en_desc_5='$host_en_desc_5' ,edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip' WHERE host_id='$id'") or
                            die(mysql_error());

                            if ($sql_update) {

                                // insert notification
                                $note_title_ar = ($lang_var_admin_387 . ": " . $host_title_ar);
                                $note_title_en = ($lang_var_admin_388 . ": " . $host_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-info'>
                            <i class='fa fa-pencil'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("packages.php?id=$id&act=update");

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
                            $sql_modify = mysql_query("SELECT * FROM " . $prefix .
                                "_hosting  WHERE host_id ='$id' ");
                            $data_modify = mysql_fetch_array($sql_modify);
                            $host_title_ar = stripcslashes($data_modify['host_title_ar']);
                            $host_title_en = stripcslashes($data_modify['host_title_en']);

                            $host_price = stripcslashes($data_modify['host_price']);
                            $host_ar_desc_1 = stripcslashes($data_modify['host_ar_desc_1']);
                            $host_en_desc_1 = stripcslashes($data_modify['host_en_desc_1']);
                            $host_ar_desc_2 = stripcslashes($data_modify['host_ar_desc_2']);
                            $host_en_desc_2 = stripcslashes($data_modify['host_en_desc_2']);
                            $host_ar_desc_3 = stripcslashes($data_modify['host_ar_desc_3']);
                            $host_en_desc_3 = stripcslashes($data_modify['host_en_desc_3']);
                            $host_ar_desc_4 = stripcslashes($data_modify['host_ar_desc_4']);
                            $host_en_desc_4 = stripcslashes($data_modify['host_en_desc_4']);
                            $host_ar_desc_5 = stripcslashes($data_modify['host_ar_desc_5']);
                            $host_en_desc_5 = stripcslashes($data_modify['host_en_desc_5']);

                            $edit_date = $data_modify['edit_date'];
                            $edit_by = GetAdminUserName($data_modify['edit_by']);
                            $edit_from = $data_modify['edit_from'];
                            ?>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_444; ?>
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="?id=<?php echo $id; ?>&act=saveupdate" method="post"
                                          class="form-horizontal"
                                          enctype="multipart/form-data">
                                        <div class="form-body">

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_443; ?>  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_title_ar" required=""
                                                           value="<?php echo $host_title_ar; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_443; ?>  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_title_en" required=""
                                                           value="<?php echo $host_title_en; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_316; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_price" required=""
                                                           value="<?php echo $host_price; ?>" class="form-control"/>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #1  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_ar_desc_1" 
                                                           value="<?php echo $host_ar_desc_1; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #1  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_en_desc_1" 
                                                           value="<?php echo $host_en_desc_1; ?>" class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #2  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_ar_desc_2" 
                                                           value="<?php echo $host_ar_desc_2; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #2  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_en_desc_2" 
                                                           value="<?php echo $host_en_desc_2; ?>" class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #3  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_ar_desc_3" 
                                                           value="<?php echo $host_ar_desc_3; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #3  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_en_desc_3" 
                                                           value="<?php echo $host_en_desc_3; ?>" class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #4  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_ar_desc_4" 
                                                           value="<?php echo $host_ar_desc_4; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #4  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_en_desc_4" 
                                                           value="<?php echo $host_en_desc_4; ?>" class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #5  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_ar_desc_5" 
                                                           value="<?php echo $host_ar_desc_5; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #5  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_en_desc_5" 
                                                           value="<?php echo $host_en_desc_5; ?>" class="form-control"/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit"
                                                        class="btn green"><?php echo $lang_var_admin_21; ?></button>
                                                &nbsp;
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
                                        <i class="fa fa-plus"></i> <?php echo $lang_var_admin_442; ?>
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="?act=insert" method="post" class="form-horizontal"
                                          enctype="multipart/form-data">
                                        <div class="form-body">

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_443; ?> <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_title_ar" required=""
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_443; ?> <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_title_en" required=""
                                                           class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_316; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_price" required=""
                                                           value="" class="form-control"/>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #1  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_ar_desc_1"
                                                           value="" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #1  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_en_desc_1"
                                                           value="" class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #2  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_ar_desc_2"
                                                           value="" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #2  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_en_desc_2"
                                                           value="" class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #3  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_ar_desc_3"
                                                           value="" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #3  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_en_desc_3"
                                                           value="" class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #4  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_ar_desc_4"
                                                           value="" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #4  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_en_desc_4"
                                                           value="" class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #5  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_ar_desc_5"
                                                           value="" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_445; ?> #5  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="host_en_desc_5"
                                                           value="" class="form-control"/>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit"
                                                        class="btn green"><?php echo $lang_var_admin_23; ?></button>
                                                &nbsp;
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
                                        <?php
                                        if ($logged_allow_add_status == 1) {
                                            ?>
                                            <div class="btn-group">
                                                <a href="?act=new"><span id="sample_editable_1_new" class="btn green">
									<?php echo $lang_var_admin_442; ?> <i class="fa fa-plus"></i>
									</span></a>
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
                                            <th><?php echo $lang_var_admin_443; ?></th>
                                            <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_316; ?></th>
                                            <th style="width: 15%;text-align: center;"><?php echo $lang_var_admin_445; ?></th>
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
                                        $sql_retrive = mysql_query("SELECT * FROM " . $prefix .
                                            "_hosting order by row_no, host_id");
                                        $page_records_count = mysql_num_rows($sql_retrive);
                                        if ($page_records_count == 0) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td colspan="7" style="text-align: center;">
                                                    <small><?php echo $lang_var_admin_93; ?></small>
                                                </td>

                                            </tr>
                                            <?php
                                        } else {

                                            while ($data_retrive = mysql_fetch_array($sql_retrive)) {
                                                if ($data_retrive['host_status'] == 1) {
                                                    $active_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                                } else {
                                                    $active_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                                }


                                                ?>
                                                <tr class="odd gradeX">
                                                    <td>
                                                        <input type="checkbox" name="multichkbx[]" class="checkboxes"
                                                               value="<?php echo
                                                               $data_retrive['host_id']; ?>"/>
                                                    </td>
                                                    <td><input type="text"
                                                               name="row_no<?php echo $data_retrive['host_id'] ?>"
                                                               style="width: 30px;text-align: center;font-size: 11px;"
                                                               value="<?php echo $data_retrive['row_no'] ?>"> &nbsp;
                                                        <small>
                                                            <strong><?php echo stripslashes($data_retrive['host_title_' . $lang]); ?></strong>
                                                        </small>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <small><?php echo stripslashes($data_retrive['host_price']); ?></small>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <small><?php echo stripslashes($data_retrive['host_'.$lang.'_desc_1']); ?></small>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <small><?php echo stripslashes($data_retrive['visits']); ?></small>
                                                    </td>
                                                    <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                    <?php
                                                    if ($logged_allow_edit_status == 1) {
                                                        ?>
                                                        <td style="text-align: center;"><a
                                                                href="?id=<?php echo $data_retrive['host_id']; ?>&act=update"
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
require_once("template/page_end.php");
?>