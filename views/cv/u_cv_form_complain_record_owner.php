<?php

use yii\helpers\Html; 
?> 
<?php echo $this->render('menu'); ?>  
 

<div class="x_panel">
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">COMPLAIN RECORD</p>
        <div class="clearfix"></div>
    </div> 
    <div class="table-responsive">
        <table class="table table-sm table-bordered jambo_table table-striped"> 
            <tr> 
                <th style="width: 3%;">No.</th> 
                <th style="width: 15%;">Staff Name</th>
                <th style="width: 15%;">Criteria</th>
                <th>Justification</th>
                <th style="width: 10%;">Date Complain</th> 
                <th style="width: 10%;">Status</th>     
                <th style="width: 10%;">Date Assign</th>    
                <th style="width: 5%;">Action</th>

            </tr> 

            <?php
            $counter = 0;
            foreach ($record as $record) {
                $counter = $counter + 1;
                ?> 

                <tr>
                    <td><?= $counter; ?></td> 
                    <td><?= $record->biodata ? $record->biodata->CONm : ' '; ?> </td> 
                    <td><?= $record->kriteria ? $record->kriteria->type : ' '; ?> </td> 
                    <td><?= $record->justifikasi ? $record->justifikasi : ' '; ?> </td> 
                    <td><?= $record->tarikh_mohon ? $record->tarikh_mohon : ' '; ?> </td> 
                    <td><span class="label label-<?= $record->status ? $record->status->color : ' '; ?>"><?= $record->status ? $record->status->output : ' '; ?></span></td>   
                    <td><?= $record->assign_at ? $record->assign_at : ' '; ?> </td> 
                    <th><?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['complain-in-action','id'=>$record->id], ['class' => 'btn btn-default btn-sm']); ?></th>
                </tr>

                <?php
            }
            ?>
        </table>
    </div>
</div>
