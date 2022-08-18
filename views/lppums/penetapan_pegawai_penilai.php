<?php

/*$js=<<<js
    
    $(document).ready(function(){
        $("input[type='button']").click(function(){

            var radioValue = $("input[name='gender']:checked").val();

            if(radioValue){

                alert("Your are a - " + radioValue);

            }

        });
    });
        
js;
$this->registerJs($js);*/

use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use yii\db\Expression;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\akademik\RefUbkBhg2 */
/* @var $form ActiveForm */
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h5><strong>Penetapan Pegawai Penilai bagi PYD (<?= $lpp->pyd->CONm; ?>) Tahun Penilaian <?= $lpp->tahun; ?></strong></h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                <div class="row">
                    <div class="table-responsive">
                        
                        <?=
                            DetailView::widget([
                                'model' => $lpp,
                                'attributes' => [
                                    [                                                  // the owner name of the model
                                        'label' => 'PEGAWAI YANG DINILAI (PYD)',
                                        'value' => function($model) {
                                            return '<strong>'.$model->pyd->CONm.'</strong><br>'.$model->pyd->ICNO.'<br><br>'
                                                    .$model->pyd->jawatan->nama.' '.$model->pyd->jawatan->gred.'<br>'.$model->pyd->department->fullname;
                                        },
                                        'format' => 'html',
                                                'captionOptions' => ['style' => 'width:25%'],
                                    ],
                                    [                                                  // the owner name of the model
                                        'label' => 'PEGAWAI PENILAI PERTAMA (PPP)',
                                        'value' => function($model) use ($lppid, $form) {
                                            if(is_null($model->ppAll)) {
                                                if(!is_null($model->ppp)) {
                                                    return '<strong>'.$model->ppp->CONm.'</strong> '.
                                                            Html::a('<span style="color:red" class="glyphicon glyphicon-minus-sign"></span>', 
                                                            (Url::to(['lppums/gugur-ppp', 'lppid' => $lppid])), [
                                                        'title' => 'Buang',
                                                    ]).'<br>'.$model->ppp->ICNO.'<br><br>'
                                                        .$model->ppp->jawatan->nama.' '.$model->ppp->jawatan->gred.'<br>'.$model->ppp->department->fullname;
                                                }else{
                                                    return $form->field($model, 'PPP')->label(false)->widget(Select2::classname(), [
                                                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                                                ->select(new Expression('`hronline`.`tblprcobiodata`.`ICNO` as ICNO, CONCAT(`hronline`.`tblprcobiodata`.`CONm` , \' - \' , `a`.`fname`) as CONm'))
                                                                ->leftJoin(['a' => '`hronline`.`gredjawatan`'], '`a`.`id` = `hronline`.`tblprcobiodata`.`gredJawatan`')
                                                                ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                                                        'options' => [
                                                            'placeholder' => 'Pilih Pegawai', 
                                                            'class' => 'form-control col-md-7 col-xs-12',
                                                            //'selected'    => 2,
                                                            'id' => 'ppp_',
                                                            ],
                                                        'pluginOptions' => [
                                                            //'allowClear' => true
                                                        ],
                                                    ]);
                                                }
                                            }else{
                                                return '<i> <font color="green">Set Sebagai PP</font> </i>';
                                            }
                                        },
                                        'format' => 'raw',
                                        'captionOptions' => ['style' => 'width:25%'],
                                    ],
                                    [                                                  // the owner name of the model
                                        'label' => 'PEGAWAI PENILAI KEDUA (PPK)',
                                        'value' => function($model) use ($lppid, $form) {
                                            if(is_null($model->ppAll)) {
                                                if(!is_null($model->ppk)) {
                                                    return '<strong>'.$model->ppk->CONm.'</strong> '.
                                                            Html::a('<span style="color:red" class="glyphicon glyphicon-minus-sign"></span>', 
                                                            (Url::to(['lppums/gugur-ppk', 'lppid' => $lppid])), [
                                                        'title' => 'Buang',
                                                    ]).'<br>'.$model->ppk->ICNO.'<br><br>'
                                                        .$model->ppk->jawatan->nama.' '.$model->ppk->jawatan->gred.'<br>'.$model->ppk->department->fullname;
                                                }else{
                                                    return $form->field($model, 'PPK')->label(false)->widget(Select2::classname(), [
                                                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                                                ->select(new Expression('`hronline`.`tblprcobiodata`.`ICNO` as ICNO, CONCAT(`hronline`.`tblprcobiodata`.`CONm` , \' - \' , `a`.`fname`) as CONm'))
                                                                ->leftJoin(['a' => '`hronline`.`gredjawatan`'], '`a`.`id` = `hronline`.`tblprcobiodata`.`gredJawatan`')
                                                                ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                                                        'options' => [
                                                            'placeholder' => 'Pilih Pegawai', 
                                                            'class' => 'form-control col-md-7 col-xs-12',
                                                            //'selected'    => 2,
                                                            'id' => 'ppk_',
                                                            ],
                                                        'pluginOptions' => [
                                                            //'allowClear' => true
                                                        ],
                                                    ]);
                                                }
                                            }else {
                                                return '<i> <font color="green">Set Sebagai PP</font> </i>';
                                            }
                                        },
                                        'format' => 'raw',
                                                'captionOptions' => ['style' => 'width:25%'],
                                    ],
                                    [                                                  // the owner name of the model
                                        'label' => 'PEGAWAI PENILAI KESELURUHAN (PP)',
                                        'value' => function($model)  use ($lppid, $form) {
                                            if(!is_null($model->ppAll)) {
                                                return '<strong>'.$model->ppAll->CONm.'</strong> '.
                                                        Html::a('<span style="color:red" class="glyphicon glyphicon-minus-sign"></span>', 
                                                        (Url::to(['lppums/gugur-pp', 'lppid' => $lppid])), [
                                                    'title' => 'Buang',
                                                ]).'<br>'.$model->ppAll->ICNO.'<br><br>'
                                                    .$model->ppAll->jawatan->nama.' '.$model->ppAll->jawatan->gred.'<br>'.$model->ppAll->department->fullname;
                                            }else{
                                                return $form->field($model, 'PP_ALL')->label(false)->widget(Select2::classname(), [
                                                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                                            ->select(new Expression('`hronline`.`tblprcobiodata`.`ICNO` as ICNO, CONCAT(`hronline`.`tblprcobiodata`.`CONm` , \' - \' , `a`.`fname`) as CONm'))
                                                            ->leftJoin(['a' => '`hronline`.`gredjawatan`'], '`a`.`id` = `hronline`.`tblprcobiodata`.`gredJawatan`')
                                                            ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                                                    'options' => [
                                                        'placeholder' => 'Pilih Pegawai', 
                                                        'class' => 'form-control col-md-7 col-xs-12',
                                                        //'selected'    => 2,
                                                        'id' => 'pp_',
                                                        ],
                                                    'pluginOptions' => [
                                                        //'allowClear' => true
                                                    ],
                                                ]);
                                            }                              
                                        },
                                        'format' => 'raw',
                                                'captionOptions' => ['style' => 'width:25%'],
                                    ],
                                    [                                                  // the owner name of the model
                                        'label' => 'CATATAN',
                                        'value' => function($model) use ($lppid, $form) {
                                            return $form->field($model, 'catatan')->textarea(['maxlength' => 255, 'style' => 
                            'overflow:auto;resize:none'])->label(false);
                                        },
                                        'format' => 'raw',
                                                'captionOptions' => ['style' => 'width:25%'],
                                    ],            
                                ],
                            ]);
                        ?>    
                
                    </div>
                </div>
                <div class="form-group pull-right">
                    <div class="">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                <?php yii\widgets\Pjax::end() ?> 
            </div>
        </div>
    </div>
</div>