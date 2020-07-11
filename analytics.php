<?php

require_once("template/page_start.php");
if ($site_analytics_status == 1) {
//--------
    $stat = @$_GET['stat'];

    $daterangepicker_start = @$_POST['this_daterangepicker_start'];
    if ($daterangepicker_start == "") {
        $daterangepicker_start = $pd_before_29day_date;
    }
    $daterangepicker_end = @$_POST['this_daterangepicker_end'];
    if ($daterangepicker_end == "") {
        $daterangepicker_end = $pd_current_date;
    }
    $daterangepicker_start_text = date("F d , Y", strtotime($daterangepicker_start));
    $daterangepicker_end_text = date("F d , Y", strtotime($daterangepicker_end));

    $sql_get_minmax = mysql_query("SELECT min(visitor_date) as min_visitor_date, max(visitor_date) as max_visitor_date FROM " . $prefix . "_analytics_visitors");
    $data_get_minmax = mysql_fetch_array($sql_get_minmax);
    $min_visitor_date = date('d-m-Y', strtotime('-29 day'));
    if ($data_get_minmax['min_visitor_date'] != "") {
        $min_visitor_date = date("d-m-Y", strtotime($data_get_minmax['min_visitor_date']));
    }
    $max_visitor_date = date('d-m-Y', strtotime('-1 day'));
    if ($data_get_minmax['max_visitor_date'] != "") {
        $max_visitor_date = date("d-m-Y", strtotime($data_get_minmax['max_visitor_date']));
        $max_visitor_date = date('d-m-Y', strtotime($max_visitor_date . ' + 1 day'));
    }

    $srchbystate = "";
    if ($stat == "city") {
        $srchbystate = "visitor_city";
        $by_title_is = $lang_var_admin_216;
    } elseif ($stat == "country") {
        $srchbystate = "visitor_country";
        $by_title_is = $lang_var_admin_217;
    } elseif ($stat == "os") {
        $srchbystate = "visitor_os";
        $by_title_is = $lang_var_admin_218;
    } elseif ($stat == "browser") {
        $srchbystate = "visitor_browser";
        $by_title_is = $lang_var_admin_219;
    } elseif ($stat == "resolution") {
        $srchbystate = "visitor_resolution";
        $by_title_is = $lang_var_admin_220;
    } elseif ($stat == "referrer") {
        $srchbystate = "visitor_referrer";
        $by_title_is = $lang_var_admin_221;
    } elseif ($stat == "hostname") {
        $srchbystate = "visitor_hostname";
        $by_title_is = $lang_var_admin_222;
    } elseif ($stat == "org") {
        $srchbystate = "visitor_org";
        $by_title_is = $lang_var_admin_223;
    } else {
        $srchbystate = "visitor_date";
        $by_title_is = $lang_var_admin_215;
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
        <link href="assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
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
                        <h3 class="page-title"><?php echo $lang_var_admin_214; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_214; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $by_title_is; ?></a>
                            </li>
                            <li class="pull-right">
                                <form method="post" action="?stat=<?php echo $stat; ?>" id="form_ofchangedate">
                                    <div id="dashboard-report-range" class="dashboard-date-range tooltips"
                                         data-placement="top" data-original-title="Change dashboard date range">
                                        <i class="fa fa-calendar"></i>
								<span>
								</span>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <input type="hidden" id="this_daterangepicker_start"
                                           name="this_daterangepicker_start" value=""/>
                                    <input type="hidden" id="this_daterangepicker_end" name="this_daterangepicker_end"
                                           value=""/>
                                </form>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <?php
                //	echo $daterangepicker_start." - ".$daterangepicker_end;
                ?>
                <!-- BEGIN CHART PORTLETS-->
                <div class="row">
                    <div class="col-md-12">


                        <!-- BEGIN INTERACTIVE CHART PORTLET-->
                        <div id="chart_2" class="chart">
                        </div>
                        <!-- END INTERACTIVE CHART PORTLET-->


                    </div>
                </div>
                <!-- END CHART PORTLETS-->

                <div>

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th style="width: 5%;text-align: center;">#</th>
                            <th><?php echo $by_title_is; ?></th>
                            <th style="width: 25%;text-align: center;"><?php echo $lang_var_admin_224; ?></th>
                            <th style="width: 25%;text-align: center;"><?php echo $lang_var_admin_225; ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $stps = 1;
                        $chart_visitors_values = "";
                        $chart_pageviews_values = "";
                        $chart_y_labels = "";

                        $order_by_is = "COUNT($srchbystate)";
                        if ($stat == "date" || $stat == "") {
                            $order_by_is = "visitor_date";
                        }
                        $sql_tv = mysql_query("SELECT * FROM " . $prefix . "_analytics_visitors where ((visitor_date = '$daterangepicker_start' OR visitor_date > '$daterangepicker_start') AND (visitor_date = '$daterangepicker_end' OR visitor_date < '$daterangepicker_end')) GROUP BY $srchbystate ORDER BY $order_by_is desc limit 40");

                        while ($data_tv = mysql_fetch_array($sql_tv)) {
                            $title_name_is = stripcslashes($data_tv[$srchbystate]);
                            $visitor_country_code = strtolower(stripcslashes($data_tv['visitor_country_code']));

                            $sql_vis = mysql_query("SELECT COUNT(visitor_id) as vvcccnnt  FROM " . $prefix . "_analytics_visitors where $srchbystate='$data_tv[$srchbystate]' and ((visitor_date = '$daterangepicker_start' OR visitor_date > '$daterangepicker_start') AND (visitor_date = '$daterangepicker_end' OR visitor_date < '$daterangepicker_end')) ");
                            $data_vis = mysql_fetch_array($sql_vis);

                            $sql_pgs = mysql_query("SELECT COUNT(page_id) as ppcccnnt FROM " . $prefix . "_analytics_pages where visitor_id in (SELECT visitor_id FROM " . $prefix . "_analytics_visitors where $srchbystate='$data_tv[$srchbystate]') and ((visitor_date = '$daterangepicker_start' OR visitor_date > '$daterangepicker_start') AND (visitor_date = '$daterangepicker_end' OR visitor_date < '$daterangepicker_end')) ");
                            $data_pgs = mysql_fetch_array($sql_pgs);

                            $stpsvlu = "";
                            if ($stps != 1) {
                                $stpsvlu = ",";
                            }
                            if ($stps < 31) {
                                $chart_visitors_values .= "$stpsvlu" . "[$stps, $data_vis[vvcccnnt]]";
                                $chart_pageviews_values .= "$stpsvlu" . "[$stps, $data_pgs[ppcccnnt]]";
                                $chart_y_labels .= "$stpsvlu" . "'$title_name_is'";
                            }
                            $flag = "";
                            if ($stat == "country") {
                                $flag = "<div class='flag flag-$visitor_country_code' style='float: $site_lang_align_left;margin: 5px;'></div>";
                            }
                            if ($stat == "browser") {
                                if ($title_name_is == "Chrome") {
                                    $flag = "<div style='float: $site_lang_align_left;margin: 5px;'><img src='assets/img/browsers/chrome.png'></div>";
                                }
                                if ($title_name_is == "Firefox") {
                                    $flag = "<div style='float: $site_lang_align_left;margin: 5px;'><img src='assets/img/browsers/firefox.png'></div>";
                                }
                                if ($title_name_is == "Internet Explorer 11") {
                                    $flag = "<div style='float: $site_lang_align_left;margin: 5px;'><img src='assets/img/browsers/iexplorer.png'></div>";
                                }
                                if ($title_name_is == "Safari") {
                                    $flag = "<div style='float: $site_lang_align_left;margin: 5px;'><img src='assets/img/browsers/safari.png'></div>";
                                }
                                if ($title_name_is == "Opera") {
                                    $flag = "<div style='float: $site_lang_align_left;margin: 5px;'><img src='assets/img/browsers/opera.png'></div>";
                                }
                            }
                            if ($stat == "os") {
                                $sub_7char = substr($title_name_is, 0, 7);
                                if ($sub_7char == "Windows") {
                                    $flag = "<div style='float: $site_lang_align_left;margin: 5px;'><img src='assets/img/browsers/microsoft.png'></div>";
                                }
                                if ($title_name_is == "Mac OS X") {
                                    $flag = "<div style='float: $site_lang_align_left;margin: 5px;'><img src='assets/img/browsers/apple.png'></div>";
                                }
                                if ($title_name_is == "Android") {
                                    $flag = "<div style='float: $site_lang_align_left;margin: 5px;'><img src='assets/img/browsers/android.png'></div>";
                                }
                                if ($title_name_is == "iPhone" || $title_name_is == "iPod" || $title_name_is == "iPad") {
                                    $flag = "<div style='float: $site_lang_align_left;margin: 5px;'><img src='assets/img/browsers/ios.png'></div>";
                                }
                                if ($title_name_is == "Linux" || $title_name_is == "Ubuntu") {
                                    $flag = "<div style='float: $site_lang_align_left;margin: 5px;'><img src='assets/img/browsers/linux.png'></div>";
                                }
                                if ($title_name_is == "BlackBerry") {
                                    $flag = "<div style='float: $site_lang_align_left;margin: 5px;'><img src='assets/img/browsers/blackberry.png'></div>";
                                }
                            }
                            ?>
                            <tr class="odd gradeX">
                                <td style="text-align: center;"><?php echo $stps; ?></td>
                                <td><?php echo $flag; ?><?php echo $title_name_is; ?></td>
                                <td style="text-align: center;"><?php echo $data_vis['vvcccnnt']; ?></td>
                                <td style="text-align: center;"><?php echo $data_pgs['ppcccnnt']; ?></td>

                            </tr>
                            <?php
                            $stps++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

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

    <script src="assets/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap-daterangepicker/daterangepicker_<?php echo $site_lang_dir; ?>.js"
            type="text/javascript"></script>

    <script src="assets/plugins/flot/jquery.flot.min.js"></script>
    <script src="assets/plugins/flot/jquery.flot.resize.min.js"></script>
    <script src="assets/plugins/flot/jquery.flot.pie.min.js"></script>
    <script src="assets/plugins/flot/jquery.flot.stack.min.js"></script>
    <script src="assets/plugins/flot/jquery.flot.crosshair.min.js"></script>
    <script src="assets/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>

    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/scripts/core/app.js"></script>


    <script>

        var Charts = function () {

            return {
                //main function to initiate the module

                init: function () {

                },

                initCharts: function () {

                    //Interactive Chart

                    function chart2() {

                        var pageviews = [
                            <?php echo $chart_visitors_values; ?>
                        ];
                        var visitors = [
                            <?php echo $chart_pageviews_values; ?>
                        ];

                        var plot = $.plot($("#chart_2"), [{
                            data: pageviews,
                            label: "&nbsp;<?php echo $lang_var_admin_224; ?>",
                            lines: {
                                lineWidth: 1,
                            },
                            shadowSize: 0

                        }, {
                            data: visitors,
                            label: "&nbsp;<?php echo $lang_var_admin_225; ?>",
                            lines: {
                                lineWidth: 1,
                            },
                            shadowSize: 0
                        }
                        ], {
                            series: {
                                lines: {
                                    show: true,
                                    lineWidth: 2,
                                    fill: true,
                                    fillColor: {
                                        colors: [{
                                            opacity: 0.05
                                        }, {
                                            opacity: 0.01
                                        }
                                        ]
                                    }
                                },
                                points: {
                                    show: true,
                                    radius: 3,
                                    lineWidth: 1
                                },
                                shadowSize: 2
                            },
                            grid: {
                                hoverable: true,
                                clickable: true,
                                tickColor: "#eee",
                                borderColor: "#eee",
                                borderWidth: 1
                            },
                            colors: ["#d12610", "#37b7f3", "#52e136"],
                            xaxis: {
                                ticks: 11,
                                tickDecimals: 0,
                                tickColor: "#eee",
                            },
                            yaxis: {
                                ticks: 11,
                                tickDecimals: 0,
                                tickColor: "#eee",
                            }
                        });


                        function showTooltip(x, y, contents) {
                            $('<div id="tooltip">' + contents + '</div>').css({
                                position: 'absolute',
                                display: 'none',
                                top: y + 5,
                                left: x + 15,
                                border: '1px solid #333',
                                padding: '4px',
                                color: '#fff',
                                'border-radius': '3px',
                                'background-color': '#333',
                                opacity: 0.80
                            }).appendTo("body").fadeIn(200);
                        }

                        var previousPoint = null;
                        $("#chart_2").bind("plothover", function (event, pos, item) {
                            $("#x").text(pos.x.toFixed(2));
                            $("#y").text(pos.y.toFixed(2));

                            if (item) {
                                if (previousPoint != item.dataIndex) {
                                    previousPoint = item.dataIndex;

                                    $("#tooltip").remove();
                                    var x = item.datapoint[0].toFixed(2),
                                        y = item.datapoint[1].toFixed(2);

                                    showTooltip(item.pageX, item.pageY, item.series.label + " " + x + " = " + y);
                                }
                            } else {
                                $("#tooltip").remove();
                                previousPoint = null;
                            }
                        });
                    }


                    //graph
                    chart2();

                },

            };

        }();

        // ------
        var Index = function () {
            return {
                initDashboardDaterange: function () {

                    $('#dashboard-report-range').daterangepicker({
                            opens: (App.isRTL() ? 'right' : 'left'),
                            startDate: '<?php echo date("d-m-Y", strtotime($daterangepicker_start)); ?>',
                            endDate: '<?php echo date("d-m-Y", strtotime($daterangepicker_end)); ?>',
                            minDate: '<?php echo $min_visitor_date; ?>',
                            maxDate: '<?php echo $max_visitor_date; ?>',
                            showDropdowns: false,
                            showWeekNumbers: false,
                            timePicker: false,
                            timePickerIncrement: 1,
                            timePicker12Hour: true,
                            ranges: {
                                '<?php echo $lang_var_admin_226; ?>': [moment(), moment()],
                                '<?php echo $lang_var_admin_227; ?>': [moment().subtract('days', 1), moment().subtract('days', 1)],
                                '<?php echo $lang_var_admin_228; ?>': [moment().subtract('days', 6), moment()],
                                '<?php echo $lang_var_admin_229; ?>': [moment().subtract('days', 29), moment()],
                                '<?php echo $lang_var_admin_230; ?>': [moment().startOf('month'), moment().endOf('month')],
                                '<?php echo $lang_var_admin_231; ?>': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                            },
                            buttonClasses: ['btn'],
                            applyClass: 'blue',
                            cancelClass: 'default',
                            format: 'DD-MM-YYYY',
                            separator: ' to ',
                            locale: {
                                applyLabel: 'Apply',
                                fromLabel: 'From',
                                toLabel: 'To',
                                customRangeLabel: '<?php echo $lang_var_admin_232; ?>',
                                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                firstDay: 1
                            }
                        },
                        function (start, end) {
                            $('#dashboard-report-range span').html(start.format('MMMM D , YYYY') + ' - ' + end.format('MMMM D , YYYY'));
                            $("#this_daterangepicker_start").val(start.format('YYYY-MM-DD'));
                            $("#this_daterangepicker_end").val(end.format('YYYY-MM-DD'));
                            $("#form_ofchangedate").submit();
                        }
                    );


                    $('#dashboard-report-range span').html("<?php echo $daterangepicker_start_text; ?>" + ' - ' + "<?php echo $daterangepicker_end_text; ?>");
                    $("#this_daterangepicker_start").val("<?php echo $daterangepicker_start; ?>");
                    $("#this_daterangepicker_end").val("<?php echo $daterangepicker_end; ?>");
                    $('#dashboard-report-range').show();
                }
            };

        }();

        jQuery(document).ready(function () {
            // initiate layout and plugins
            App.init();
            Charts.init();
            Charts.initCharts();
            Index.initDashboardDaterange();
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