<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

?>
<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: center;
}

</style>


          <div class="row" style="display: <?php echo $display;?>">
<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?>
</div>



<div class="row">
<div class="col-md-12 col-xs-12"> 
    
            <div class="x_content"> 

    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->

<?php
  echo Html::a(Yii::t('app','<i class="fa fa-users"></i> <span class="label label-success">MAKLUMAT UMUM</span>'), ['/portfolio/maklumat-bahagian','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-university"></i> <span class="label label-info">MAKLUMAT KHUSUS</span>'), ['/portfolio/carta-organ-staf','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-book"></i> <span class="label label-warning">MAKLUMAT JD</span>'), ['/my-portfolio/view-maklumat-umum','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);


?>
         </div>
    </div>
    
    
    <div class="x_panel">
         <div class="x_content"> 
<?php
  echo Html::a(Yii::t('app','Maklumat Umum'), ['/my-portfolio/view-maklumat-umum','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
  echo Html::a(Yii::t('app','Tujuan Pewujudan Jawatan'), ['/my-portfolio/tujuan-jawatan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Akauntabiliti'), ['/my-portfolio/lihat-akauntabiliti','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Dimensi'), ['/my-portfolio/lihat-dimensi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Kelayakan Akademik'), ['/my-portfolio/lihat-kelayakan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Kompetensi'), ['/my-portfolio/lihat-kompetensi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Pengalaman'), ['/my-portfolio/lihat-pengalaman','id' => $deskripsi->id], ['class' => 'btn btn-success']);

// if($display){
//      echo '';
//  }else{
//  echo Html::a(Yii::t('app','Pengesahan'), ['/my-portfolio/pengesahan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
//  echo Html::a(Yii::t('app','Jana JD'), ['/my-portfolio/index','id' => $deskripsi->id], ['class' => 'btn btn-success']);
//  }

?>
         </div>
    </div>
</div>
</div>
          </div>


        <div class="row" style="display: <?php echo $display2;?>">
<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/my-portfolio/_menu');?>
</div>



<div class="row">
<div class="col-md-12 col-xs-12"> 
    
 
    
    <div class="x_panel">
         <div class="x_content"> 
<?php
  echo Html::a(Yii::t('app','Maklumat Umum'), ['/my-portfolio/view-maklumat-umum','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
  echo Html::a(Yii::t('app','Tujuan Pewujudan Jawatan'), ['/my-portfolio/tujuan-jawatan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Akauntabiliti'), ['/my-portfolio/lihat-akauntabiliti','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Dimensi'), ['/my-portfolio/lihat-dimensi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Kelayakan Akademik'), ['/my-portfolio/lihat-kelayakan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Kompetensi'), ['/my-portfolio/lihat-kompetensi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Pengalaman'), ['/my-portfolio/lihat-pengalaman','id' => $deskripsi->id], ['class' => 'btn btn-success']);

 if($display3){
      echo '';
  }else{
  echo Html::a(Yii::t('app','Pengesahan'), ['/my-portfolio/pengesahan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Jana JD'), ['/my-portfolio/index','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  }

?>
         </div>
    </div>
</div>
</div>
          </div>


<div class="row">
<div class="col-md-12 col-xs-12"> 
     <div class="x_panel" >
        <div class="x_title">
            <h2>Deskripsi Tugas</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
          
                </div>
        <div class="x_content">
          <div class="table-responsive">
              <p style="color:red">* Sila pastikan Pegawai menyemak dan Pegawai meluluskan adalah betul.</p>
               <?php   echo Html::a('Kemaskini', ['my-portfolio/kemaskini-maklumat-umum', 'id' => $deskripsi->id], ['class' => 'btn btn-primary']);?>
               
                <table class="table table-sm table-bordered">
                    <tr>
                        <th colspan="4"><strong> MAKLUMAT UMUM </strong></td>
                        
                    </tr>
                     <tr>
                     <td><strong>GELARAN JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->jawatan)?></td>
                     <td><strong>KETUA PERKHIDMATAN</strong></td>
                     <td>KETUA PENGARAH PENDIDIKAN TINGGI</td>
                     </tr>
                     <tr>
                     <td><strong>RINGKASAN GELARAN JAWATAN</strong></td>
                     <td><?=strtoupper( $deskripsi->ringkasan_gelaran )?></td>
                     <td><strong>KEDUDUKAN DI WARAN PERJAWATAN</strong></td>
                     <td>TIDAK BERKENAAN</td>
                     </tr>
                     <tr>
                         <td><strong>GRED JAWATAN</strong></td>
                     <td><?php if($deskripsi->gred_jawatan == null){
                       echo "<span class='badge badge-danger'>Sila Isikan Maklumat Ini</span>";
                     }else{
                         echo strtoupper($deskripsi->jawatanss->gred); 
                     }?></td>
                     <td><strong>BIDANG UTAMA</strong></td>
                     <td><?= strtoupper($deskripsi->bidang_utama) ?></td>
                     </tr>
                     <tr>
                      <td><strong>GRED JD</strong></td>
                   <td><?= strtoupper($deskripsi->gredJawatan->gred)?></td>
                     <td><strong>SUB BIDANG</strong></td>
                     <td><?= strtoupper($deskripsi->sub_bidang) ?></td>
                     </tr>
                     <tr>
                         <td><strong>STATUS JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->status_jawatan)?></td>
                     <td><strong>DISEDIAKAN OLEH</strong></td>
                     <td><?= strtoupper($deskripsi->name) ?></td>
                     </tr>
                    <tr>
                        <td><strong>HIRARKI 1 (BAHAGIAN)</strong></td>
                     <td><?=strtoupper( $deskripsi->department->fullname)?></td>
                     <td><strong>DISEMAK OLEH</strong></td>
                     <td><?= strtoupper($deskripsi->ketuaPerkhidmatan->CONm);?>     <?php  echo Html::a('Tambah / Kemaskini', ['my-portfolio/kemaskini-pp-individu','id' => $deskripsi->id], ['class' => 'btn btn-primary']); ?></td>
                     </tr>
                      <tr>
                          <td><strong>HIRARKI 2 (CAWANGAN /SEKTOR/ UNIT)</strong></td>
                     <td><?= strtoupper($deskripsi->hirarki_2)?></td>
                     <td><strong>DILULUSKAN OLEH</strong></td>
                     <td><?= strtoupper($deskripsi->ketuaJabatan->CONm) ?>  <?php  echo Html::a('Tambah / Kemaskini', ['my-portfolio/kemaskini-kj-individu','id' => $deskripsi->id], ['class' => 'btn btn-primary']); ?></td></td>
                     </tr>
                    <tr>
                        <td><strong>SKIM PERKHIDMATAN</strong></td>
                       <td><?=strtoupper( $deskripsi->applicant->jawatan->skimPerkhidmatan->name)?></td>
         
                     <td><strong>TARIKH DOKUMEN</strong></td>
                     <td><?= strtoupper($deskripsi->tarikhDokumen)?></td>
                     </tr>
              
                </table>
            
          
        </div>
        
    </div>
    </div>
</div>
</div>     


