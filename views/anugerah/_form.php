<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use app\models\hronline\Anugerah;
use app\models\hronline\KategoriAnugerah;
use app\models\hronline\Negeri;
use app\models\hronline\Negara;
use app\models\hronline\DianugerahkanOleh;
use app\models\hronline\Gelaran;



/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblanugerah */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblanugerah-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
    
    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Katgeori Anugerah">Kategori Anugerah: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          
            <?=
            $form->field($model, 'AwdCatCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(KategoriAnugerah::find()->where(['isActive'=>1])->all(), 'AwdCatCd', 'AwdCat'),
                'options' => ['placeholder' => 'Pilih Kategori Anugerah', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>    
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NamaAnugerah">Nama Anugerah: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
           
            <?=
            $form->field($model, 'AwdCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Anugerah::find()->where(['isActive'=>1])->all(), 'AwdCd', 'Awd'),
                'options' => ['placeholder' => 'Pilih Nama Anugerah', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="SingkatanAnugerah">Singkatan Anugerah: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'AwdAbbr')->textInput(['maxlength' => true])->label(false); ?>
        </div>
        </div>
        
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Gelaran">Gelaran: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
           
            <?=
            $form->field($model, 'TitleCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Gelaran::find()->where(['isActive'=>1])->all(), 'TitleCd', 'Title'),
                'options' => ['placeholder' => 'Pilih Gelaran', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="DianugerahkanOleh">Dianugerahkan Oleh: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
           
            <?=
            $form->field($model, 'CfdByCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(DianugerahkanOleh::find()->where(['isActive'=>1])->all(), 'CfdByCd', 'CfdBy'),
                'options' => ['placeholder' => 'Pilih Penganugerah', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
            
        <div class="form-group" id="negara">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Negara">Negara: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'CountryCd')->widget(Select2::classname(), ['data' => ArrayHelper::map(Negara::find()->where(['isActive'=>1])->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                        'options' => [
                            'placeholder' => 'Pilh Negara'],
                    ])->label(false);
                    ?>
                </div>
            </div>
            
        <div class="form-group" id="negeri" >
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Negeri">Negeri: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'StateCd')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(Negeri::find()->all(), 'StateCd', 'State'),
                        'options' => [
                            'multiple' => false],
                        'pluginOptions' => [
                            'placeholder' => 'Pilih Negeri',
                            'depends' => [Html::getInputId($model, 'CountryCd')],
                            'initialize' => true,
                            'url' => Url::to(['/alamat/statelist'])
                        ]
                    ])->label(false)
                    ?>
                </div>
            </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhDianugerahkan">Tarikh Dianugerahkan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'AwdCfdDt',
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
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="SebabDianugerahkan">Sebab Dianugerahkan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'AwdReason')->textInput(['maxlength' => true])->label(false); ?>
        </div>
        </div>

        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="SebabDianugerahkan">Status anugerah: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'AwdStatus')->checkbox(['label' => 'Tandakan Jika Aktif', 'value' => 1, 'uncheck' => 0]) ?>
        </div>
        </div>

        </div>
    </div>        
            
    <div class="form-group text-center">
        <?= Html::a('Kembali', ['view'],  ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
