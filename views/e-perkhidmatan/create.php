<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Borang Permohonan');

//echo $this->render('/aduan/_topmenu');
echo $this->render('/e-perkhidmatan/contact');
?>

<div class="rpt-tbl-aduan-create">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="panel">

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
                    'status' => 1 //create new permohonan (event)

                ]) ?>
            </div>
        </div>
    </div>
</div>