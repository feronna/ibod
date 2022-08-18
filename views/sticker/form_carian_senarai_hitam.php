<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
<div class="x_panel"> 
    <div class="x_title">
        <h2>Carian</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">     

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">   
                    <?=
                    $form->field($model, 'id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\esticker\TblPelawat::find()->where(['in','CatCd',[1]])->all(), 'id', 'CONm'),
                        'options' => ['placeholder' => 'Pilih Nama', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
                </div>
            </div>
        </div>


        <?php ActiveForm::end(); ?>

    </div>
</div> 

<div class="x_panel"> 
    <div class="x_title">
        <h2>Rekod Senarai Hitam</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">     
        <div class="table-responsive">

            <?=
            GridView::widget([
                'pager' => [
                    'firstPageLabel' => 'First',
                    'lastPageLabel' => 'Last'
                ],
                'options' => [
                    'class' => 'table-responsive',
                ],
                'dataProvider' => $record,
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn',
                        'header' => 'No',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Nama Pelawat',
                        'value' => function ($model) {
                            return $model->pelawat->CONm;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'No. KP',
                        'value' => function ($model) {
                            return $model->ICNO;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'No. Tel',
                        'value' => function ($model) {
                            return $model->pelawat->COOffTelNo;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Tarikh/Masa Daftar Masuk',
                        'value' => function ($model) {
                            return $model->check_in;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Tindakan',
                        'value' => function ($model) {
                            return Html::a('TUTUP KES', ['senarai-hitam','id'=>$model->pelawat->id,'url'=>Yii::$app->controller->action->id,'flag' => 2], ['class' => 'btn btn-success btn-sm']);
                        },
                                'format' => 'raw',
                            ],
                        ],
                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                        'resizableColumns' => false,
                        'responsive' => false,
                        'responsiveWrap' => false,
                        'hover' => true,
                        'floatHeader' => true,
                        'floatHeaderOptions' => [
                            'position' => 'absolute',
                        ],
                    ]);
                    ?>
        </div>
    </div>
</div>
