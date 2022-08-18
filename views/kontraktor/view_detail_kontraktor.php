<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use kartik\grid\GridView;

?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
 

<div class="x_panel"> 
    <div class="x_title">
        <h2>Maklumat Kontraktor</h2> 
        <div class="form-group text-right">
            <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">  <br/>    
        <?php
        if ($record) {
            ?>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama Syarikat/Pemilik: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($record, 'name')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div> 
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Alamat: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($record->kontraktor, 'apsu_address1')->textInput(['maxlength' => true, 'disabled' => true])->label(false)
                        .$form->field($record->kontraktor, 'apsu_address2')->textInput(['maxlength' => true, 'disabled' => true])->label(false)
                        .$form->field($record->kontraktor, 'apsu_address3')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Tel: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
                        <?= $form->field($record->kontraktor, 'apsu_phone')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Emel: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
                        <?= $form->field($record->kontraktor, 'apsu_email')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div>
        <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Perkhidmatan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
                        <?= $form->field($record, 'syarikat')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div>
        <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Tarikh Mula: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
                        <?= $form->field($record->kontraktor, 'tarikhmulasah')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?> 
        <?php ActiveForm::end(); ?><br/>   <br/>   
        

    </div>
    
    <div class="x_panel">
    <div class="table-responsive">     
        
        <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Nama Pekerja', 
                'value' => 'CONm',
            ],
             [
                'label' => 'No. K/P',
                'value' => 'ICNO',
            ],
           
            [
                'label' => 'No.Permit',
                'value' => 'no_permit',
            ],
           
            [
                'label' => '',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list){
                             
                        return  
                        Html::a('<i class="fa fa-eye">', ["kontraktor/perincian-pekerja", 'id' => $list->id]);
                          
                           
                        
                      },
            ], 
        ];
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'beforeHeader' => [
                [
                    'columns' => [],
                    'options' => ['class' => 'skip-export'] // remove this row from export
                ]
            ],
            'toolbar' => [
//                '{export}',
//                '{toggleData}'
            ],
            'bordered' => true,
            'striped' => false,
            'condensed' => false,
            'responsive' => true,
            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => '<h2>Maklumat Pekerja</h2>',
            ],
        ]);
        ?>
       
    </div>
</div>  
</div> 
