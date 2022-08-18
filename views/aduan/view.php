<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\aduan\RptTblAduan */

$this->title = Yii::t('app', 'Borang Aduan: BKUMS{name}', [
    'name' => $model->aduan_id,
]);
$subtitle = Yii::t('app', 'Status Aduan');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Senarai Aduan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->aduan_id, 'url' => ['view', 'id' => $model->aduan_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Kemaskini');

echo $this->render('/aduan/_topmenu');
echo $this->render('/aduan/contact');
?>

<div class="rpt-tbl-aduan-update">
    <!-- <div class="container-fluid"> -->
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <!-- <div class="x_panel">
                <div class="x_title">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <div class="clearfix"></div>
                </div> -->
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h2><?= Html::encode($this->title) ?></h2>
                </div>
                </br>

                <?= $this->render('_form', [
                    'model' => $model,
                    'modelBio' => $modelBio,
                    'status' => 2 //view each aduan

                ]) ?>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>

<?php if ($model->penerima_date != NULL) { ?>
<div class="rpt-tbl-aduan-update">
    <!-- <div class="container-fluid"> -->
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h2><?= $subtitle ?></h2>
                </div>
                </br>

                <?= $this->render('_form_status', [
                    'model' => $model,
                    'modelBio' => $modelBio,
                    'status' => 2 //view each aduan

                ]) ?>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>
<?php }
