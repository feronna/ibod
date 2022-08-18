<?php

//$js=<<<js
//    $('.modalButton').on('click', function () {
//        $('#modal').modal('show')
//                .find('#modalContent')
//                .load($(this).attr('value'));
//    });
//js;
//$this->registerJs($js);

use app\models\hronline\Department;
use app\models\lppums\TblLppTahun;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= ($this->context->action->id != 'penetap-pantau-pergerakan-borang') ? $this->render('_menuAdmin') : $this->render('_menuUtama'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Carian Borang</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'CONm')->textInput([
                                'placeholder' => 'Cari Nama',
                                ])->label(false);
                        ?>
                    </div>
                </div>
            
                <?php if ($this->context->action->id != 'penetap-pantau-pergerakan-borang') { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">J/F/P/I/U</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'jspiu')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Department::find()
//                                        ->innerJoin(['a' => 'elnpt.tbl_kump_dept'], 'a.dept_id = `hronline`.department.id')
                                        ->orderBy(['fullname' => SORT_ASC,])
                                        ->all(), 'id', 'fullname'),
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Cari JFPIU', 
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
                <?php } ?>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pengesahan PYD</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'PYD_sah')->widget(SwitchInput::classname(), [
                                    'pluginOptions'=>[
//        'handleWidth'=>60,
        'onText'=>'Sudah',
        'offText'=>'Belum'
    ]
                            ])->label(false);
                        ?>
                    </div>
                </div>
            
            <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pengesahan PPP</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'PPP_sah')->widget(SwitchInput::classname(), [
                                'pluginOptions'=>[
//        'handleWidth'=>60,
        'onText'=>'Sudah',
        'offText'=>'Belum'
    ]
                            ])->label(false);
                        ?>
                    </div>
                </div>
            
            <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pengesahan PPK</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'PPK_sah')->widget(SwitchInput::classname(), [
                                'pluginOptions'=>[
//        'handleWidth'=>60,
        'onText'=>'Sudah',
        'offText'=>'Belum'
    ]
                            ])->label(false);
                        ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_ASC,])->all(), 'lpp_tahun', 'lpp_tahun'),
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Pilih Tahun', 
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
            <h2><strong>Pantau Pergerakan Borang</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
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
//                            'pager' => [
//                                'class' => \kop\y2sp\ScrollPager::className(),
//                                'container' => '.grid-view tbody',
//                                'triggerOffset' => 10,
//                                'item' => 'tr',
//                                'paginationSelector' => '.grid-view .pagination',
//                                'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
//                             ],
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
                                    'label' => 'NAMA GURU',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return Html::a('<strong>'.$model->pyd->CONm.'</strong>', Url::to(['lppums/bahagian1', 'lpp_id' => $model->lpp_id]))
                                                .'<br>PPP : <small>'.(is_null($model->ppp) ? '<span class="label label-warning">Belum Set</span>' : $model->ppp->CONm).'</small>'
                                                .'<br>PPK : <small>'.(is_null($model->ppk) ? '<span class="label label-warning">Belum Set</span>' : $model->ppk->CONm).'</small>'
                                                ;
                                        
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'JFPIU',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center col-md-1'],
                                    'value' => function($model) {
                                        return $model->pyd->department->shortname;
                                        
                                    },
                                    'format' => 'html',
                                ],            
                                [
                                    'label' => 'PYD',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return ($model->PYD_sah == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green"></span>' :
                                                '<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red"></span>';
                                    },
                                    //'attribute' => 'tahun',
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PPP',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return ($model->PPP_sah == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green"></span>' :
                                                '<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red"></span>';
                                    },
                                    //'attribute' => 'tahun',
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PPK',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return ($model->PPK_sah == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green"></span>' :
                                                '<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red"></span>';
                                    },
                                    //'attribute' => 'tahun',
                                    'format' => 'html',
                                ],            
                                [
                                        'label' => 'STATUS PENILAIAN',
                                        'headerOptions' => ['class'=>'text-center col-md-1'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return ($model->PPP_sah == 1 && $model->PPK_sah == 1 && $model->PYD_sah == 1)
                                        ? '<span class="label label-success">Sudah selesai</span>' : '<span class="label label-warning">Belum selesai</span>';
                                        },
                                        //'attribute' => 'tahun',
                                        'format' => 'html',
                                ],            
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'PERINGATAN',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'template' => '{reset}',
                                    'buttons' => [
                                        'reset' => function ($url, $model) {
                                            $url = Url::to(['lppums/notify-all', 'lppid' => $model->lpp_id]);
                                            return Html::button('<span class="glyphicon glyphicon-bell"></span>', 
                                                    [
                                                        'class' => 'btn btn-default btn-sm',
                                                        'onclick' => "
                                                                $.ajax({
                                                                    type: 'POST',
                                                                    url: '".$url."',
                                                                     
                                                                    success: function(result) {
                                                                        if(result == 1) {
                                                                             setTimeout(function(){
                                                                                location.reload(); // then reload the page.(3)
                                                                           }, 1); 
                                                                        } else {
                                                                        }
                                                                    }, 
                                                                    error: function(result) {
                                                                        console.log(\"Ada Error\");
                                                                    }
                                                                });
                                                            "
                                                        
                                                        ]);

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