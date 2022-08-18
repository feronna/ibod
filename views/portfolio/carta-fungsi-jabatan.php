<?php
use yii\helpers\Html;
use kongoon\orgchart\OrgChart;


?>

<style>
th {
  background-color: #008000;
  color: white;
  text-align: center;
}

</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <?php echo $this->render('menu_info_tugas'); ?> 
</div>

<div class="col-md-3 col-sm-12 col-xs-12"> 
    <?php echo $this->render('menu_services'); ?>   
</div>
    <div class="col-md-9 col-sm-12 col-xs-12">

    <div class="x_panel">
            <div class="product_price">

        <center><h4> <span class="label label-success">CARTA FUNGSI <?= strtoupper($test->department->fullname);?></span></h4></center>
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
    
          <div class="x_panel">
                  <div class="table-responsive">
                <table class="table table-sm table-bordered">
    
     <tr>
                        <th  <td style="width:50px; height: 20px">Bil.</strong></td></th>
                         <th colspan="2" <td style="width:200px; height: 20px">UNIT</strong></td></th>
                         <th colspan="3"<td style="width:500px; height: 20px">FUNGSI UNIT</strong></td></th>
                   
                    </tr>
                               <?php if($fungsiUnit) {
                    
                   foreach ($fungsiUnit as $key=>$item){?>
                    <tr>
                            <td align="center"><?= $key+1?></td>
                            <td colspan="2">
                            <?= ucwords(strtolower($item->unit_details))?> </td>
                             <td colspan="2">
                            <?php echo ($item->TugasUtama2($item->id))?> </td>
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