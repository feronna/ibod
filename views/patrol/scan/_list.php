<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
        <thead>
            <tr class="headings">
                <th>Bil</th>
                <th class="text-center">Type</th>
                <th class="text-center">Date</th>
                <th class="text-center">Period</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($record as $rows) { ?>
                <tr>
                    <td class="text-center"><?= $bil++ ?></td>
                    <td class="text-center"><?= $rows->route->route_name ?></td>
                    <td class="text-center"><?= $rows->bit->bit_name ?></td>
                
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>