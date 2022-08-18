<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

?>


<div class="col-md-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Papar Tuntutan Rawatan Bukan Panel</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">        
        <p>
            <?= Html::a('<i class="fa fa-sign-out" aria-hidden="true"></i> Kembali', ['bukan-panel'], ['class' => 'btn btn-primary']) ?>
            <?=
                    Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> Padam', ['deleteb', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ])
                    ?>
        </p>
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
                'value' => $model->insertby->CONm],                     
                ['label' => 'Direkodkan Pada',
                'value' => $model->insert_dt],                     
                ['label' => 'Baki Peruntukan (RM)',
                'value' => $model->kakitangan->current_balance],                     
                ],
        'template' => '<tr><th>{label}</th><td style="width:70%;">{value}</td></tr>',
    ])
    ?>
       
    </div>
    </div>
</div>



