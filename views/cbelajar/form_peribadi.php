<?php

use yii\helpers\Html; 
 

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$title = $this->title = 'Maklumat Peribadi';
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
     PERMOHONAN BAHARU PENGAJIAN LANJUTAN SEPENUH MASA
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
</div>
<?php echo $this->render('_menu', ['title' => $title, 'id'=> $iklan->id]) ?>

                    
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">                                                                                                                                                               
            
            <div class="x_title">
                <h4><strong><i class="fa fa-user-circle"></i> MAKLUMAT PERIBADI</strong></h4>
                 <p align ="right">
                    <?php echo Html::a('<i class="fa fa-edit"></i> ', ['biodata/lihatbiodata'], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']); ?>
                  
                </p>
                
                <div class="clearfix"></div>
            </div>
            

             <div class="table-responsive">
               
                    <table class="table table-sm jambo_table table-striped"> 
                        <tr>
                            <th width="25%">Nama Penuh: </th>
                            <td><?= $biodata->gelaran->Title ." ". ucwords(strtolower($biodata->CONm)) ?></td>
                            <th width="25%">Taraf Perkahwinan: </th>
                            <td><?=  ($biodata->displayTarafPerkahwinan) ?></td> 
                         <tr>
                            <th width="25%">Jabatan/Fakulti/Pusat/Institut: </th>
                            <td><?=  ucwords(strtolower($biodata->displayDepartment)) ?></td>  
                            <th width="25%">No. Tel Bimbit: </th>
                            <td><?=  ucwords(strtolower($biodata->COHPhoneNo)) ?></td> 
                        </tr>
                        <tr>
                            <th width="25%">Jawatan & Gred: </th>
                            <td><?=  ($biodata->jawatan->nama) ." ". ($biodata->jawatan->gred) ?></td>  
                            <th width="25%">Emel: </th>
                            <td><?= ($biodata->COEmail) ?></td> 
                        </tr>
                         <tr>
                            <th width="25%">No. Kad Pengenalan: </th>
                            <td><?=  ($biodata->ICNO) ?></td> 
                            <th width="25%">Umur: </th>
                            <td><?=date("Y") - date("Y", strtotime($biodata->COBirthDt))." ". " Tahun"?></td> 
                        </tr>
                        <tr>
                            <th width="25%">Tarikh Lantikan: </th>
                            <td><?=  ($biodata->displayStartLantik) ?></td>  
                          

                          <th class="col-md-2 col-sm-3 col-xs-12 text-left">Tarikh Disahkan Dalam Perkhidmatan: </th> <td>
                            <?php if($model2)
                            {
                                echo $confirm;
                            }
 else {
     echo '-';
     
 }?>
                           </td>
                        
                           
                        </tr>
                        
                        <tr>
                            <th width="25%">Tempoh Berkhidmat (Hingga Kini): </th>
                            <td><?=  ($biodata->tempohkhidmat) ?></td> 
                            <th width="25%">Umur Bersara: </th>
                            <td>
                            <?php if(!$biodata->bersara)
                            {
                            echo "Tiada Maklumat";

                           }
                            else{
                                 echo $biodata->bersara->umurBersara->RetireAgeCd.' Tahun';
                            }
                            
                            ?></td> 
                        </tr>

                         

                    </table><p align ="right">
                  
                    <?= Html::a('Seterusnya', ['maklumat-akademik',  'id' => $iklan->id], ['class' => 'btn btn-info btn-sm']); ?>
                    <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  
                </p>
    
                </div>
            </div>
        
            


 
</div>
</div>