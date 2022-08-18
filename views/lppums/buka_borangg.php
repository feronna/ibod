<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\lnpt\RefAkses;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\widgets\DateTimePicker;
use app\models\hronline\Tblprcobiodata;
use yii\db\Expression;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
<?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                    
                    <div class="form-group"> 
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">ID BORANG</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($model, 'lpp_id')->textInput()->label(false);
                        ?>
                        </div>
                    </div>
                    
                    <div class="form-group"> 
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA PEMOHON</label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                       <?=
                                $form->field($model, 'ICNO')->label(false)->widget(Select2::classname(), [
                                    'data' =>  ArrayHelper::map(Tblprcobiodata::find()
                                             ->select(new Expression('CONCAT(CONm, \' - \', ICNO) as CONm, ICNO'))
//                                        ->innerJoin(['a' => 'elnpt.tbl_kump_dept'], 'a.dept_id = `hronline`.department.id')
                                        ->orderBy(['CONm' => SORT_ASC,])
                                        ->all(), 'ICNO', 'CONm'),
//                                    'hideSearch' => true,
                                    'options' => ['placeholder' => 'Carian Nama', 
                                        'class' => 'form-control col-md-7 col-xs-12',
//                                        'id' => 'jenis_carian',
                                        ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                            ?>

                        </div>
                    </div>
                    
                    <div class="form-group"> 
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">DATE CLOSE</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($model, 'close_date')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Pilih tarikh',
                                'autocomplete' => 'off'
                                ],
                            'pluginOptions' => [
                                    'autoclose' => true
                            ]
                        ])->label(false);

                        ?>
                        </div>
                    </div>
                    
                    <div class="pull-right">
                       
                        <?= Html::submitButton($model->isNewRecord ? 'Buka' : 'Kemaskini', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <?php yii\widgets\Pjax::end() ?>
                </div>
            </div> 
        </div>   
    </div>    
</div>