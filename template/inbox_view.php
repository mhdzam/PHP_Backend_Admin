<?php
require_once("page_start2.php");

$page_records = 20;
$cat_id = @$_GET['cat'];
$searchword_q = @$_GET['qqq'];

if ($cat_id == "") {
    $cat_id = 0;
}
if ($cat_id == 4) {
    $show_cat = "search";
} elseif ($cat_id == 3) {
    $show_cat = "trash";
} elseif ($cat_id == 2) {
    $show_cat = "draft";
} elseif ($cat_id == 1) {
    $show_cat = "sent";
} else {
    $show_cat = "inbox";
}
$page_no = @$_GET['page'];

if ($page_no == "") {
    $page_no = 1;
}
$nex_page = $page_no + 1;
$pref_page = $page_no - 1;
if ($pref_page < 1) {
    $pref_page = 1;
}
$iDisplayStart = (($page_no - 1) * $page_records);
$iDisplayLength = $page_records;

$flag_id = @$_GET['flag'];
if ($flag_id != "" && $flag_id !== 0) {
    $sql_block = mysql_query("UPDATE " . $prefix . "_webmail SET wm_flag= IF(wm_flag=1, 0, 1) WHERE wm_id = '$flag_id'") or die(mysql_error
    ());
}
?>
<form name="multicheckfrm" id="multicheckfrm" method="post"
      action="?a=<?php echo $show_cat; ?>&p=<?php echo $page_no; ?>">
    <table class="table table-striped table-advance table-hover">
        <?php

        $catsearch_filter = "and cat_id='$cat_id'";
        if ($cat_id == 4) {
            $catsearch_filter = "";
        }
        $search_filter = "";
        if ($searchword_q != "") {
            $search_filter = "AND (wm_title like '%$searchword_q%')";
        }
        $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_webmail where wm_id!='' $catsearch_filter $search_filter order by wm_date desc, wm_id desc limit $iDisplayStart,$iDisplayLength");
        $sql_total = mysql_query("SELECT * FROM " . $prefix . "_webmail where wm_id!='' $catsearch_filter $search_filter");
        $page_records_count = mysql_num_rows($sql_total);
        $pages_count = round($page_records_count / $page_records);
        $pages_count0 = round($page_records_count / $page_records, 1);
        if ($pages_count0 > $pages_count) {
            $pages_count++;
        }
        if ($nex_page > $pages_count) {
            $nex_page = $pages_count;
        }
        if ($page_records_count == 0){
            ?>
            <tr>
                <th>
                    <?php echo $lang_var_admin_170; ?>
                </th>

            </tr>
            <?php
        }else{
        ?>
        <thead>
        <tr>
            <th colspan="3">
                <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                <?php
                if ($logged_allow_edit_status == 1) {
                    ?>
                    <div class="btn-group">
                        <a class="btn btn-sm blue" href="#" data-toggle="dropdown">
                            <?php echo $lang_var_admin_5; ?> <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:;"
                                   onclick="multicheckfrm.clicked_btn.value='b_active';document.getElementById('multicheckfrm').submit();">
                                    <i class="fa fa-pencil"></i> <?php echo $lang_var_admin_165; ?>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:;"
                                   onclick="multicheckfrm.clicked_btn.value='b_block';document.getElementById('multicheckfrm').submit();">
                                    <i class="fa fa-envelope-o"></i> <?php echo $lang_var_admin_166; ?>
                                </a>
                            </li>
                            <?php
                            if ($cat_id == 0) {
                                ?>
                                <li>
                                    <a href="javascript:;"
                                       onclick="multicheckfrm.clicked_btn.value='b_archive';document.getElementById('multicheckfrm').submit();">
                                        <i class="fa fa-folder-o"></i> <?php echo $lang_var_admin_167; ?>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            </li>
                            <?php
                            if ($logged_allow_delete_status == 1) {
                                ?>
                                <li class="divider">
                                </li>
                                <li>
                                    <a href="javascript:;" id="confirmation_box_for_delete">
                                        <i class="fa fa-trash-o"></i> <?php echo $lang_var_admin_19; ?>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <input type="hidden" name="clicked_btn" size="78" value=""/>
                    </div>
                    <?php
                }
                ?>
            </th>
            <th class="pagination-control" colspan="3">
                <?php
                $tooz = $iDisplayLength * $page_no;
                if ($tooz > $page_records_count) {
                    $tooz = $page_records_count;
                }
                $froom = $iDisplayStart + 1;
                if ($froom < 1) {
                    $froom = 1;
                }
                $rcrdsss = $froom . '-' . $tooz . ' ' . $lang_var_admin_168 . ' ' . $page_records_count;
                ?>
                <span class="pagination-info" style="min-width: 100px;">
			 <?php echo $rcrdsss; ?>
		</span>
                <?php
                //	if($page_records_count>$iDisplayLength){
                ?>
                <a class="btn btn-sm blue" srch-wrd="<?php echo $searchword_q; ?>" show-cat="<?php echo $show_cat; ?>"
                   cat-id="<?php echo $cat_id; ?>" page-no="<?php echo $pref_page; ?>">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="btn btn-sm blue" srch-wrd="<?php echo $searchword_q; ?>" show-cat="<?php echo $show_cat; ?>"
                   cat-id="<?php echo $cat_id; ?>" page-no="<?php echo $nex_page; ?>">
                    <i class="fa fa-angle-right"></i>
                </a>
                <?php
                //	}
                ?>
            </th>
        </tr>
        </thead>
        <tbody>

        <?php
        $messageid = 1;
        while ($data_retrive = mysql_fetch_array($sql_retrive)) {
            if ($data_retrive['wm_status'] == 1) {
                $wm_status = "";
            } else {
                $wm_status = "class='unread'";
            }

            $sql_get_attachfiles = mysql_query("SELECT * FROM " . $prefix . "_webmail_files  WHERE wm_id ='$data_retrive[wm_id]'");
            $attachfiles_count = mysql_num_rows($sql_get_attachfiles);

            ?>
            <tr <?php echo $wm_status; ?> data-messageid="<?php echo $messageid; ?>">
                <td class="inbox-small-cells">
                    <input type="checkbox" class="mail-checkbox" name="multichkbx[]"
                           value="<?php echo $data_retrive['wm_id']; ?>">
                </td>
                <td class="inbox-small-cells">
                    <?php
                    $str_color = "";
                    if ($data_retrive['wm_flag'] == 1) {
                        $str_color = "inbox-started";
                    }
                    ?>
                    <span class="page-star"><span srch-wrd="<?php echo $searchword_q; ?>"
                                                  message-id="<?php echo $data_retrive['wm_id']; ?>"
                                                  show-cat="<?php echo $show_cat; ?>" cat-id="<?php echo $cat_id; ?>"
                                                  page-no="<?php echo $page_no; ?>"><i
                                class="fa fa-star <?php echo $str_color; ?>"></i></span></span>

                </td>
                <td class="view-message hidden-xs" message-id="<?php echo $data_retrive['wm_id']; ?>"
                    cat-id="<?php echo $cat_id; ?>">
                    <?php
                    if ($data_retrive['cat_id'] == 1 || $data_retrive['cat_id'] == 2) {

                        echo stripslashes($data_retrive['wm_to_email']);
                        if (stripslashes($data_retrive['wm_to_cc']) != "") {
                            echo "<br /><small>" . stripslashes($data_retrive['wm_to_cc']) . "</small>";
                        }
                        if (stripslashes($data_retrive['wm_to_bcc']) != "") {
                            echo ",<small>" . stripslashes($data_retrive['wm_to_bcc']) . "</small>";
                        }
                    } else {
                        if (stripslashes($data_retrive['wm_from_name']) != "") {
                            echo stripslashes($data_retrive['wm_from_name']);
                        } else {
                            echo stripslashes($data_retrive['wm_from']);
                        }
                    }
                    ?>
                </td>
                <td class="view-message " message-id="<?php echo $data_retrive['wm_id']; ?>"
                    cat-id="<?php echo $cat_id; ?>">
                    <?php echo stripslashes($data_retrive['wm_title']); ?>
                </td>

                <td class="view-message " message-id="<?php echo $data_retrive['wm_id']; ?>"
                    cat-id="<?php echo $cat_id; ?>">
                    <?php
                    if ($attachfiles_count > 0) {
                        ?>
                        <i class="fa fa-paperclip"></i>
                        <?php
                    }
                    ?>
                </td>

                <td class="view-message text-right" message-id="<?php echo $data_retrive['wm_id']; ?>"
                    cat-id="<?php echo $cat_id; ?>"
                    title="<?php echo FormatDateTimeLong(stripslashes($data_retrive['wm_date'])); ?>">
                    <?php echo FormatDateTime(stripslashes($data_retrive['wm_date'])); ?>
                </td>
            </tr>
            <?php

            $messageid++;
        }

        }
        ?>

        </tbody>
    </table>
</form>  