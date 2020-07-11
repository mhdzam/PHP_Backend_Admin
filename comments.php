<?php
require_once("template/page_start.php");
//--------
$id = @$_GET['id'];
$link = @$_GET['link'];
$clicked_btn = @$_POST['clicked_btn'];
//-------

$name = mysql_real_escape_string(@$_POST['name']);
$email = mysql_real_escape_string(@$_POST['email']);
$comment = mysql_real_escape_string(@$_POST['comment']);

if ($wm_section != "" && $wm_section != 0 && is_numeric($wm_section)) {

    $sql_get_webmaster_sections = mysql_query("SELECT * FROM " . $prefix . "_webmaster_sections  WHERE ws_id ='$wm_section'");
    $data_get_webmaster_sections = mysql_fetch_array($sql_get_webmaster_sections);
    $ws_title_var = stripcslashes($data_get_webmaster_sections['ws_title_var']);
    $ws_title_var = $$ws_title_var;
    $ws_sections_st = stripcslashes($data_get_webmaster_sections['ws_sections_st']);
    $ws_comments_st = stripcslashes($data_get_webmaster_sections['ws_comments_st']);
    $ws_type = stripcslashes($data_get_webmaster_sections['ws_type']);
    $ws_extra1_title_var = stripcslashes($data_get_webmaster_sections['ws_extra1_title_var']);
    $ws_extra2_title_var = stripcslashes($data_get_webmaster_sections['ws_extra2_title_var']);
    $ws_extra3_title_var = stripcslashes($data_get_webmaster_sections['ws_extra3_title_var']);
    $ws_extra4_title_var = stripcslashes($data_get_webmaster_sections['ws_extra4_title_var']);
    $ws_extra5_title_var = stripcslashes($data_get_webmaster_sections['ws_extra5_title_var']);
    $ws_extra6_title_var = stripcslashes($data_get_webmaster_sections['ws_extra6_title_var']);
    $ws_date_status = stripcslashes($data_get_webmaster_sections['ws_date_status']);
    $ws_longtext_status = stripcslashes($data_get_webmaster_sections['ws_longtext_status']);
    $ws_editor_status = stripcslashes($data_get_webmaster_sections['ws_editor_status']);
    $ws_attachfile_status = stripcslashes($data_get_webmaster_sections['ws_attachfile_status']);

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
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-datepicker/css/datepicker.css"/>


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
                        <h3 class="page-title"><?php echo $lang_var_admin_86 . " " . $ws_title_var; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">

                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $ws_title_var; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_86 . " " . $ws_title_var; ?></a>
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


                        if ($act == "saveupdate" && $comment != "" && $id != "") {

                            $sql_update = mysql_query("UPDATE " . $prefix . "_topics_comments SET name='$name',email='$email',comment='$comment',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip' WHERE comment_id='$id'") or
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

                            @ require_once("template/topic_update_comments.php");

                        } else {

                            @ require_once("template/topic_view_comments.php");

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

    <script type="text/javascript" src="assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-markdown/lib/markdown.js"></script>

    <!-- END PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript" src="assets/plugins/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="assets/scripts/custom/tinymce.js"></script>

    <link type="text/css" rel="stylesheet"
          href="assets/plugins/tinymce/plugins/moxiemanager/skins/lightgray/skin.min.css"/>
    <script src="assets/plugins/tinymce/plugins/moxiemanager/js/moxman.api.min.js"></script>
    <script src="assets/plugins/tinymce/plugins/moxiemanager/api.php?action=PluginJs"></script>

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/scripts/core/app.js"></script>
    <script src="assets/scripts/custom/table-managed.js"></script>

    <script src="assets/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="assets/scripts/custom/ui-alert-dialog-api.js"></script>
    <script src="assets/scripts/core/datatable_<?php echo $site_lang_dir; ?>.js"></script>
    <script src="assets/scripts/custom/table-ajax.js"></script>
    <script>
        var TableAjax = function () {

            var initPickers = function () {
                //init date pickers
                $('.date-picker').datepicker({
                    rtl: App.isRTL(),
                    autoclose: true
                });
            }

            var handleRecords = function () {

                var grid = new Datatable();
                grid.init({
                    src: $("#datatable_ajax"),
                    onSuccess: function (grid) {
                        // execute some code after table records loaded
                    },
                    onError: function (grid) {
                        // execute some code on network or other general error
                    },
                    dataTable: {  // here you can define a typical datatable settings from http://datatables.net/usage/options
                        /*
                         By default the ajax datatable's layout is horizontally scrollable and this can cause an issue of dropdown menu is used in the table rows which.
                         Use below "sDom" value for the datatable layout if you want to have a dropdown menu for each row in the datatable. But this disables the horizontal scroll.
                         */
                        //"sDom" : "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>r>>",

                        "aLengthMenu": [
                            [10, 30, 50, 100, 150, -1],
                            [10, 30, 50, 100, 150, "All"] // change per page values here
                        ],
                        "iDisplayLength": 30, // default record count per page
                        "bServerSide": true, // server side processing
                        "sAjaxSource": "template/topic_view_comments_ajax.php?wm_section=<?php echo $wm_section; ?>&lang=<?php echo $lang; ?>&var_admin_6=<?php echo $lang_var_admin_6; ?>&var_admin_25=<?php echo $lang_var_admin_25; ?>&logged_allow_edit_status=<?php echo $logged_allow_edit_status; ?>", // ajax source
                        "aaSorting": [[1, "desc"]], // set first column as a default sort by asc
                        "aoColumnDefs": [{
                            'bSortable': false,
                            'aTargets': [0, 5]
                        }]
                    }
                });

                // handle group actionsubmit button click
                grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
                    e.preventDefault();
                    var action = $(".table-group-action-input", grid.getTableWrapper());
                    if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                        if (action.val() == "b_delete") {
                            if (confirm('<?php echo $lang_var_admin_109; ?>')) {
                                // Save it!
                                grid.addAjaxParam("sAction", "group_action");
                                grid.addAjaxParam("sGroupActionName", action.val());
                                var records = grid.getSelectedRows();
                                for (var i in records) {
                                    grid.addAjaxParam(records[i]["name"], records[i]["value"]);
                                }
                                grid.getDataTable().fnDraw();
                                grid.clearAjaxParams();
                            }
                        } else {
                            grid.addAjaxParam("sAction", "group_action");
                            grid.addAjaxParam("sGroupActionName", action.val());
                            var records = grid.getSelectedRows();
                            for (var i in records) {
                                grid.addAjaxParam(records[i]["name"], records[i]["value"]);
                            }
                            grid.getDataTable().fnDraw();
                            grid.clearAjaxParams();
                        }
                    } else if (action.val() == "") {
                        App.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: '<?php echo $lang_var_admin_107; ?>',
                            container: grid.getTableWrapper(),
                            place: 'prepend'
                        });
                    } else if (grid.getSelectedRowsCount() === 0) {
                        App.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: '<?php echo $lang_var_admin_108; ?>',
                            container: grid.getTableWrapper(),
                            place: 'prepend'
                        });
                    }
                });

            }

            return {

                //main function to initiate the module
                init: function () {

                    initPickers();
                    handleRecords();
                }

            };

        }();

        jQuery(document).ready(function () {
            App.init();
            UIAlertDialogApi.init();
            TableManaged.init();

            TableAjax.init();

        });
    </script>
    </body>
    <!-- END BODY -->
    </html>
    <?php
} else {
    header("Location: index.php");
    exit();
}
require_once("template/page_end.php");
?>