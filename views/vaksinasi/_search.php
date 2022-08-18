<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\ServiceStatus;
use app\models\hronline\StatusLantikan;
use app\models\hronline\ProgramPengajaran;
use app\models\hronline\Kampus;
?>

<div class="x_title">
    <h2>Carian</h2>
    <div class="clearfix"></div>
</div>
<?php $form = ActiveForm::begin([
    'action' => ['vaksinasi-list'],
    'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]
]); ?>
<div class="form-group ">

    <div class="form-group">
        <div class="form-group align-center">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <?=
                $form->field($carian, 'program_vaksinasi')->label(false)->widget(Select2::classname(), [
                    'data' => ["1"=>"Sudah Isi", "2"=>"Belum Isi"],
                    'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-4 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class=" col-md-2 col-sm-2 col-xs-12">
                <?=
                $form->field($carian, 'jenis_carian')->label(false)->widget(Select2::classname(), [
                    'data' => ["0" => "IC", "1" => "Nama", "2" => "UMSPER"],
                    'options' => ['placeholder' => 'Jenis Carian', 'class' => 'form-control col-md-2 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>

            <div class=" col-md-5 col-sm-5 col-xs-12">
                <?= $form->field($carian, 'carian_data')->textInput(['placeholder' => 'Nama / Nombor IC / ID', 'autofocus' => 'autofocus',])->label(false) ?>
            </div>
            <div class=" col-md-1 col-sm-1 col-xs-12">
                <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary',]) ?>
            </div>
        </div>
    </div>
</div>
    <?php ActiveForm::end(); ?>