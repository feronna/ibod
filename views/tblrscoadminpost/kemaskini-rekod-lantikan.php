<?php
/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblrscoadminpost */

//$this->title = 'Update Tblrscoadminpost: ' . $model->id;
$this->title = 'Kemaskini Rekod #' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Tblrscoadminposts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 " > 
<div class="x_panel">
    <div class="x_title">
        <h2><strong>Kemaskini Rekod Lantikan</strong></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
    <?= $this->render('_form', [
        'model' => $model,
        'job_group' => $job_group,
         'biodata' => $biodata
    ]) ?>
    </div>
</div>
</div>
</div>
