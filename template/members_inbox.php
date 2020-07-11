

<div class="table-toolbar">
    <?php
    if ($logged_allow_add_status == 1) {
        ?>
        <div class="btn-group">
            <a href="inbox.php?a=compose&member_id=<?php echo $id; ?>"><span id="sample_editable_1_new"
                                                                             class="btn green">
									<?php echo $lang_var_admin_164; ?> <i class="fa fa-plus"></i>
									</span></a>
        </div>
        <?php
    }
    ?>
</div>
<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th><?php echo $lang_var_admin_452; ?></th>
        <th style="width: 15%;text-align: center;"><?php echo $lang_var_admin_101; ?></th>
        <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_5; ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql_notices = mysql_query("SELECT * FROM " . $prefix . "_webmail where (member_id ='$id' || wm_to_email = '$member_email') and cat_id = 1 order by wm_date desc");
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
                        <small><?php echo nl2br(stripslashes($data_notices['wm_title'])); ?></small>
                    </div>
                </td>
                <td style="text-align: center;" title="<?php echo FormatDateTimeLong($data_notices['wm_date']); ?>"><?php echo FormatDateTime($data_notices['wm_date']); ?></td>

                <td style="text-align: center;"><a
                        href="inbox.php?id=<?php echo $data_notices['wm_id']; ?>&a=view" class="btn btn-sm default"> <?php echo $lang_var_admin_103; ?>
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
