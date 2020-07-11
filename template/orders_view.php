
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
                <option value="b_new"><?php echo $lang_var_admin_351; ?></option>
                <option value="b_ok"><?php echo $lang_var_admin_352; ?></option>
                <option value="b_chip"><?php echo $lang_var_admin_353; ?></option>
                <option value="b_done"><?php echo $lang_var_admin_354; ?></option>
                <option value="" disabled>------------</option>
                <option value="b_pay"><?php echo $lang_var_admin_356; ?></option>
                <option value="b_nopay"><?php echo $lang_var_admin_357; ?></option>
                <?php
                if ($logged_allow_delete_status == 1) {
                    ?>
                    <option value="" disabled>------------</option>
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
                <?php echo $lang_var_admin_101; ?>
            </th>

            <th width="30%">
                <?php echo $lang_var_admin_346; ?>
            </th>
            <th width="10%">
                <?php echo $lang_var_admin_284; ?>
            </th>
            <th width="10%">
                <?php echo $lang_var_admin_347; ?>
            </th>
            <th width="10%" style="text-align:center;">
                <?php echo $lang_var_admin_348; ?>
            </th>
            <th width="10%" style="text-align:center;">
                <?php echo $lang_var_admin_355; ?>
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
                    <input type="text" class="form-control form-filter input-sm"  name="order_date_from"
                           placeholder="<?php echo $lang_var_admin_115; ?>">
				<span class="input-group-btn">
					<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
                </div>
                <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                    <input type="text" class="form-control form-filter input-sm"  name="order_date_to"
                           placeholder="<?php echo $lang_var_admin_116; ?>">
				<span class="input-group-btn">
					<button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
                </div>
            </td>
            <td>
                <input type="text" class="form-control form-filter input-sm" name="order_name">
            </td>
            <td>
                <input type="text" class="form-control form-filter input-sm" name="order_phone">
            </td>
            <td>
                <div class="margin-bottom-5">
                    <input type="text" class="form-control form-filter input-sm" name="order_price_from"
                           placeholder="<?php echo $lang_var_admin_349; ?>">
                </div>
                <input type="text" class="form-control form-filter input-sm" name="order_price_to"
                       placeholder="<?php echo $lang_var_admin_350; ?>">
            </td>
            <td style="text-align: center;">
                <select name="order_status" class="form-control form-filter input-sm">
                    <option value="">...</option>
                    <option value="0"><?php echo $lang_var_admin_351; ?></option>
                    <option value="1"><?php echo $lang_var_admin_352; ?></option>
                    <option value="2"><?php echo $lang_var_admin_353; ?></option>
                    <option value="3"><?php echo $lang_var_admin_354; ?></option>

                </select>
            </td>
            <td style="text-align: center;">
                <select name="order_pay_status" class="form-control form-filter input-sm">
                    <option value="">...</option>
                    <option value="1"><?php echo $lang_var_admin_356; ?></option>
                    <option value="0"><?php echo $lang_var_admin_357; ?></option>
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
