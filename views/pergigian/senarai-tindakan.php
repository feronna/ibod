<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\Pergigian\PergigianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1261, 1264, 1291], 'vars' => []]); ?>
<div class="col-md-12 col-xs-12">
</div>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
    <div class="x_title">    
        <h2><i class="fa fa-list"></i><strong> Senarai Menunggu Tindakan</strong></h2>
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
                        <th class="column-title">NAMA KLINIK</th>
                        <th class="column-title">TARIKH RAWATAN </th>
                        <th class="column-title">JUMLAH TUNTUTAN</th>
                        <th class="column-title">BAKI PERUNTUKAN</th>
                        <th class="column-title">STATUS SEMAK</th>
                        <th class="column-title">STATUS LULUS</th>
                        <th class="column-title">STATUS BAYAR</th>
                        <th class="text-center column-title">DOKUMEN SOKONGAN</th>
                        <th class="text-center column-title">SURAT KELULUSAN</th>
                        <th class="column-title">TINDAKAN</th>

                    </tr>                                             
                </thead>
                <tbody>
                        <?php if ($model) { ?>
                        <?php foreach ($model as $models){ ?>
                            <tr>
                                <td><?= $bil++; ?></td>
                                <td><?php echo $models->kakitangan->CONm; ?>    </td>
                                <td><?php if($models->jenis_tuntutan_id == 1){
                                if($models->klinik_gigi_id == 174){
                                    echo $models->lain;
                                }else{
                                     echo $models->klinikname; 
                                }}else {echo $models->kacamata;}
                               ?>     
                                </td>
                                <td class="text-center"><?= $models->used_dt; ?></td>
                                <td class="text-center"><?= Yii::$app->formatter->asCurrency($models->jumlah_tuntutan,'RM '); ?></td>
                                <td class="text-center"><?= Yii::$app->formatter->asCurrency( $models->baki, 'RM '); ?></td>
                                <td class="text-center"><?php echo $models->statusS;?></td>
                                <td class="text-center"><?php echo $models->statusL;?></td>
                                <td class="text-center"><?php echo $models->statusB;?></td>
                                <td class="text-center"><a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($models->dokumen_sokongan), true); ?>" target="_blank" ><i class="fa fa-download"></i><u> Dokumen Sokongan.pdf</u></a></td> 
                                <td class="text-center"><?php
                                if ($models->status_app === 'DILULUSKAN'){
                                    echo \yii\helpers\Html::a(' Muat Turun', ['pergigian/surat_lulus', 'id' => $models->tuntutan_gigi_id], ['class'=>'fa fa-download', 'target' => '_blank']);
                                }else{
                                    echo '';
                                }                               
                               ?> </td>
                                <td class="text-center"> 
                                <?= Html::button('', ['id' => 'modalButton', ''
                                    . 'value' => Url::to(['tindakan', 'id' => $models->tuntutan_gigi_id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit mapBtn']) ?> </td>
  
                                
                
                            </tr>
                        <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="12" class="align-center text-center"><i>Belum ada tuntutan</i></td>
                                </tr>
                                <?php } ?>
                    </tbody>
                    
            </table>
            <ul>
                <li><span class="label label-warning">BARU</span> : Tuntutan Baru</li>
                <li><span class="label label-primary">DISEMAK</span> : Tuntutan Telah Disemak</li>                   
                <li><span class="label label-success">DILULUSKAN</span> : Tuntutan Telah Diluluskan</li>                   
                <li><span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI</span> : Menunggu Tindakan Dari Bendahari</li>                   
                <li><span class="label label-danger">DITOLAK</span> : Tidak Diluluskan</li>   
                
            </ul>
        </div>
      </div>
    </div>
  </div>


    
 

