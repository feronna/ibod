<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

$statusLabel = [
    '1' => 'Monthly',
    '2' => 'Part-time/Claims-based Salary',
    '3' => 'Bonus/Cash Assist (Separate)',
    '4' => 'BOD'
];
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-book"></i>Rekod LPG</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <?php 
              
                echo Html::a('Kembali', ['view-lantikan-staf','id'=>$bio->ICNO], ['class' => 'btn btn-primary']) ;
                echo Html::a( $model ? 'Kemaskini' : 'Tambah'  , ['tklpg','ICNO'=>$bio->ICNO,], ['class' => 'btn btn-primary']) ;
            
            if($model){
                echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [                     
                            'label' => 'IC',
                            'value' => $model->i_lpg_ICNO,
                        ],
                    ],
                ]); 
            }else{
                echo "</br>";
                echo "Tidak Ada Data.";
            }   
                      
            ?>


            </div>
        </div>
    </div>
</div>