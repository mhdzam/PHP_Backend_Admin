
<div class="header navbar">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="header-inner">
        <!-- BEGIN LOGO -->
        <a class="navbar-brand" href="index.php">
            <img src="assets/img/logo-big.png" alt="logo" class="img-responsive"/>
        </a>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <img src="assets/img/menu-toggler.png" alt=""/>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <ul class="nav navbar-nav pull-right">
            <!-- BEGIN NOTIFICATION DROPDOWN -->
            <li class="dropdown" id="header_notification_bar">
                <a href="../" target="_blank" class="dropdown-toggle"
                   title="<?php echo $lang_var_admin_279; ?>">
                    <i class="fa fa-share"></i>
                </a>
            </li>
            <?php
            $sql_retrive_notifications = mysql_query("SELECT * FROM " . $prefix . "_notifications where note_type='1' and note_status='0' order by note_date desc, note_id desc");
            $notifications_records_count = mysql_num_rows($sql_retrive_notifications);
            $sql_retrive_notifications = mysql_query("SELECT * FROM " . $prefix . "_notifications where note_type='1' order by note_date desc, note_id desc");
            $notifications_all_records_count = mysql_num_rows($sql_retrive_notifications);
            ?>
            <li class="dropdown" id="header_notification_bar">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                   data-close-others="true">
                    <i class="fa fa-globe"></i>
                    <?php if ($notifications_records_count > 0) { ?>
                        <span class="badge">
						 <?php echo $notifications_records_count; ?>
					</span>
                    <?php } ?>
                </a>
                <ul class="dropdown-menu extended notification">
                    <?php if ($notifications_records_count > 0) { ?>
                        <li>
                            <p>
                                <?php echo $lang_var_admin_266; ?>
                                <strong><?php echo $notifications_records_count; ?></strong> <?php echo $lang_var_admin_270; ?>
                            </p>
                        </li>
                    <?php } ?>
                    <li>
                        <?php if ($notifications_all_records_count > 0) { ?>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;">
                                <?php
                                $sql_retrive_notifications = mysql_query("SELECT * FROM " . $prefix . "_notifications order by note_date desc, note_id desc limit 15");
                                while ($data_retrive_notifications = mysql_fetch_array($sql_retrive_notifications)) {
                                    if ($data_retrive_notifications['note_status'] == 1) {
                                        $last_msgs_status = "style='color: #999;font-style: italic;'";
                                    } else {
                                        $last_msgs_status = "";
                                    }
                                    $note_icon = str_replace("label-sm", "label-icon", stripslashes($data_retrive_notifications['note_icon']));
                                    $note_url = stripslashes($data_retrive_notifications['note_url']);

                                    ?>
                                    <li>
                                        <a <?php echo $last_msgs_status; ?> href="<?php echo $note_url; ?>"
                                                                            title="<?php echo FormatDateTimeLong(stripslashes($data_retrive_notifications['note_date'])); ?>">
                                            <?php echo $note_icon; ?>
                                            <?php echo stripslashes($data_retrive_notifications['note_title_' . $lang]); ?>
                                        </a>
                                    </li>

                                    <?php
                                }
                                ?>
                            </ul>
                        <?php } ?>
                    </li>
                    <?php if ($notifications_all_records_count > 0) { ?>
                        <li class="external">
                            <a href="notifications.php">
                                <small><?php echo $lang_var_admin_269; ?></small>
                                <i class="m-icon-swap<?php echo $site_lang_align_left; ?>"></i>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="external">
                            <a>
                                <small><?php echo $lang_var_admin_277; ?></small>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <!-- END NOTIFICATION DROPDOWN -->
            <!-- BEGIN INBOX DROPDOWN -->
            <?php
            $sql_retrive_newmessages = mysql_query("SELECT * FROM " . $prefix . "_webmail where cat_id='0' and wm_status!=1 order by wm_date desc, wm_id desc");
            $inbox_new_records_count = mysql_num_rows($sql_retrive_newmessages);
            $sql_retrive_newmessages = mysql_query("SELECT * FROM " . $prefix . "_webmail where cat_id='0' order by wm_date desc, wm_id desc");
            $inbox_all_records_count = mysql_num_rows($sql_retrive_newmessages);
            ?>
            <li class="dropdown" id="header_inbox_bar">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                   data-close-others="true">
                    <i class="fa fa-envelope"></i>
                    <?php if ($inbox_new_records_count > 0) { ?>
                        <span class="badge">
						 <?php echo $inbox_new_records_count; ?>
					</span>
                    <?php } ?>
                </a>
                <ul class="dropdown-menu extended inbox">
                    <?php if ($inbox_new_records_count > 0) { ?>
                        <li>
                            <p>
                                <?php echo $lang_var_admin_266; ?>
                                <strong><?php echo $inbox_new_records_count; ?></strong> <?php echo $lang_var_admin_267; ?>
                            </p>
                        </li>
                    <?php } ?>
                    <li>
                        <?php if ($inbox_all_records_count > 0) { ?>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;">
                                <?php
                                $sql_retrive_newmessages = mysql_query("SELECT * FROM " . $prefix . "_webmail where cat_id='0' order by wm_date desc, wm_id desc limit 10");
                                while ($data_retrive_newmessages = mysql_fetch_array($sql_retrive_newmessages)) {
                                    if ($data_retrive_newmessages['wm_status'] == 1) {
                                        $last_msgs_status = "style='color: #999;font-style: italic;'";
                                    } else {
                                        $last_msgs_status = "";
                                    }
                                    ?>
                                    <li>
                                        <a <?php echo $last_msgs_status; ?>
                                            href="inbox.php?id=<?php echo $data_retrive_newmessages['wm_id']; ?>&a=view">
									<span class="subject">
										<span class="from">
											 <?php echo stripslashes($data_retrive_newmessages['wm_from_name']); ?>
										</span>
										<span class="time"
                                              title="<?php echo FormatDateTimeLong(stripslashes($data_retrive_newmessages['wm_date'])); ?>">
											 <?php echo FormatDateTime(stripslashes($data_retrive_newmessages['wm_date'])); ?>
										</span>
									</span>
									<span class="message">
										 <?php echo stripslashes($data_retrive_newmessages['wm_title']); ?>
									</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        <?php } ?>

                    </li>
                    <?php if ($inbox_all_records_count > 0) { ?>
                        <li class="external">
                            <a href="inbox.php">
                                <small><?php echo $lang_var_admin_265; ?></small>
                                <i class="m-icon-swap<?php echo $site_lang_align_left; ?>"></i>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="external">
                            <a>
                                <small><?php echo $lang_var_admin_278; ?></small>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <!-- END INBOX DROPDOWN -->
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                   data-close-others="true">
                    <?php
                    $av_usr_img = "assets/img/avatar.png";
                    if ($logged_admin_user_photo != "") {
                        $av_usr_img = "../uploads/$logged_admin_user_photo";
                    }
                    ?>
                    <img alt="" src="<?php echo $av_usr_img; ?>"
                         style="width: 29px;height: 29px;border-radius: 50% !important;"/>
					<span class="username">
						 <?php echo $logged_admin_user_name; ?>
					</span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="users.php?id=<?php echo $pd_admin_user_id; ?>&act=update">
                            <i class="fa fa-user"></i> <?php echo $lang_var_admin_271; ?>
                        </a>
                    </li>
                    <?php
                    if ($site_calendar_status == 1) {
                        ?>
                        <li>
                            <a href="calendar.php">
                                <i class="fa fa-calendar"></i> <?php echo $lang_var_admin_195; ?>
                            </a>
                        </li>
                        <?php
                    }
                    if ($site_inbox_status == 1) {
                        ?>
                        <li>
                            <a href="inbox.php">
                                <i class="fa fa-envelope"></i> <?php echo $lang_var_admin_159; ?>
                                <?php if ($inbox_new_records_count > 0) { ?>
                                    <span class="badge badge-danger">
        						 <?php echo $inbox_new_records_count; ?>
        					</span>
                                <?php } ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="divider">
                    </li>
                    <li>
                        <a href="javascript:;" id="trigger_fullscreen">
                            <i class="fa fa-arrows"></i> <?php echo $lang_var_admin_272; ?>
                        </a>
                    </li>
                    <li>
                        <a href="lock.php?act=lock">
                            <i class="fa fa-lock"></i> <?php echo $lang_var_admin_273; ?>
                        </a>
                    </li>
                    <li>
                        <a href="signout.php">
                            <i class="fa fa-key"></i> <?php echo $lang_var_admin_274; ?>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
<span id="detrmine_pag_dir" style="display: none;direction: <?php echo $site_lang_dir; ?>"></span>