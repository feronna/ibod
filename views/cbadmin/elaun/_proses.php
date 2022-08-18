<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
error_reporting(0);

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

?> 

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

     

    <div class="x_panel">
        <div class="x_content">
           <span class="required" style="color:black;">
                <strong>
                    <center><?= strtoupper('
   <u><h2><strong>REKOD PEMBAYARAN ELAUN DAN YURAN KAKITANGAN</strong></h2></u></b>
 '); ?>
                </strong> </center>
            </span> 
        </div>
   
    </div>

 <div class="row">
     
    <div class="col-xs-12 col-md-12 col-lg-12" >

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" >
                        <p align="right">  <?= Html::a('Kembali', ['cbadmin/biasiswa','id'=>$b->id], ['class' => 'btn btn-primary btn-sm']) ?></p>

    <div class="x_panel">

        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> REKOD AMAUN PEMBAYARAN</strong></h2>

        <div class="clearfix"></div>
       
        </div>
        <div class="x_content ">
<table class="table table-striped table-sm  table-bordered">
<thead>
        <tr> 
                        <th style="width:10%" align="right">NAMA KAKITANGAN</th>
                        <td style="width:20%"><?=
                        strtoupper($b->kakitangan->CONm) ?></td>
                       
                    </tr> 
                    
                     <tr> 
                        <th style="width:10%" align="right">NO KAD PENGENALAN</th>
                        <td style="width:20%"><?=
                        strtoupper($b->kakitangan->ICNO) ?></td>
                       
                    </tr>
                                 
                    <tr> 
                        <th style="width:10%" align="right">NAMA TAJAAN</th>
                        <td style="width:20%"><?=
                        strtoupper($b->nama_tajaan) ?></td>
                       
                    </tr> 
                    
                    <tr> 
                        <th style="width:10%" align="right">TARAF PERKAHWINAN</th>
                        <td style="width:20%">
                        <?=
                        strtoupper($b->kakitangan->displayTarafPerkahwinan) ?></td>
                       
                    </tr>
                   <tr>  <?php if($b->e)
                     {?>
                        <th style="width:10%" align="right">LOKASI PENGAJIAN</th>
                        <td style="width:20%"><?=
                        strtoupper($b->e->lokasi) ?></td>
                       
                    </tr> 
                    
                    <tr> 
                        <th style="width:10%" align="right">AKUAN MEMBAWA KELUARGA? (YA/TIDAK)</th>
                        <td style="width:20%"><?=
                        strtoupper($b->e->family) ?></td>
                       
                    </tr>
                    
                     <tr> 
                        <th style="width:10%" align="right">PASANGAN</th>
                        <td style="width:20%"><?=
                        strtoupper($b->e->pasangan) ?></td>
                        
                       
                    </tr>
                    <tr>
                        <th align="right">ANAK</th>
                        <td style="width:20%"><?=
                        strtoupper($b->e->anak) ?></td>
                    </tr>
                    <tr> 
                        <th style="width:10%" align="right">JENIS KADAR</th>
                        <td style="width:20%"><?=
                        strtoupper($b->e->kadar) ?></td>
                        
                     <?php }?>
                    </tr>
                     
                   
                   
                   

                            </thead>

                                
                      
                        </table>
            
            
                    </div> 
    </div>
</div>   
    
    
 </div>
 
    </div>
 
</div>
 <div class="row">
     
     <div class="col-xs-12 col-md-12 col-lg-12" >
         <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-money"></i> ELAUN <?= $b->e->kadar; ?></strong></h2>
 <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
        <div class="clearfix"></div>
        
        </div>
        
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#menu1">ESH</a></li><!--
    <li><a data-toggle="tab" href="#menu2">EP</a></li>
    <li><a data-toggle="tab" href="#menu3">EAP</a></li>
    <li><a data-toggle="tab" href="#menu4">EAPS</a></li>
    <li><a data-toggle="tab" href="#menu5">EB</a></li>
    <li><a data-toggle="tab" href="#menu8">EBK</a></li>-->
    <li><a data-toggle="tab" href="#menu5">EBSR</a></li>
    <li><a data-toggle="tab" href="#menu6">YURAN PENGAJIAN</a></li>
    <li><a data-toggle="tab" href="#menu7">TIKET PENERBANGAN</a></li>
  </ul><br/> 
     

<div class="tab-content">

    
    <div id="menu1" class="tab-pane fade in active">
        <p align="left"> 
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-sara?id='.$id,
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
             
            </p>  
  
     
    <tbody>
                       <form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
 
     <thead>
     <strong> <p style="color:green">ELAUN SARA HIDUP </p></strong>
        <tr class="headings">
            <th class="column-title text-center">BAYARAN </th>
            <th class="column-title text-center">AMAUN </th>
           <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>  
                       <tbody>
                    <?php 
//                    echo $pengajian->tarikh_mula;

               if($sara)
               {
                    foreach($sara as $sara)
                    {
//                        echo round($sem);
                       ?>  <tr>
                            <td class="column-title text-center"> UMS </td>
                             <td class="column-title text-center">
                                 <?php 
                                 
                                 
                                 echo 'RM'.$sara->amaun;
                                 ?>
                             </td>
                             
                              
        
         <td class="text-center" style="width:30%;">
                    <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-esh', 'id' => $sara->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> | 
                    <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-sara?id='.$sara->id], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?> 

               
         </td> 
            </tr>
            
                <?php 
               }}
                else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
                </tbody>
                    
                    
         
        
        



 </table>
</form> 
    </div>
     
    <div id="menu5" class="tab-pane fade in ">
        <p align="left"> 
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-sewa?id='.$id,
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
             
            </p>  
  
     
    <tbody>
                       <form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
 
     <thead>
     <strong> <p style="color:green">ELAUN BANTUAN SEWA RUMAH (LUAR NEGARA)</p></strong>
        <tr class="headings">
            <th class="column-title text-left">JENIS ELAUN </th>
            <th class="column-title text-center">BAYARAN </th>
            <th class="column-title text-center">AMAUN </th>
           <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>  
                       <tbody>
                    <?php 
//                    echo $pengajian->tarikh_mula;

               if($sewa)
               {
                    foreach($sewa as $sewa)
                    {
//                        echo round($sem);
                       ?>  <tr>
                             <td class="column-title text-left"> <?= $sewa->jenis->elaun?> </td>
                            <td class="column-title text-center"> UMS </td>
                             <td class="column-title text-center">
                                 <?php 
                                 
                                 
                                 echo 'RM'.$sewa->amaun;
                                 ?>
                             </td>
                             
                              
        
         <td class="text-center" style="width:30%;">
                    <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-ebsr', 'id' => $sewa->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> | 
                    <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-sewa?id='.$sewa->id], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?> 

               
         </td> 
            </tr>
            
                <?php 
               }}
                else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
                </tbody>
                    
                    
         
        
        



 </table>
</form> 
    </div>
    
     <div id="menu6" class="tab-pane fade">
<p align="left"> 
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-yuran?id='.$id,
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
             
          
            </p>    <form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
 
     <thead>
     <strong> <p style="color:green">YURAN PENGAJIAN (BY SEMESTER)</p></strong>
        <tr class="headings">
            <th class="column-title text-center">SEMESTER</th>
            <th class="column-title text-left">JENIS ELAUN </th>
            <th class="column-title text-center">BAYARAN </th>
            <th class="column-title text-center">AMAUN </th>
           <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>  
                       <tbody>
                    <?php 
//                    echo $pengajian->tarikh_mula;
if($lkk)
{
               
                    foreach($lkk as $lkk)
                    {
//                        echo round($sem);
                       ?>  <tr>
                             <td class="column-title text-center"> <?= $lkk->semester?> </td>
                             <td class="column-title text-left"> <?= $lkk->jenis->elaun?> </td>
                            <td class="column-title text-center"> UMS </td>
                             <td class="column-title text-center">
                                 <?php 
                                 
                                 
                                 echo 'RM'.$lkk->amaun;
                                 ?>
                             </td>
                             
                              
        
         <td class="text-center" style="width:30%;">
                    <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-yp', 'id' => $lkk->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> | 
                    <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-yuran?id='.$lkk->id], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?> 

               
         </td> 
            </tr>
            
                <?php 
}}
                        else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                } ?>
                </tbody>
                    
                    
         
        
        



 </table>
</form> 
    </div>
    
    <div id="menu7" class="tab-pane fade">
<p align="left"> 
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-tiket?id='.$id,
                  ]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
             
          
            </p>    <form id="w0" class="form-horizontal form-label-left" action="">
            <table class="table table-sm table-bordered">
 
     <thead>
     <strong> <p style="color:green">TIKET PENERBANGAN (PERGI & BALIK)</p></strong>
        <tr class="headings">
            <th class="column-title text-left">JENIS TUNTUTAN</th>
            <th class="column-title text-center">BAYARAN </th>
            <th class="column-title text-center">AMAUN </th>
           <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>  
                       <tbody>
                    <?php 
//                    echo $pengajian->tarikh_mula;
                    if($t)
                    {
               
                    foreach($t as $t)
                    {
//                        echo round($sem);
                       ?>  <tr>
                             <td class="column-title text-left" > <?= $t->jenis->elaun;?>  </td>
                            <td class="column-title text-center"> UMS </td>
                             <td class="column-title text-center">
                                 
                                 
                                 
                               RM<?= $t->amaun;
                                 ?>
                             </td>
                             
                              
        
         <td class="text-center" style="width:30%;">
                    <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-tp', 'id' => $t->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> | 
                    <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete-tiket?id='.$t->id], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?> 

               
         </td> 
            </tr>
            
                <?php 
                    }}
                       else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Tiada Maklumat</i></td>                     
                        </tr>
                  <?php  
                } ?>
                </tbody>
                    
                    
         
        
        



 </table>
</form> 
    </div>
    
</div>
  
</div>
         
  </div>
     
   <?php ActiveForm::end(); ?>
  
    </div>



