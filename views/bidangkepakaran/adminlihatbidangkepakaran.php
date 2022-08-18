<?php

use yii\helpers\Html;

$this->title = 'Lihat Kepakaran';
?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="tblpraddress-view">

                <p>
                    <?= Html::a('Kembali', ['adminview', 'icno' => $model->ICNO], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Kemaskini', ['adminupdate', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

                </p>

                <?= $this->render('_lihatbidangkepakaran',[
                    'model'=>$model,
                ]); ?>

            </div>
        </div>
    </div>
</div>
