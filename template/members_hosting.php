﻿<?php



$hostact = @$_GET['hostact'];
$host_id = @$_GET['host_id'];
$sve_in = "#hosting";

$host_name = mysql_real_escape_string(@$_POST['host_name']);
$host_register_date = mysql_real_escape_string(@$_POST['host_register_date']);
$host_expire_date = mysql_real_escape_string(@$_POST['host_expire_date']);
$host_noties = mysql_real_escape_string(@$_POST['host_noties']);
$host_price = mysql_real_escape_string(@$_POST['host_price']);

if ($hostact == "delete" && $host_id != "") {
    $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_members_hosting where host_id = '$host_id' && member_id='$id'");
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
if ($hostact == "save" && $host_id != "") {

    $sql_update = mysql_query("UPDATE " . $prefix . "_members_hosting SET host_name='$host_name',host_register_date='$host_register_date',host_expire_date='$host_expire_date',host_price='$host_price',host_noties='$host_noties',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip' WHERE host_id = '$host_id' && member_id='$id'") or
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
if ($hostact == "insert" && $host_name != "") {

    $sql_slct_max = mysql_query("select max(host_id)  from " . $prefix . "_members_hosting");
    $data_slct_max = mysql_fetch_array($sql_slct_max);
    $next_host_id = $data_slct_max[0] + 1;
    $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_members_hosting (
  host_id,
  host_name,
  host_register_date,
  host_expire_date,
  host_price,
  host_noties,
  create_date,
  edit_by,
  edit_date,
  edit_from,
  member_id) VALUES ('$next_host_id','$host_name','$host_register_date','$host_expire_date','$host_price','$host_noties',now(),'$pd_admin_user_id',now(),'$pd_admin_ip','$id')");
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
    function del_host_confirmation(id, name) {
        var answer = confirm("<?php echo $lang_var_admin_190; ?> " + name + " ?")
        if (answer) {
            window.location = "members.php?id=<?php echo $id; ?>&act=update&host_id=" + id + "&hostact=delete<?php echo $sve_in; ?>";
        }
    }
</script>

<div class="table-toolbar">
    <?php
    if ($logged_allow_add_status == 1) {
        ?>
        <div class="btn-group">
            <a href="members_hosting_edit.php?id=<?php echo $id; ?>&stat=new" data-target="#ajax"
               data-toggle="modal"><span id="sample_editable_1_new" class="btn green">
									<?php echo $lang_var_admin_460; ?> <i class="fa fa-plus"></i>
									</span></a>
        </div>
        <?php
    }
    ?>
</div>
<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th><?php echo $lang_var_admin_443; ?></th>
        <th style="width: 20%;text-align: center;"><?php echo $lang_var_admin_454; ?></th>
        <th style="width: 20%;text-align: center;"><?php echo $lang_var_admin_455; ?></th>
        <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_456; ?></th>
        <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_316; ?>  <small>(<?php echo $defult_currency; ?>)</small></th>
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
    $sql_hosting = mysql_query("SELECT * FROM " . $prefix . "_members_hosting where member_id='$id' order by create_date");
    $hosting_records_count = mysql_num_rows($sql_hosting);
    if ($hosting_records_count == 0) {
        ?>
        <tr class="odd gradeX">
            <td colspan="6" style="text-align: center;">
                <small><?php echo $lang_var_admin_93; ?></small>
            </td>

        </tr>
        <?php
    } else {

        while ($data_hosting = mysql_fetch_array($sql_hosting)) {
            $date1 = new DateTime($data_hosting['host_expire_date']);
            $date2 = new DateTime($pd_current_date);
            $interval = $date1->diff($date2);
            //echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";
            $dayes_diff = $interval->days;
            if ($date2 > $date1) {
                $dayes_diff = $dayes_diff * (-1);
            }

            ?>
            <tr class="odd gradeX">
                <td>
                    <?php echo stripslashes($data_hosting['host_name']); ?>
                    <div>
                        <small><?php echo nl2br(stripslashes($data_hosting['host_noties'])); ?></small>
                    </div>
                </td>
                <td style="text-align: center;"><?php echo $data_hosting['host_register_date']; ?></td>
                <td style="text-align: center;"><?php echo $data_hosting['host_expire_date']; ?></td>
                <td style="text-align: center;"><?php echo $dayes_diff; ?></td>
                <td style="text-align: center;"><?php echo $data_hosting['host_price']; ?></td>
                <?php
                if ($logged_allow_edit_status == 1) {
                    ?>
                    <td style="text-align: center;"><a
                            href="members_hosting_edit.php?id=<?php echo $id; ?>&host_id=<?php echo $data_hosting['host_id']; ?>&stat=update"
                            data-target="#ajax" data-toggle="modal"
                            class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?>
                            <i
                                class="fa fa-edit"></i></a>
                        <?php
                        if ($logged_allow_delete_status == 1) {
                            ?>
                            <a href="javascript:del_host_confirmation(<?php echo $data_hosting['host_id']; ?>,'<?php echo stripslashes($data_hosting['host_name']); ?>')"
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
