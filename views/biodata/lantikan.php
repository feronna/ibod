<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use app\models\hronline\Department;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\ServiceStatus;
use app\models\hronline\SenaraiLantikan;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblprcobiodataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekod Peribadi';
?>
<div class="tblprcobiodata-form" >

    <div class="x_panel" style="color:black;">
        <div class="x_title">
            <h2>Note:</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
                <h4>Sila pastikan anda memilih jenis lantikan yang betul. Terima kasih.</h4>

        </div>
    </div>
</div>

<div class="tblprcobiodata-form">
     <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="x_panel" style="color:black;">
        <div class="x_title">
            <h2>Lantikan</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jabatan"><span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'jenislantikan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(SenaraiLantikan::find()->where(['IN','id',$idlist])->all(), 'id', 'lantikanNm'),
                        //'data' => ArrayHelper::map(SenaraiLantikan::find()->all(), 'id', 'lantikanNm'),
                        'options' => ['placeholder' => 'Pilih Jenis Lantikan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
                     
        </div>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton('Seterusnya', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>