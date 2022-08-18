<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$title = $this->title = 'Maklumat Akademik';
error_reporting(0);
?> 
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN PENGAJIAN LANJUTAN LATIHAN INDUSTRI
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
</div>
<?php echo $this->render('_menusm', ['title' => $title, 'id'=> $iklan->id]) ?>



<!-- Maklumat Akademik -->
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
            
            <div class="x_title">
                <h2><strong><i class="fa fa-book"></i> Maklumat Akademik</strong></h2>
                 <p align ="right">
                <?php echo Html::a('<i class="fa fa-edit"></i> ', ['pendidikan/view'], ['class' => 'btn btn-success btn-sm','target'=>'_blank']); ?>
                
        </p>
               
                <div class="clearfix"></div>
            </div>
    <p style="color:red"> *Bagi yang memohon peringkat Sarjana dan PHD, sila pastikan maklumat CGPA Sarjana Muda dan Sarjana telah diisi bagi memudahkan proses permohonan anda layak. 
        <br/>Untuk mengemaskini maklumat akademik, sila tekan butang kemaskini dihujung kanan.</p>
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
<!--                        <th class="column-title text-center">BAKI IKATAN PERKHIDMATAN</th-->
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($akademik as $akademik) { ?>

                        <tr>

                            <td class="text-center"><?= $bil++ ?></td>
                            <td><?= strtoupper($akademik->tahapPendidikan); ?></td>
                            <td><?= strtoupper($akademik->namaMajor);?></td>
                            <td><?= strtoupper($akademik->namainstitut);?></td>
                            <td><?= strtoupper($akademik->OverallGrade);?></td>
                            <td><?= strtoupper($akademik->confermentDt);?></td> 
                            <td><?= strtoupper($akademik->namapenaja);?></td>
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
            <h2><strong><i class="fa fa-university"></i> Rekod Pengajian Yang Pernah Dipohon</strong></h2>
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
</div>

  
