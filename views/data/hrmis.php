<?php
use yii\helpers\Html;
?>
<div>
    <?php echo $this->render('_topmenu'); ?>
</div>
<div class="col-md-12 col-xs-12"> 
  <div class="x_panel">
 

        <div class="x_title">
            <h2><strong>Pengemaskinian Data HRMIS</strong></h2> 
            <div class="clearfix"></div>
        </div>
      
                 <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                   [
                                        'icon' => 'address-card',
                                        'header' => Yii::t('app','Mata Gaji HRMIS'),
                                     //   'text' => Yii::t('app','Keterangan Mengenai Pegawai'),
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['data/hrmis']);
                    ?>
                </div>
        
      
         
 </div>
</div>


