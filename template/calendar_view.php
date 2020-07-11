
<div class="table-container">
    <?php
    if ($logged_allow_delete_status == 1) {
        ?>
        <div class="table-actions-wrapper">
		<span>
		</span>
            <select name="sGroupActionName"
                    class="table-group-action-input form-control input-inline input-small input-sm">
                <option value="">...</option>
                <option value="b_delete"><?php echo $lang_var_admin_32; ?></option>
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
                <?php echo $lang_var_admin_197; ?>
            </th>

            <th width="15%">
                <?php echo $lang_var_admin_198; ?>
            </th>
            <th width="55%">
                <?php echo $lang_var_admin_201; ?>
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
                <div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy-mm-dd">
                    <input type="text" class="form-control form-filter input-sm" readonly name="order_date_from"
                           placeholder="<?php echo $lang_var_admin_115; ?>">
				<span class="input-group-btn">
					<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
                </div>
                <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                    <input type="text" class="form-control form-filter input-sm" readonly name="order_date_to"
                           placeholder="<?php echo $lang_var_admin_116; ?>">
				<span class="input-group-btn">
					<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
                </div>
            </td>

            <td colspan="2">
                <input type="text" class="form-control form-filter input-sm" name="order_name">
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