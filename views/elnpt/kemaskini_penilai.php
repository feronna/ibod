<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\widgets\SwitchInput;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

use app\models\elnpt\Tblprcobiodata;
use app\models\elnpt\Department;

$tmp = ArrayHelper::map(Tblprcobiodata::find()
    ->select(['hronline.tblprcobiodata.ICNO as ICNO, CONCAT(hronline.tblprcobiodata.CONm, \' - \',  e.`gred`) as CONm'])
    //->leftJoin(['a' => '`hrm`.`elnpt_tbl_main`'], '`hronline`.`tblprcobiodata`.ICNO = `a`.PYD and `a`.tahun = '.date('y').'')
    ->rightJoin(['b' => '`hrm`.`elnpt_tbl_kump_dept`'], '`hronline`.`tblprcobiodata`.`DeptId` = b.`dept_id`')
    ->rightJoin(['c' => '`hrm`.`elnpt_tbl_kump_gred`'], '`hronline`.`tblprcobiodata`.`gredJawatan` = c.`gred_id`')
    ->leftJoin(['d' => '`hrm`.`elnpt_tbl_kump_rubrik`'], 'd.`kump_dept_id` = b.`id` and d.`kump_gred_id` = c.`id`')
    ->leftJoin(['e' => '`hronline`.`gredjawatan`'], 'e.`id` = `hronline`.`tblprcobiodata`.`gredJawatan`')
    // ->where(['`hronline`.`tblprcobiodata`.Status' => [1, 2, 3, 4, 5]])
    ->all(), 'ICNO', 'CONm');

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">

            <p><b><i class="fa fa-info-circle" aria-hidden="true"></i>
                    Untuk menetap PP Keseluruhan, sila set PPP dan PPK dengan orang yang sama.</b></p>

            <div class="panel-body">
                <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                <?= $form->errorSummary($model) ?>
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">PPP JFPIU</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'jspiu_PPP')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::find()
                                //                                    ->innerJoin(['a' => 'hrm.elnpt_tbl_kump_dept'], 'a.dept_id = `hronline`.department.id')
                                ->all(), 'id', 'fullname'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian JFPIU',
                                'id' => 'jspiu_PPP'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">PPP</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'PPP')->label(false)->widget(DepDrop::classname(), [
                            'type' => DepDrop::TYPE_SELECT2,
                            'data' => $tmp,
                            'options' => ['id' => 'subcat1-id', 'placeholder' => 'Pilih PPP'],
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                //'placeholder' => 'Pilih PPP',
                                'depends' => ['jspiu_PPP'],
                                'url' => Url::to(['/elnpt/icno-list']),
                                //                                'params' => ['input-type-1', 'input-type-2']
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">PPK JFPIU</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'jspiu_PPK')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::find()
                                //                                    ->innerJoin(['a' => 'hrm.elnpt_tbl_kump_dept'], 'a.dept_id = `hronline`.department.id')
                                ->all(), 'id', 'fullname'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian JFPIU',
                                'id' => 'jspiu_PPK'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">PPK</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'PPK')->label(false)->widget(DepDrop::classname(), [
                            'type' => DepDrop::TYPE_SELECT2,
                            'data' => $tmp,
                            'options' => ['id' => 'subcat2-id', 'placeholder' => 'Pilih PPK'],
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                //'placeholder' => 'Pilih PPP',
                                'depends' => ['jspiu_PPK'],
                                'url' => Url::to(['/elnpt/icno-list']),
                                //                                'params' => ['input-type-1', 'input-type-2']
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">PEER JFPIU</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'jspiu_PEER')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::find()
                                //                                    ->innerJoin(['a' => 'hrm.elnpt_tbl_kump_dept'], 'a.dept_id = `hronline`.department.id')
                                ->all(), 'id', 'fullname'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian JFPIU',
                                'id' => 'jspiu_PEER'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">PEER</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'PEER')->label(false)->widget(DepDrop::classname(), [
                            'type' => DepDrop::TYPE_SELECT2,
                            'data' => $tmp,
                            'options' => ['id' => 'subcat3-id', 'placeholder' => 'Pilih PEER'],
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                //'placeholder' => 'Pilih PPP',
                                'depends' => ['jspiu_PEER'],
                                'url' => Url::to(['/elnpt/icno-list']),
                                //                                'params' => ['input-type-1', 'input-type-2']
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Catatan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                        $form->field($model, 'catatan')->textarea(['maxlength' => 255, 'style' =>
                        'overflow:auto;resize:none'])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-push-4 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary', 'onClick' => '$("#ppp").val(null).trigger("change");'
                            . '$("#ppk").val(null).trigger("change");$("#peer").val(null).trigger("change");'
                            . '$("#subcat1-id").val(null).trigger("change");$("#subcat3-id").val(null).trigger("change");'
                            . '$("#subcat2-id").val(null).trigger("change");']) ?>
                        <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                <?php yii\widgets\Pjax::end() ?>
            </div>
        </div>
    </div>
</div>