<?php

use app\models\allocation\TblProfiles;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\ServiceStatus;
use app\models\hronline\StatusLantikan;
use app\models\hronline\StatusWarganegara;

?>
<?php $form = ActiveForm::begin([
    'action' => ['data-list'],
    'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]
]); ?>
<div class="form-group ">


    <div class="col-md-8 col-sm-8 col-xs-12">
        <?= $form->field($carian, 'CONm')->label(false)->textInput(['placeholder' => 'Nama']); ?>
    </div>

    <div class=" col-md-2 col-lg-2 col-xs-12 col-sm-12">
        <?=
        $form->field($carian, 'carian_kategorijawatan')->label(false)->widget(Select2::classname(), [
            'data' => ["1" => "Akademik", "2" => "Pentadbiran"],
            'options' => ['placeholder' => 'Kategori Jawatan', 'class' => 'form-control col-md-2 col-xs-12'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-12">
        <?=
        $form->field($carian, 'DeptId')->label(false)->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
            'options' => ['placeholder' => 'JFPIU', 'class' => 'form-control col-md-4 col-xs-12'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12">
        <?=
        $form->field($carian, 'NatStatusCd')->label(false)->widget(Select2::classname(), [
            'data' => ArrayHelper::map(StatusWarganegara::find()->all(), 'NatStatusCd', 'NatStatus'),
            'options' => ['placeholder' => 'Status Warganegara', 'class' => 'form-control col-md-4 col-xs-12'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>

    <div class=" col-md-2 col-lg-2 col-xs-12 col-sm-12">
        <?=
        $form->field($carian, 'Status')->label(false)->widget(Select2::classname(), [
            'data' => ArrayHelper::map(ServiceStatus::find()->all(), 'ServStatusCd', 'ServStatusNm'),
            'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-4 col-xs-12'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>

    <div class=" col-md-3 col-lg-3 col-xs-12 col-sm-12">
        <?=
        $form->field($carian, 'statLantikan')->label(false)->widget(Select2::classname(), [
            'data' => ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm'),
            'options' => ['placeholder' => 'Status Lantikan', 'class' => 'form-control col-md-4 col-xs-12'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>

    <div class=" col-md-2 col-lg-2 col-xs-12 col-sm-12">
        <?=
        $form->field($carian, 'carian_jenis_lantikan')->label(false)->widget(Select2::classname(), [
            'data' => ["UMS" => "UMS", "HUMS" => "HUMS"],
            'options' => ['placeholder' => 'Jenis Lantikan', 'class' => 'form-control col-md-2 col-xs-12'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
    <div class=" col-md-2 col-lg-2 col-xs-12 col-sm-12">
        <?=
        $form->field($carian, 'carian_sumber_peruntukan')->label(false)->widget(Select2::classname(), [
            'data' => TblProfiles::arrSumberPeruntukan(),
            'options' => ['placeholder' => 'Sumber Peruntukan', 'class' => 'form-control col-md-2 col-xs-12'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
    <div class=" col-md-2 col-lg-2 col-xs-12 col-sm-12">
        <?=
        $form->field($carian, 'carian_status_kontrak')->label(false)->widget(Select2::classname(), [
            'data' => TblProfiles::arrStatusKontrak(),
            'options' => ['placeholder' => 'Status Kontrak', 'class' => 'form-control col-md-2 col-xs-12'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>


    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
        <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary',]) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>