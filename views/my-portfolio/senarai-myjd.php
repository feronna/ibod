<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Menu;
// use buttflattery\multimenu;
use buttflattery\multimenu\MultiMenu;
use app\assets\AppAsset;


// AppAsset::register($this);
$statusLabel = [
        1 => '<span class="label label-warning">Dalam Tindakan KP</span>',
        2 => '<span class="label label-info">Dalam Tindakan KJ</span>',
        3 => '<span class="label label-primary">Dalam Tindakan BSM</span>',
        4 => '<span class="label label-success">Berjaya</span>',
        0 => '<span class="label label-danger">Ditolak</span>',
        5 => '<span class="label label-danger">Ditolak</span>'
];



?>

<style>
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  padding: 12px 16px;

}

.dropdown:hover .dropdown-content {
  display: block;
}
a:active {
  color:red;
  background-color: transparent;
  text-decoration: underline;
}

a:hover {
  color: red;
  background-color: transparent;
  text-decoration: underline;
}
</style>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/my-portfolio/_menu');?>
</div>

<div class="row">
<div class="col-md-12 col-xs-12"> 
  <div class="x_panel">
 
        <div class="x_content">
             <div class="table-responsive">
                <strong>  
                    
                    Sebarang pertanyaan dan kemusykilan mengenai sistem MYJD sila hubungi talian berikut:<br/><br/>
                  
                      <table  class="table table-bordered jambo_table">
                          
                        <tr>
                            <td width="1px">Nama </td> 
                            <td width="1px">Puan Hafizah binti Hassan</td>
                        </tr>
                         <tr>
                            <td width="1px">Jawatan</td> 
                            <td width="1px">Penolong Pegawai Teknologi Maklumat</td>
                        </tr>
                           <tr>
                            <td width="1px">No Telefon</td> 
                            <td width="1px">0102386110
                        </tr>  
                     

                         <tr>
                            <td width="1px">Slide Pembentangan Penyediaan Deskripsi Tugas Kakitangan Pentadbiran</td> 
                            <td width="1px"> <?php ?>
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to('@web/files/myjd.pdf'); ?>" target="_blank" ><u>Slide Penyediaan JD P&P.pdf</u></a>
                    <?php 
?></td>
                        </tr>  
                     
                    </table>
                    
                </strong>
             </div>
        </div>
        </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2><strong>Senarai MYJD</h2>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    
                        <?= Html::a('Tambah MYJD Baharu', ['maklumat-umum'], ['class' => 'btn btn-primary', 'data'=>['confirm'=>'TAMBAH MYJD BARU SEKIRANYA BERLAKU PERUBAHAN SKIM/JAWATAN ATAU PERTUKARAN TEMPAT BERTUGAS SAHAJA. JIKA TIDAK SILA KEMASKINI MYJD SEDIA ADA. TERUSKAN ?']]) ?>  
            <div class="table-responsive">
      
                
      <p style="color:green"> * TAMBAH MYJD BARU SEKIRANYA BERLAKU PERUBAHAN SKIM/JAWATAN ATAU PERTUKARAN TEMPAT BERTUGAS</p>
              
                <table class="table table-striped table-sm jambo_table">
                    
                        <thead>

                        <tr class="headings">
                            <th class="column-title">BIL </th>
                            <th class="column-title">NAMA</th>
                            <th class="column-title">JAWATAN SEMASA</th>
                            <th class="column-title">JFPIU SEMASA </th>
                            <th class="column-title">STATUS</th>
                            <th class="column-title">PENGGANTI</th>
                            <th class="column-title">CETAK</th>
                             <th class="column-title">PADAM JD</th>
                            
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($models as $key => $models){ ?>
                            <tr> 
                                <td><?= $key+1 ?></td>
                                
                                <td style="text-decoration: underline"><?php {
                        echo  Html::a($models->name, ["view-maklumat-umum", 'id' => $models->id], ['target' => '_blank']);
                        }?></td>
                                
                                <td><?= strtoupper($models->jawatan) ?></td>
                                <td><?= strtoupper($models->department->fullname )?></td>
                                <td> <?php if($models->status_hantar == null){
                           echo '<span class="label label-danger">BELUM DIHANTAR</span>';
                        }
                            else{
                            echo $models->tarikh_hantar;
                          }?></td>
                                <td><?= $models->pengganti ?></td>
                                <td>  <?= \yii\helpers\Html::a('', ['my-portfolio/generate-letter', 'id' => $models->id], ['class'=>'fa fa-edit', 'target' => '_blank']) ?> </td>
                                <td class="text-center" colspan="4"><?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-portfolio', 'id' => $models->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>      
                
                          
                            </tr>
                   
                        </tbody>
         <?php }?>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


