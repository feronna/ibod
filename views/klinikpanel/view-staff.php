<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

?>


<div class="col-md-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-medkit"></i><strong> Papar Tuntutan Rawatan Bukan Panel</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">        
        <?=
    DetailView::widget([
        'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
        'model' => $model,
        'attributes' => [
                ['label' => 'Nama Kakitangan',
                'value' => $model->kakitangan->kakitangan->CONm],                           
                ['label' => 'No.KP Kakitangan',
                'value' => $model->icno],                           
                ['label' => 'Nama Klinik',
                'value' => $model->nama_klinik],                           
                ['label' => 'Tarikh Tuntutan',
                'value' => $model->tuntutan_date],                           
                ['label' => 'Rawatan',
                'value' => $model->rawatan],                           
                ['label' => 'Jumlah Tuntutan',
                'value' => Yii::$app->formatter->asCurrency($model->tuntutan,'RM')],                           
                ['label' => 'No. Resit',
                'value' => $model->no_resit],                     
                ['label' => 'Direkodkan Oleh',
                'value' => !empty($model->insertby->CONm) ? $model->insertby->CONm : $model->insert_by],                     
                ['label' => 'Direkodkan Pada',
                'value' => $model->insert_dt],                                          
                ],
        'template' => '<tr><th>{label}</th><td style="width:70%;">{value}</td></tr>',
    ])
    ?>
       
    </div>
    </div>
</div>



