<?php


require_once("template/page_start.php");
//--------
$thisip = mysql_real_escape_string(@$_GET['ip']);
//-------


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
        <link rel="stylesheet" type="text/css" href="assets/css/flags.css"/>
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
                        <h3 class="page-title"><?php echo $lang_var_admin_420; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-<?php echo $site_lang_align_right; ?>"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_214; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_420; ?></a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="inbox-header">
                    <form class="form-inline" method="get" action="?" data-ajax="false">
                        <input type="hidden" name="a" value="search"/>

                        <div class="input-group input-medium">
                            <input type="text" name="ip" value="<?php echo @$thisip; ?>" required=""
                                   pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" class="form-control"
                                   placeholder="IP">
								<span class="input-group-btn">
									<button type="submit" class="btn green"><i class="fa fa-search"></i></button>
								</span>
                        </div>
                    </form>
                </div>
                <br>

                <div class="row">
                    <?php
                    //   ----------- PAGE START

                    if ($thisip != "") {

                        $sql_modify = mysql_query("SELECT * FROM " . $prefix . "_analytics_visitors  WHERE visitor_ip ='$thisip' order by visitor_id desc limit 1 ");
                        $data_modify = mysql_fetch_array($sql_modify);
                        $visitor_location_cor1 = stripcslashes($data_modify['visitor_location_cor1']);
                        $visitor_location_cor2 = stripcslashes($data_modify['visitor_location_cor2']);
                        $visitor_os = stripcslashes($data_modify['visitor_os']);
                        $visitor_browser = stripcslashes($data_modify['visitor_browser']);
                        $visitor_resolution = stripcslashes($data_modify['visitor_resolution']);
                        $visitor_referrer = stripcslashes($data_modify['visitor_referrer']);
                        $visitor_hostname = stripcslashes($data_modify['visitor_hostname']);
                        $visitor_org = stripcslashes($data_modify['visitor_org']);
                        $post_date_lng = "";
                        $visitor_time_lng = "";
                        if ($data_modify['visitor_date'] != "") {
                            $post_date_lng = date('d-m-Y', strtotime($data_modify['visitor_date']));
                            $visitor_time_lng = date('h:i:s A', strtotime($data_modify['visitor_time']));
                        }
                        $flag0 = "";
                        if ($visitor_browser == "Chrome") {
                            $flag0 = "<img src='assets/img/browsers/chrome.png'>";
                        }
                        if ($visitor_browser == "Firefox") {
                            $flag = "<img src='assets/img/browsers/firefox.png'>";
                        }
                        if ($visitor_browser == "Internet Explorer 11") {
                            $flag0 = "<img src='assets/img/browsers/iexplorer.png'>";
                        }
                        if ($visitor_browser == "Safari") {
                            $flag0 = "<img src='assets/img/browsers/safari.png'>";
                        }
                        if ($visitor_browser == "Opera") {
                            $flag0 = "<img src='assets/img/browsers/opera.png'>";
                        }

                        $flag1 = "";
                        $sub_7char = substr($visitor_os, 0, 7);
                        if ($sub_7char == "Windows") {
                            $flag1 = "<img src='assets/img/browsers/microsoft.png'>";
                        }
                        if ($visitor_os == "Mac OS X") {
                            $flag1 = "<img src='assets/img/browsers/apple.png'>";
                        }
                        if ($visitor_os == "Android") {
                            $flag1 = "<img src='assets/img/browsers/android.png'>";
                        }
                        if ($visitor_os == "iPhone" || $visitor_os == "iPod" || $visitor_os == "iPad") {
                            $flag1 = "<div style='float: $site_lang_align_left;'><img src='assets/img/browsers/ios.png'>";
                        }
                        if ($visitor_os == "Linux" || $visitor_os == "Ubuntu") {
                            $flag1 = "<img src='assets/img/browsers/linux.png'>";
                        }
                        if ($visitor_os == "BlackBerry") {
                            $flag1 = "<img src='assets/img/browsers/blackberry.png'>";
                        }


                        $visitor_ip_details = json_decode(@file_get_contents("http://ipinfo.io/{$thisip}/json"));

                        $visitor_city = @$visitor_ip_details->city;
                        if ($visitor_city == "") {
                            $visitor_city = "unknown";
                        }
                        $visitor_region = @$visitor_ip_details->region;
                        if ($visitor_region == "") {
                            $visitor_region = "unknown";
                        }

                        $visitor_country_code = @$visitor_ip_details->country;

                        $sql_gc = mysql_query("SELECT * FROM " . $prefix . "_countries  WHERE country_code ='$visitor_country_code' limit 1 ");
                        $data_gc = mysql_fetch_array($sql_gc);
                        $visitor_country = stripcslashes($data_gc['country_en']);
                        $visitor_address = "$visitor_region, $visitor_city, $visitor_country";

                        $visitor_loc = explode(',', @$visitor_ip_details->loc);
                        $visitor_loc_0 = @$visitor_loc[0];
                        if ($visitor_loc_0 == "") {
                            $visitor_loc_0 = "unknown";
                        }
                        $visitor_loc_1 = @$visitor_loc[1];
                        if ($visitor_loc_1 == "") {
                            $visitor_loc_1 = "unknown";
                        }

                        $visitor_org = @$visitor_ip_details->org;
                        if ($visitor_org == "") {
                            $visitor_org = "unknown";
                        }
                        $visitor_hostname = @$visitor_ip_details->hostname;
                        if ($visitor_hostname == "") {
                            $visitor_hostname = "No Hostname";
                        }


                        $flag = "";
                        $country_code = strtolower(stripcslashes($visitor_country_code));
                        if ($country_code != "unknown") {
                            $flag = "<div class='flag flag-$country_code' style='display: inline-block'></div>";
                        }

                        ?>
                        <?php
                        $col2wdth = "12";
                        if ($visitor_loc_0 != "unknown" && $visitor_loc_1 != "unknown") {
                            $col2wdth = "6";
                            ?>
                            <div class="col-md-6">
                                <!-- BEGIN MARKERS PORTLET-->
                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-map-marker"></i> <?php echo $lang_var_admin_421; ?>
                                        </div>
                                    </div>
                                    <div class="portlet-body">

                                        <div id="ipmap" class="gmaps" style="height: 380px">
                                        </div>
                                        <?php echo $lang_var_admin_191; ?> : <?php echo $visitor_loc_0; ?>
                                        , <?php echo $visitor_loc_1; ?>

                                    </div>
                                </div>
                                <!-- END MARKERS PORTLET-->
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-md-<?php echo $col2wdth; ?>">
                            <div class="portlet">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <br>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-hover">

                                        <tbody>

                                        <tr>
                                            <th style="border: 0"><?php echo $lang_var_admin_217; ?></th>
                                            <td style="border: 0"><?php echo $flag; ?> <?php echo $visitor_country; ?>
                                                - <?php echo $visitor_country_code; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $lang_var_admin_216; ?></th>
                                            <td><?php echo $visitor_city; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $lang_var_admin_423; ?></th>
                                            <td><?php echo $visitor_region; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $lang_var_admin_192; ?></th>
                                            <td><?php echo $visitor_address; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $lang_var_admin_222; ?></th>
                                            <td><?php echo $visitor_hostname; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $lang_var_admin_223; ?></th>
                                            <td><?php echo $visitor_org; ?></td>
                                        </tr>

                                        <tr>
                                            <th><?php echo $lang_var_admin_422; ?></th>
                                            <td><?php echo $post_date_lng; ?>
                                                &nbsp; <?php echo $visitor_time_lng; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $lang_var_admin_218; ?></th>
                                            <td><?php echo $flag1; ?><?php echo $visitor_os; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $lang_var_admin_219; ?></th>
                                            <td><?php echo $flag0; ?><?php echo $visitor_browser; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $lang_var_admin_220; ?></th>
                                            <td><?php echo $visitor_resolution; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo $lang_var_admin_221; ?></th>
                                            <td><?php echo $visitor_referrer; ?></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h4><?php echo $lang_var_admin_424; ?></h4>
                            <hr>
                            <?php
                            @ require_once("template/ip_view.php");
                            ?>
                        </div>

                        <?php
//   ----------- PAGE END

                    }

                    ?>

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
                        "sAjaxSource": "template/ip_view_ajax.php?lang=<?php echo $lang; ?>&var_admin_6=<?php echo $lang_var_admin_6; ?>&var_admin_25=<?php echo $lang_var_admin_25; ?>&thisip=<?php echo $thisip; ?>", // ajax source
                        "aaSorting": [[1, "desc"]], // set first column as a default sort by asc
                        "aoColumnDefs": [{
                            'bSortable': false,
                            'aTargets': [0]
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
    <?php
    if ($visitor_loc_0 != "unknown" && $visitor_loc_1 != "unknown") {
        ?>
        <script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyAgzruFTTvea0LEmw_jAqknqskKDuJK7dM&sensor=false"></script>
        <script type="text/javascript">
            function initialize() {
                var latlng = new google.maps.LatLng(<?php echo $visitor_loc_0; ?>, <?php echo $visitor_loc_1; ?>);
                var myOptions = {
                    zoom: 9,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                var map = new google.maps.Map(document.getElementById("ipmap"), myOptions);

                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: '<?php echo $thisip; ?>'
                });
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
        <?php
    }
    ?>
    </body>
    <!-- END BODY -->
    </html>
<?php
require_once("template/page_end.php");
?>