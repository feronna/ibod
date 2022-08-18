<?php
use yii\helpers\Html;
?>
<div>
    <?php echo $this->render('_topmenu'); ?>
</div>
<div class="col-md-12 col-xs-12"> 
  <div class="x_panel">
 

        <div class="x_title">
            <h2><strong>Pemurnian Data Sumber Manusia</strong></h2> 
            <div class="clearfix"></div>
        </div>
      
                 <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                   [
                                        'icon' => 'address-card',
                                        'header' => Yii::t('app','Status Lantikan'),
                                     //   'text' => Yii::t('app','Keterangan Mengenai Pegawai'),
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['data/admin-status-lantikan']);
                    ?>
                </div>
        <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                   [
                                        'icon' => 'address-card',
                                        'header' => Yii::t('app','Status Sandangan'),
                                     //   'text' => Yii::t('app','Keterangan Mengenai Pegawai'),
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['data/admin-status-sandangan']);
                    ?>
                </div>
      
         <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                   [
                                        'icon' => 'address-card',
                                        'header' => Yii::t('app','Status Perkhidmatan'),
                                     //   'text' => Yii::t('app','Keterangan Mengenai Pegawai'),
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['data/admin-status-perkhidmatan']);
                    ?>
                </div>
     
     
                   <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                   [
                                        'icon' => 'address-card',
                                        'header' => Yii::t('app','Pendidikan'),
                                     //   'text' => Yii::t('app','Keterangan Mengenai Pegawai'),
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['data/data-pendidikan']);
                    ?>
                </div>
            <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                   [
                                        'icon' => 'address-card',
                                        'header' => Yii::t('app','Mata Gaji HRMIS'),
                                     //   'text' => Yii::t('app','Keterangan Mengenai Pegawai'),
                                        'number' => '5',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['harta/carian-admin']);
                    ?>
                </div>   
      
         <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                   [
                                        'icon' => 'address-card',
                                        'header' => Yii::t('app','Senarai Latihan'),
                                     //   'text' => Yii::t('app','Keterangan Mengenai Pegawai'),
                                        'number' => '5',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['data/senarai-latihan']);
                    ?>
                </div>  
                <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                   [
                                        'icon' => 'address-card',
                                        'header' => Yii::t('app','Senarai Aktiviti'),
                                     //   'text' => Yii::t('app','Keterangan Mengenai Pegawai'),
                                        'number' => '6',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['data/senarai-aktivitikomuniti']);
                    ?>
                </div>  
        </div>
        </div>
         
 </div>

