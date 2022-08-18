<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\grid\GridView;
use yii\helpers\Url;    

error_reporting(0);

?> 


<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php echo $this->render('menu_info_tugas'); ?> 
</div>

<div class="col-md-3 col-sm-12 col-xs-12"> 
    <?php echo $this->render('menu_services'); ?>   
</div>

<div class="col-md-9 col-sm-12 col-xs-12">
    <div class="x_panel"> 
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">KELULUSAN CARTA</p> 
            <div class="clearfix"></div>
        </div>        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

        <div class="x_content"> 
             
              
            
               <div class="form-group">
                   
                <label class="control-label col-md-3 col-sm-3 col-xs-12">MESYUARAT MELULUSKAN CARTA: <span class="required" style="color:red;">*</span>
                  <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title=" Cth : Mesyuarat Fakulti Pertanian Lestari Bil.2/2022"></i> 
                
                </label>
                   
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                <?= $form->field($model, 'mesyuarat_meluluskan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
               
                </div>
            </div>
         
            
                <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH KELULUSAN CARTA: <span class="required" style="color:red;">*</span>
                </label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                       <?= $form->field($model, 'tarikh_diluluskan')->widget(DatePicker::className(),
                          ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                          ])->label(false);?>
                    </div>
                </div>
            
                     <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">DOKUMEN PUNCA KUASA:
                  <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title=" Cth : Petikan Minit/Surat Kelulusan"></i> 
                
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php if($model->file)
                        {
                           ?> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                 href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->file), true); ?>" target="_blank" ><u>Download Document</u></a>
                       <?php }
                       else{?>
                           <?= $form->field($model, 'files')->fileInput()->label(false);?> </td>

                     <?php  }
?>
             
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
                        'label' => 'MESYUARAT MELULUSKAN CARTA',
                        'value' => function ($record) {
                            return $record->mesyuarat_meluluskan ? $record->mesyuarat_meluluskan  : ' ';
                        }, 
                    ],
                                
                      [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'TARIKH DILULUSKAN',
                        'value' => function ($record) {
                            return $record->tarikh_diluluskan ? $record->tarikh_diluluskan  : ' ';
                        }, 
                    ],
                                [
                                                'label' => 'SALINAN CARTA',
                                                'format' => 'raw',
                                                'headerOptions' => ['class' => 'text-center'],
                                                'contentOptions' => ['class' => 'text-center'],
                                                'value' => function ($data) {

                                            if ($data->file != null) {

                                                return Html::a('', (Yii::$app->FileManager->DisplayFile($data->file)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']);
                                            } else {
                                                return '-';
                                            }
                                        },
                                            ],
                                                     
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'TINDAKAN',
                        'value' => function ($record) {
                            return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $record->id, 'title' => 'kelulusan-carta'], ['class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => 'Anda yakin ingin padam?',
                                            'method' => 'post',
                                ]]) . ' ' . Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-carta', 'id' => $record->id, 'title' => 'kelulusan-carta'], ['class' => 'btn btn-default']);
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
</div>