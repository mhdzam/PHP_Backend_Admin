<?php



require_once("template/page_start.php");
//--------
$id = @$_GET['id'];
$link = @$_GET['link'];
$clicked_btn = @$_POST['clicked_btn'];
$step = @$_GET['step'];
$type = @$_GET['type'];

//-------
$item_code = mysql_real_escape_string(@$_POST['item_code']);
$item_title_en = mysql_real_escape_string(@$_POST['item_title_en']);
$item_title_ar = mysql_real_escape_string(@$_POST['item_title_ar']);

$item_details_ar = mysql_real_escape_string(@$_POST['item_details_ar']);
$item_details_en = mysql_real_escape_string(@$_POST['item_details_en']);

$cat_id = mysql_real_escape_string(@$_POST['cat_id']);
$brand_id = mysql_real_escape_string(@$_POST['brand_id']);
$item_rate = mysql_real_escape_string(@$_POST['item_rate']);
$item_attach_file = mysql_real_escape_string(@$_POST['item_attach_file']);
$item_image_file = mysql_real_escape_string(@$_POST['item_image_file']);
$file_del = mysql_real_escape_string(@$_POST['file_del']);
$item_date = mysql_real_escape_string(@$_POST['item_date']);
if ($item_date == "") {
    $item_date = $pd_current_date;
}

$item_price = mysql_real_escape_string(@$_POST['item_price']);
$item_first_price = mysql_real_escape_string(@$_POST['item_first_price']);
$item_type = mysql_real_escape_string(@$_POST['item_type']);
$item_offer_type = mysql_real_escape_string(@$_POST['item_offer_type']);
$chome = mysql_real_escape_string(@$_POST['chome']);



$item_video_file = mysql_real_escape_string(@$_POST['item_video_file']);
$up_dir = "../uploads/items/";
$file_name = @$_FILES['myfile']['name'];
$file_temp_name = @$_FILES['myfile']['tmp_name'];
$file_size = $up_dir . @$_FILES['myfile']['size'];

$ws_date_status = 0;
$ws_sections_st = 2;
$ws_longtext_status = 1;
$ws_editor_status = 1;
$ws_multiimages_status = 1;
$ws_sizesandcolors_status = 1;
$ws_quantities_status = 1;

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
        <link href="assets/plugins/dropzone/css/dropzone.css" rel="stylesheet"/>
        <link href="assets/css/pages/portfolio.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
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
                        <h3 class="page-title"><?php echo $lang_var_admin_298; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <?php
                            if ($logged_allow_add_status == 1) {
                                ?>
                                <?php
                                if ($act != "new" && $act != "update") {
                                    ?>
                                    <li class="btn-group">
                                        <a href="?act=new"><span id="sample_editable_1_new"
                                                                 class="btn green">
    	<?php echo $lang_var_admin_94; ?> <i class="fa fa-plus"></i>
</span></a>
                                    </li>
                                    <?php

                                }
                                ?>
                                <?php

                            }
                            ?>
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_295; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_298; ?></a>
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

                        if ($act == "insert" && ($item_title_ar != "" || $item_title_en != "")) {
                            // --- upload
                            $item_image_file = "";
                            if ($file_name != "") {
                                $ext = strrchr($file_name, ".");
                                $ext = strtolower($ext);
                                $xrand = time() . rand(11, 99);
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
                                            $item_image_file = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            $sql_slct_max = mysql_query("select max(item_id)  from " . $prefix .
                                "_shop_items");
                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                            $next_item_id = $data_slct_max[0] + 1;
                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_shop_items (
  item_id,
  item_code,
  item_title_ar,
  item_title_en,
  item_details_ar,
  item_details_en,  
  cat_id,
  brand_id,
  item_image_file,
  item_status,
  edit_by,  
  edit_date,
  edit_from,
  item_date,
  item_video_file,
  item_price,
  item_first_price,
  item_type,
  item_offer_type,
  item_rate,chome) VALUES ('$next_item_id','$item_code','$item_title_ar','$item_title_en','$item_details_ar','$item_details_en','$cat_id','$brand_id','$item_image_file','1','$pd_admin_user_id',now(),'$pd_admin_ip','$item_date','$item_video_file','$item_price','$item_first_price','$item_type','$item_offer_type','$item_rate','$chome')");

                            if ($sql_insert_new) {

                                // insert notification
                                $note_title_ar = ($lang_var_admin_405 . ": " . $item_title_ar);
                                $note_title_en = ($lang_var_admin_406 . ": " . $item_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-success'>
                            <i class='fa fa-shopping-cart'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("shop_items.php?id=$next_item_id&act=update");

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
                        if ($act == "saveupdate" && ($item_title_ar != "" || $item_title_en != "") && $id != "") {

                            // --- upload
                            if ($file_del == 1) {
                                @unlink("$up_dir" . "$item_image_file");
                                $item_image_file = "";
                            }
                            if ($file_name != "") {
                                if ($item_image_file != "") {
                                    @unlink("$up_dir" . "$item_image_file");
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
                                            $item_image_file = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            $sql_update = mysql_query("UPDATE " . $prefix . "_shop_items SET item_code='$item_code',item_title_ar='$item_title_ar',item_title_en='$item_title_en',cat_id='$cat_id',brand_id='$brand_id',item_image_file='$item_image_file',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip',item_details_ar='$item_details_ar',item_details_en='$item_details_en',item_date='$item_date',item_video_file='$item_video_file',item_price='$item_price',item_first_price='$item_first_price',item_type='$item_type',item_offer_type='$item_offer_type',item_rate='$item_rate',chome='$chome' WHERE item_id='$id'") or
                            die(mysql_error());

                            if ($sql_update) {

                                // insert notification
                                $note_title_ar = ($lang_var_admin_387 . " " . $item_title_ar);
                                $note_title_en = ($lang_var_admin_388 . " " . $item_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-info'>
                            <i class='fa fa-pencil-square-o'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("shop_items.php?id=$id&act=update");

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

                            $act = "update";
                        }

                        if ($act == "update") {

                            @ require_once("template/shop_items_update.php");

                        } elseif ($act == "new") {

                            @ require_once("template/shop_items_new.php");

                        } else {

                            @ require_once("template/shop_items_view.php");
                            ?>
                            <a class="mix-preview fancybox-button" data-rel="fancybox-button"></a>
                            <?php
                        }
                        ?>

                        <?php
                        //   ----------- PAGE END


                        $nosrtt_clmn = "5";
                        if ($ws_date_status == 1) {
                            $nosrtt_clmn = "6";
                        }

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

    <script src="assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"
            type="text/javascript"></script>
    <script src="assets/plugins/dropzone/dropzone.js"></script>
    <script src="assets/scripts/custom/form-dropzone.js"></script>

    <script type="text/javascript" src="assets/plugins/jquery-mixitup/jquery.mixitup.min.js"></script>
    <script type="text/javascript" src="assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
    <script src="assets/scripts/custom/portfolio.js"></script>

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
                        "sAjaxSource": "template/shop_items_view_ajax.php?lang=<?php echo $lang; ?>&var_admin_6=<?php echo $lang_var_admin_6; ?>&var_admin_25=<?php echo $lang_var_admin_25; ?>&logged_allow_edit_status=<?php echo $logged_allow_edit_status; ?>", // ajax source
                        "aaSorting": [[1, "desc"]], // set first column as a default sort by asc
                        "aoColumnDefs": [{
                            'bSortable': false,
                            'aTargets': [0, <?php echo $nosrtt_clmn; ?>]
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
            FormDropzone.init();
            TableAjax.init();
            Portfolio.init();
            UIAlertDialogApi.init();

        });
    </script>

    </body>
    <!-- END BODY -->
    </html>
<?php

require_once("template/page_end.php");
?>