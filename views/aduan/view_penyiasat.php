<?php

use yii\helpers\Html;
use app\models\hronline\Tblprcobiodata;

/* @var $this yii\web\View */
/* @var $model app\models\aduan\RptTblAduan */

$this->title = Yii::t('app', 'Borang Aduan: BKUMS{name}', [
    'name' => $model->aduan_id,
]);
$subtitle = Yii::t('app', 'Penerima Aduan');
$subtitle2 = Yii::t('app', 'Senarai Penyiasat');
$subtitle3 = Yii::t('app', 'Laporan Kes : BKUMS{name}', [
    'name' => $model->aduan_id,
]);
$subtitle4 = Yii::t('app', 'Semakan Pegawai');

echo $this->render('/aduan/_topmenu');
echo $this->render('/aduan/contact');
?>

<div class="rpt-tbl-aduan-update">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h2><?= Html::encode($this->title) ?></h1>
                </div>
                </br>
                <?= $this->render('_form_admin', [
                    'model' => $model,
                    'modelBio' => Tblprcobiodata::find()->where(['ICNO' => $model->staff_icno])->one(),
                    'status' => 2 //UPDATE

                ]) ?>
            </div>
        </div>
    </div>
</div>

<div class="rpt-tbl-aduan-update">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h2><?= Html::encode($subtitle) ?></h2>
                </div>
                </br>
                <?= $this->render('_form_penerima', [
                    'model' => $model,
                    'modelPenerima' => $modelPenerima,
                    'modelUnit' => $modelUnit,
                    'status' => 2 //UPDATE

                ]) ?>
            </div>
        </div>
    </div>
</div>

<div class="rpt-tbl-aduan-update">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h2><?= Html::encode($subtitle4) ?></h2>
                </div>
                </br>
                <?= $this->render('_form_pegawai', [
                    'model' => $model,
                    'modelPegawai' => $modelPegawai,
                    'modelUnit' => $modelUnitPeg,
                    'status' => 2 //UPDATE

                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php if ($model->aduan_status != 1 || $model->aduan_status != 4) { ?>
<div class="rpt-tbl-aduan-update">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h2><?= Html::encode($subtitle2) ?></h2>
                </div>
                </br>
                <?= $this->render('_form_penyiasat', [
                    'model' => $model,
                    'modelPenerima' => $modelPenerima,
                    'modelUnit' => $modelUnit,
                    'status' => 2, //UPDATE
                    'allStaf' => $allStaf,
                    'penyiasat' => $penyiasat,
                    'userStatus' => 'chief'

                ]) ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<div class="rpt-tbl-aduan-update">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h2><?= Html::encode($subtitle3) ?></h2>
                </div>
                </br>
                <?= $this->render('_form_laporan', [
                    'model' => $model,
                    'modelPenerima' => $modelPenerima,
                    'modelUnit' => $modelUnit,
                    'modelBio' => $modelBio,
                    'status' => 2, //UPDATE
                    'allStaf' => $allStaf,
                    'penyiasat' => $penyiasat,
                    'userStatus' => 'chief'

                ]) ?>
            </div>
        </div>
    </div>
</div>