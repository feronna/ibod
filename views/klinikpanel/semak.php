<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel app\models\Pergigian\PergigianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
error_reporting(0);
?>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
            <p>
                <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
            </p>
    <div class="x_title">    
        <h2><i class="fa fa-list"></i><strong> Senarai Permohonan Penambahan Peruntukan Klinik Panel (MyHealth)</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-bordered jambo_table">
                <thead>
                    <tr class="headings">
                        <th class="column-title">BIL </th>
                        <th class="column-title">NAMA KAKITANGAN </th>
                        <th class="column-title">PERMOHONAN KALI</th>
                        <th class="column-title text-center">TARIKH MOHON </th>
                        <th class="column-title text-center">JUMLAH MOHON</th>
                        <th class="column-title text-center">STATUS PERMOHONAN</th>
                        <th class="column-title text-center"><span class="glyphicon glyphicon-info-sign"></span></th>

                    </tr>                                             
                </thead>
                <tbody>
                        <?php if ($model) { ?>
                        <?php foreach ($model as $models){ ?>
                            <tr>
                                <td><?= $bil++; ?></td>
                                <td><?php echo $models->kakitangan->kakitangan->CONm; ?>    </td>
                                <td><?php if($models->entry_id == 1){
                                    echo 'PERTAMA';
                                }else{
                                     echo 'KEDUA'; 
                                }
                               ?>     
                                </td>
                                <td class="text-center"><?= $models->entry_dt; ?></td>
                                <td class="text-center"><?= Yii::$app->formatter->asCurrency($models->jumlah_mohon,'RM '); ?></td>
                                <td class="text-center"><?php echo $models->statusS;?></td>
                                <td class="text-center"><?php if ($models->status == 4){
                                    echo Html::a('', ['klinikpanel/memo-lulus', 'id' => $models->id], ['class'=>'fa fa-eye', 'target' => '_blank']);
                                }else{
                                    echo '';
                                }                               
                               ?> </td>
                            </tr>
                        <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="12" class="align-center text-center"><i>Tiada rekod permohonan</i></td>
                                </tr>
                                <?php } ?>
                    </tbody>
                    
            </table>
            <ul>
                <li><span class="label label-warning">BARU</span> : Permohonan Baru</li>
                <li><span class="label label-info">DIPERAKU</span> : Permohohan Telah Diperaku Ketua Jabatan</li>                   
                <li><span class="label label-primary">DISEMAK</span> : Permohonan Telah Disemak</li>                   
                <li><span class="label label-success">DILULUSKAN</span> : Permohonan Telah Diluluskan</li>                   
                <li><span class="label label-danger">DITOLAK</span> : Permohonan Tidak Diluluskan</li>  
                
            </ul>
        </div>
      </div>
    </div>
  </div>


    
 

