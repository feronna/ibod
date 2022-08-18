<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\db\Expression;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\ikalendar\RefHrCategories;
use app\models\ikalendar\RefHrGroups;
use app\models\ikalendar\TblHrStatus;
use kartik\widgets\DateTimePicker;
use yii\web\View;

$result = ArrayHelper::map($list, 'category_id', 'name', 'sub_of');

// return \yii\helpers\VarDumper::dump($result, $depth = 10, $highlight = true);

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
<?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Aktiviti</label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <?=
        $form->field($model, 'title')->textarea(['style' => 'resize: none;'])->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Peringkat</label>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <?=
        $form->field($model, 'rasmi')->label(false)->widget(Select2::classname(), [
            'data' => [
                '0' => 'Bahagian',
                '1' => 'Jabatan Pendaftar',
                '2' => 'Universiti',
            ],
            'hideSearch' => false,
            'options' => [
                'placeholder' => 'Carian Jabatan',
                'id' => 'peringkat'


            ],
            'hashVarLoadPosition' => View::POS_READY,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jabatan</label>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <?=
        $form->field($model, 'group_id')->label(false)->widget(Select2::classname(), [
            'data' => ArrayHelper::map(RefHrGroups::find()
                ->all(),  'group_id', 'name'),
            'hideSearch' => false,
            'options' => [
                'placeholder' => 'Carian Jabatan',
                'id' => 'jabatan'


            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Aktiviti Bahagian/Seksyen</label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <?=
        $form->field($model, 'category_id')->label(false)->widget(Select2::classname(), [
            'data' => $result,
            'hideSearch' => false,
            'options' => [
                'placeholder' => 'Carian Aktiviti Bahagian/Seksyen',
                'id' => 'bahagian'


            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat</label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <?=
        $form->field($model, 'venue')->textInput([])->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Dihubungi</label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <?=
        $form->field($model, 'contact')->textInput([])->label(false);
        ?>
    </div>
</div>

<hr style="border-top: dotted 1px;" />

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Start DateTime</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?=
        $form->field($date, 'date')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Pilih tarikh dan masa'],
            'pluginOptions' => [
                'autoclose' => true
            ]
        ])->label(false);

        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">End DateTime</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?=
        $form->field($date, 'end_date')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Pilih tarikh dan masa'],
            'pluginOptions' => [
                'autoclose' => true
            ]
        ])->label(false);

        ?>
    </div>
</div>

<hr style="border-top: dotted 1px;" />

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Terkini</label>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <?=
        $form->field($model, 'status')->label(false)->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TblHrStatus::find()
                ->all(),  'stats_id', 'name'),
            'hideSearch' => false,
            'options' => [
                'placeholder' => 'Carian Aktiviti Bahagian/Seksyen',
                'id' => 'status'


            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Selesai/Tunda <span class="required" style="color:red;">*</span></label>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <?=
        DatePicker::widget([
            'model' => $model,
            'attribute' => 'tarikh_tunda',

            'type' => DatePicker::TYPE_INPUT,
            'options' => ['placeholder' => 'Tarikh Selesai/Tunda'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan Tambahan
        (Jika Berkaitan)</label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <?=
        $form->field($model, 'description')->textarea(['style' => 'resize: none;'])->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <div class="col-md-push-3 col-sm-6 col-xs-12">
        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?php yii\widgets\Pjax::end() ?>
<br />