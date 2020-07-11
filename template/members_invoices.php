<?php

$invoiceact = @$_GET['invoiceact'];
$invoice_id = @$_GET['invoice_id'];
$sve_in = "#invoices";

$invoice_title = mysql_real_escape_string(@$_POST['invoice_title']);
$invoice_date = mysql_real_escape_string(@$_POST['invoice_date']);
$invoice_price = mysql_real_escape_string(@$_POST['invoice_price']);
$invoice_canceled = mysql_real_escape_string(@$_POST['invoice_canceled']);
$invoice_free = mysql_real_escape_string(@$_POST['invoice_free']);
$invoice_sub = mysql_real_escape_string(@$_POST['invoice_sub']);
$invoice_father = mysql_real_escape_string(@$_POST['invoice_father']);


if ($invoiceact == "delete" && $invoice_id != "") {
    $sql_delete0 = mysql_query("DELETE FROM  " . $prefix . "_members_invoices where invoice_father = '$invoice_id' && member_id='$id'");
    $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_members_invoices where invoice_id = '$invoice_id' && member_id='$id'");
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
if ($invoiceact == "save" && $invoice_id != "") {

    $sql_update = mysql_query("UPDATE " . $prefix . "_members_invoices SET invoice_title='$invoice_title',invoice_date='$invoice_date',invoice_price='$invoice_price',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip',invoice_free='$invoice_free',invoice_canceled='$invoice_canceled',invoice_father='$invoice_father' WHERE invoice_id = '$invoice_id' && member_id='$id'") or
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
if ($invoiceact == "insert" && $invoice_title != "") {

    $sql_slct_max = mysql_query("select max(invoice_id)  from " . $prefix . "_members_invoices");
    $data_slct_max = mysql_fetch_array($sql_slct_max);
    $next_invoice_id = $data_slct_max[0] + 1;
    $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_members_invoices (
  invoice_id,
  invoice_type,
  invoice_canceled,
  invoice_title,
  invoice_date,
  invoice_price,
  invoice_paid,
  invoice_free,
  invoice_sub,
  create_date,
  edit_by,
  edit_date,
  edit_from,
  member_id,
  invoice_father) VALUES ('$next_invoice_id','0','$invoice_canceled','$invoice_title','$invoice_date','$invoice_price','0','$invoice_free','$invoice_sub',now(),'$pd_admin_user_id',now(),'$pd_admin_ip','$id','$invoice_father')");
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
    function del_invoice_confirmation(id, name) {
        var answer = confirm("<?php echo $lang_var_admin_190; ?> " + name + " ?")
        if (answer) {
            window.location = "members.php?id=<?php echo $id; ?>&act=update&invoice_id=" + id + "&invoiceact=delete<?php echo $sve_in; ?>";
        }
    }
</script>

<div class="table-toolbar">

    <?php

    echo "<h3> <i class='fa fa-usd'></i> $lang_var_admin_449</h3><hr>";
    if ($logged_allow_add_status == 1) {
        ?>
        <div class="btn-group pull-right" style="margin-top: -65px">
            <a href="members_invoices_edit.php?id=<?php echo $id; ?>&stat=new" data-target="#ajax"
               data-toggle="modal"><span id="sample_editable_1_new" class="btn green">
									<?php echo $lang_var_admin_465; ?> <i class="fa fa-plus"></i>
									</span></a>
        </div>
        <?php
    }
    ?>
</div>
<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th><?php echo $lang_var_admin_103; ?></th>
        <th style="width: 15%;text-align: center;"><?php echo $lang_var_admin_316; ?>
            <small>(<?php echo $defult_currency; ?>)</small>
        </th>
        <th style="width: 15%;text-align: center;"><?php echo $lang_var_admin_101; ?></th>
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
    $sql_invoices = mysql_query("SELECT * FROM " . $prefix . "_members_invoices where member_id='$id' and invoice_type=0 and invoice_father=0 order by create_date");
    $invoices_records_count = mysql_num_rows($sql_invoices);
    if ($invoices_records_count == 0) {
        ?>
        <tr class="odd gradeX">
            <td colspan="6" style="text-align: center;">
                <small><?php echo $lang_var_admin_93; ?></small>
            </td>

        </tr>
        <?php
    } else {

        $sum_of_invoices = 0;
        while ($data_invoices = mysql_fetch_array($sql_invoices)) {

            $invoice_price_is = $data_invoices['invoice_price'];
            if ($data_invoices['invoice_free'] == 1) {
                $invoice_price_is = " <small><span style='text-decoration: line-through;'>" . $data_invoices['invoice_price'] . "</span> " . $lang_var_admin_467 . "<small>";
            }

            $invoice_canceled = "";
            if ($data_invoices['invoice_canceled'] == 1) {
                $invoice_canceled = "text-decoration: line-through;color:gray;";
            }

            if ($data_invoices['invoice_free'] == 0 && $data_invoices['invoice_canceled'] == 0) {
                $sum_of_invoices += $data_invoices['invoice_price'];
            }

            $invoice_title = stripslashes($data_invoices['invoice_title']);
            $invoice_price_show = $invoice_price_is;
            if ($data_invoices['invoice_sub'] == 1) {
                $invoice_title = "$lang_var_admin_474 # $data_invoices[invoice_id]";
                $invoice_price_show = "";
            }
            ?>
            <tr class="odd gradeX">
                <td style="<?php echo $invoice_canceled; ?>">
                    <div style="margin-bottom: 20px;"><?php echo $invoice_title; ?></div>
                </td>

                <td style="<?php echo $invoice_canceled; ?>text-align: center;"><?php echo $invoice_price_show; ?></td>
                <td style="<?php echo $invoice_canceled; ?>text-align: center;"><?php echo $data_invoices['invoice_date']; ?></td>
                <?php
                if ($logged_allow_edit_status == 1) {
                    ?>
                    <td style="text-align: center;">
                        <?php
                        if ($data_invoices['invoice_sub'] == 0) {
                            ?>
                            <a
                                href="members_invoices_edit.php?id=<?php echo $id; ?>&invoice_id=<?php echo $data_invoices['invoice_id']; ?>&stat=update"
                                data-target="#ajax" data-toggle="modal"
                                class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?>
                                <i
                                    class="fa fa-edit"></i></a>
                            <?php
                        }
                        if ($logged_allow_delete_status == 1) {
                            ?>
                            <a href="javascript:del_invoice_confirmation(<?php echo $data_invoices['invoice_id']; ?>,'<?php echo stripslashes($data_invoices['invoice_title']); ?>')"
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
            $sql2_invoices = mysql_query("SELECT * FROM " . $prefix . "_members_invoices where member_id='$id' and invoice_type=0 and invoice_sub=0 and invoice_father='$data_invoices[invoice_id]' order by create_date");
            while ($data2_invoices = mysql_fetch_array($sql2_invoices)) {

                $invoice_price_is = $data2_invoices['invoice_price'];
                if ($data2_invoices['invoice_free'] == 1) {
                    $invoice_price_is = " <small><span style='text-decoration: line-through;'>" . $data2_invoices['invoice_price'] . "</span> " . $lang_var_admin_467 . "<small>";
                }

                $invoice_canceled = "";
                if ($data2_invoices['invoice_canceled'] == 1) {
                    $invoice_canceled = "text-decoration: line-through;color:gray;";
                }

                if ($data2_invoices['invoice_free'] == 0 && $data2_invoices['invoice_canceled'] == 0) {
                    $sum_of_invoices += $data2_invoices['invoice_price'];
                }

                $invoice_title = stripslashes($data2_invoices['invoice_title']);
                $invoice_price_show = $invoice_price_is;

                ?>
                <tr class="odd gradeX">
                    <td style="<?php echo $invoice_canceled; ?>">
                        <img
                            src="assets/img/treepart_<?php echo $site_lang_dir; ?>.png"
                            class="submenu_img"/> &nbsp; <?php echo $invoice_title; ?>
                    </td>

                    <td style="<?php echo $invoice_canceled; ?>text-align: center;"><?php echo $invoice_price_show; ?></td>
                    <td style="<?php echo $invoice_canceled; ?>text-align: center;"><?php echo $data2_invoices['invoice_date']; ?></td>
                    <?php
                    if ($logged_allow_edit_status == 1) {
                        ?>
                        <td style="text-align: center;"><a
                                href="members_invoices_edit.php?id=<?php echo $id; ?>&invoice_id=<?php echo $data2_invoices['invoice_id']; ?>&stat=update"
                                data-target="#ajax" data-toggle="modal"
                                class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?>
                                <i
                                    class="fa fa-edit"></i></a>
                            <?php
                            if ($logged_allow_delete_status == 1) {
                                ?>
                                <a href="javascript:del_invoice_confirmation(<?php echo $data2_invoices['invoice_id']; ?>,'<?php echo stripslashes($data2_invoices['invoice_title']); ?>')"
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

        <tr class="odd gradeX">
            <td style="border: none;text-align: <?php echo $site_lang_align_left; ?>"><?php echo $lang_var_admin_347; ?></td>
            <td style="text-align: center;">
                <strong><?php echo $sum_of_invoices; ?> <?php echo $defult_currency; ?></strong></td>
            <td style="text-align: center;border: none"></td>
            <?php
            if ($logged_allow_edit_status == 1) {
                ?>
                <td style="text-align: center;border: none"></td>
                <?php

            }
            ?>
        </tr>

        <?php
    }
    ?>
    </tbody>
</table>
