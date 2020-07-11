
<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th style="width: 15%;text-align: center;"><?php echo $lang_var_admin_362; ?></th>
        <th style="text-align: center;"><?php echo $lang_var_admin_101; ?></th>
        <th style="width: 15%;text-align: center;"><?php echo $lang_var_admin_347; ?></th>
        <th style="width: 15%;text-align: center;"><?php echo $lang_var_admin_348; ?></th>
        <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_355; ?></th>
        <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_5; ?></th>
    </tr>
    </thead>
    <tbody>
    <?php

    $status_list = array(
        array("danger" => "<i class='fa fa-clock-o'></i> $lang_var_admin_351"),
        array("warning" => "<i class='fa fa-star-o'></i> $lang_var_admin_352"),
        array("info" => "<i class='fa fa-plane'></i> $lang_var_admin_353"),
        array("success" => "<i class='fa fa-check'></i> $lang_var_admin_354")
    );

    $status_list2 = array(
        array("default" => "<i class='fa fa-times'></i>"),
        array("info" => "<i class='fa fa-check'></i>")
    );

    $sql_orders = mysql_query("SELECT * FROM " . $prefix . "_shop_orders where (member_id ='$id'  || customer_email = '$member_email') order by order_id desc");
    $orders_records_count = mysql_num_rows($sql_orders);
    if ($orders_records_count == 0) {
        ?>
        <tr class="odd gradeX">
            <td colspan="6" style="text-align: center;">
                <small><?php echo $lang_var_admin_93; ?></small>
            </td>

        </tr>
        <?php
    } else {
        while ($data_orders = mysql_fetch_array($sql_orders)) {

            $status = $status_list[$data_orders['order_status']];
            $status2 = $status_list2[$data_orders['order_pay_status']];

            ?>
            <tr class="odd gradeX">
                <td style="text-align: center;"><?php echo stripslashes($data_orders['order_no']); ?></td>
                <td style="text-align: center;" title="<?php echo FormatDateTimeLong($data_orders['order_date']); ?>"><?php echo FormatDateTime($data_orders['order_date']); ?></td>
                <td style="text-align: center;"><?php echo stripslashes($data_orders['order_total']); ?></td>
                <td style="text-align: center;"><span class="label label-sm label-<?php echo (key($status)); ?>">&nbsp;<?php echo (current($status)); ?>&nbsp;</span></td>
                <td style="text-align: center;"><span class="label label-sm label-<?php echo (key($status2)); ?>"> <?php echo (current($status2)); ?></span></td>
                <td style="text-align: center;"><a
                        href="shop_orders.php?id=<?php echo $data_orders['order_id']; ?>&act=update" class="btn btn-sm default"> <?php echo $lang_var_admin_103; ?>
                        <i
                            class="fa fa-edit"></i></a>
                </td>

            </tr>
            <?php

        }

    }
    ?>
    </tbody>
</table>