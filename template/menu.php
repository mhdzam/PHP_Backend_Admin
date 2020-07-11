<?php

/*
// banars
$sql_banars_count = mysql_query("SELECT count(banar_id) as banars_count FROM ".$prefix."_banars");
$data_banars_count = mysql_fetch_array($sql_banars_count);
$banars_count=$data_banars_count['banars_count'];
// calendar
$sql_calendar_count = mysql_query("SELECT count(cal_id) as calendar_count FROM ".$prefix."_calendar where from_date>= '$curdate'");
$data_calendar_count = mysql_fetch_array($sql_calendar_count);
$calendar_count=$data_calendar_count['calendar_count'];
// members
$sql_members_count = mysql_query("SELECT count(member_id) as members_count FROM ".$prefix."_members");
$data_members_count = mysql_fetch_array($sql_members_count);
$members_count=$data_members_count['members_count'];
// newsletter
$sql_newsletter_count = mysql_query("SELECT count(nl_id) as newsletter_count FROM ".$prefix."_newsletter");
$data_newsletter_count = mysql_fetch_array($sql_newsletter_count);
$newsletter_count=$data_newsletter_count['newsletter_count'];
// shop_brands
$sql_shop_brands_count = mysql_query("SELECT count(brand_id) as shop_brands_count FROM ".$prefix."_shop_brands");
$data_shop_brands_count = mysql_fetch_array($sql_shop_brands_count);
$shop_brands_count=$data_shop_brands_count['shop_brands_count'];
// shop_comments
$sql_shop_comments_count = mysql_query("SELECT count(comment_id) as shop_comments_count FROM ".$prefix."_shop_comments where comment_status=0");
$data_shop_comments_count = mysql_fetch_array($sql_shop_comments_count);
$shop_comments_count=$data_shop_comments_count['shop_comments_count'];
// shop_coupons
$sql_shop_coupons_count = mysql_query("SELECT count(coupon_id) as shop_coupons_count FROM ".$prefix."_shop_coupons where coupon_date_to >= '$curdate'");
$data_shop_coupons_count = mysql_fetch_array($sql_shop_coupons_count);
$shop_coupons_count=$data_shop_coupons_count['shop_coupons_count'];
// shop_currencies
$sql_shop_currencies_count = mysql_query("SELECT count(currency_id) as shop_currencies_count FROM ".$prefix."_shop_currencies");
$data_shop_currencies_count = mysql_fetch_array($sql_shop_currencies_count);
$shop_currencies_count=$data_shop_currencies_count['shop_currencies_count'];
// shop_items
$sql_shop_items_count = mysql_query("SELECT count(item_id) as shop_items_count FROM ".$prefix."_shop_items");
$data_shop_items_count = mysql_fetch_array($sql_shop_items_count);
$shop_items_count=$data_shop_items_count['shop_items_count'];
// shop_orders
$sql_shop_orders_count = mysql_query("SELECT count(member_id) as shop_orders_count FROM ".$prefix."_shop_orders");
$data_shop_orders_count = mysql_fetch_array($sql_shop_orders_count);
$shop_orders_count=$data_shop_orders_count['shop_orders_count'];
// shop_paymethods
$sql_shop_paymethods_count = mysql_query("SELECT count(paymethod_id) as shop_paymethods_count FROM ".$prefix."_shop_paymethods");
$data_shop_paymethods_count = mysql_fetch_array($sql_shop_paymethods_count);
$shop_paymethods_count=$data_shop_paymethods_count['shop_paymethods_count'];
// shop_sections
$sql_shop_sections_count = mysql_query("SELECT count(section_id) as shop_sections_count FROM ".$prefix."_shop_sections");
$data_shop_sections_count = mysql_fetch_array($sql_shop_sections_count);
$shop_sections_count=$data_shop_sections_count['shop_sections_count'];
// shop_shipping
$sql_shop_shipping_count = mysql_query("SELECT count(shipping_id) as shop_shipping_count FROM ".$prefix."_shop_shipping");
$data_shop_shipping_count = mysql_fetch_array($sql_shop_shipping_count);
$shop_shipping_count=$data_shop_shipping_count['shop_shipping_count'];
// webmail
$sql_webmail_count = mysql_query("SELECT count(wm_id) as webmail_count FROM ".$prefix."_webmail");
$data_webmail_count = mysql_fetch_array($sql_webmail_count);
$webmail_count=$data_webmail_count['webmail_count'];
*/

?>

<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler hidden-phone">
                </div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <form class="sidebar-search" action="search.php" method="POST">
                    <div class="form-container">
                        <div class="input-box">
                            <a href="javascript:;" class="remove">
                            </a>
                            <input name="q" type="text" placeholder="<?php echo $lang_var_admin_111; ?>..."/>
                            <input type="button" class="submit" value=" "/>
                        </div>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <?php $activ_this_submnu = "class='start'";
            if ($pd_current_page_php == "index.php") {
                $activ_this_submnu = "class='start active'";
            } ?>
            <li <?php echo $activ_this_submnu; ?>>
                <a href="index.php"><i class="fa fa-home"></i><span
                        class="title"><?php echo $lang_var_admin_56; ?></span>
                    <span class="selected"></span>
                </a>
            </li>


            <?php
            if ($logged_admin_control_type == 0 || $logged_admin_control_type == 1) {
                if ($site_analytics_status == 1) {
                    $sub_mnu_pages = array("analytics.php", "ip.php", "ip_history.php");
                    $activ_this_mnu = "";
                    $activ_this_arw = "";
                    if (in_array($pd_current_page_php, $sub_mnu_pages)) {
                        $activ_this_mnu = "class='active'";
                        $activ_this_arw = "open";
                    }
                    ?>
                    <li <?php echo $activ_this_mnu; ?>>
                        <a href="javascript:;"><i class="fa fa-bar-chart-o"></i><span
                                class="title"><?php echo $lang_var_admin_214; ?></span><span
                                class="arrow <?php echo $activ_this_arw; ?>"></span><span class="selected"></span></a>
                        <ul class="sub-menu">
                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "analytics.php" && @$stat == "date") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="analytics.php?stat=date"><span><?php echo $lang_var_admin_215; ?></span></a>
                            </li>

                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "analytics.php" && @$stat == "city") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="analytics.php?stat=city"><span><?php echo $lang_var_admin_216; ?></span></a>
                            </li>


                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "analytics.php" && @$stat == "country") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="analytics.php?stat=country"><span><?php echo $lang_var_admin_217; ?></span></a>
                            </li>

                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "analytics.php" && @$stat == "os") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="analytics.php?stat=os"><span><?php echo $lang_var_admin_218; ?></span></a>
                            </li>

                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "analytics.php" && @$stat == "browser") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="analytics.php?stat=browser"><span><?php echo $lang_var_admin_219; ?></span></a>
                            </li>

                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "analytics.php" && @$stat == "resolution") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="analytics.php?stat=resolution"><span><?php echo $lang_var_admin_220; ?></span></a>
                            </li>

                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "analytics.php" && @$stat == "referrer") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="analytics.php?stat=referrer"><span><?php echo $lang_var_admin_221; ?></span></a>
                            </li>

                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "analytics.php" && @$stat == "hostname") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="analytics.php?stat=hostname"><span><?php echo $lang_var_admin_222; ?></span></a>
                            </li>

                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "analytics.php" && @$stat == "org") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="analytics.php?stat=org"><span><?php echo $lang_var_admin_223; ?></span></a>
                            </li>
                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "ip_history.php") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="ip_history.php"><span><?php echo $lang_var_admin_429; ?></span></a>
                            </li>
                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "ip.php") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="ip.php"><span><?php echo $lang_var_admin_420; ?></span></a>
                            </li>

                        </ul>
                    </li>
                    <?php
                }
            }
            ?>

            <!-- End Of LOAD Main Sections -->
            <?php
            if ($site_members_status == 1) {
                $activ_this_submnu = "class=''";
                if ($pd_current_page_php == "members.php") {
                    $activ_this_submnu = "class='active'";
                } ?>
                <li <?php echo $activ_this_submnu; ?>>
                    <a href="members.php"><i class="fa fa-users"></i><span
                            class="title"><?php echo $lang_var_admin_287; ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <?php
            }
            ?>
            <!-- End Of LOAD Main Sections -->

            <!-- End Of LOAD Main Sections -->
            <?php
            if ($site_orders_status == 1) {
                $activ_this_submnu = "class=''";
                if ($pd_current_page_php == "shop_orders.php") {
                    $activ_this_submnu = "class='active'";
                } ?>
                <li <?php echo $activ_this_submnu; ?>>
                    <a href="shop_orders.php"><i class="fa fa-list"></i><span
                            class="title"><?php echo $lang_var_admin_303; ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <?php
            }
            ?>
            <!-- End Of LOAD Main Sections -->

            <?php
            if ($site_shop_status == 1) {
                $sub_mnu_pages = array("shop_sections.php", "shop_brands.php", "shop_items.php", "shop_comments.php");
                $activ_this_mnu = "";
                $activ_this_arw = "";
                if (in_array($pd_current_page_php, $sub_mnu_pages)) {
                    $activ_this_mnu = "class='active'";
                    $activ_this_arw = "open";
                }
                ?>
                <li <?php echo $activ_this_mnu; ?>>
                    <a href="javascript:;"><i class="fa fa-barcode"></i><span
                            class="title"><?php echo $lang_var_admin_295; ?></span><span
                            class="arrow <?php echo $activ_this_arw; ?>"></span><span class="selected"></span></a>
                    <ul class="sub-menu">
                        <?php $activ_this_submnu = "";
                        if ($pd_current_page_php == "shop_sections.php") {
                            $activ_this_submnu = "class='active'";
                        } ?>
                        <li <?php echo $activ_this_submnu; ?>>
                            <a href="shop_sections.php"><span><?php echo $lang_var_admin_296; ?></span></a>
                        </li>

                        <?php $activ_this_submnu = "";
                        if ($pd_current_page_php == "shop_brands.php") {
                            $activ_this_submnu = "class='active'";
                        } ?>
                        <li <?php echo $activ_this_submnu; ?>>
                            <a href="shop_brands.php"><span><?php echo $lang_var_admin_297; ?></span></a>
                        </li>


                        <?php $activ_this_submnu = "";
                        if ($pd_current_page_php == "shop_items.php") {
                            $activ_this_submnu = "class='active'";
                        } ?>
                        <li <?php echo $activ_this_submnu; ?>>
                            <a href="shop_items.php"><span><?php echo $lang_var_admin_298; ?></span></a>
                        </li>

                        <?php $activ_this_submnu = "";
                        if ($pd_current_page_php == "shop_comments.php") {
                            $activ_this_submnu = "class='active'";
                        } ?>
                        <li <?php echo $activ_this_submnu; ?>>
                            <a href="shop_comments.php"><span><?php echo $lang_var_admin_299; ?></span></a>
                        </li>

                    </ul>
                </li>
            <?php } ?>

            <?php
            if ($logged_admin_control_type == 0 || $logged_admin_control_type == 1) {
                if ($site_shop_settings_status == 1) {
                    $sub_mnu_pages = array("shop_settings_currencies.php", "shop_settings_shipping.php", "shop_settings_paymethods.php", "shop_settings_coupons.php");
                    $activ_this_mnu = "";
                    $activ_this_arw = "";
                    if (in_array($pd_current_page_php, $sub_mnu_pages)) {
                        $activ_this_mnu = "class='active'";
                        $activ_this_arw = "open";
                    }
                    ?>
                    <li <?php echo $activ_this_mnu; ?>>
                        <a href="javascript:;"><i class="fa fa-cog"></i><span
                                class="title"><?php echo $lang_var_admin_300; ?></span><span
                                class="arrow <?php echo $activ_this_arw; ?>"></span><span class="selected"></span></a>
                        <ul class="sub-menu">
                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "shop_settings_currencies.php") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="shop_settings_currencies.php"><span><?php echo $lang_var_admin_301; ?></span></a>
                            </li>

                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "shop_settings_shipping.php") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="shop_settings_shipping.php"><span><?php echo $lang_var_admin_302; ?></span></a>
                            </li>
                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "shop_settings_paymethods.php") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="shop_settings_paymethods.php"><span><?php echo $lang_var_admin_333; ?></span></a>
                            </li>
                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "shop_settings_coupons.php") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="shop_settings_coupons.php"><span><?php echo $lang_var_admin_337; ?></span></a>
                            </li>

                        </ul>
                    </li>
                    <?php
                }
            }
            ?>

            <!-- LOAD Main Sections -->
            <?php
            $mnu_icons_type = array("fa fa-folder-open-o", "fa fa-picture-o", "fa fa-film", "fa fa-volume-up");
            $sql_menu_retrive = mysql_query("SELECT * FROM " . $prefix . "_webmaster_sections where ws_status=1 order by ws_status desc,  ws_id");
            while ($data_menu_retrive = mysql_fetch_array($sql_menu_retrive)) {
                if ($data_menu_retrive['ws_sections_st'] == 0 && $data_menu_retrive['ws_comments_st'] == 0) {
                    ?>
                    <?php
                    $sub_mnu_pages = array("topics.php");
                    $activ_this_mnu = "";
                    if (in_array($pd_current_page_php, $sub_mnu_pages) && @$wm_section == $data_menu_retrive['ws_id']) {
                        $activ_this_mnu = "class='active'";
                    }
                    ?>
                    <li <?php echo $activ_this_mnu; ?>>
                        <a href="topics.php?wm_section=<?php echo $data_menu_retrive['ws_id']; ?>"><i
                                class="<?php echo $mnu_icons_type[$data_menu_retrive['ws_type']]; ?>"></i><span
                                class="title"><?php echo $$data_menu_retrive['ws_title_var']; ?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php
                } else {
                    ?>
                    <?php
                    $sub_mnu_pages = array("topics.php", "sections.php", "comments.php");
                    $activ_this_mnu = "";
                    $activ_this_arw = "";
                    if (in_array($pd_current_page_php, $sub_mnu_pages) && @$wm_section == $data_menu_retrive['ws_id']) {
                        $activ_this_mnu = "class='active'";
                        $activ_this_arw = "open";
                    }
                    ?>
                    <li <?php echo $activ_this_mnu; ?>>
                        <a href="javascript:;"><i
                                class="<?php echo $mnu_icons_type[$data_menu_retrive['ws_type']]; ?>"></i><span
                                class="title"><?php echo $$data_menu_retrive['ws_title_var']; ?></span><span
                                class="arrow <?php echo $activ_this_arw; ?>"></span><span class="selected"></span></a>
                        <ul class="sub-menu">
                            <?php
                            if ($data_menu_retrive['ws_sections_st'] != 0) {
                                $activ_this_submnu = "";
                                if ($pd_current_page_php == "sections.php" && @$wm_section == $data_menu_retrive['ws_id']) {
                                    $activ_this_submnu = "class='active'";
                                } ?>
                                <li <?php echo $activ_this_submnu; ?>>
                                    <a href="sections.php?wm_section=<?php echo $data_menu_retrive['ws_id']; ?>"><span><?php echo $lang_var_admin_85 . " " . $$data_menu_retrive['ws_title_var']; ?></span></a>
                                </li>
                                <?php
                            }
                            $activ_this_submnu = "";
                            if ($pd_current_page_php == "topics.php" && @$wm_section == $data_menu_retrive['ws_id']) {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="topics.php?wm_section=<?php echo $data_menu_retrive['ws_id']; ?>"><span><?php echo $$data_menu_retrive['ws_title_var']; ?></span></a>
                            </li>

                            <?php
                            if ($data_menu_retrive['ws_comments_st'] != 0) {
                                $activ_this_submnu = "";
                                if ($pd_current_page_php == "comments.php" && @$wm_section == $data_menu_retrive['ws_id']) {
                                    $activ_this_submnu = "class='active'";
                                } ?>
                                <li <?php echo $activ_this_submnu; ?>>
                                    <a href="comments.php?wm_section=<?php echo $data_menu_retrive['ws_id']; ?>"><span><?php echo $lang_var_admin_86 . " " . $$data_menu_retrive['ws_title_var']; ?></span></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php
                }
            }
            ?>

            <!-- End Of LOAD Main Sections -->
            <?php
            if ($site_banars_status == 1) {
                $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_banars_sections where bs_status=1 order by bs_id");
                $page_father_count = mysql_num_rows($sql_father_retrive);
                if ($page_father_count > 0) {
                    ?>
                    <?php $activ_this_submnu = "class=''";
                    if ($pd_current_page_php == "banars.php") {
                        $activ_this_submnu = "class='active'";
                    } ?>
                    <li <?php echo $activ_this_submnu; ?>>
                        <a href="banars.php"><i class="fa fa-bookmark-o"></i><span
                                class="title"><?php echo $lang_var_admin_153; ?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
            <!-- End Of LOAD Main Sections -->
            <?php
            if ($site_inbox_status == 1) {
                $activ_this_submnu = "class=''";
                if ($pd_current_page_php == "inbox.php") {
                    $activ_this_submnu = "class='active'";
                } ?>
                <li <?php echo $activ_this_submnu; ?>>
                    <a href="inbox.php"><i class="fa fa-envelope-o"></i><span
                            class="title"><?php echo $lang_var_admin_159; ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <?php
            }
            ?>
            <!-- End Of LOAD Main Sections -->
            <?php
            if ($site_newsletter_status == 1) {
                $activ_this_submnu = "class=''";
                if ($pd_current_page_php == "news_letter.php") {
                    $activ_this_submnu = "class='active'";
                } ?>
                <li <?php echo $activ_this_submnu; ?>>
                    <a href="news_letter.php"><i class="fa fa-meh-o"></i><span
                            class="title"><?php echo $lang_var_admin_282; ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <?php
            }
            ?>
            <!-- End Of LOAD Main Sections -->
            <?php
            if ($site_calendar_status == 1) {
                $activ_this_submnu = "class=''";
                if ($pd_current_page_php == "calendar.php" || $pd_current_page_php == "calendar_list.php") {
                    $activ_this_submnu = "class='active'";
                } ?>
                <li <?php echo $activ_this_submnu; ?>>
                    <a href="calendar.php"><i class="fa fa-calendar"></i><span
                            class="title"><?php echo $lang_var_admin_195; ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <?php
            }
            ?>

            <?php
            if ($logged_admin_control_type == 0 || $logged_admin_control_type == 1) {
                if ($site_settings_status == 1) {
                    $sub_mnu_pages = array("settings.php", "users.php", "backup.php", "menus.php","packages.php","services.php");
                    $activ_this_mnu = "";
                    $activ_this_arw = "";
                    if (in_array($pd_current_page_php, $sub_mnu_pages)) {
                        $activ_this_mnu = "class='active'";
                        $activ_this_arw = "open";
                    }
                    ?>
                    <li <?php echo $activ_this_mnu; ?>>
                        <a href="javascript:;"><i class="fa fa-cog"></i><span
                                class="title"><?php echo $lang_var_admin_58; ?></span><span
                                class="arrow <?php echo $activ_this_arw; ?>"></span><span class="selected"></span></a>
                        <ul class="sub-menu">
                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "settings.php") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="settings.php"><span><?php echo $lang_var_admin_59; ?></span></a>
                            </li>
                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "menus.php") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="menus.php"><span><?php echo $lang_var_admin_434; ?></span></a>
                            </li>
<?php /*
                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "services.php") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="services.php"><span><?php echo $lang_var_admin_483; ?></span></a>
                            </li>
 */ ?>
                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "users.php") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="users.php"><span><?php echo $lang_var_admin_33; ?></span></a>
                            </li>
                            <?php $activ_this_submnu = "";
                            if ($pd_current_page_php == "backup.php") {
                                $activ_this_submnu = "class='active'";
                            } ?>
                            <li <?php echo $activ_this_submnu; ?>>
                                <a href="backup.php"><span><?php echo $lang_var_admin_60; ?></span></a>
                            </li>
                        </ul>
                    </li>
                    <?php
                }
            }
            ?>

            <?php
            if ($logged_full_control_status == 1) {
                $sub_mnu_pages = array("site_settings.php", "site_sections.php", "languages.php", "languages_words.php", "site_banarsections.php");
                $activ_this_mnu = "class='last'";
                $activ_this_arw = "";
                if (in_array($pd_current_page_php, $sub_mnu_pages)) {
                    $activ_this_mnu = "class='last active'";
                    $activ_this_arw = "open";
                }
                ?>
                <li <?php echo $activ_this_mnu; ?>>
                    <a href="javascript:;"><i class="fa fa-cogs"></i><span
                            class="title"><?php echo $lang_var_admin_37; ?></span><span
                            class="arrow <?php echo $activ_this_arw; ?>"></span><span class="selected"></span></a>
                    <ul class="sub-menu">
                        <?php $activ_this_submnu = "";
                        if ($pd_current_page_php == "site_settings.php") {
                            $activ_this_submnu = "class='active'";
                        } ?>
                        <li <?php echo $activ_this_submnu; ?>>
                            <a href="site_settings.php"><span><?php echo $lang_var_admin_59; ?></span></a>
                        </li>
                        <?php $activ_this_submnu = "";
                        if ($pd_current_page_php == "site_sections.php") {
                            $activ_this_submnu = "class='active'";
                        } ?>
                        <li <?php echo $activ_this_submnu; ?>>
                            <a href="site_sections.php"><span><?php echo $lang_var_admin_57; ?></span></a>
                        </li>
                        <?php $activ_this_submnu = "";
                        if ($pd_current_page_php == "site_banarsections.php") {
                            $activ_this_submnu = "class='active'";
                        } ?>
                        <li <?php echo $activ_this_submnu; ?>>
                            <a href="site_banarsections.php"><span><?php echo $lang_var_admin_143; ?></span></a>
                        </li>
                        <?php $activ_this_submnu = "";
                        if ($pd_current_page_php == "languages_words.php") {
                            $activ_this_submnu = "class='active'";
                        } ?>
                        <li <?php echo $activ_this_submnu; ?>>
                            <a href="languages_words.php"><span><?php echo $lang_var_admin_50; ?></span></a>
                        </li>
                        <?php $activ_this_submnu = "";
                        if ($pd_current_page_php == "languages.php") {
                            $activ_this_submnu = "class='active'";
                        } ?>
                        <li <?php echo $activ_this_submnu; ?>>
                            <a href="languages.php"><span><?php echo $lang_var_admin_36; ?></span></a>
                        </li>
                    </ul>
                </li>
                <?php
            }
            ?>

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>