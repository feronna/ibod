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
<div class="row">
<div class="col-md-12">
    <?php echo $this->render('/sejarah-penempatan/_topmenu'); ?> 
</div>
</div>
<div class="x_title">
    <h2>Carian</h2>
    <div class="clearfix"></div>
</div>

<?php $form = ActiveForm::begin([
    'action' => ['halaman-utama'],
    'method' => 'get',
'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]
]); ?>

<div class="form-group ">
    <div class="form-group">
        <div class=" col-md-4 col-sm-4 col-xs-12">
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
        <div class=" col-md-4 col-sm-4 col-xs-12">
            <?=
                $form->field($carian, 'carian_programpengajaran')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(ProgramPengajaran::find()->all(), 'id', 'NamaProgram'),
                    'options' => ['placeholder' => 'Program Pengajaran', 'class' => 'form-control col-md-2 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
        </div>
        <div class=" col-md-4 col-sm-4 col-xs-12">
            <?=
                $form->field($carian, 'carian_kodprogram')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(ProgramPengajaran::find()->groupBy('KodProgram')->all(), 'KodProgram', 'KodProgram'),
                    'options' => ['placeholder' => 'Kod Program', 'class' => 'form-control col-md-2 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
        </div>

    </div>



    <div class="form-group">
    <div class=" col-md-3 col-sm-3 col-xs-12">
            <?=
                $form->field($carian, 'campus_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Kampus::find()->all(), 'campus_id', 'campus_name'),
                    'options' => ['placeholder' => 'Kampus', 'class' => 'form-control col-md-2 col-xs-12'],
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
                $form->field($carian, 'statLantikan')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm'),
                    'options' => ['placeholder' => 'Status Lantikan', 'class' => 'form-control col-md-4 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <?=
                $form->field($carian, 'HighestEduLevelCd')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(PendidikanTertinggi::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                    'options' => ['placeholder' => 'Pendidikan Tertinggi', 'class' => 'form-control col-md-4 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
        </div>

    </div>


    <div class="form-group align-center">
        <div class="col-md-4 col-sm-4 col-xs-12">
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
        <div class=" col-md-2 col-sm-2 col-xs-12">
            <?=
                $form->field($carian, 'jenis_carian')->label(false)->widget(Select2::classname(), [
                    'data' => ["0" => "Nama", "1" => "IC", "2" => "UMSPER"],
                    'options' => ['placeholder' => 'Jenis Carian', 'class' => 'form-control col-md-2 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
        </div>

        <div class=" col-md-5 col-sm-5 col-xs-12">
            <?= $form->field($carian, 'carian_data')->textInput(['placeholder' => 'Nama / Nombor IC / ID', 'autofocus' => 'autofocus', ])->label(false) ?>
        </div>
        <div class=" col-md-1 col-sm-1 col-xs-12">
            <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary',]) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>