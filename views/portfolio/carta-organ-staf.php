<?php
use yii\helpers\Html;
use kongoon\orgchart\OrgChart;
?>





<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?> 
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_content"> 

    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->

<?php
  echo Html::a(Yii::t('app','<i class="fa fa-users"></i> <span class="label label-info">MAKLUMAT UMUM</span>'), ['/portfolio/maklumat-bahagian','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-university"></i> <span class="label label-success">MAKLUMAT KHUSUS</span>'), ['/portfolio/carta-organ-staf','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-book"></i> <span class="label label-info">MAKLUMAT JD</span>'), ['/portfolio/deskripsi-tugas','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);


?>
         </div>
    </div>
     <div class="x_panel">
         <div class="x_content"> 
   
<?php
  echo Html::a(Yii::t('app','CARTA ORGANISASI'), ['/portfolio/carta-organ-staf','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
  echo Html::a(Yii::t('app','CARTA FUNGSI'), ['/portfolio/carta-fungsi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','AKTIVITI FUNGSI'), ['/portfolio/aktiviti-fungsi','id' => $deskripsi->id], ['class' => 'btn btn-success']);

  echo Html::a(Yii::t('app','PROSES KERJA'), ['/portfolio/proses-kerja','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','SENARAI UNDANG-UNDANG'), ['/portfolio/senarai-undang','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  
 echo Html::a(Yii::t('app','SENARAI BORANG'), ['/portfolio/senarai-borang','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','SENARAI JAWATANKUASA'), ['/portfolio/senarai-jawatankuasa','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','PERAKUAN'), ['/portfolio/perakuan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
   echo Html::a(Yii::t('app','JANA MYPORTFOLIO'), ['/portfolio/jana-portfolio','id' => $deskripsi->id], ['class' => 'btn btn-success']);

  ?>
         </div></div>


     <div class="x_panel">
                     <div class="x_content">
                      
            <div class="table-responsive">
            <div class="product_price">

        <center><h4> <span class="label label-success">CARTA ORGANISASI <?= strtoupper($deskripsi->department->fullname);?></span></h4></center>
            </div>
  <?php  
  
  

echo OrgChart::widget([
    
    
   // 'model' => $model,
    'data' => $model,

//     'data' => [
//            [['v' => '1.1', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Mike&w=120&h=150" /><br  /> <strong>Sharifah Ismail</strong><br  />'],'', ''],
//            [['v' => '2.1', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Norlina</strong><br  />The Test'],'1.1', 'VP'],
//          
//         
//              [['v' => '2.2', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Sharifah Ismail</strong><br  />The Test'],'1.1', 'VP'],
//              [['v' => '2.2.1', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Illani</strong><br  />The Test'],'2.2', 'VP'],
//              [['v' => '2.2.2', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Erneh</strong><br  />The Test'],'2.2', 'VP'],
//              [['v' => '2.4', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Norlina</strong><br  />The Test'],'1.1', 'VP'],
//         
//         
//         
//         
//            [['v' => '2.3', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Saffuan</strong><br  />The Test'],'1.1', 'VP'],
//            [['v' => '2.3.1', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Asrafuddin</strong><br  />The Test'],'2.3', 'VP'],
//            [['v' => '2.3.2', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Dalton</strong><br  />The Test'],'2.3', 'VP'],
//    
//         
//         
//           [['v' => '3.1', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Asfie</strong><br  />The Test'],'2.1', 'VP'],
//           [['v' => '3.1.1', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Ryna</strong><br  />The Test'],'3.1', 'VP'],
//        
//           [['v' => '3.2', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Muhammad Arbe</strong><br  />The Test'],'2.1', 'VP'],
//            [['v' => '3.3', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Revina</strong><br  />The Test'],'2.1', 'VP'],
//            [['v' => '3.4', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Chaplene</strong><br  />The Test'],'2.1', 'VP'],
//            [['v' => '3.4.1', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Azizah</strong><br  />The Test'],'3.4', 'VP'],
//      
//         
//             [['v' => '3.5', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Dk Mastikah</strong><br  />The Test'],'2.1', 'VP'],
//            [['v' => '3.6', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Norlina</strong><br  />The Test'],'2.1', 'VP'],
//         
//         ]
    
    ]) ?>

</div>
                     </div></div>
 
            

</div>
</div>