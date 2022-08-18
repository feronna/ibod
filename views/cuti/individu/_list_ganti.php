<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
    <thead>
                            <th class="column-title text-center">Substitute For</th>
                            <th class="column-title text-center">Leave Start</th>
                            <th class="column-title text-center">Leave End</th>
                            <th class="column-title text-center">Duration</th>
                            <th class="column-title text-center">Remark</th>
                            <th class="column-title text-center">Status</th>
                          
                    </thead>
                    <?php foreach ($model as $v) { ?>

                    <tr class='text-center'>
                        <td><?= $v->kakitangan->CONm ?></td>
                        <td><?= $v->start_date ?></td>
                        <td><?= $v->end_date ?></td>
                        <td><?= $v->tempoh ?></td>
                        <td><?= $v->remark ?></td>
                        <td><?= $v->status ?></td>
         
                    </tr>
                    <?php } ?>
    </table>
</div>