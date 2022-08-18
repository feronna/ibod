<?php
use yii\widgets\DetailView;
?>

<div class="table-responsive">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
                ['label' => 'Nama Klinik',
                'value' => $model->klinik->nama,
                'contentOptions' => ['style' => 'width:auto'],
                'captionOptions' => ['style' => 'width:26%'],],
                ['label' => 'Tarikh Rawatan',
                'value' => Yii::$app->formatter->asDatetime($model->rawatan_date)],
                ['label' => 'ICNO Kakitangan',
                'value' => $model->visit_icno],
                ['label' => 'ICNO Pesakit',
                'value' => $model->pesakit_icno],
                ['label' => 'Nama Pesakit',
                'value' => $model->pesakit_name],
                ['label' => 'Rawatan',
                'value' => !empty($model->rawatan) ? $model->rawatan :'TIADA',
            ],            
        ],
    ])
    ?>
    
        
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Nama Ubat</th>
                    <th>Unit/Kuantiti</th>
                    <th>Harga</th>   
                </tr>
                </thead>
                <?php if($namaubat) {
                    
                   foreach ($namaubat as $data) {
                    
                ?>
                  
                <tr>
                    <td><?= $data->namaUbat->name ?></td>
                    <td><?= $data->tblmed_unit ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($data->tblmed_price,'RM') ?></td>  
                </tr>

                   <?php }
                   ?>
                   <tr>
                       <td colspan="2"><b>JUMLAH HARGA UBAT</b></td>
                    
                       <td><b><?= Yii::$app->formatter->asCurrency($jumlah,'RM') ?></b></td>  
                </tr>
                <?php
                }else{
                    ?>
                    <tr>
                        <td colspan="4" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
           
   
    
    <div class="table-responsive">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
                
                ['label' => 'KOS KONSULTASI',
                'value' => Yii::$app->formatter->asCurrency($model->id_konsultasi, 'RM')],
                ['label' => 'JUMLAH TUNTUTAN',
                'value' => Yii::$app->formatter->asCurrency($model->jum_tuntutan, 'RM')],
        ],
    ])
    ?>
</div>
</div>