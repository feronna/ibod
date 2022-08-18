<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use kartik\file\FileInput;


?>
<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: center;
}

</style>



<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?> 
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_content"> 

    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->

<?php
  echo Html::a(Yii::t('app','<i class="fa fa-users"></i> <span class="label label-success">MAKLUMAT UMUM</span>'), ['/portfolio/maklumat-bahagian','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-university"></i> <span class="label label-info">MAKLUMAT KHUSUS</span>'), ['/portfolio/carta-organ-staf','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);


?>
         </div>
    </div>
     <div class="x_panel">
         <div class="x_content"> 
   
<?php
  echo Html::a(Yii::t('app','CARTA ORGANISASI'), ['/portfolio/carta-organ-staf','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','CARTA FUNGSI'), ['/portfolio/carta-fungsi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
 echo Html::a(Yii::t('app','PROSES KERJA'), ['/portfolio/proses-kerja','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
  echo Html::a(Yii::t('app','SENARAI UNDANG-UNDANG'), ['/portfolio/senarai-undang','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  
 echo Html::a(Yii::t('app','SENARAI BORANG'), ['/portfolio/senarai-borang','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','SENARAI JAWATANKUASA'), ['/portfolio/senarai-jawatankuasa','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','PERAKUAN'), ['/portfolio/perakuan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
 echo Html::a(Yii::t('app','JANA MYPORTFOLIO'), ['/portfolio/jana-portfolio','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  ?>
         </div></div>


    
 <?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>


  
<div class="col-md-12 col-xs-12"> 


    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">AKTIVITI </p> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content ">
            
        <div class="form-group" id="jenisHarta">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenisHarta">Struktur: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=     
                    $form->field($modelmel, 'section_id')->widget(Select2::classname(), ['data' => ArrayHelper::map(\app\models\portfolio\RefSection::find()->all(), 'id', 'section_details'),
                        'options' => [
                            'placeholder' => '- Pilh Stuktur - '],
                    ])->label(false);
                    ?>
                </div>
            </div>
            
            <div class="form-group" id="senarai" >
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai">Unit: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($modelmel, 'unit_id')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(\app\models\portfolio\RefUnit::find()->all(), 'id', 'unit_details'),
                        'options' => [
                            'multiple' => false],
                        'pluginOptions' => [
                            'placeholder' => '- Pilih Unit - ',
                            'depends' => [Html::getInputId($modelmel, 'section_id')],
                            'initialize' => true,
                            'url' => Url::to(['/portfolio/statelist'])
                        ]
                    ])->label(false)
                    ?>
                    
                  
                </div>
            </div>

            <div class="form-group" id="daerah" >
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Daerah">Fungsi Unit: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($modelmel, 'fungsi_unit')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(\app\models\portfolio\RefFungsiUnit::find()->all(), 'id', 'description'),
                        'options' => [
                            'multiple' => false,],
                        'pluginOptions' => [
                            'placeholder' => '- Pilih Fungsi Unit - ',
                            'depends' => [Html::getInputId($modelmel, 'unit_id')],
                            'initialize' => true,
                            'url' => Url::to(['/portfolio/citylist'])
                        ]
                    ])->label(false)
                    ?>
                </div>
            </div>
            
                 <div class="form-group" id="daerah" >
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Daerah">Aktiviti Bagi Fungsi: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($modelmel, 'aktiviti_fungsi')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(\app\models\portfolio\TblAktiviti::find()->all(), 'id', 'aktiviti'),
                        'options' => [
                            'multiple' => false,],
                        'pluginOptions' => [
                            'placeholder' => '- Pilih Aktiviti -',
                            'depends' => [Html::getInputId($modelmel, 'fungsi_unit')],
                            'initialize' => true,
                            'url' => Url::to(['/portfolio/fungsilist'])
                        ]
                    ])->label(false)
                    ?>
                </div>
            </div>
            
            
                 <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Undang-undang, Peraturan dan Punca Kuasa: <span class="required" style="color:red;">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?= $form->field($modelmel, 'undang')->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                            </div>
                                        </div>
            
                <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Carta Alir:
                              <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title=" Sila muat naik Carta Alir Proses kerja "></i> 
            </label>
                  
            <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php if($modelmel->file)
                        {
                           ?> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                 href="<?= Url::to(Yii::$app->FileManager->DisplayFile($modelmel->file), true); ?>" target="_blank" ><u>Muat Turun</u></a>
                       <?php }?>
                      
                           <?= $form->field($modelmel, 'file')->fileInput()->label(false);?> </td>

     
            </div>
        </div>
            
            </div>
    </div>
        <div class="x_panel">
            <div class="customer-form">
               <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 10, // the maximum times, an element can be added (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsBarang[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'description',
                          
                        ],
                    ]); ?>

                <div class="panel panel-default">
                  
                    <div class="panel-body">
                        <div class="container-items">
                            <!-- widgetBody -->
                            <?php foreach ($modelsBarang as $i => $modelsBarang) : ?>
                                <div class="item panel panel-default">
                                    <!-- widgetItem -->
                                    <div class="panel-heading">

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                        // necessary for update action.
                                        if (!$modelsBarang->isNewRecord) {
                                            echo Html::activeHiddenInput($modelsBarang, "[{$i}]id");

                                        }
                                        ?>
                                
                                        
                                               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggungjawab: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($modelsBarang, "[{$i}]tanggungjawab")->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                ->where(['DeptId' => $deskripsi->jabatan_semasa])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Pilih Staf', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div> 
                                        
                                             <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Proses Kerja: <span class="required" style="color:red;">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?= $form->field($modelsBarang, "[{$i}]proses_kerja")->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                            </div>
                                        </div>
                                        
                                          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Lain/Dirujuk: 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($modelsBarang, "[{$i}]pegawai_lain")->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                ->where(['DeptId' => $deskripsi->jabatan_semasa])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Pilih Staf', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
                               
                                        
                                             <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh / Kekerapan: <span class="required" style="color:red;">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?= $form->field($modelsBarang, "[{$i}]tempoh")->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                            </div>
                                        </div>
     
                   
                                        
                                        </div>
                                      
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div><!-- .panel -->
                <?php DynamicFormWidget::end(); ?>
                <!--           view dyanamic end here-->
          
     <div class="form-group text-center">
        <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?>
    </div>
                
        </div>
    

    </div>
    



    <?php ActiveForm::end(); ?>
    </div>
</div>

 

   
