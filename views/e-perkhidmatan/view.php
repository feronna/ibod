<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Borang Permohonan : {name}', [
    'name' => $model->event_id,
]);
$subtitle = Yii::t('app', 'Status Permohonan');

//echo $this->render('/aduan/_topmenu');
echo $this->render('/e-perkhidmatan/contact');
?>

<div class="rpt-tbl-aduan-update">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="panel">

                <!-- <div class="panel-heading">
                    <h2><= Html::encode($this->title) ?></h2>
                </div> -->

                <div class="panel-heading">
                    <div class="x_title">
                        <h2><?= Html::encode($this->title) ?></h2>
                        <div class="clearfix"></div>
                    </div>
                </div>
                </br>

                <?= $this->render('_form', [
                    'model' => $model,
                    'modelBio' => $modelBio,
                    'status' => 2 //view each permohonan (event)

                ]) ?>

            </div>
        </div>
    </div>
</div>