<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper; 
?>

<?= $this->render('menu') ?>  


<div class="x_panel"> 
    <div class="x_title">
        <p align="right">
            <?php $form = ActiveForm::begin(); ?>
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%;"> 
                <?=
                    $form->field($model, 'isActive')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname'),
                        'options' => ['placeholder' => 'Pilih Jabatan...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i>', ['class' => 'btn btn-primary btn-sm']) ?> </td>
            </tr>
        </table> 

        <?php ActiveForm::end(); ?> 
        </p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                    <tr class="headings"> 
                        <th>Department</th> 
                        <th class="text-center">Jumlah Kakitangan</th>
                        <th class="text-center">Tindakan</th>
                        <!--<th class="text-center">Laporan Bulanan</th>-->
                    </tr> 
                </thead>
                <?php
                if ($department) {
                    $counter = 0;
                    foreach ($department as $department) {
                        $counter = $counter + 1;
                        $bg = "#FFFFFF";
                        ?>

                        <tr> 
                            <td bgcolor=<?= $bg; ?> style="font-size:18px;"><?= $department->fullname; ?></td> 
                            <td class="text-center" bgcolor=<?= $bg; ?>><?= $permohonan->getJumlahKakitangan($department->id); ?></td>
                            <td class="text-center" bgcolor=<?= $bg; ?>><?= Html::a('', ['carian-pegawai', 'dept' => $department->id], ['class' => 'fa fa-edit btn btn-default btn-sm']); ?></td> 
                            <!--<td class="text-center" bgcolor=<?php// $bg; ?>><?php// Html::a('', ['jana-laporan', 'dept' => $department->id, 'month' => date('m')], ['class' => 'fa fa-bar-chart btn btn-default btn-sm']); ?></td>--> 

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
