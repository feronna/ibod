<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\grid\GridView;
?> 
<?php echo $this->render('menu'); ?> 
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php echo $this->render('menu_info_tugas'); ?> 
</div>

<div class="col-md-3 col-sm-12 col-xs-12"> 
    <?php echo $this->render('menu_services'); ?>   
</div>

<div class="col-md-9 col-sm-12 col-xs-12">
    <div class="x_panel"> 
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">PENGLIBATAN LUAR</p> 
            <div class="clearfix"></div>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
        <div class="x_content">    
            <?= $form->field($model, 'ICNO')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12"> 
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'date',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'required' => 'required', 'placeholder' => '....'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                        ]
                    ]);
                    ?>
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Peringkat: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12"> 
                    <?=
                    $form->field($model, 'level')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\cv\RefActivitiesOther::find()->all(), 'id', 'output'),
                        'options' => ['placeholder' => '....', 'multiple' => false],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>

                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Aktiviti lain: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12"> 
                    <?= $form->field($model, 'other')->textarea(['rows' => 3])->label(false); ?>
                </div>
            </div>   
            <div class="form-group text-center">
                <?= Html::submitButton($model->isNewRecord ? 'SIMPAN' : 'KEMASKINI', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?> 
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">REKOD</p> 
            <div class="clearfix"></div>
        </div> 
        <div class="table-responsive">
            
            <?=
            GridView::widget([
                'dataProvider' => $record,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Tarikh',
                        'value' => function ($record) {
                            return $record->date ? $record->date : ' ';
                        }, 
                                'contentOptions' => ['class' => 'text-center','width' => '100px'],
                    ],  
                                [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Peringkat',
                        'value' => function ($record) {
                            return $record->peringkat ? $record->peringkat->output : ' ';
                        }, 
                    ], 
                                [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Aktiviti lain',
                        'value' => function ($record) {
                            return $record->other ? $record->other : ' ';
                        }, 
                    ], 
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Tindakan',
                        'value' => function ($record) {
                            return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $record->id, 'title' => 'activities-other'], ['class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => 'Anda yakin ingin padam?',
                                            'method' => 'post',
                                ]]) . ' ' . Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-services', 'id' => $record->id, 'title' => 'activities-other'], ['class' => 'btn btn-default']);
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center','width' => '130px'],
                            ],
                        ],
                    ]);
                    ?>  
             
        </div>
    </div>
</div>
