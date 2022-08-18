<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Lihat Kurang Upaya';
?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 " > 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
<div class="tblpraddress-view">


    <p>
        <?= Html::a('Kembali', ['lihatkeluarga','id'=>$model->tblfmy_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Kemaskini', ['update-k-u', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    
    <?= $this->render('_lihatkurangupaya',['model'=>$model]) ?>
    
</div>
        </div>
    </div>
</div>
</div>