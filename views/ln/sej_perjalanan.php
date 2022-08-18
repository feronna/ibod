<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use kartik\grid\GridView;
use kartik\select2\Select2; 
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;  
use kartik\date\DatePicker;
error_reporting(0);
?>
 
<?php echo $this->render('/ln/_topmenu'); ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>

<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Tambah Sejarah Perjalanan LN1</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama<span class="required" style="color:red;"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

            <?= $form->field($model, 'icno')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => 'Nama'],
                            ])->label(false);                                 
            ?>
 
            </div>
        </div>
 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Pergi<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'date_from')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Balik<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'date_to')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Lawatan<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'nama_lawatan')->textInput(['maxlength' => true]) ->label(false);?> 
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tujuan<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tujuan')->textInput(['maxlength' => true]) ->label(false);?> 
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'nama_tempat')->textInput(['maxlength' => true]) ->label(false);?> 
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kod Peruntukan<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'kod_peruntukan_cn')->textInput(['maxlength' => true]) ->label(false);?> 
            </div>
        </div>
        <div class="ln_solid"></div>
 
        <div class="form-group" align="center">
                <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-3"> 
                    <br>
                 
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
        </div>
    </div>
    </div>
</div>
</div>

<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Sejarah Perjalanan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'showFooter' => true,
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        
                    'options' => [
                            'class' => 'table-responsive',
                                ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                        'header' => 'Bil',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'], 
                                            ],
                        [
                            'label' => 'Nama',
                            'value' => 'name',
                                                       
                        ],
                        // [
                        //     'label' => 'No.IC',
                        //     'value' => 'icno',
                            
                        // ],
                        [
                            'label' => 'Tarikh Perjalanan', 
                            'value' => function($dataProvider) { return $dataProvider->dateFrom  . " - " . $dataProvider->dateTo ;},

                            
                        ], 
                        [
                            'label' => 'Nama Lawatan',
                            'value' => 'nama_lawatan',
                        ],
                        [
                            'label' => 'Tempat',
                            'value' => 'nama_tempat',
                        ],
                        [
                            'label' => 'Kod Peruntukan',
                            'value' => 'kod_peruntukan_cn',
                        ],
                    //     [
                    //         'label' => 'Tindakan',
                    //         'format' => 'raw', 
                    //         'headerOptions' => ['class'=>'text-center'],
                    //         'contentOptions' => ['class'=>'text-center'], 
                    //         'value'=>function ($list){
                    //         return Html::a('', ['kemudahan/update-admin', 'id' => $list->id], [
                    //         'class' => 'btn btn-primary fa fa-edit',
                             
                    //     ])       
                    //         .Html::a('', ['delete', 'id' => $list->id], [
                    //         'class' => 'btn btn-danger fa fa-trash',
                    //         'data' => [
                    //             'confirm' => 'Are you sure you want to delete this item?',
                    //             'method' => 'post',
                    //         ],
                    //     ]);
                          
                        
                    //   },
                            
                    //     ],
                                   
                    ],
                           
                           
                ]); ?>
            </table>
        </div>
    </div>
</div>
</div>
 
 
 <?php ActiveForm::end(); ?>

