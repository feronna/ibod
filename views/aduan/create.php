<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\aduan\RptTblAduan */

$this->title = Yii::t('app', 'Borang Aduan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Senarai Aduan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('/aduan/_topmenu');
echo $this->render('/aduan/contact');
?>

<div class="rpt-tbl-aduan-create">
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
                    'status' => 1 //create new aduan

                ]) ?>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>