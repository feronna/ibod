<?php

use yii\helpers\Html;
?>

<div class="x_panel" style="color:black;">
    <div class="x_title">

        <h2><i class="fa fa-eyedropper"></i> : Program Vaksinasi</h2>
        <ul class="nav navbar-right panel_toolbox">

        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content ">

        </br>
        <div class="row">
            <div class="col-xs-12 col-md-3">
                <?php
                $baru = \yiister\gentelella\widgets\StatsTile::widget(
                                [
                                    //'icon' => 'comments-o',
                                    'header' => 'Vaksinasi',
                                    'text' => 'Dos Pertama, Dos Kedua, Booster.',
                                    'number' => '1',
                ]);

                echo Html::a($baru, ['view-st-vaksinasi',], ['class' => '']);
                
                //echo Yii::$app->MP->HaveVaccineRecord($icno) ?  Html::a($baru, ['view-status-vaksinasi',], ['class' => '']) : Html::button($baru, ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['not-registered',]),'class' => 'btn  mapBtn ']);
                
                ?>
            </div>
            <div class="col-xs-12 col-md-3">
                <?php
                $booster = \yiister\gentelella\widgets\StatsTile::widget(
                                [
                                    'header' => 'Dos Penggalak (Booster)',
                                    'text' => 'Perakuan Terima Dos Penggalak.',
                                    'number' => '2',
                                ]
                );
                //echo Yii::$app->MP->EligibleBooster() ? Html::a($booster,  ['view-bc',], ['class' => ' ']) : ' ';
                // echo Html::a($booster,  ['view-bc',], ['class' => ' ']);
                ?>
            </div>
        </div>
        </br>
    </div>

</div>