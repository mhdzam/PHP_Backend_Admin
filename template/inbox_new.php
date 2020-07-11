<?php
require_once("page_start2.php");
$up_dir = "../uploads/mail/";
$cat_id = @$_GET['cat'];
$member_id = @$_GET['member_id'];
$wm_msg_id = @$_GET['msgid'];
$msgstatus = @$_GET['msgstatus'];

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

$wm_title = "";
$wm_details = "";
$wm_from = "";
$wm_from_name = "";
$wm_from_tel = "";
$wm_to_email = "";
$wm_to_name = "";
$wm_to_cc = "";
$wm_to_bcc = "";


if ($member_id != "" && $member_id != 0) {

    $sql_modify = mysql_query("SELECT * FROM " . $prefix . "_members  WHERE member_id ='$member_id' ");
    $data_modify = mysql_fetch_array($sql_modify);
    $wm_to_name = stripcslashes($data_modify['member_firstname']) . stripcslashes($data_modify['member_lastname']);
    $wm_to_email = stripcslashes($data_modify['member_email']);
}

if ($wm_msg_id != "" && $wm_msg_id != 0) {
    $sql_modify = mysql_query("SELECT * FROM " . $prefix . "_webmail  WHERE wm_id ='$wm_msg_id' ");
    $data_modify = mysql_fetch_array($sql_modify);
    $wm_title = stripcslashes($data_modify['wm_title']);
    $wm_details = nl2br(stripcslashes($data_modify['wm_details']));
    $wm_from = stripcslashes($data_modify['wm_from']);
    $wm_from_name = stripcslashes($data_modify['wm_from_name']);
    $wm_from_tel = stripcslashes($data_modify['wm_from_tel']);
    $wm_to_email = stripcslashes($data_modify['wm_to_email']);
    $wm_to_name = stripcslashes($data_modify['wm_to_name']);
    $wm_to_cc = stripcslashes($data_modify['wm_to_cc']);
    $wm_to_bcc = stripcslashes($data_modify['wm_to_bcc']);
    $member_id = stripcslashes($data_modify['member_id']);
    if ($msgstatus == "re") {
        $wm_title = "Re: " . $wm_title;
        $wm_to_email = $wm_from;
        $wm_to_cc = "";
        $wm_to_bcc = "";
        $wm_details = "<br/><br/><hr>" . $wm_details;
    } elseif ($msgstatus == "fw") {
        $wm_title = "FW: " . $wm_title;
        $wm_to_cc = "";
        $wm_to_bcc = "";
    }

}

?>
<form class="inbox-compose form-horizontal" id="fileupload"
      action="?act=send&msgid=<?php echo $wm_msg_id; ?>&msgstatus=<?php echo $msgstatus; ?>" method="POST"
      enctype="multipart/form-data">
    <input type="hidden" name="a" id="adafrt" value="sent"/>

    <div class="inbox-compose-btn">
        <button class="btn blue"><i class="fa fa-check"></i><?php echo $lang_var_admin_176; ?></button>
        <button class="btn"
                onclick="javascript:document.getElementById('adafrt').value='draft'"><?php echo $lang_var_admin_178; ?></button>
        <button class="btn inbox-discard-btn"><?php echo $lang_var_admin_177; ?></button>

    </div>
    <div class="inbox-form-group mail-to">
        <label class="control-label"><?php echo $lang_var_admin_179; ?>:</label>

        <div class="controls controls-to">
            <input type="text" class="form-control" name="to" required="" value="<?php echo $wm_to_email; ?>">
			<span class="inbox-cc-bcc">
				<span class="inbox-cc">
					 Cc
				</span>
				<span class="inbox-bcc">
					 Bcc
				</span>
			</span>
        </div>
    </div>
    <div class="inbox-form-group input-cc display-hide">
        <a href="javascript:;" class="close">
        </a>
        <label class="control-label">Cc:</label>

        <div class="controls controls-cc">
            <input type="text" name="cc" class="form-control" value="<?php echo $wm_to_cc; ?>">
        </div>
    </div>
    <div class="inbox-form-group input-bcc display-hide">
        <a href="javascript:;" class="close">
        </a>
        <label class="control-label">Bcc:</label>

        <div class="controls controls-bcc">
            <input type="text" name="bcc" class="form-control" value="<?php echo $wm_to_bcc; ?>">
            <input type="text" name="member_id" class="form-control" value="<?php echo $member_id; ?>">
        </div>
    </div>
    <div class="inbox-form-group">
        <label class="control-label"><?php echo $lang_var_admin_182; ?>:</label>

        <div class="controls">
            <input type="text" class="form-control" name="subject" value="<?php echo $wm_title; ?>" required="">
        </div>
    </div>
    <div class="inbox-form-group">
        <textarea class="inbox-editor inbox-wysihtml5 form-control" name="message"
                  rows="12"><?php echo $wm_details; ?></textarea>
    </div>
    <br/><input class="btn default" type="file" name="filesnames[]" multiple><br/><br/>

    <div class="inbox-compose-btn">
        <button class="btn blue"><i class="fa fa-check"></i><?php echo $lang_var_admin_176; ?></button>
        <button class="btn"
                onclick="javascript:document.getElementById('adafrt').value='draft'"><?php echo $lang_var_admin_178; ?></button>
        <button class="btn"><?php echo $lang_var_admin_177; ?></button>

    </div>
</form>