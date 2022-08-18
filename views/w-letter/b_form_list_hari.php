<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
?>  
 <?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

 

<?php if (!empty($month) && !empty($year)) { ?>

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Senarai Bekerja Dari Office (WFO) - <?= $month . '/' . $year; ?></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?></p>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table">
                    <thead>
                        <tr class="headings"> 
                            <th class="text-center">Date</th>  
                            <th class="text-center">Day</th>  
                            <th class="text-center" style="width:1px;white-space:nowrap">Jumlah Kakitangan Bekerja Dari Rumah (WFO)</th>
                            <th class="text-center">Tindakan</th>
                             <th class="text-center"></th>
                        </tr> 
                    </thead>
                    <?php
                    $day = cal_days_in_month(CAL_GREGORIAN, $month, 2020);
                    if ($day) {
                        for ($i = 1; $i <= $day; $i++) {
                            ?> 
                            <tr> 
                                <td class="text-center"><?= $i . '/' . $month . '/' . $year; ?></td> 
                                <?php
                                if (strlen($i) == 1) {
                                    $i = '0' . $i;
                                }
                                $date = $year . '-' . $month . '-' . $i;
                                ?>
                                <td class="text-center"><?= date('D', strtotime($date)); ?></td> 
                                <td class="text-center" style="width:1px;white-space:nowrap"><?= $permohonan->getTotalWFObyDay($date); ?></td> 
                                <td class="text-center"><?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['tambah-jadual-hari', 'date' => $date], ['class' => 'btn btn-sm btn-default',]); ?> </td> 
                                <td class="text-center"><input name="check[<?=$i;?>]" type="checkbox" value="<?= $date; ?>"/>
                                </td>  
                            </tr> 


                        <?php }
                        ?> 


                    <?php } else {
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">Tiada Rekod</td>                     
                        </tr>
                    <?php }
                    ?>
                </table>
            </div> 

        </div>
    </div>    

<?php } ?>


<div class="col-md-12 col-sm-12 col-xs-12" align="right">  
    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
</div
<?php ActiveForm::end(); ?> 



