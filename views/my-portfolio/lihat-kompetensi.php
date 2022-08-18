 
<?php

use yii\helpers\Html;
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
  echo Html::a(Yii::t('app','Maklumat Umum'), ['/my-portfolio/view-maklumat-umum','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Tujuan Pewujudan Jawatan'), ['/my-portfolio/tujuan-jawatan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Akauntabiliti'), ['/my-portfolio/lihat-akauntabiliti','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Dimensi'), ['/my-portfolio/lihat-dimensi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Kelayakan Akademik'), ['/my-portfolio/lihat-kelayakan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Kompetensi'), ['/my-portfolio/lihat-kompetensi','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
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
    <div class="x_panel">
        <div class="x_title">
            <h2>Kompetensi</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
                 <div class="table-responsive">
         <?= Html::a('Tambah', ['my-portfolio/kompetensi', 'id' => $deskripsi->id], ['class' => 'btn btn-primary']) ?>
     <p style="color:red">* Wajib melengkapkan dan menyimpan maklumat didalam 'maklumat Umum' sebelum mengisi 'Kompetensi'</p>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Bil.</th>
                        <th colspan="2"><strong> KOMPETENSI</strong></th>
                        <th <td width="10px" height="20px"><strong>TINDAKAN</strong></td></th>
                    </tr>
                      <?php if($lihatKompetensi) {
                    
                   foreach ($lihatKompetensi as $key=>$item){
                    
                ?>
                
                        <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td colspan="2">
                            <?= $item->kompetensi?>
                              <td class="text-center"><?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['my-portfolio/kemaskini-kompetensi', 'id' => $item->id, 'portfolio_id' => $item->portfolio_id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-kompetensi', 'id' => $item->id, 'portfolio_id' => $item->portfolio_id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td> 
                                                  </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                        
                  
                    
                </table>
            
        </div>
        
    </div>
    </div>
</div>
</div>     
