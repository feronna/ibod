
<?php

use yii\helpers\Html;
use app\models\keselamatan\cuti;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
// as a widget
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Senarai Permohonan Cuti</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

<!--                <div style='padding: 15px;' class="table-bordered">
                    <font>[ &#10004; ]</font> : Remarked&nbsp;&nbsp;&nbsp;&nbsp;
                    <font color="white" style="background-color:green;">[ &#10004; ]</font> : Remark has been Approved &nbsp;&nbsp;&nbsp;&nbsp;
                    <font style="color:red">[ &#x2716; ]</font> : No Remark / Remark not approved
                </div>-->
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Pemohon</th>
                                <th class="text-center">Tarikh</th>
                                <th class="text-center">Tempoh</th>
                                <th class="text-center">Catatan</th>
                                <th class="text-center">Status Perakuan</th>
                                <th class="text-center">Peraku</th>
                                <th class="text-center">Details</th>
                            </tr>
                        </thead>
                    <?php foreach ($model as $models) { ?>
                            <tr>

                                <td class="text-center"  style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->pemohoncuti->CONm ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->formattarikh ?> - <?= $models->formattarikhtamat ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->cuti_tempoh ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->cuti_catatan ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->statusperaku ?></td>
                                <td class="text-center"  style="text-align:center"><?= Html::button('<i class="fa fa-edit"></i>', ['value' => Url::to(['keselamatan/approved-cuti', 'id' => $models->cuti_rekod_id]), 'class' => 'mapBtn', 'id' => 'modalButton']) ?></td>
                                <td class="text-center"  style="text-align:center"><?= Html::button('<i class="fa fa-eye"></i>', ['value' => Url::to(['keselamatan/list-cuti', 'id' => $models->cuti_icno]), 'class' => 'mapBtn', 'id' => 'modalButton']) ?></td>

                            </tr>
                    <?php } ?>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
       
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
JS;
$this->registerJs($script);
?>

