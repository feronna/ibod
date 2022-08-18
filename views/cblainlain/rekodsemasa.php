<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;

// use dosamigos\datepicker\DatePicker;
// use yii\web\UploadedFile;
// use yii\helpers\ArrayHelper;

?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-th-list"></i><strong> REKOD PERMOHONAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        
            <?php

            $items = [
               
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Cuti Belajar', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cutibelajar/rekod-baru'], 
                ],
                
                 [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Cuti Sabatikal/Latihan Industri',
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['cutisabatikal/rekod-sabatikal'],                  
                   
                    
                ],
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Pelanjutan Tempoh Cuti Belajar', 
                  'content' => '<p style="color: red"> </p>',
                    'url' =>  ['lanjutancb/rekod-lanjutan'],    
                   
                    
                ], 
                [
                    'label' => '<i class="fa fa-server"></i>&nbsp;Lain-Lain Permohonan' , 
                    'content' =>  $this->render('/cblainlain/_rekodbaru', [ 'icno' => $icno, 'statuslain'=> $statuslain]), 
                    'active' => true
                ], 
                [
                    'label' => '<i class="fa fa-server"></i>&nbsp;LKK' , 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['lkk/rekod-lkk'],     
                ], 
                 [
                    'label' => '<i class="fa fa-server"></i>&nbsp;Lapor Diri', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['lapordiri/rekod-lapor-diri'], 
                ], 
               [
                  'label' => '<i class="fa fa-list"></i>&nbsp;Tiket Penerbangan', 
                    'content' => '<p style="color: red"> </p>',
                    'url' =>  ['tiketpenerbangan/rekod-penerbangan'], 
              ], 
                
//                [
//                    'label' => '<i class="fa fa-list"></i>&nbsp;Pembelian Alat Komunikasi', 
//                    'content' => '<p style="color: red"> </p>',
//                    'url' =>  ['borang-alat/senaraitindakan'], 
//                    
//                ], 
 
                
            ];
            echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
            ?>

         <br>
           
     </div>
    </div> 
<!--            end of dropdownl link-->
   <div class="x_panel">
<ul>
                <li><span class="label label-info">Dalam Tindakan KJ</span> : Menunggu perakuan dari Ketua Jabatan</li>
                <li><span class="label label-primary">Dalam Tindakan BSM</span> : Menunggu kelulusan dari BSM</li>
                <li><span class="label label-success">Berjaya</span> : Diluluskan</li> 
                <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
            </ul>
    </div>
    </div>
</div>
