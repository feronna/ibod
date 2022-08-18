<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\harta;

$options = [
        1 => 'Sendiri', 2 => 'Pasangan' , 3 => 'Anak',

];
error_reporting(0);
$title = $this->title = 'Pengkemaskinian';

?>

<div class="col-md-12 col-xs-12"> 
 <div class="x_panel">
<?php if ($models == false){
   echo $this->render('_menu1', ['title' => $title]) ;      
}else{
    echo $this->render('_menu2', ['title' => $title]) ;   
}
?>
 </div> 
 </div>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>BAHAGIAN 4 - KETERANGAN MENGENAI HARTA SEDIA ADA/PERTAMBAHAN</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
       <div class="tbl-serah-tugas-index">

 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah', ['tambah-harta2'], ['class' => 'btn btn-success']) ?>
    </p>
              
            <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">HTA / HA</th>
                    <th class="text-center">Jenis Harta</th>
                    <th class="text-center">Spesifikasi Harta</th>
                    <th class="text-center">Pemilikan</th>
                    <th class="text-center">Cara dan dari Siapa Harta Diperolehi(dipusakai,
                 dibeli, dihadiahkan, dll)</th>
                    <th class="text-center">Tarikh Pemilikan</th>
                   <th class="text-center">Nilai Pembelian Aset(RM)</th>
                 
                     <th> Tindakan </th>
                </tr>
                         <?php if($model) {
                    
                   foreach ($model as $key=>$item) {
                    
                ?>
                  
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= strtoupper($item->hta->jenis_harta)?></td>
                    <td><?= strtoupper($item->jenisHarta->keterangan)?></td>
                     <td><?= strtoupper($item->spesifikasiHarta->keterangan)?></td>
                      <td><?= strtoupper($options[$item->pemilikan])?></td>
                      <td>
                        <?php  if ($item->AcqSrcCd == 'XX'){
                    echo strtoupper($item->cara);
                  }else{
                    echo strtoupper($item->caraDiperolehi->AcqSrcNm);
                 }
                ?>
                   </td>
                      
                      <td><?= $item->tarikhPemilikan?></td>
                     <td>RM  <?=$item->AlPurchasedValue?></td>
                   
                     <td class="text-center"> <?= Html::a('<i class="fa fa-info" aria-hidden="true"></i>', ['detail-harta', 'id' => $item->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-harta2', 'id' => $item->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-tambah-harta2', 'id' => $item->id], [
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
                        <td colspan="11" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    
                     
              
                  

            </table>
    </div>
          
</div>

    </div>
</div>
    
    </div>

