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

            <th width="75%">
                <?php echo $lang_var_admin_411; ?>
            </th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>