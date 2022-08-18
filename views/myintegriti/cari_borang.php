<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\myintegriti\TblBhgnA;
use app\models\myintegriti\MyintegritiViewSkorBahagianA;
use kartik\date\DatePicker;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?= $this->render('_topmenu') ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Cari Borang</h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['action' => ['carian-borang'], 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?>
                
                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">Nama
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'CONm')->textInput(['id' => 'nama_pyd'])->label(false);
                        ?>
                    </div>
                </div>
               
                <div class="form-group jspiu">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai">Senarai JSPIU</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($searchModel, 'dept_id')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC])->all(), 'id', 'shortname'),
                                'options' => [
                                    'placeholder' => 'Pilih Jabatan', 
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    //'selected'    => 2,
                                    'id' => 'senarai',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
            
                <div class="form-group tarikh">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikh">Tarikh</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?=
                            $form->field($searchModel, 'created_dt')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Pilih Tarikh'],
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true,
                                ]
                            ])->label(false);
                        ?>
                    </div>
                </div>
            
                <div class="ln_solid"></div>
            
                <div class="form-group">
                    <div class="pull-right">
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div></div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Hasil Carian Borang</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <?=
                GridView::widget([
                    //'tableOptions' => [
                      //  'class' => 'table table-striped jambo_table',
                    //],
                    'emptyText' => 'Tiada Rekod',
                    'summary' => '',
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'BIL',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        [
                            'label' => 'NAMA',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                return Html::a('<strong>'.$model->biodata->CONm.'</strong>', ['result', 'id' => $model->id]).'<br><small>'.$model->department->fullname.'</small>'.
                                        '<br><small>'.$model->jawatan->nama.' '.$model->jawatan->gred;
                            }, 
                                    'format' => 'html',
                        ],
                        [
                            'label' => 'JSPIU',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                return $model->department->shortname;
                            },
                        ],
                        [
                            'label' => 'TARIKH / MASA',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'attribute' => 'created_dt'
                        ],            
                        [
                            'label' => 'TAHUN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'attribute' => 'tahun'
                        ],
						[
                            'label' => 'SKOR',
                            'headerOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                return '<ul>
                            <li>Amanah : '.$model->amanah.'</li>
                            <li>Bijaksana : '.$model->bijaksana.'</li>
                            <li>Hemah : '.$model->hemah.'</li>
                            <li>Indeks Integriti : '.$model->indeks_integriti.'%</li>
                            <li>Social Desirability : '.$model->social_desirability.'</li>
                            </ul>';
                            },
                                    'format' => 'html',
                        ],
                    ],
                ]);
            ?>
            </div>
            
            </div> 
    </div></div>
    </div>
