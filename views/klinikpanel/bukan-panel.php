<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
?>

<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel" >
        <div class="x_content">
                <p>
                    <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
                </p>
        </div>
        <div class="x_title">
            <h2><i class="fa fa-plus"></i><strong> Tuntutan Rawatan Klinik Bukan Panel</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">PEMOHON<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['IN','statLantikan', [1,3]])->orderBy(['CONm'=>SORT_ASC])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Carian Nama Kakitangan'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA KLINIK<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'nama_klinik')->textarea(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="used_dt">TARIKH TUNTUTAN<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <!--<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">-->
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tuntutan_date',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">RAWATAN<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'rawatan')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JUMLAH TUNTUTAN (RM)<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tuntutan')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NO RESIT<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'no_resit')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
                   

            </div>
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="reset">Reset</button>
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end();?>
     </div>
    

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        
        
        <div class="x_title">
            <h2><i class="fa fa-pencil-square-o"></i><strong>Rekod Tuntutan Rawatan Klinik Bukan Panel</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="tblmaxtuntutan-search">
        <?php
        $form = ActiveForm::begin([
                    'action' => ['bukan-panel'],
                    'method' => 'get',
        ]);
        ?>
   
        
        <div class="col-md-6 col-sm-6 col-xs-12">
        <?=
                $form->field($searchModel, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Carian Kakitangan'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
        </div>
        
        <div class="form-group">
        
        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    </div>
            <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
                ['class' => 'kartik\grid\SerialColumn',
                ],
                ['label' => 'NAMA KAKITANGAN',
                'attribute' => 'kakitangan.kakitangan.CONm',
                'format' => 'text',
                ],
                ['label' => 'NO.KP PEMOHON',
                'attribute' => 'icno',
                'format' => 'text',
                ],
                ['label'=> 'NAMA KLINIK',
                'attribute' => 'nama_klinik',
                'format' => 'text',
                ],
                
                ['label' => 'JUMLAH TUNTUTAN (RM)',
                'attribute' => 'tuntutan',
                'format' => 'text',
                ],
                ['label' => 'DIREKODKAN OLEH',
                'attribute' => 'insertby.CONm',
                'format' => 'text',
                ],
                ['label' => 'DIREKODKAN PADA',
                'attribute' => 'insert_dt',
                'format' => 'text',
                ],
                ['class' => 'kartik\grid\ActionColumn',
                'header' => '',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $dataProvider) {
                        $url = Url::to(['klinikpanel/update', 'id' => $dataProvider->id]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    }
                ]
    ]
                    ]]);
    ?>
</div>
                
        </div>
    </div>
</div>

