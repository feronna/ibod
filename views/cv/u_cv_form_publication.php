<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\grid\GridView;
?> 
<?php echo $this->render('menu'); ?> 
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">PUBLICATION</p> 
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">   
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Author: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12">  
                <?=
                $form->field($model, 'ICNO')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->all(), 'ICNO', 'CONm'),
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                ])->label(false);
                ?>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">My Role: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12">  
                <?=
                $form->field($model, 'role_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cv\RefRolePublication::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label(false);
                ?>
            </div>
        </div> 

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Full Author Name: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12">  
<?= $form->field($model, 'full_author')->textarea(['rows' => 3, 'placeholder' => 'e.g: Azman Hashim, Selvia Joseph, Yung Tze Sam'])->label(false); ?>
            </div>
        </div>  
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Title: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12"> 
<?= $form->field($model, 'title')->textarea(['rows' => 3])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Type: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12">  
                <?=
                $form->field($model, 'type_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cv\RefPublicationSort::find()->where(['!=', 'name', 'Tiada Data'])->all(), 'id', 'name'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'readonly' => true,
                    ],
                ])->label(false);
                ?>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Year: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?=
                DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'year',
                    'template' => '{input}{addon}',
                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'required' => 'required', 'placeholder' => '....'],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy',
                        'startView' => 'years',
                        'minViewMode' => 'years',
                    ]
                ]);
                ?>

            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Indexing: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12">  
                <?=
                $form->field($model, 'indexing')->widget(Select2::classname(), [
                    'data' => ['High-Indexed (SCOPUS/WOS/ERA)' => 'High-Indexed (SCOPUS/WOS/ERA)', 'Indexed (MyCite)' => 'Indexed (MyCite)', 'Non-Indexed' => 'Non-Indexed'],
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'readonly' => true,
                    ],
                ])->label(false);
                ?>

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Volume: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12"> 
<?= $form->field($model, 'volume')->textInput()->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Issue: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12"> 
<?= $form->field($model, 'issue')->textInput()->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Page No.: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
<?= $form->field($model, 'page_no')->textInput(['placeholder' => 'e.g.: 22 or 61-74'])->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Publisher: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12"> 
        <?= $form->field($model, 'publisher')->textarea(['rows' => 2])->label(false); ?>
            </div>
        </div>

        <div class="form-group text-center">
<?= Html::submitButton($model->isNewRecord ? 'SAVE' : 'UPDATE', ['class' => 'btn btn-success']) ?>
        </div>
<?php ActiveForm::end(); ?> 
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">RECORD</p>  
        <div class="clearfix"></div>
    </div> 
    <div class="table-responsive">
        <?=
        GridView::widget([
            'dataProvider' => $record,
            'layout' => '{items}{pager}',
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => 'No.'
                ],
                [
                    'class' => 'yii\grid\DataColumn',
                    'label' => 'Details',
                    'format' => 'raw',
                    'value' => function ($record) {
                        return $record->full_author . ', ' . $record->year . ', ' . $record->title . '. ' . $record->role->name . '. ' . $record->volume . '. ' . $record->issue . '. ' . $record->page_no . '. ' . $record->issue . '. ' . $record->publisher;
                    },
                    'contentOptions' => ['width' => '500px'],
                ],
                [
                    'class' => 'yii\grid\DataColumn',
                    'label' => 'Type',
                    'value' => function ($record) {
                        return $record->type ? $record->type->name : ' ';
                    },
                ],
                [
                    'class' => 'yii\grid\DataColumn',
                    'label' => 'Indexing',
                    'value' => function ($record) {
                        return $record->indexing;
                    },
                ],
                [
                    'class' => 'yii\grid\DataColumn',
                    'label' => 'Status',
                    'format' => 'raw',
                    'value' => function ($record) {
                        return $record->verification;
                    },
                ],
                [
                    'class' => 'yii\grid\DataColumn',
                    'label' => 'Action',
                    'value' => function ($record) {
                        return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $record->id, 'title' => 'publication'], ['class' => 'btn btn-default',
                            'data' => [
                                'confirm' => 'Anda yakin ingin padam?',
                                'method' => 'post',
                    ]]) . ' ' . Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-services', 'id' => $record->id, 'title' => 'publication'], ['class' => 'btn btn-default']);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center', 'width' => '130px'],
                ],
            ],
        ]);
        ?>   

    </div>
</div> 