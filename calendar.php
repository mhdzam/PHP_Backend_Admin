<?php

require_once("template/page_start.php");
if ($site_calendar_status == 1) {
//--------

    $eventact = @$_GET['eventact'];
    $event_id = @$_GET['id'];
    $cal_title = mysql_real_escape_string(@$_POST['cal_title']);
    $from_date = mysql_real_escape_string(@$_POST['from_date']);
    if ($from_date == "") {
        $from_date = $pd_current_date_long;
    }
    $pview = @$_GET['pview'];
    $to_date = mysql_real_escape_string(@$_POST['to_date']);
    $cal_details = mysql_real_escape_string(@$_POST['cal_details']);
    $cal_color = mysql_real_escape_string(@$_POST['cal_color']);


    if ($eventact == "delete" && $event_id != "") {
        $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_calendar where cal_id = '$event_id'");
        if ($pview == "list") {
            header("Location: calendar_list.php");
        }
    }

    if ($eventact == "save" && $cal_title != "" && $event_id != "") {
        if ($from_date != "") {
            $from_date = date('Y-m-d H:i:s', strtotime($from_date));
        }
        $toosave = ",to_date=NULL";
        if ($to_date != "") {
            $to_date = date('Y-m-d H:i:s', strtotime($to_date));
            $toosave = ",to_date='$to_date'";
        }
        $sql_update = mysql_query("UPDATE " . $prefix . "_calendar SET cal_title='$cal_title',from_date='$from_date' $toosave,cal_details='$cal_details',cal_color='$cal_color',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip' WHERE cal_id='$event_id'") or
        die(mysql_error());

        if ($sql_update) {

            $post_date_lng = date('d-m-Y h:i A', strtotime($from_date));
            // insert notification
            $note_title_ar = ($lang_var_admin_387 . " " . $cal_title . " $post_date_lng");
            $note_title_en = ($lang_var_admin_388 . " " . $cal_title . " $post_date_lng");
            $note_icon = mysql_real_escape_string("<div class='label label-sm label-warning'>
                            <i class='fa fa-calendar'></i>
                        </div>");
            $note_url = mysql_real_escape_string("calendar.php");

            require_once("template/notifications_insert.php");
            // end of insert notification
        }
        if ($pview == "list") {
            header("Location: calendar_list.php");
        }
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
        <link href="assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet"/>

        <link rel="stylesheet" type="text/css" href="assets/plugins/clockface/css/clockface.css"/>
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-datepicker/css/datepicker.css"/>
        <link rel="stylesheet" type="text/css"
              href="assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>

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
                        <h3 class="page-title"><?php echo $lang_var_admin_195; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_195; ?></a>
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

    if ($act == "update") {

        $sql_modify = mysql_query("SELECT * FROM " . $prefix . "_calendar WHERE cal_id ='$event_id' ");
        $data_modify = mysql_fetch_array($sql_modify);
        $from_date = stripcslashes($data_modify['from_date']);
        $to_date = stripcslashes($data_modify['to_date']);
        $cal_title = stripcslashes($data_modify['cal_title']);
        $cal_color = stripcslashes($data_modify['cal_color']);
        $cal_details = stripcslashes($data_modify['cal_details']);

        $edit_date = $data_modify['edit_date'];
        $edit_by = GetAdminUserName($data_modify['edit_by']);
        $edit_from = $data_modify['edit_from'];

        $from_date = date('Y-m-d h:i A', strtotime($from_date));
        if ($to_date != "") {
            $to_date = date('Y-m-d h:i A', strtotime($to_date));
        }

        ?>
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-edit"></i> <?php echo $lang_var_admin_387; ?>
                </div>
                <div class="tools">
                    <a href="?" class="close"></a>

                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <script type="text/javascript">
                    function del_event_confirmation() {
                        var answer = confirm("<?php echo $lang_var_admin_190; ?> <?php echo $cal_title; ?> ?")
                        if (answer) {
                            window.location = "calendar.php?id=<?php echo $event_id; ?>&eventact=delete&pview=<?php echo $pview; ?>";
                        }
                    }
                </script>
                <form action="calendar.php?id=<?php echo $event_id; ?>&eventact=save&pview=<?php echo $pview; ?>" method="post"
                      class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-body">


                        <div class="form-group">
                            <label class="control-label col-md-2"><?php echo $lang_var_admin_201; ?> <span class="required">*</span></label>

                            <div class="col-md-9">
                                <input type="text" name="cal_title" required="" value="<?php echo $cal_title; ?>"
                                       class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2"><?php echo $lang_var_admin_197; ?></label>

                            <div class="col-md-9">
                                <div class="input-group date form_meridian_datetime input-large">
                                    <input type="text" name="from_date" value="<?php echo $from_date; ?>" size="16" readonly
                                           class="form-control">
    			<span class="input-group-btn">
    				<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
    			</span>
    			<span class="input-group-btn">
    				<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
    			</span>
                                </div>
                                <!-- /input-group -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2"><?php echo $lang_var_admin_198; ?></label>

                            <div class="col-md-9">
                                <div class="input-group date form_meridian_datetime input-large">
                                    <input type="text" name="to_date" value="<?php echo $to_date; ?>" size="16" readonly
                                           class="form-control">
    			<span class="input-group-btn">
    				<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
    			</span>
    			<span class="input-group-btn">
    				<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
    			</span>
                                </div>
                                <!-- /input-group -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2"><?php echo $lang_var_admin_103; ?> </label>

                            <div class="col-md-9">
                                <textarea name="cal_details" rows="8" class="form-control"><?php echo $cal_details; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2"><?php echo $lang_var_admin_199; ?></label>

                            <div class="col-md-3">
                                <div class="input-group color colorpicker-default" data-color="<?php echo $cal_color; ?>"
                                     data-color-format="rgba">
                                    <input type="text" class="form-control" name="cal_color" value="<?php echo $cal_color; ?>"
                                           readonly>
				<span class="input-group-btn">
					<button class="btn default" type="button"><i
                            style="background-color: <?php echo $cal_color; ?>;"></i>&nbsp;</button>
				</span>
                                </div>
                                <!-- /input-group -->
                            </div>
                        </div>

                    </div>
                    <div class="form-actions fluid">
                        <div class="col-md-offset-2 col-md-7">
                            <button type="submit" class="btn green"><?php echo $lang_var_admin_21; ?></button>
                            &nbsp;
                            <a href="?">
                                <button type="button" data-dismiss="modal"
                                        class="btn default"><?php echo $lang_var_admin_22; ?></button>
                            </a>
                        </div>
                        <?php
                        if ($logged_allow_delete_status == 1) {
                            ?>
                            <div class="col-md-3">
                                <a href="javascript:del_event_confirmation()"><strong><?php echo $lang_var_admin_202; ?></strong></a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </form>

                <!-- END FORM-->
            </div>
            <!-- END VALIDATION STATES-->
        </div>

        <?php
    }else {
        ?>
        <div class="portlet box blue calendar">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-calendar"></i><?php echo $lang_var_admin_196; ?>
                </div>
            </div>
            <div class="portlet-body light-grey">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <!-- BEGIN DRAGGABLE EVENTS PORTLET-->
                        <h3 class="event-form-title"><?php echo $lang_var_admin_200; ?></h3>
                        <?php
                        if ($eventact == "insert" && $cal_title != "") {

                            if ($from_date != "") {
                                $from_date = date('Y-m-d H:i:s', strtotime($from_date));
                            }
                            $toosave = ",NULL";
                            if ($to_date != "") {
                                $to_date = date('Y-m-d H:i:s', strtotime($to_date));
                                $toosave = ",'$to_date'";
                            }

                            $sql_slct_max = mysql_query("select max(cal_id)  from " . $prefix . "_calendar");
                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                            $next_cal_id = $data_slct_max[0] + 1;
                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_calendar (
  cal_id,
  cal_title,
  cal_details,
  from_date,
  to_date,
  cal_color,
  edit_by, 
  edit_date,
  edit_from) VALUES ('$next_cal_id','$cal_title','$cal_details','$from_date' $toosave ,'$cal_color','$pd_admin_user_id',now(),'$pd_admin_ip')");

                            if ($sql_insert_new) {
                                $post_date_lng = date('d-m-Y h:i A', strtotime($from_date));
                                // insert notification
                                $note_title_ar = ($lang_var_admin_381 . " " . $cal_title . " $post_date_lng");
                                $note_title_en = ($lang_var_admin_382 . " " . $cal_title . " $post_date_lng");
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-warning'>
                            <i class='fa fa-calendar'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("calendar.php");

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

                        $sql_get_clr = mysql_query("SELECT cal_color FROM " . $prefix . "_calendar order by edit_date desc limit 1");
                        $data_get_clr = mysql_fetch_array($sql_get_clr);
                        $cal_color = stripcslashes($data_get_clr['cal_color']);
                        if ($cal_color == "") {
                            $cal_color = "#888888";
                        }

                        ?>
                        <div id="external-events">
                            <form class="inline-form"
                                  action="?id=<?php echo $event_id; ?>&eventact=insert" method="post">
                                <input type="text" name="cal_title" value="" class="form-control"
                                       placeholder="<?php echo $lang_var_admin_201; ?>..."/><br/>

                                <div>
                                    <div class="input-group date form_meridian_datetime">
                                        <input type="text" name="from_date" value="" size="16" readonly
                                               placeholder="<?php echo $lang_var_admin_197; ?>..."
                                               class="form-control">
<span class="input-group-btn">
<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
</span>
<span class="input-group-btn">
<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
</span>
                                    </div>
                                    <!-- /input-group -->
                                </div>
                                <br/>

                                <div>
                                    <div class="input-group date form_meridian_datetime">
                                        <input type="text" name="to_date" value="" size="16" readonly
                                               placeholder="<?php echo $lang_var_admin_198; ?>..."
                                               class="form-control">
<span class="input-group-btn">
<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
</span>
<span class="input-group-btn">
<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
</span>
                                    </div>
                                    <!-- /input-group -->
                                </div>
                                <br/>

                                                <textarea name="cal_details"
                                                          placeholder="<?php echo $lang_var_admin_103; ?>..." rows="6"
                                                          class="form-control"></textarea>
                                <br/>

                                <div class="input-group color colorpicker-default"
                                     data-color="<?php echo $cal_color; ?>" data-color-format="rgba">
                                    <input type="text"
                                           placeholder="<?php echo $lang_var_admin_199; ?>..."
                                           class="form-control" name="cal_color"
                                           value="<?php echo $cal_color; ?>" readonly>
				<span class="input-group-btn">
					<button class="btn default" type="button"><i
                            style="background-color: <?php echo $cal_color; ?>;"></i>&nbsp;</button>
				</span>
                                </div>
                                <br/>

                                <button type="submit"
                                        class="btn green"><?php echo $lang_var_admin_23; ?></button>
                                <br/>


                            </form>
                            <hr/>
                            <a href="calendar_list.php"
                               class="btn blue"><?php echo $lang_var_admin_203; ?></a>
                        </div>
                        <!-- END DRAGGABLE EVENTS PORTLET-->
                    </div>
                    <div class="col-md-9 col-sm-12">
                        <div id="calendar" class="has-toolbar">
                        </div>
                    </div>
                </div>
                <!-- END CALENDAR PORTLET-->
            </div>
        </div>
        <?php
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
    <script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-markdown/lib/markdown.js"></script>


    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/plugins/fullcalendar/fullcalendar/fullcalendar.min_<?php echo $lang; ?>.js"></script>
    <script type="text/javascript">
        var Calendar = function () {


            return {
                //main function to initiate the module
                init: function () {
                    Calendar.initCalendar();
                },

                initCalendar: function () {

                    if (!jQuery().fullCalendar) {
                        return;
                    }

                    var date = new Date();
                    var d = date.getDate();
                    var m = date.getMonth();
                    var y = date.getFullYear();

                    var h = {};

                    if (App.isRTL()) {
                        if ($('#calendar').parents(".portlet").width() <= 720) {
                            $('#calendar').addClass("mobile");
                            h = {
                                right: 'title, prev, next',
                                center: '',
                                right: 'agendaDay, agendaWeek, month, today'
                            };
                        } else {
                            $('#calendar').removeClass("mobile");
                            h = {
                                right: 'title',
                                center: '',
                                left: 'agendaDay, agendaWeek, month, today, prev,next'
                            };
                        }
                    } else {
                        if ($('#calendar').parents(".portlet").width() <= 720) {
                            $('#calendar').addClass("mobile");
                            h = {
                                left: 'title, prev, next',
                                center: '',
                                right: 'today,month,agendaWeek,agendaDay'
                            };
                        } else {
                            $('#calendar').removeClass("mobile");
                            h = {
                                left: 'title',
                                center: '',
                                right: 'prev,next,today,month,agendaWeek,agendaDay'
                            };
                        }
                    }


                    var initDrag = function (el) {
                        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                        // it doesn't need to have a start or end
                        var eventObject = {
                            title: $.trim(el.text()) // use the element's text as the event title
                        };
                        // store the Event Object in the DOM element so we can get to it later
                        el.data('eventObject', eventObject);
                        // make the event draggable using jQuery UI
                        el.draggable({
                            zIndex: 999,
                            revert: true, // will cause the event to go back to its
                            revertDuration: 0 //  original position after the drag
                        });
                    }

                    var addEvent = function (title) {
                        title = title.length == 0 ? "Untitled Event" : title;
                        var html = $('<div class="external-event label label-default">' + title + '</div>');
                        jQuery('#event_box').append(html);
                        initDrag(html);
                    }

                    $('#external-events div.external-event').each(function () {
                        initDrag($(this))
                    });

                    $('#event_add').unbind('click').click(function () {
                        var title = $('#event_title').val();
                        addEvent(title);
                    });

                    //predefined events
                    $('#event_box').html("");
                    addEvent("My Event 1");
                    addEvent("My Event 2");
                    addEvent("My Event 3");

                    $('#calendar').fullCalendar('destroy'); // destroy the calendar
                    $('#calendar').fullCalendar({ //re-initialize the calendar
                        header: h,
                        slotMinutes: 15,
                        editable: true,
                        droppable: true, // this allows things to be dropped onto the calendar !!!
                        drop: function (date, allDay) { // this function is called when something is dropped

                            // retrieve the dropped element's stored Event Object
                            var originalEventObject = $(this).data('eventObject');
                            // we need to copy it, so that multiple events don't have a reference to the same object
                            var copiedEventObject = $.extend({}, originalEventObject);

                            // assign it the date that was reported
                            copiedEventObject.start = date;
                            copiedEventObject.allDay = allDay;
                            copiedEventObject.className = $(this).attr("data-class");

                            // render the event on the calendar
                            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                            // is the "remove after drop" checkbox checked?
                            if ($('#drop-remove').is(':checked')) {
                                // if so, remove the element from the "Draggable Events" list
                                $(this).remove();
                            }
                        },
                        eventClick: function (calEvent, jsEvent, view) {


                        },
                        eventDrop: function (calEvent, dayDelta, minuteDelta, allDay, revertFunc) {

                            if (!confirm("<?php echo $lang_var_admin_204; ?>")) {
                                revertFunc();
                            } else {
                                // SAVE with AJAX
                                $.ajax({
                                    url: 'template/calendar_update.php?eventact=drag&id=' + calEvent.id + '&evdayes=' + dayDelta + '&evminutes=' + minuteDelta,
                                }); //End of Ajax
                            }

                        },
                        eventResize: function (calEvent, dayDelta, minuteDelta, revertFunc) {

                            if (!confirm("<?php echo $lang_var_admin_205; ?>")) {
                                revertFunc();
                            } else {
                                // SAVE with AJAX
                                $.ajax({
                                    url: 'template/calendar_update.php?eventact=resize&id=' + calEvent.id + '&evdayes=' + dayDelta + '&evminutes=' + minuteDelta,
                                }); //End of Ajax

                            }

                        },
                        events: [

                            <?php
                                $irw=0;
                                $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_calendar order by cal_id");
                                while ($data_retrive = mysql_fetch_array($sql_retrive)) {
                                    if($irw!=0){ echo ",";}
                                    $from_date = date("Y-m-d H:i:s", strtotime("-1 month", strtotime($data_retrive['from_date'])));
                                    $from_year=date('Y', strtotime($from_date));
                                    $from_month=date('m', strtotime($from_date));
                                    $from_day=date('d', strtotime($from_date));
                                    $from_hours=date('H', strtotime($from_date));
                                    $from_minits=date('i', strtotime($from_date));

                                    if($from_hours==0 && $from_minits==0){
                                    $from_iss="$from_year,$from_month,$from_day";
                                    }else{
                                    $from_iss="$from_year,$from_month,$from_day,$from_hours,$from_minits";
                                    }
                                    $to_date = date("Y-m-d H:i:s", strtotime("-1 month", strtotime($data_retrive['to_date'])));
                                    $to_year=date('Y', strtotime($to_date));
                                    $to_month=date('m', strtotime($to_date));
                                    $to_day=date('d', strtotime($to_date));
                                    $to_hours=date('H', strtotime($to_date));
                                    $to_minits=date('i', strtotime($to_date));

                                    if($to_hours==0 && $to_minits==0){
                                    $to_iss="$to_year,$to_month,$to_day";
                                    }else{
                                    $to_iss="$to_year,$to_month,$to_day,$to_hours,$to_minits";
                                    }

                            ?>
                            {
                                id: <?php echo $data_retrive['cal_id']; ?>,
                                title: '<?php echo stripslashes($data_retrive['cal_title']); ?>',
                                start: new Date(<?php echo $from_iss; ?>),
                                end: new Date(<?php echo $to_iss; ?>),
                                <?php
                                if($from_hours==0 && $from_minits==0){ }else{
                                ?>
                                allDay: false,
                                <?php
                                }
                                ?>
                                backgroundColor: '<?php echo stripslashes($data_retrive['cal_color']); ?>',
                                url: 'calendar.php?act=update&id=<?php echo $data_retrive['cal_id']; ?>',
                            }
                            <?php
                                $irw++; }
                            ?>

                        ]
                    });

                }

            };

        }();
    </script>
    <script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-daterangepicker/daterangepicker_<?php echo $site_lang_dir; ?>.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script type="text/javascript"
            src="assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

    <script src="assets/scripts/custom/components-pickers.js"></script>
    <script src="assets/scripts/core/app.js"></script>
    <script>
        jQuery(document).ready(function () {
            App.init();
            Calendar.init();
            ComponentsPickers.init();

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