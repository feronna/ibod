<?php
use yii\helpers\Url;    
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\Institut;
use app\models\cbelajar\PendidikanTertinggi;
use app\models\hronline\Penaja;
use app\models\hronline\Negara;
use app\models\hronline\MajorMinor; 
use app\models\cbelajar\TblTajaan; 
use app\models\cbelajar\TblBantuan; 
error_reporting(0);
$title = $this->title = 'Pembiayaan / Pinjaman';
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
<?php echo $this->render('_menu', ['title' => $title,'id'=> $iklan->id]) ?>

<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-money"></i> Maklumat Pembiayaan / Pinjaman Yang Dipohon</strong></h2> 
             <p align="right">
                <?php echo Html::a('Tambah Biasiswa', ['cutisabatikal/tambah-biasiswa', 'id' => $iklan->id], ['class' => 'btn btn-success btn-sm']); ?>
                
                </p>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">   
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <thead>
                        <tr class="headings">
                            <th class="text-center">Bil</th>
                            <th class="text-center">Nama Tajaan</th>
                            <th class="text-center">Bentuk Tajaan</th>
                            <th class="text-center">Amaun Bantuan (RM)</th>
                            <th class="text-center">Tindakan</th>  
                        </tr>
                    </thead>
                    <?php
                    if ($sponsor) {
                        $counter = 0;
                        foreach ($sponsor as $sponsor) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center"><?= $counter; ?></td>                        
                                <td class="text-center">
                             <?php  if ($sponsor->jenisCd == '1')
                                    {
                                      echo strtoupper($sponsor->nama_tajaan);
                                    }elseif ($sponsor->jenisCd == '2')
                                    {
                                      echo strtoupper($sponsor->nama_tajaan);
                                    }
                                    elseif ($sponsor->jenisCd == '3')
                                    {
                                      echo strtoupper($sponsor->nama_tajaan);
                                    }
                                     elseif ($sponsor->jenisCd == '4')
                                    {
                                      echo strtoupper($sponsor->nama_tajaan);
                                    }
                                ?></td>
                                <td class="text-center">
                                 
                                <?php  
                                    if ($sponsor->BantuanCd == '4')
                                    {
                                      echo strtoupper($sponsor->bantuan->bentukBantuan);
                                    }
                                    elseif ($sponsor->BantuanCd == '6')
                                    {
                                      echo strtoupper($sponsor->bantuan->bentukBantuan);
                                    }
                                    else
                                    {
                                      echo strtoupper($sponsor->bantuan->bentukBantuan);
                                    }
                                    
                                ?>
                                    
                                </td>
                                <td class="text-center"> 
                                    <?php  
                                      echo strtoupper($sponsor->amaunBantuan);
                                    
                                ?>
                                    </td>
                               
                                <td class="text-center">
                                  <?= Html::a('<i class="fa fa-info-circle" aria-hidden="true"></i>', ['cbelajar/lihatbiasiswa', 'id' => $sponsor->id], ['class' => 'btn btn-default']) ?> |

                                 

                                  <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['cbelajar/delete-biasiswa?id='.$sponsor->id.'&i='.$sponsor->iklan_id], ['class' => 'btn btn-default',
                                        'data' => [
                                        'confirm' => 'Anda ingin membuang rekod ini?',
                                        'method' => 'post',
                                        ],
                                    ])
                                  ?>
                                    
                                  </td>  

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                </table>
                <p align ="right">
               
                <?= Html::a('Seterusnya', ['senarai-dokumen-dimuat-naik','id'=>$iklan->id], ['class' => 'btn btn-info btn-sm']);?>
                <?php echo Html::a('Kembali',['maklumat-biasiswa', 'id'=>$iklan->id], ['class' => 'btn btn-primary btn-sm']); ?>  
    
            </p>
            </div>
   </div>
   </div>
</div>


            





          

   



