<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Lihat Anugerah';

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
        <?= Html::a('Kembali', ['view'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Kemaskini', ['update', 'id' => $model->awdId], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= $this->render('_lihatanugerah',[
        'model'=>$model,
    ]); ?>

</div>
        </div>
    </div>
</div>

