<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use app\models\elnpt\GredJawatan;
use app\models\elnpt\RefKumpGred;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= $this->render('_menuAdmin'); ?>

<?php
    Modal::begin([
        'header' => 'Tamabah / Kemaskini Rubrik Gred',
        //'id' => 'modal',
        'size' => 'modal-md',
        'options' => [
            'id' => 'modal',
            'tabindex' => false // important for Select2 to work properly
        ],
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Carian Rubrik Gred</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">KATEGORI</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'ref_kump_gred_id')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(RefKumpGred::find()
                                    ->all(), 'id', 'kump_gred'),
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian ...', 
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">GRED JAWATAN</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'gred_id')->label(false)->widget(Select2::classname(), [
                                'data' =>  ArrayHelper::map(GredJawatan::find()
                                    //->leftJoin(['a' => 'hrm.elnpt_tbl_kump_dept'], 'a.dept_id = `hronline`.department.id')
                                    //->where(['a.dept_id' => null])
                                    ->all(), 'id', 'fname'),
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian ...', 
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
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Gred Jawatan</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <p>
                <?php $form = ActiveForm::begin([]); ?>
                <?= Html::button('Tambah Gred Jawatan', [
                    'value' => Url::to(['elnpt/tambah-rubrik-gred']),
                    'class' => 'btn btn-success modalButton']); ?>
                <?php ActiveForm::end(); ?>
            </p>
            
            <?php
//                Modal::begin([
//                    'header' => 'Reset Borang',
//                    'id' => 'modal',
//                    'size' => 'modal-md',
//                ]);
//                echo "<div id='modalContent'></div>";
//                Modal::end();
            ?>
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
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                ],
//                                [
//                                    'label' => 'NAMA GURU',
//                                    'headerOptions' => ['class'=>'text-center'],
//                                    'value' => function($model) {
//                                        return $model->guru->CONm.'<br>';
//                                    },
//                                    'format' => 'html',
//                                ],
                                [
                                    'label' => 'KATEGORI',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return strtoupper($model->namaKumpGred->kump_gred);
                                        
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'GRED JAWATAN',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->gred) ? null : $model->gred->fname;
                                        
                                    },
                                    'format' => 'html',
                                ],            
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'TINDAKAN',
                                    'headerOptions' => ['class'=>'text-center col-md-2'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'template' => '{update} {delete}',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            $url1 = Url::to(['elnpt/kemaskini-rubrik-gred', 'id' => $model->id]);
                                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url1, 'class' => 'btn btn-default btn-sm modalButton']);
                                        },
                                        'delete' => function ($url, $model) {
                                            $url2 = Url::to(['elnpt/padam-rubrik-gred', 'id' => $model->id]);
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url2, ['class' => 'btn btn-default btn-sm']);
                                            //Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value' => $url2, 'class' => 'btn btn-default btn-sm']);
                                        },       
                                    ],        
                                ],           
                            ],
                        ]);
                    ?>
                </div>
        </div>
    </div>
    </div>
</div>       