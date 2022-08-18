 <?php 
 use yii\helpers\Html;
 use yii\helpers\Url;
 error_reporting(0);
 ?> 


         <p align="right"> 
    
            <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>
        </p>   
        
        
         <div class="x_panel">
    <div class="x_title">
        <h5><strong><i class="fa fa-users"></i> KATEGORI PEGAWAI</strong>
        <div class="clearfix"></div>
    </div>   
     <h2><?php echo $urus->kategoriPegawai->kategori_nm?> </h2>
</div>
        
 <div class="x_panel">
    <div class="x_title">
        <h5><strong><i class="fa fa-book"></i> BIDANG KUASA</strong>
        <div class="clearfix"></div>
    </div>   
     <h2><?php echo $urus->bidang->bidang_kuasa_nm ?> </h2>
</div>
        
 <div class="x_panel">
    <div class="x_title">
        <h5><strong><i class="fa fa-user"></i> PENGERUSI</strong>
        <div class="clearfix"></div>
    </div>   
     <h2><?php if($urus->pengerusi_icno != null){
         echo $urus->namaPengerusi->CONm ;
     }else{
         echo 'Tiada Rekod';
     }?> </h2>
</div>


<div class="x_panel">
    <div class="x_title">
        <h5><strong><i class="fa fa-book"></i> SENARAI KEANGGOTAAN JAWATANKUASA TATATERTIB (KAKITANGAN UMS)</strong>  
         <?php echo // Html::a('<span class="fa fa-info-circle" aria-hidden="true">  Tambah</span>', ['tatatertib-staf/tambah-ahli-meeting', 'id' => $model->id ], ['class' => 'btn btn-success btn-block']); 
        Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tatatertib-staf/tambah-ahli-meeting', 'id' => $urus->id]), 'class' => 'fa fa-plus mapBtn btn btn-info']);?> </h5>
      
        <div class="clearfix"></div>
    </div>   
      
                <div class="x_content">          
                <table class="table table-bordered jambo_table" style="font-size: 12px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">NAMA</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JAWATAN</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TINDAKAN</th>
            
                </tr> 
                </thead>
                <tbody>
                      <?php
 
                if($ahliMeeting){ ?>
                <?php $bil=1; foreach ($ahliMeeting as $ahliMeetings) { ?>
                    <tr>
                        <td class="text-center"><?= $bil++ ?></td>
                        <td class="text-center"><?= strtoupper($ahliMeetings->kakitangan->CONm); ?></td>
                        <td class="text-center"><?= strtoupper($ahliMeetings->kakitangan->jawatan->nama . " (" . $ahliMeetings->kakitangan->jawatan->gred . ")"); ?></td>
                   
                         <td class="text-center"> <?php echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kemaskini-akses-luar', 'id' => $ahliMeetingLuar->id]), 'class' => 'fa fa-pencil mapBtn btn btn-info']); 
                                    ?>| <?php echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kemaskini-akses-luar', 'id' => $ahliMeetingLuar->id]), 'class' => 'fa fa-trash mapBtn btn btn-info', 
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ], ]) ?>
                        </td> 
                       
                    </tr>
                <?php } }
                        else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                </tbody>
        </table>              
    </div>
    
     
             
</div>

<div class="x_panel">
    <div class="x_title">
        <h5><strong><i class="fa fa-book"></i> SENARAI KEANGGOTAAN JAWATANKUASA TATATERTIB (AKSES LUAR)</strong>  
         <?php echo // Html::a('<span class="fa fa-info-circle" aria-hidden="true">  Tambah</span>', ['tatatertib-staf/tambah-ahli-meeting', 'id' => $model->id ], ['class' => 'btn btn-success btn-block']); 
        Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tatatertib-staf/register-external-user', 'id' => $urus->id]), 'class' => 'fa fa-plus mapBtn btn btn-info']);?> </h5>
      
        <div class="clearfix"></div>
    </div>   
     
                <div class="x_content">          
                <table class="table table-bordered jambo_table" style="font-size: 12px;font-family:Arial;" >
                <thead style="background-color:lightseagreen;color:white">
                <tr class="headings" colspan="2" style="background-color:lightseagreen;color:white">
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">BIL</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">NAMA</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">USERNAME</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">EMEL</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JAWATAN</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">JABATAN</th>
                    <th class="column-title text-center"  style="background-color:lightseagreen;color:white">TINDAKAN</th>
            
                </tr> 
                </thead>
                <tbody>
                       <?php
 
                if($ahliMeetingLuar){ ?>
                <?php $bil=1; foreach ($ahliMeetingLuar as $ahliMeetingLuar) { ?>
                    <tr>
                        <td class="text-center"><?= $bil++ ?></td>
                        <td class="text-center"><?= strtoupper($ahliMeetingLuar->name); ?></td>
                        <td class="text-center"><?= strtoupper($ahliMeetingLuar->icno); ?></td>
                        <td class="text-center"><?= strtoupper($ahliMeetingLuar->username); ?></td>
                        <td class="text-center"><?= strtoupper($ahliMeetingLuar->jawatan); ?></td>
                        <td class="text-center"><?= strtoupper($ahliMeetingLuar->jabatan); ?></td>
                        <td class="text-center"> <?php echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kemaskini-akses-luar', 'id' => $ahliMeetingLuar->id]), 'class' => 'fa fa-pencil mapBtn btn btn-info']); 
                                    ?>| <?php echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kemaskini-akses-luar', 'id' => $ahliMeetingLuar->id]), 'class' => 'fa fa-trash mapBtn btn btn-info', 
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ], ]) ?>
                        </td> 
                       
                    </tr>
                <?php } }
                        else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                </tbody>
        </table>              
    </div>
             
</div>
