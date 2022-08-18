<?php
$this->title = 'Create Tblrscoadminpost';
$this->params['breadcrumbs'][] = ['label' => 'Tblrscoadminposts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
    <div class="x_title">
            <h2><strong>Tambah Rekod Lantikan</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('&nbsp;Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?></p>   
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

    <?= $this->render('tambah-rekod', [
        'model' => $model,
        'job_group' => $job_group,
        'biodata' => $biodata
    ]) ?>

    </div>
</div>
</div>
</div>
