<?php
use yii\helpers\Html;

 
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>
<div class="x_panel">
<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
           <!--            <h2><strong><i class="fa fa-list"></i> Permohonan Online</strong></h2>-->
             <h2><strong><i class="fa fa-list"></i> Permohonan Baharu Pengajian Lanjutan</strong></h2>
             <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
       

 <div class="x_content"> 
            <div class="row">
              
             
            <div class="x_content">
<!--                <div>  ubah kat sini -->
                <div class="table-responsive">
                   
                        <table class="table table-striped jambo_table">
                            <thead>
                                <tr>
                                    <th class="text-left" style="text-align:center">Bil</th>
<!--                                    <th class="text-left">Kod Kursus</th>-->
                                    <th class="text-left" style="width: 500px">Permohonan</th>
                                    
<!--                                    <th class="text-left">Penceramah</th>-->
                                    <th class="text-center">Tindakan</th>
                                    
                                </tr>
                                
                            </thead>
                             <tr>
                                    <th class ="text-center"> 1 </th>
                                    <th class ="text-left"> Cuti Belajar </th>
                                     
                                    <th><?= Html::a('<span class="btn-label">Mohon</span>', ['borang/mohon_elaun', 'id' => 3 ], ['class' => 'btn btn-primary btn-block']) ?> </th>
                                </tr>
                                <tr>
                                    <th class ="text-center"> 2 </th>
                                    <th class ="text-left"> Cuti Sabatikal
                                    <th><?= Html::a('<span class="btn-label">Mohon</span>', ['borang/mohon_elaun', 'id' => 3 ], ['class' => 'btn btn-primary btn-block']) ?> </th>
                                </tr>
<!--                                <tr>
                                    <th class ="text-center"> 2 </th>
                                    <th class ="text-left"> Mengunjungi Wilayah Asal </th>
                                    <th><?= Html::a('<span class="btn-">Mohon</span>', ['kemudahan/lihattuntutan'], ['class' => 'btn btn-primary btn-block']) ?> </th>
                                  
                                </tr>-->
                            </table>
                        
                             
                             
                        
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
         
      
                </div> 
 </div>
 </div>
 


    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Permohonan Pelanjutan Tempoh Cuti Belajar</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div> 
 <div class="x_content"> 
            <div class="row">
              
             
            <div class="x_content">
                <div>   
                <div class="table-responsive">
                   
                        <table class="table table-striped jambo_table">
                            <thead>
                                <tr>
                                    <th class="text-left" style="text-align:center">Bil</th> 
                                    <th class="text-left" style="width: 500px">Permohonan</th>  
                                    <th class="text-center">Tindakan</th>
                                    
                                </tr>
                                
                            </thead>
<!--                             <tr>
                                    <th class ="text-center"> 1 </th>
                                    <th class ="text-left"> Tambang Belas Ehsan </th>
                                     
                                    <th><?= Html::a('<span class="btn-label">Mohon</span>', ['borangehsan/form_pemohon', 'id' => 5 ], ['class' => 'btn btn-primary btn-block']) ?> </th>
                                </tr>-->
                                <tr>
                                    <th class ="text-center"> 1 </th>
                                    <th class ="text-left"> Bayaran Balik </th>
                                    <th><?= Html::a('<span class="btn-label">Mohon</span>', ['boranglesen/index'], ['class' => 'btn btn-primary btn-block']) ?> </th>
                                  
                                </tr>
<!--                                <tr>
                                    <th class ="text-center"> 3 </th>
                                    <th class ="text-left"> Pembelian Alat Komunikasi </th>
                                    <th><?= Html::a('<span class="btn-label">Mohon</span>', ['borang-alat/maklumat-pembelian', 'id' => 6 ], ['class' => 'btn btn-primary btn-block']) ?> </th>
                                  
                                </tr>
                                 <tr>
                                    <th class ="text-center"> 4 </th>
                                    <th class ="text-left"> Perpindahan Perumahan </th>
                                    <th><?= Html::a('<span class="btn-label">Mohon</span>', ['borangperpindahan/maklumat-perpindahan', 'id' => 1 ], ['class' => 'btn btn-primary btn-block']) ?> </th>
                                  
                                </tr>
                                <tr>
                                    <th class ="text-center"> 5 </th>
                                    <th class ="text-left"> Yuran / Badan Ikhtisas </th>
                                    <th><?= Html::a('<span class="btn-label">Mohon</span>', ['borangyuran/maklumat-yuran', 'id' => 2 ], ['class' => 'btn btn-primary btn-block']) ?> </th>
                                  
                                </tr>-->
                            </table>
                        
                             
                             
                        
                </div>   
            </div>   
         
      
                </div>
            </div>
 </div>
    </div>
</div>
 </div>
 </div> 
 </div>
 </div>
 </div>

 