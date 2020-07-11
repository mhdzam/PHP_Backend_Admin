<?php

require_once("template/page_start.php");
//--------
$id = @$_GET['id'];
$clicked_btn = @$_POST['clicked_btn'];
//-------
$word_variable = mysql_real_escape_string(@$_POST['word_variable']);
$word_type = mysql_real_escape_string(@$_POST['word_type']);
$old_word_variable = mysql_real_escape_string(@$_POST['old_word_variable']);

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
                        <h3 class="page-title"><?php echo $lang_var_admin_50; ?>
                            <small><?php echo $lang_var_admin_51; ?></small>
                        </h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-<?php echo $site_lang_align_right; ?>"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_37; ?></a>
                                <i class="fa fa-angle-<?php echo $site_lang_align_right; ?>"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_50; ?></a>
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
                            if ($clicked_btn == "b_delete") {
                                $sql_delete_who = mysql_query("SELECT * FROM " . $prefix .
                                    "_languages_words where word_variable  in (SELECT word_variable FROM " . $prefix .
                                    "_languages_words where word_id in ($multichkbx))");
                                while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                    $sql_delete = mysql_query("DELETE FROM  " . $prefix .
                                        "_languages_words where word_id ='$data_delete_who[word_id]'");
                                    if ($sql_delete) {
                                        $actin_done = 1;
                                    }
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

                        if ($act == "insert" && $word_variable != "") {
                            $actin_done = 0;

                            $sql_sam_var = mysql_query("SELECT word_id FROM " . $prefix . "_languages_words where word_variable ='$word_variable'");
                            $sam_var_records_count = mysql_num_rows($sql_sam_var);
                            if ($sam_var_records_count > 0) {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <?php echo $lang_var_admin_49; ?>
                                </div>
                                <?php
                            } else {

                                $sql_langs_retrive = mysql_query("SELECT * FROM " . $prefix . "_languages order by lang_id");
                                while ($data_langs_retrive = mysql_fetch_array($sql_langs_retrive)) {

                                    $lang_word_text = mysql_real_escape_string(@$_POST['lang_id_is_' . $data_langs_retrive['lang_id']]);
                                    $this_lang_id = $data_langs_retrive['lang_id'];

                                    $sql_slct_max = mysql_query("select max(word_id)  from " . $prefix . "_languages_words");
                                    $data_slct_max = mysql_fetch_array($sql_slct_max);
                                    $next_word_id = $data_slct_max[0] + 1;
                                    $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_languages_words (
  word_id,
  lang_id,
  word_type,
  word_variable,
  word_text,
  edit_by,  
  edit_date,
  edit_from) VALUES ('$next_word_id','$this_lang_id','$word_type','$word_variable','$lang_word_text','$pd_admin_user_id',now(),'$pd_admin_ip')");
                                    if ($sql_insert_new) {
                                        $actin_done = 1;
                                    }

                                }

                                if ($actin_done) {
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
                        if ($act == "saveupdate" && $old_word_variable != "" && $id != "") {

                            $sql_old_var_delete = mysql_query("DELETE FROM  " . $prefix . "_languages_words where word_variable ='$old_word_variable'");

                            $actin_done = 0;

                            $sql_sam_var = mysql_query("SELECT word_id FROM " . $prefix . "_languages_words where word_variable ='$word_variable'");
                            $sam_var_records_count = mysql_num_rows($sql_sam_var);
                            if ($sam_var_records_count > 0) {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <?php echo $lang_var_admin_49; ?>
                                </div>
                                <?php
                            } else {

                                $sql_langs_retrive = mysql_query("SELECT * FROM " . $prefix . "_languages order by lang_id");
                                while ($data_langs_retrive = mysql_fetch_array($sql_langs_retrive)) {

                                    $lang_word_text = mysql_real_escape_string(@$_POST['lang_id_is_' . $data_langs_retrive['lang_id']]);
                                    $this_lang_id = $data_langs_retrive['lang_id'];

                                    $sql_slct_max = mysql_query("select max(word_id)  from " . $prefix . "_languages_words");
                                    $data_slct_max = mysql_fetch_array($sql_slct_max);
                                    $next_word_id = $data_slct_max[0] + 1;
                                    $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_languages_words (
  word_id,
  lang_id,
  word_type,
  word_variable,
  word_text,
  edit_by,  
  edit_date,
  edit_from) VALUES ('$next_word_id','$this_lang_id','$word_type','$word_variable','$lang_word_text','$pd_admin_user_id',now(),'$pd_admin_ip')");
                                    if ($sql_insert_new) {
                                        $actin_done = 1;
                                    }

                                }

                                if ($actin_done) {
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

                        if ($act == "update") {
                            $sql_modify = mysql_query("SELECT * FROM " . $prefix .
                                "_languages_words  WHERE word_id ='$id' ");
                            $data_modify = mysql_fetch_array($sql_modify);
                            $lang_id = stripcslashes($data_modify['lang_id']);
                            $word_type = stripcslashes($data_modify['word_type']);
                            $word_variable = stripcslashes($data_modify['word_variable']);
                            $word_text = stripcslashes($data_modify['word_text']);

                            $edit_date = $data_modify['edit_date'];
                            $edit_by = GetAdminUserName($data_modify['edit_by']);
                            $edit_from = $data_modify['edit_from'];
                            ?>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_50; ?>
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="?id=<?php echo $id; ?>&act=saveupdate" id="languages_words_form"
                                          method="post" class="form-horizontal" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="alert alert-danger display-hide">
                                                <?php echo $lang_var_admin_12; ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_54; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list" data-error-container="#word_type_error">
                                                        <label><input type="radio" name="word_type"
                                                                      value="0" <?php if ($word_type == "0") {
                                                                echo "checked";
                                                            } ?>/>Admin</label>
                                                        <label><input type="radio" name="word_type"
                                                                      value="1" <?php if ($word_type == "1") {
                                                                echo "checked";
                                                            } ?>/>Public site</label>
                                                    </div>
                                                    <div id="word_type_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_55; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="word_variable"
                                                           value="<?php echo $word_variable; ?>" class="form-control"/>
                                                    <input type="hidden" readonly="" name="old_word_variable"
                                                           value="<?php echo $word_variable; ?>" class="form-control"/>
                                                </div>
                                            </div>

                                            <?php
                                            $sql_langs_retrive = mysql_query("SELECT * FROM " . $prefix . "_languages order by lang_id");
                                            while ($data_langs_retrive = mysql_fetch_array($sql_langs_retrive)) {

                                                $sql_word_text = mysql_query("SELECT word_text FROM " . $prefix . "_languages_words where word_variable ='$data_modify[word_variable]' and lang_id='$data_langs_retrive[lang_id]' limit 1");
                                                $data_word_text = mysql_fetch_array($sql_word_text);
                                                $this_lang_word_text = stripslashes($data_word_text['word_text']);

                                                ?>

                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo stripslashes($data_langs_retrive['lang_title']); ?></label>

                                                    <div class="col-md-4">
                                                        <textarea
                                                            name="lang_id_is_<?php echo $data_langs_retrive['lang_id']; ?>"
                                                            rows="2"
                                                            dir="<?php echo $data_langs_retrive['lang_dir']; ?>"
                                                            class="form-control"><?php echo $this_lang_word_text; ?></textarea>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

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

                            $sql_count_retrive = mysql_query("SELECT word_id FROM " . $prefix . "_languages_words where word_type=0 group by word_variable order by word_id desc");
                            $new_admin_var_noo = mysql_num_rows($sql_count_retrive) + 1;

                            $sql_count_retrive = mysql_query("SELECT word_id FROM " . $prefix . "_languages_words where word_type=1 group by word_variable order by word_id desc");
                            $new_public_var_noo = mysql_num_rows($sql_count_retrive) + 1;

                            ?>

                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-plus"></i> <?php echo $lang_var_admin_53; ?>
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <script language="JavaScript">
                                        function CopyToClipboard(text) {
                                            Copied = text.value;
                                            window.prompt("To Copy to clipboard: Ctrl+C, Enter", "<" + "?php echo $" + Copied + "; ?>");
                                        }
                                    </script>
                                    <form action="?act=insert" id="languages_words_form" method="post"
                                          class="form-horizontal" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="alert alert-danger display-hide">
                                                <?php echo $lang_var_admin_12; ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_54; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list" data-error-container="#word_type_error">
                                                        <label><input type="radio"
                                                                      onclick="document.getElementById('vaaarrrr').value='lang_var_admin_<?php echo $new_admin_var_noo; ?>';"
                                                                      name="word_type" value="0"/>Admin</label>
                                                        <label><input type="radio"
                                                                      onclick="document.getElementById('vaaarrrr').value='lang_var_public_<?php echo $new_public_var_noo; ?>';"
                                                                      name="word_type" value="1"/>Public site</label>
                                                    </div>
                                                    <div id="word_type_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_55; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="word_variable" id="vaaarrrr"
                                                           class="form-control"/>
                                                </div>
                                            </div>

                                            <?php
                                            $sql_langs_retrive = mysql_query("SELECT * FROM " . $prefix . "_languages order by lang_id");
                                            while ($data_langs_retrive = mysql_fetch_array($sql_langs_retrive)) {
                                                ?>

                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo stripslashes($data_langs_retrive['lang_title']); ?></label>

                                                    <div class="col-md-4">
                                                        <textarea
                                                            name="lang_id_is_<?php echo $data_langs_retrive['lang_id']; ?>"
                                                            rows="2"
                                                            dir="<?php echo $data_langs_retrive['lang_dir']; ?>"
                                                            class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit"
                                                        onclick="CopyToClipboard(document.getElementById('vaaarrrr'))"
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
									<?php echo $lang_var_admin_53; ?> <i class="fa fa-plus"></i>
									</span></a>
                                        </div>
                                        <div class="btn-group pull-right">
                                            <button class="btn dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-th-large"></i> Actions <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="javascript:;" id="confirmation_box_for_delete"
                                                       onclick="multicheckfrm.clicked_btn.value='b_delete';"><i
                                                            class="fa fa-trash-o"></i> Delete</a></li>
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
                                            <th><?php echo $lang_var_admin_55; ?></th>
                                            <?php
                                            $sql_langs_retrive = mysql_query("SELECT * FROM " . $prefix . "_languages order by lang_id limit 3");
                                            while ($data_langs_retrive = mysql_fetch_array($sql_langs_retrive)) {
                                                ?>
                                                <th dir="<?php echo $data_langs_retrive['lang_dir']; ?>"><?php echo stripslashes($data_langs_retrive['lang_title']); ?></th>
                                                <?php
                                            }
                                            ?>
                                            <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_54; ?></th>
                                            <th style="width: 10%;">&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql_retrive = mysql_query("SELECT * FROM " . $prefix .
                                            "_languages_words group by word_variable order by word_id desc");
                                        while ($data_retrive = mysql_fetch_array($sql_retrive)) {
                                            if ($data_retrive['word_type'] == 1) {
                                                $active_icn = "<span class='label label-sm label-info'>Public site</span>";
                                            } else {
                                                $active_icn = "<span class='label label-default'>Admin</span>";
                                            }
                                            ?>
                                            <tr class="odd gradeX">
                                                <td>
                                                    <input type="checkbox" name="multichkbx[]" class="checkboxes"
                                                           value="<?php echo
                                                           $data_retrive['word_id']; ?>"/>
                                                </td>
                                                <td>
                                                    <small><?php echo stripslashes($data_retrive['word_variable']); ?></small>
                                                </td>
                                                <?php
                                                $sql_langs_retrive = mysql_query("SELECT * FROM " . $prefix . "_languages order by lang_id limit 3");
                                                while ($data_langs_retrive = mysql_fetch_array($sql_langs_retrive)) {
                                                    $sql_word_text = mysql_query("SELECT word_text FROM " . $prefix . "_languages_words where word_variable ='$data_retrive[word_variable]' and lang_id='$data_langs_retrive[lang_id]' limit 1");
                                                    $data_word_text = mysql_fetch_array($sql_word_text);
                                                    $this_lang_word_text = stripslashes($data_word_text['word_text']);

                                                    ?>
                                                    <td dir="<?php echo $data_langs_retrive['lang_dir']; ?>">
                                                        <small><?php echo $this_lang_word_text; ?></small>
                                                    </td>
                                                    <?php
                                                }
                                                ?>

                                                <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                <td style="text-align: center;"><a
                                                        href="?id=<?php echo $data_retrive['word_id']; ?>&act=update"
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