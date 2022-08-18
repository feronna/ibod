<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
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
            <p style="font-size:15px;font-weight: bold;">INOVASI DALAM KERJA (Di gred jawatan semasa)</p> 
            <div class="clearfix"></div>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
        <div class="x_content">    
            <?= $form->field($model, 'ICNO')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12"> 
                    <?=
                    $form->field($model, 'year')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => '....'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy',
                            'minViewMode' => "years"
                        ]
                    ])->label(false);
                    ?> 

                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                    <?=
                    $form->field($model, 'dept_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Department::find()->all(), 'id', 'fullname'),
                        'options' => ['multiple' => false],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?> 
                </div>
            </div>  
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Unit/Seksyen/Bahagian: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                    <?= $form->field($model, 'unit')->textInput()->label(false); ?>
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Inovasi: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12"> 
                    <?= $form->field($model, 'innovation')->textarea(['rows' => 3])->label(false); ?>
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
                        'label' => 'Tahun',
                        'value' => function ($record) {
                            return $record->year ? $record->year : ' ';
                        }, 
                    ],  
                                [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'JSPIU',
                        'value' => function ($record) {
                            return $record->department ? $record->department->fullname : ' ';
                        }, 
                    ],
                                [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Unit/Seksyen/Bahagian',
                        'value' => function ($record) {
                            return $record->unit ? $record->unit : ' ';
                        }, 
                    ],
                                [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Inovasi',
                        'value' => function ($record) {
                            return $record->innovation ? $record->innovation : ' ';
                        }, 
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Tindakan',
                        'value' => function ($record) {
                            return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $record->id, 'title' => 'innovation'], ['class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => 'Anda yakin ingin padam?',
                                            'method' => 'post',
                                ]]) . ' ' . Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-services', 'id' => $record->id, 'title' => 'innovation'], ['class' => 'btn btn-default']);
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
