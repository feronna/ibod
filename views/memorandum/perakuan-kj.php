<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
use yii\widgets\DetailView;


error_reporting(0);
?>
        
   

<div class="row">
<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-users"></i> Tindakan Pegawai Peraku</strong></h2>
               <p align="right" >
                    <?php echo Html::a('Kembali', ['halaman-kj'], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content"><?php
                
                 echo DetailView::widget([
    'model' => $model,
    'attributes' => [

                 [
            'label' => 'Bil.JPU',
              'format' => 'raw',
           'value' => function ($data) {
            return  strtoupper($data->tblRekod->bil_jpu). '&nbsp'. "Kali Ke-". '&nbsp'.strtoupper($data->tblRekod->kali_ke);
         }
              
        ],
         
       
         [
            'label' => 'Tarikh Mesyuarat',
            'attribute' =>  'tblRekod.tarikhRekod',
        ],
        
         [
            'label' => 'JAFPIB',
             'value' => function ($data) {
            return  strtoupper($data->department->fullname);
         }
        ],
        
            [
            'label' => 'Status Perakuan',
            'format' => 'raw',
           'value' => function ($data) {
          $statusLabel = [
           0 => '<span class="label label-danger">BELUM DIPERAKUKAN</span>',
           1 => '<span class="label label-success">DIPERAKUKAN</span>',
           2 => '<span class="label label-danger">DITOLAK</span>',
           ];
            return  $statusLabel[$data->status_kj];
         }
         
        ],
     [
            'label' => 'Urusetia JAFPIB',
            'format' => 'raw',
            'value' => function ($data) {
            return  strtoupper($data->kakitangan->CONm);
         }
                 
        ],  
                
                  [
            'label' => 'Tarikh Maklumbalas',
            'format' => 'raw',
            'value' => function ($data) {
            return  strtoupper($data->tarikhMaklumbalas);
         }
                 
        ], 
                
            [
            'attribute' => 'file',
            'label' => 'Lampiran Dokumen',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->doc_name) {
                    return Html::a(''  . $model->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->hashcode, $schema = true), ['target' => '_blank',  'style' =>  'text-decoration: underline; color:green']);
                } else {
                    return 'Tiada Lampiran';
                }
            }

        ],

    ],
]);?>
                  <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                      
                      
                      
                      
                      
                  <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Maklumbalas Urusetia:<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
               <?= $form->field($model, 'maklumbalas_ptj')->widget(TinyMce::className(), [
                            'options' => ['rows' => 15],
                            'language' => 'en',
                            'clientOptions' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table contextmenu paste"
                                ],
                                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                            ]
                        ])->label(false); ?>
                </div>
            </div>
                      
                      
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Perakuan Pegawai Peraku :<span class="required" style="color:red;">*</span></label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?=
                            $form->field($model, 'status_kj')->label(false)->widget(Select2::classname(), [
                                'data' => [1 => 'DPERAKUKAN'],
                                'options' => ['placeholder' => 'Pilih Tindakan', 'class' => 'form-control col-md-7 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
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
                <!--form-->
            </div>
            </div>
        </div>
    </div>
</div>
<div id="alert" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Perhatian!</h4>
            </div>
            <div class="modal-body">
                <b>Maklumbalas <mark>DITUTUP</mark> sementara bagi memberi laluan kepada Mesyuarat JPU pada <br> <?php echo $masa->tarikhTutup ?> .
                 Maklumbalas <mark>DIBUKA</mark> semula selepas mesyuarat JPU. Terima Kasih.
                </b>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){

        function checker(){
            var is_open = <?= $options['open'] ?>

            if(is_open === false){
               $("button[type='submit']").prop("disabled",true);
                $("#alert").modal('show');
            }
             
        }

        $( "#application-reason").keypress(function() {
            checker();
        });

        checker();
    });
</script>

