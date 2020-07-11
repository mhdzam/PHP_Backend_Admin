<div class="table-container">
    <?php
    if ($logged_allow_edit_status == 1) {
        ?>
        <div class="table-actions-wrapper">
		<span>
		</span>
            <select name="sGroupActionName"
                    class="table-group-action-input form-control input-inline input-small input-sm">
                <option value="">...</option>
                <option value="b_active"><?php echo $lang_var_admin_30; ?></option>
                <option value="b_block"><?php echo $lang_var_admin_31; ?></option>
                <?php
                if ($logged_allow_delete_status == 1) {
                    ?>
                    <option value="b_delete"><?php echo $lang_var_admin_32; ?></option>
                    <?php
                }
                ?>
            </select>
            <button class="btn btn-sm yellow table-group-action-submit"><i
                    class="fa fa-check"></i> <?php echo $lang_var_admin_110; ?></button>
        </div>
        <?php
    }
    ?>
    <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
        <thead>
        <tr role="row" class="heading">
            <th width="3%" style="text-align:center;">
                <input type="checkbox" class="group-checkable">
            </th>
            <th width="5%">
                ID&nbsp;
            </th>

            <th width="15%">
                <?php echo $lang_var_admin_126; ?>
            </th>

            <th width="62%">
                <?php echo $lang_var_admin_127; ?>
            </th>
            <th width="8%" style="text-align:center;">
                <?php echo $lang_var_admin_4; ?>
            </th>
            <th width="5%" style="text-align:center;">
                <?php echo $lang_var_admin_5; ?>
            </th>
        </tr>
        <tr role="row" class="filter">
            <td colspan="2">
                <input type="text" class="form-control form-filter input-sm" name="order_id">
            </td>

            <td>
                <input type="text" class="form-control form-filter input-sm" name="order_by">
            </td>

            <td>
                <input type="text" class="form-control form-filter input-sm" name="order_name">
            </td>
            <td style="text-align: center;">
                <select name="order_status" class="form-control form-filter input-sm">
                    <option value="">...</option>
                    <option value="1"><?php echo $lang_var_admin_113; ?></option>
                    <option value="0"><?php echo $lang_var_admin_114; ?></option>
                </select>
            </td>
            <td style="text-align: center;">
                <button class="btn btn-sm yellow filter-submit margin-bottom"><i
                        class="fa fa-search"></i> <?php echo $lang_var_admin_111; ?></button>
            </td>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>