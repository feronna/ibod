<?php

use app\models\cuti\JenisCuti;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

?>


            <div class="clearfix">
                </u></span>
            
                <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
                    <thead>
                        <!-- <tr class="headings"> -->
                        <th class="column-title text-center">PEMOHON</th>
                        <th class="column-title text-center">LEAVE TYPE</th>
                        <th class="column-title text-center">START</th>
                        <th class="column-title text-center">END</th>
                        <th class="column-title text-center">DURATION</th>
                        <th class="column-title text-center">STATUS</th>
                        <!-- <th class="column-title text-center">VERIFIER</th> -->
                        <th class="column-title text-center">DETAILS</th>
                        <th class="column-title text-center">ACTION</th>
                        <!-- </tr> -->
                    </thead>
                    <?php
                    // if (!empty($data)) {

                    foreach ($model as $data) {

                    ?>
                        <tr>
                            <td class="text-center"><?= $data->kakitangan->CONm ?></td>
                            <td class="text-center"><?= $data->jenisCuti->jenis_cuti_nama ?></td>
                            <td class="text-center"><?= $data->start_date ?></td>
                            <td class="text-center"><?= $data->end_date ?></td>
                            <td class="text-center"><?= $data->tempoh ?></td>
                            <td class="text-center"><?= $data->status ?></td>
                            <td class="text-center"> <?= Html::button('<i class="fa fa-search"></i>  ', ['value' => Url::to(['cuti/supervisor/leave-details', 'id' => $data->id]), 'class' => 'mapBtn']); ?>
                               
                            </td>

                        </tr>
                    <?php
                    }
                    // } else {
                    ?>
                    <!-- <tr class="text-center">
                                <td colspan="9">No Data.</td>
                            </tr> -->
                    <?php
                    // }
                    ?>

                </table>
            </div>
        </div>
    </div>
</div>