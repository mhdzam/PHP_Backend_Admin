<div class="table-container">
    <div class="table-actions-wrapper">
		<span>
		</span>
        <select name="sGroupActionName" class="table-group-action-input form-control input-inline input-small input-sm">
            <option value="">...</option>
            <option value="b_delete"><?php echo $lang_var_admin_32; ?></option>
        </select>
        <button class="btn btn-sm yellow table-group-action-submit"><i
                class="fa fa-check"></i> <?php echo $lang_var_admin_110; ?></button>
    </div>
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
                <?php echo $lang_var_admin_101; ?>
            </th>
            <th width="60%">
                <?php echo $lang_var_admin_411; ?>
            </th>
            <th width="10%">
                <?php echo $lang_var_admin_13; ?>
            </th>

        </tr>
        <tr role="row" class="filter">
            <td colspan="2">
                <input type="text" class="form-control form-filter input-sm" name="order_id">
            </td>

            <td colspan="2">
                <input type="text" class="form-control form-filter input-sm" name="order_name">
            </td>
            <td style="text-align: center">
                <button class="btn btn-sm yellow filter-submit margin-bottom"><i
                        class="fa fa-search"></i> <?php echo $lang_var_admin_111; ?></button>
            </td>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>