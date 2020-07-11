<?php
require_once("page_start2.php");
$wm_id = @$_GET['id'];
$up_dir = "../uploads/mail/";
$cat_id = @$_GET['cat'];

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

if ($wm_id != "" && $wm_id != 0) {

    $sql_active = mysql_query("UPDATE " . $prefix . "_webmail SET wm_status=1 WHERE wm_id ='$wm_id' and cat_id!= 1") or die(mysql_error());
    $sql_modify = mysql_query("SELECT * FROM " . $prefix . "_webmail  WHERE wm_id ='$wm_id' ");
    $data_modify = mysql_fetch_array($sql_modify);
    $wm_title = stripcslashes($data_modify['wm_title']);
    $wm_details = nl2br(stripcslashes($data_modify['wm_details']));
    $wm_date = $data_modify['wm_date'];
    $wm_from = stripcslashes($data_modify['wm_from']);
    $wm_from_name = stripcslashes($data_modify['wm_from_name']);
    $wm_from_tel = stripcslashes($data_modify['wm_from_tel']);
    $wm_to_email = stripcslashes($data_modify['wm_to_email']);
    $wm_to_name = stripcslashes($data_modify['wm_to_name']);

    $wm_to_cc = stripcslashes($data_modify['wm_to_cc']);
    $wm_to_bcc = stripcslashes($data_modify['wm_to_bcc']);

    $member_id = stripcslashes($data_modify['member_id']);

    $wm_ip = stripcslashes($data_modify['wm_ip']);
    $cat_id = $data_modify['cat_id'];

    $edit_date = $data_modify['edit_date'];
    $edit_by = GetAdminUserName($data_modify['edit_by']);
    $edit_from = $data_modify['edit_from'];

    ?>
    <div class="inbox-header inbox-view-header">
        <h1 class="pull-left"><?php echo $wm_title ?></h1>

        <div class="pull-right">
            <i class="fa fa-print"></i>
        </div>
    </div>
    <div class="inbox-view-info">
        <div class="row">
            <div class="col-md-7">
                <?php echo $lang_var_admin_168 ?>:
			<span class="bold">
				 <?php echo $wm_from_name ?>
			</span>
			<span dir="ltr">
				 &#60;<?php echo $wm_from ?>&#62; <?php echo $wm_from_tel ?>
			</span>
                <br/><?php echo $lang_var_admin_179 ?>:
			<span class="bold">
			<span class="bold">
				 <?php echo $wm_to_name ?>
			</span>
			<span dir="ltr">
				 &#60;<?php echo $wm_to_email ?>&#62;
                <?php
                if ($wm_to_cc != "") {
                    echo ", &#60;" . $wm_to_cc . "&#62;";
                }
                if ($wm_to_bcc != "") {
                    echo ", &#60;" . $wm_to_bcc . "&#62;";
                }
                ?>
			</span>				 
			</span>
                <br/><?php echo FormatDateTimeLong($wm_date); ?>

            </div>
            <?php
            if ($logged_allow_edit_status == 1) {
                ?>
                <div class="col-md-5 inbox-info-btn">
                    <div class="btn-group">

                        <button class="btn blue dropdown-toggle" data-toggle="dropdown">
                            Reply &nbsp; <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="?a=compose&id=<?php echo $wm_id; ?>&status=re">
                                    <i class="fa fa-reply reply-btn"></i> <?php echo $lang_var_admin_171; ?>
                                </a>
                            </li>
                            <li>
                                <a href="?a=compose&id=<?php echo $wm_id; ?>&status=fw">
                                    <i class="fa fa-arrow-right reply-btn"></i> <?php echo $lang_var_admin_172; ?>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-print"></i> <?php echo $lang_var_admin_173; ?>
                                </a>
                            </li>
                            <li class="divider">
                            </li>
                            <?php
                            if ($cat_id == 0) {
                                ?>
                                <li>
                                    <a href="?act=moveToArchive&msgid=<?php echo $wm_id; ?>&a=<?php echo $show_cat; ?>&p=<?php echo $page_no; ?>">
                                        <i class="fa fa-folder-o"></i> <?php echo $lang_var_admin_167; ?>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <?php
                            if ($logged_allow_delete_status == 1) {
                                ?>
                                <li class="confirmation_delete">
                                    <a id="confirmation_msg_for_delete" message-id="<?php echo $wm_id; ?>"
                                       show-cat="<?php echo $show_cat; ?>" cat-id="<?php echo $cat_id; ?>"
                                       page-no="<?php echo $page_no; ?>">
                                        <i class="fa fa-trash-o"></i> <?php echo $lang_var_admin_19; ?>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="inbox-view">
        <?php
        if($member_id!="" && $member_id!=0) {
            $sql_modify = mysql_query("SELECT * FROM " . $prefix .
                "_members  WHERE member_id ='$member_id' ");
            $data_modify = mysql_fetch_array($sql_modify);

            $member_username = stripcslashes($data_modify['member_username']);
            $member_password = @base64_decode(stripcslashes($data_modify['member_password']));
            $member_firstname = stripcslashes($data_modify['member_firstname']);
            $member_lastname = stripcslashes($data_modify['member_lastname']);
            $member_photo = stripcslashes($data_modify['member_photo']);
            $member_phone = stripcslashes($data_modify['member_phone']);
            $member_city = stripcslashes($data_modify['member_city']);
            $member_country_id = stripcslashes($data_modify['member_country_id']);
            $member_email = stripcslashes($data_modify['member_email']);

            $member_regdate = $data_modify['regdate'];
            $member_ipaddress = $data_modify['ipaddress'];
            $member_lastlogin = $data_modify['lastlogin'];

            $edit_date = $data_modify['edit_date'];
            $edit_by = GetAdminUserName($data_modify['edit_by']);
            $edit_from = $data_modify['edit_from'];

            $av_usr_img = "assets/img/profile.jpg";
            if ($member_photo != "") {
                $av_usr_img = "../uploads/members/$member_photo";
            }
            $sql_gc = mysql_query("SELECT * FROM " . $prefix . "_countries  WHERE cnt_id ='$member_country_id' limit 1 ");
            $data_gc = mysql_fetch_array($sql_gc);
            $member_country_code = strtolower($data_gc['country_code']);
            $member_country_title = strtolower($data_gc['country_'.$lang]);
            ?>
            <div class="note" style="background-color: #f5f5f5 ">
                <div class="pull-right"><a href="members.php?id=<?php echo $member_id; ?>&act=update"><img src="<?php echo $av_usr_img; ?>" style="max-height:70px;margin:5px;border-radius: 50% !important;"></a>
                </div>
                <br>
                <h4> &nbsp;<a href="members.php?id=<?php echo $member_id; ?>&act=update"><?php echo $member_firstname; ?> <?php echo $member_lastname; ?></a> &nbsp;</h4>

                <ul class="list-inline">
                    <li>
                        <?php echo $member_country_title; ?> - <?php echo $member_city; ?>
                    </li>
                    <li>
                        <i class="fa fa-phone"></i> <span dir="ltr"><?php echo $member_phone; ?></span>
                    </li>
                    <li>
                        <i class="fa fa-envelope"></i> <?php echo $member_email; ?>
                    </li>

                </ul>


            </div>
            <?php
        }
        ?>

        <?php echo $wm_details ?>
    </div>
    <?php
    $sql_files_retrive = mysql_query("SELECT * FROM " . $prefix . "_webmail_files where wm_id='$wm_id' and wf_file!='' order by wf_id");
    $files_count = mysql_num_rows($sql_files_retrive);
    if ($files_count > 0) {
        ?>
        <hr>
        <div class="inbox-attached">

            <?php
            while ($data_files_retrive = mysql_fetch_array($sql_files_retrive)) {
                $wf_title = stripcslashes($data_files_retrive['wf_title']);
                $wf_file = stripcslashes($data_files_retrive['wf_file']);
                $wf_fileext = strtolower(strrchr($wf_file, "."));
                $wf_filesize = GetFileSize("../" . $up_dir . $wf_file);
                $file_privew_url = "<a href='../template/$up_dir" . "$wf_file' target='_blank'><img src='$up_dir" . "$wf_file'></a>";
                if (!in_array($wf_fileext, $allowed_imgs_type)) {
                    $file_privew_url = "<a href='../template/download.php?name=$wf_title&path=../$up_dir" . "$wf_file'><i style='font-size:200%;margin:5px 0;padding:10px;border:1px dotted #ccc' class='fa fa-paperclip'></i></a>";
                }
                ?>
                <div class="margin-bottom-25">
                    <?php echo $file_privew_url ?>
                    <div>
                        <strong><?php echo $wf_title ?></strong>
					<span>
						 <?php echo $wf_filesize ?>
					</span>&nbsp;|&nbsp;
                        <?php
                        if (in_array($wf_fileext, $allowed_imgs_type)) {
                            ?>
                            <a href="<?php echo $up_dir . $wf_file ?>" target="_blank">
                                <?php echo $lang_var_admin_175; ?>
                            </a>&nbsp;|&nbsp;
                            <?php
                        }
                        ?>
                        <a href="template/download.php?name=<?php echo $wf_title ?>&path=../<?php echo $up_dir . $wf_file ?>">
                            <?php echo $lang_var_admin_174; ?>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
        <?php
    }
}
?>        