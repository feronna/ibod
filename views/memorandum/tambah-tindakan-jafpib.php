<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use dosamigos\datepicker\DatePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\hronline\Department;
use kartik\number\NumberControl;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\DetailView;

error_reporting(0);

?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/memorandum/_menu');?> 
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
                  <p align="right" >
                    <?php echo Html::a('Kembali', ['tambah-tindakan'], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
               
<?php
echo DetailView::widget([
    'model' => $perkara,
    'attributes' => [
        [
            'label' => 'Bil.JPU',
            'format' =>  'raw',
           'value' => function ($data) {
            return  strtoupper($data->tblRekod->bil_jpu). '&nbsp'. "Kali Ke-". '&nbsp'.strtoupper($data->tblRekod->kali_ke);
         }
        ],
          [
            'format' => 'raw',
            'label' => 'Subjek Minit',
            'attribute' =>  'tblRekod.perkara',
        ],
                
                   [
            'format' => 'raw',
            'label' => 'Perkara',
            'attribute' =>  'perkara',
        ],
                
             [
            'attribute' => 'file',
            'label' => 'Lampiran Dokumen',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->tblRekod->doc_name) {
                    return Html::a(''  . $model->tblRekod->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->tblRekod->hashcode, $schema = true), ['target' => '_blank',  'style' =>  'text-decoration: underline; color:green']);
                } else {
                    return 'Tiada Lampiran';
                }
            }

        ],
        
         [
            'label' => 'Tarikh Mesyuarat',
            'attribute' =>  'tblRekod.tarikhRekod',
        ],
                
          [
            'label' => 'Tarikh Akhir Penghantaran',
            'attribute' =>  'tblRekod.tarikhTamat',
        ],
        
        [
            'label' => 'Status Index' ,
           'format' => 'raw',
            'attribute' =>  'tblRekod.statusMemorandum',
        ],
        
 
       
                 
       
  
//        
//        [
//            'label' => 'Maklumbalas',
//            'format' => 'raw',
//            'value' => function ($data) {
//            
//            return Html::a($data->TugasUtama($data->id) );
//         }
//         
//        ]
         

    ],
]);
        
   ?>
            
            
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
          
                <h2><i class="fa fa-book"></i>&nbsp;<strong>Tambah Tindakan JAFPIB</strong></h2>
                <hr>
            <div class="x_content">


                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data'],'id' => 'dynamic-form']); ?>
                
           
          
                
                
                
           <div class="customer-form">

        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelMakluman[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'dimensi',
                    'dimensi_utama',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelMakluman as $i => $modelMakluman): ?>
                
                
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                    
                       
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                     
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelMakluman->isNewRecord) {
                                echo Html::activeHiddenInput($modelMakluman, "[{$i}]id");
                            }
                        ?>
                        
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">JAFPIB :<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                
                        <?php // Usage with ActiveForm and model
                        echo $form->field($modelMakluman, "[{$i}]dept_id")->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($department, 'id', 'fullname'),
                            'options' => ['placeholder' => '-- Pilih JAFPIB --'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);

                        ?>
                </div>
            </div>
                        
                        
                        
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Urusetia JAFPIB :<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                      <?=
                    $form->field($modelMakluman, "[{$i}]penyelia")->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'PekerjaNm'),
                        'options' => ['placeholder' => '-- Pilih Urusetia --', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
                        
                        
           <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Pegawai Peraku :<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?=
                    $form->field($modelMakluman, "[{$i}]pegawai_peraku")->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'PekerjaNm'),
                        'options' => ['placeholder' => '-- Pilih Pegawai --', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
                        
                        
                   
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        
            <?php DynamicFormWidget::end(); ?>
        </div>
    


</div>
                
                
    
                  <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Hantar', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>