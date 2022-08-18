<?php
$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;

$this->registerJs($js);
$this->registerJsFile('@web/js/circleprogress.js');

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
error_reporting(0);
$this->title = 'Bon Perkhidmatan';

?> 

<style>
    @media screen and (min-width: 701px) {
        .app1 {
          width: 280px;}}
     @media screen and (max-width: 700px) {
        .app1 {
          width: 200px;}}
    .app1{
        background-color: #efefef;
        height: 50px;
        white-space: normal;
    }
    div.scrollmenu {
  overflow: auto;
  white-space: nowrap;
}

.labelc{
    font-size: 18px;
}
.canvasc {
    display: block;
    position:absolute;
    top:0;
    left:0;
}
.spanc {
    color:#555;
    display:grid;
    text-align:center;
    font-family:sans-serif;
    font-size:16px;
    height: 100px;
    align-items: center;
}

.appname{
        white-space: normal;
    
}

.table > tbody > tr > td, .table > tfoot > tr > td{
    border-top: none;
}
</style>
 <div class="row">
       <?php echo $this->render('/cutibelajar/_topmenu'); ?>

    
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <p align="right">  <?= Html::a('Kembali', ['cbadmin/search-bon'], ['class' => 'btn btn-primary btn-sm']) ?></p>

            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="row text-center" >
                <div class="col-lg-1 col-sm-3 col-xs-12 text-center">
                    <div class="col-lg-1 col-md-1 col-xs-12 text-center" rowspan="6" valign="top"><span><img height='100px' width="80px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $model->ICNO)); ?>.jpeg"></span></div>
                </div>
                <div class="col-lg-11 col-sm-9 col-xs-12" >
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Nama:</b></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left" ><?= $model->gelaran->Title ." ". ucwords(strtolower($model->CONm)) ?></div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>No. KP / Paspot:</b></div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?= $model->ICNO ?></div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords(strtolower($model->department->fullname)) ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Kampus Cawangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left " ><?= ucwords(strtolower($model->kampus->campus_name)) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>UMSPER:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->COOldID ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Disandang:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->jawatan->nama . " (" . $model->jawatan->gred . ")"; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Sandangan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusSandangan->sandangan_name ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Sandangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartSandangan ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Jawatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusLantikan->ApmtStatusNm ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartLantik ?> hingga <?= $model->tarikhbersara?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Pekerja:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><span><?= $model->Status ? $model->serviceStatus->ServStatusNm : 'Not Set' ?></span></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Status:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartDateStatus ?></div>
                    </div>
                </div>
            </div> </br>    

<div class="x_panel" >
    <div class="x_title">
        <h2>Bon Perkhidmatan</h2>
        <div class="clearfix"></div>
    </div>                             
                                
<div class="well well-lg"> 
                <div class="row ">
<div class="x_content"> 


            <div class="row">

                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list-alt',
                                        'header' => 'MAKLUMAT BON',
                                        'text' => 'Kakitangan Akademik',
                                        'number' => '1',
                                    ]
                    ); 
                    echo Html::a($dokumen, 
                ['view-bon?icno='.$lapor->icno.'&id='.$lapor->pengajian->HighestEduLevelCd.'&page=rekod-bon']);
                    
                    
                    ?>
                </div>

                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'money',
                                        'header' => 'PENGIRAAN GANTIRUGI',
                                        'text' => 'Jumlah Tuntutan Gantirugi',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($semakan, ['view-bon?id='.$model->ICNO.'&page=tuntut-gantirugi']);
                    ?>
           </div>
                
            
                
               
       </div>

                


        </div>
                </div></div>

   </div></div></div>
</div></div>
 
<div class="row">    
<div class="col-md-12 col-sm-12 col-xs-12 "> <?php    
if (isset($_GET['page'])) {
if ($_GET['page'] == "rekod-bon") {?>


<div class="x_panel">

<div class="x_title">
   <h2><strong><i class="fa fa-book"></i> PENGIRAAN TEMPOH BERKHIDMAT (TIDAK TERMASUK TEMPOH PENGAJIAN LANJUTAN KAKITANGAN)</strong></h2>
   <div class="clearfix"></div>
</div>
    <p align="left"> 
<!--            <= Html::a('Kembali', ['index', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>-->
<!--            <= Html::a('Kemaskini', ['update2', 'id' => $model->ICNO], ['class' => 'btn btn-primary mapBtn ', 'id' => 'modalButton']) ?>-->
            <?= Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-bon', 'icno'=>$lapor->icno
                   ,'id'=>$model->lapor->laporID]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
<!--            <= Html::a('Padam', ['delete', 'id' => $model->ICNO], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
-->            </p>
 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
   <thead>
       
        <tr class="headings">
            <th class="column-title text-center">BIL</th>
            <th class="column-title text-center">TARIKH MULA BON </th>
            <th class="column-title text-center">CATATAN</th>
            <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>
    <tbody>
         <?php if($bon){ ?>
        <?php $bil=1; foreach ($bon as $bon) { ?>
        <tr>
<td class="text-center"><?= $bil++ ?></td>
<td class="text-center"><?= strtoupper($bon->dtm); ?> <b> HINGGA </b><?= strtoupper($bon->dtt); ?></td>
            <td class="text-center"><?= $bon->catatan; ?></td>
<!--<td class="text-center"><?php //$bon->j_bon; ?></td>-->
            <td class="text-center">

                 <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-bon', 'id' => $bon->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?> |

                
                    
                 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', 
                    ['cbadmin/delete?id='.$bon->id.'&page=rekod-bon'], 
                    ['class' => 'btn btn-default btn-xs',
                     'data' => ['confirm' => 'Anda ingin membuang rekod ini?',],                                   
                    ])
                    ?>
            </td>

        </tr>
        <?php }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
                  <?php  
                } ?>
                    
         
        <tr class="headings" >
            
            <th class="column-title text-center" colspan="2">JUMLAH TEMPOH PERKHIDMATAN </th>
            <td class="text-center"><?= $bon->j_bon; ?></td>
          
            
        </tr>
        



 </table>
</form>           </div> <!-- div for row-->
          <!-- div for well-->
</div>
    <div class="x_panel">

    
         <div class="x_title">
   <h2><strong><i class="fa fa-book"></i> MAKLUMAT BON PERKHIDMATAN</strong></h2>
   <div class="clearfix"></div>
</div>
                                  <?php
                if (!$bon1){

                //if ($model->status !=0 ) {
                echo Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-bon-khidmat', 'id' => $model->ICNO]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
                
                </p>
            
       
                <?php }
 else {
    echo Html::button('Kemaskini Maklumat <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-bon-khidmat', 'id' => $model->ICNO]),
                     'class' => 'btn btn-primary btn-xs mapBtn'])                               
                 ;
                 
 }
?>
  
 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
 
    <tbody>
         <?php if($bon1){ ?>
        <?php $bil=1; foreach ($bon1 as $bon) { ?>
        <tr>
            <th class="column-title text-left">TEMPOH BON PHD </th>
            <td class="text-left">: <?= $bon->t_phd; ?></td>
        </tr>
        <tr>
            <th class="column-title text-left">TEMPOH BON SABATIKAL</th>
            <td class="text-left">: <?= $bon->t_sabatikal; ?></td>
        </tr>
           
      
      
                    
         
        <tr class="headings" >
            
            <th class="column-title text-left">JUMLAH BON</th>
            <td class="text-left" colspan="4">: <?= $bon->j_bon; ?></td>
          
            
        </tr>
        
         <tr class="headings" >
            
            <th class="column-title text-left" >JUMLAH PERKHIDMATAN DARI LAPOR DIRI</th>
            <td class="text-left">: <?= $bon->j_lapor; ?></td>
          
            
        </tr>
        <tr class="headings" >
            
            <th class="column-title text-left">BAKI BON PERKHIDMATAN</th>
            <td class="text-left" colspan="4">: <?= $bon->baki_bon; ?></td>
          
            
        </tr>
        
  <?php }}
  ?>


 </table>
</form>           </div> <!-- div for row-->
     <!-- div for well-->

                



<?php }
else if ($_GET['page'] == "tuntut-gantirugi") {?>

 <div class="x_panel">

    
         <div class="x_title">
   <h2><strong><i class="fa fa-money"></i> PENGIRAAN JUMLAH GANTIRUGI</strong></h2>
   <div class="clearfix"></div>
</div>
                                  <?php
                if (!$tuntut){

                //if ($model->status !=0 ) {
                echo Html::button('Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['add-tuntutan-gantirugi', 'id' => $model->ICNO]),'class' => 'btn btn-primary btn-xs mapBtn']) ?>
                
          
            
       
                <?php }
 else {
    echo Html::button('Kemaskini Maklumat <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-tuntut', 'id' => $model->ICNO]),
                     'class' => 'btn btn-primary btn-xs mapBtn']); 
 }
?>
  
 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
 
    <tbody>
         <?php if($tuntut){ ?>
        <?php $bil=1; foreach ($tuntut as $tuntut) { ?>
        <tr>
            <th class="column-title text-left">JENIS TUNTUTAN </th>
            <td class="text-left">= 
            <?= $tuntut->jenis_tuntutan; ?><br/>
            <?= $tuntut->perkara;?><br/>
            JUMLAH GANTIRUGI <?= $tuntut->j_gantirugi; ?>
         </td>
        </tr>
        <tr>
            <th class="column-title text-left">PERKARA</th>
            <td class="text-left">: <?= $tuntut->perkara; ?></td>
        </tr>
           
      
      
                    
         
       
        
         
        
        
  <?php }} ?>


 </table>
</form>           </div> <!-- div for row-->
            </div>

</div>


<?php }
else if ($_GET['page'] == "nominal-damages") {?>

 <div class="x_panel">

    
         <div class="x_title">
   <h2><strong><i class="fa fa-money"></i> REKOD NOMINAL DAMAGES</strong></h2>
   <div class="clearfix"></div>
</div>
                              
  
 <div>
<form id="w0" class="form-horizontal form-label-left" action="">
   <table class="table table-bordered jambo_table">
 
    <tbody>
         <?php if($nd){ ?>
        
        <?php $bil=1; foreach ($nd as $nd) { ?>
        <tr class="headings" >
            
            <th class="column-title text-left" style="width:300px" >TARIKH NOMINAL DAMAGES</th>
            <td class="text-left">: <?= strtoupper($nd->tarikhnd); ?></td>
          
            
        </tr>
       
      
      
                    
         
       
        
         
        
        
  <?php }} else{
  echo "Tiada Rekod";}
  } ?>


 </table>
</form>           </div> <!-- div for row-->
            </div>


</div>
       </div>   
<?php }?>
   

