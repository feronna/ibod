<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$title = $this->title = 'Maklumat Akademik';
?> 
<div class="col-md-12 col-sm-12 col-xs-12"> 
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel">
<div class="x_content">  
    <span class="required" style="color:#062f49;">
<center> <h2><strong><?= strtoupper('
CUTI SABATIKAL /LATIHAN INDUSTRI '); ?>
                        </strong></h2> </center>
            </span> 
</div>
    </div>
</div>
<?php echo $this->render('_menu', ['title' => $title, 'id'=> $iklan->id]) ?>



<!-- Maklumat Akademik -->
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
            
            <div class="x_title">
                <h2><strong><i class="fa fa-book"></i> MAKLUMAT AKADEMIK</strong></h2>
                 <p align ="right">
                <?php echo Html::a('<i class="fa fa-edit"></i> ', ['pendidikan/view'], ['class' => 'btn btn-success btn-sm','target'=>'_blank']); ?>
                
        </p>
               
                <div class="clearfix"></div>
            </div>

 <div class="table-responsive">
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL</th>
                        <th class="column-title text-center">TAHAP PENDIDIKAN </th>
                        <th class="column-title text-center">BIDANG</th>
                        <th class="column-title text-center">UNIVERSITI/INSTITUSI</th>
                        <th class="column-title text-center">KELAS/CGPA</th>
                        <th class="column-title text-center">TARIKH DIANUGERAHKAN</th>
                        <th class="column-title text-center">TAJAAN</th>
                        <th class="column-title text-center">BAKI IKATAN PERKHIDMATAN</th
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($akademik as $akademik) { ?>

                        <tr>

                            <td class="text-center"><?= $bil++ ?></td>
                            <td><?= $akademik->tahapPendidikan; ?></td>
                            <td><?= $akademik->namaMajor;?></td>
                            <td><?= $akademik->namainstitut;?></td>
                            <td><?= $akademik->OverallGrade;?></td>
                            <td><?= $akademik->confermentDt;?></td> 
                            <td><?= $akademik->Sponsorship;?></td>
                            <td align="center"><?= $akademik->jumlahBon;?></td>
                        </tr>
                    <?php } ?>
                </tbody>

                     </table>

                </form>

                 <p align ="right">
                    
                    <?= Html::a('Seterusnya', ['maklumat-pengajian',  'id' => $iklan->id], ['class' => 'btn btn-info btn-sm']); ?>
                    <?php echo Html::a('Kembali',  ['maklumat-peribadi',  'id' => $iklan->id], ['class' => 'btn btn-primary btn-sm']); ?> 
                </p>



            </div>
        </div>
        <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-university"></i> REKOD PENGAJIAN YANG PERNAH DIPOHON</strong></h2>
<!--             <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
            </ul>-->
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
       
    <div class="table-responsive">
         <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL</th>
                        <th class="text-center">PERINGKAT PENGAJIAN  </th>
                        <th class="text-center">TARIKH MULA </th>
                        <th class="text-center">TARIKH TAMAT</th>
                        <th class="text-center">UNIVERSITI/INSTITUSI</th>
                        <th class="text-center">NEGARA </th>
<!--                        <th class="text-center">Baki Bon Perkhidmatan (Tahun) </th>-->
                     

                    </tr>
                </thead>
                 <?php if($sabatikal2) {
                   $counter = 0; 
                   foreach ($sabatikal2 as $sabatikal2) {
                   $counter = $counter + 1;
                ?>
                   
                <tr>
                    
                    <td><?= $counter; ?></td>
                    <td class="text-center"><?= $sabatikal2->HighestEduLevel?></td>
                    <td class="text-center"><?= strtoupper($sabatikal2->tarikhmula)?></td>
                    <td class="text-center"><?= strtoupper($sabatikal2->tarikhtamat)?></td>
                    <td class="text-center"><?= strtoupper($sabatikal2->InstNm)?></td>
                    <td class="text-center"><?= strtoupper($sabatikal2->negara->Country)?></td>
                  
                
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
        </table>
               
</div>
        </div>
    </div>
   </div>

  
