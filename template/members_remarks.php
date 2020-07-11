<?php

$noticeact = @$_GET['noticeact'];
$notice_id = @$_GET['notice_id'];
$sve_in = "#remarks";

$notice_date = mysql_real_escape_string(@$_POST['notice_date']);
$notice_details = mysql_real_escape_string(@$_POST['notice_details']);

if ($noticeact == "delete" && $notice_id != "") {
    $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_members_notices where notice_id = '$notice_id' && member_id='$id'");
    if ($sql_delete) {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true"></button>
            <?php echo $lang_var_admin_25; ?>
        </div>
        <?php
    }
}
if ($noticeact == "save" && $notice_id != "") {

    $sql_update = mysql_query("UPDATE " . $prefix . "_members_notices SET notice_date='$notice_date',notice_details='$notice_details',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip' WHERE notice_id = '$notice_id' && member_id='$id'") or
    die(mysql_error());
    if ($sql_update) {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true"></button>
            <?php echo $lang_var_admin_25; ?>
        </div>
        <?php
    }
}
if ($noticeact == "insert" && $notice_details != "") {

    $sql_slct_max = mysql_query("select max(notice_id)  from " . $prefix . "_members_notices");
    $data_slct_max = mysql_fetch_array($sql_slct_max);
    $next_notice_id = $data_slct_max[0] + 1;
    $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_members_notices (
  notice_id,
  notice_date,
  notice_details,
  create_date,
  edit_by,
  edit_date,
  edit_from,
  member_id) VALUES ('$next_notice_id','$notice_date','$notice_details',now(),'$pd_admin_user_id',now(),'$pd_admin_ip','$id')");
    if ($sql_insert_new) {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true"></button>
            <?php echo $lang_var_admin_25; ?>
        </div>
        <?php
    }

}
?>
<script type="text/javascript">
    function del_notice_confirmation(id, name) {
        var answer = confirm("<?php echo $lang_var_admin_190; ?> " + name + " ?")
        if (answer) {
            window.location = "members.php?id=<?php echo $id; ?>&act=update&notice_id=" + id + "&noticeact=delete<?php echo $sve_in; ?>";
        }
    }
</script>

<div class="table-toolbar">
    <?php
    if ($logged_allow_add_status == 1) {
        ?>
        <div class="btn-group">
            <a href="members_remarks_edit.php?id=<?php echo $id; ?>&stat=new" data-target="#ajax"
               data-toggle="modal"><span id="sample_editable_1_new" class="btn green">
									<?php echo $lang_var_admin_462; ?> <i class="fa fa-plus"></i>
									</span></a>
        </div>
        <?php
    }
    ?>
</div>
<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th><?php echo $lang_var_admin_450; ?></th>
        <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_101; ?></th>
        <?php
        if ($logged_allow_edit_status == 1) {
            ?>
            <th style="width: 15%;text-align: center;"><?php echo $lang_var_admin_5; ?></th>
            <?php
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql_notices = mysql_query("SELECT * FROM " . $prefix . "_members_notices where member_id='$id' order by notice_date desc");
    $notices_records_count = mysql_num_rows($sql_notices);
    if ($notices_records_count == 0) {
        ?>
        <tr class="odd gradeX">
            <td colspan="6" style="text-align: center;">
                <small><?php echo $lang_var_admin_93; ?></small>
            </td>

        </tr>
        <?php
    } else {

        while ($data_notices = mysql_fetch_array($sql_notices)) {
            ?>
            <tr class="odd gradeX">
                <td>
                    <div>
                        <small><?php echo nl2br(stripslashes($data_notices['notice_details'])); ?></small>
                    </div>
                </td>
                <td style="text-align: center;"><?php echo $data_notices['notice_date']; ?></td>
                <?php
                if ($logged_allow_edit_status == 1) {
                    ?>
                    <td style="text-align: center;"><a
                            href="members_remarks_edit.php?id=<?php echo $id; ?>&notice_id=<?php echo $data_notices['notice_id']; ?>&stat=update"
                            data-target="#ajax" data-toggle="modal"
                            class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?>
                            <i
                                class="fa fa-edit"></i></a>
                        <?php
                        if ($logged_allow_delete_status == 1) {
                            ?>
                            <a href="javascript:del_notice_confirmation(<?php echo $data_notices['notice_id']; ?>,'<?php echo stripslashes($data_notices['notice_name']); ?>')"
                               class="btn btn-sm default" id="confirmation_box_for_delete"><i
                                    class="fa fa-trash-o"></i> <?php echo $lang_var_admin_19; ?>
                            </a>
                            <?php
                        }
                        ?>
                    </td>
                    <?php

                }
                ?>
            </tr>
            <?php

        }

    }
    ?>
    </tbody>
</table>
