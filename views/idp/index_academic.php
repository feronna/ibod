<?php //needed for Html tag usage

use app\widgets\TopMenuWidget;
use yii\helpers\Html;
use app\widgets\IdpTileWidget;
use yii\bootstrap\Alert;
use app\models\myidp\Kehadiran;

/* Menu */
echo $this->render('/idp/_topmenu'); 
?>

<div class="clearfix"></div> 
<div class="row">
    <div class="col-xs-12 col-md-4">
            <?php
            $testingPage1 = IdpTileWidget::widget(
                            [
                                'icon' => 'pie-chart',
                                //'icon' => 'fas fa-chart-pie',
                                'header' => 'Teras (50%)',
                                //'text' => '<p class="bg-primary">Kursus wajib universiti</p>',
                                'text' => 'Kursus Teras',
                                'number' => $individualTerasAcademic . '/' . $minTerasAcademic,
                                'pbar' => '<div class="'.$taprogressBarColour.' role="progressbar" data-transitiongoal="'.$percentageTerasAcademic.'">'.$percentageTerasAcademic.'%</div>',
                            ]
            );
            echo Html::a($testingPage1, ['idp/index?page=viewTerasAca'], ['title'=> 'Sila klik untuk melihat senarai kursus dihadiri.']);
            ?> 
    </div>
    <div class="col-xs-12 col-md-4">
            <?php
            $testingPage2 = IdpTileWidget::widget(
                            [
                                'icon' => 'pie-chart',
                                'header' => 'Elektif (30%)',
                                'text' => 'Kursus Elektif',
                                'number' => $individualElektifAcademic . '/' . $minElektifAcademic,
                                'pbar' => '<div class="'.$eprogressBarColour.' role="progressbar" data-transitiongoal="'.$percentageElektif.'">'.$percentageElektif.'%</div>',
                            ]
            );
            echo Html::a($testingPage2, ['idp/index?page=viewElektifAca'], ['title'=> 'Sila klik untuk melihat senarai kursus dihadiri.']);
            ?>
    </div>
    <div class="col-xs-12 col-md-4">
            <?php
            $testingPage3 = IdpTileWidget::widget(
                            [
                                'icon' => 'pie-chart',
                                'header' => 'Umum (20%)',
                                'text' => 'Kursus Umum',
                                'number' => $individualUmumAcademic . '/' . $minUmumAcademic,
                                'pbar' => '<div class="'.$uaprogressBarColour.' role="progressbar" data-transitiongoal="'.$percentageUmumAcademic.'">'.$percentageUmumAcademic.'%</div>',
                            ]
            );
            echo Html::a($testingPage3, ['idp/index?page=viewUmum'], ['title'=> 'Sila klik untuk melihat senarai kursus dihadiri.']);
            ?>
        </div>
</div>
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h5>IDP Semasa</h5>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <p>Mata IDP Minimum Kumpulan</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="x_panel">
                                    <div><?= /**$modelcpdgroup->mataMin**/ $modelRpt->idp_mata_min ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <p>Jumlah Mata IDP Semasa</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="x_panel">
                                    <div><?= $individualTerasAcademic + $individualUmumAcademic + $individualElektifAcademic ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <p>Jumlah Mata IDP Yang Diambilkira</p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="x_panel">
                                    <div><?= $jumlahMataAmbilKira ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <?php
                
                    if (isset($_GET['page'])) {
                        echo '<h2>Senarai Kursus Dihadiri</h2>';
                    } else {
                        echo '<h2>Maklumat Diri</h2>';
                    }
                ?>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini -->
                    <?php
                    
                    $bil = 1;
                    
                        if (isset($_GET['page'])) {
                            if ($_GET['page'] == "viewTerasAca") {
                                ?><p>Kursus Teras Akademik</p><?php
                                if ($teras) {?>
                                    <table class="table table-striped jambo_table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Bil</th>
                                                <th class="text-center">Nama Kursus</th>
                                                <th class="text-center">Tarikh Kursus</th>
                                                <th class="text-center">Jumlah Mata</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        foreach ($teras as $lat) {
                                        //echo $lat->latihan->vcsl_nama_latihan . '<br>';?>
                                            <tr>
                                                <td class="text-center"><?php echo $bil++ ?></td>
                                                <td class="text-left"><?php echo $lat->sasaran3->tajukLatihan;
                                                            //$lat->sasaran9->sasaran4->sasaran3->tajukLatihan; 
                                                                            //echo $lat->tajukLatihan; ?></td>
                                            <?php 
                                            
                                                /** old
                                                $tarikhKursus = $lat->sasaran9->sasaran4->tarikhMula;
                                                
                                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                                $formatteddate = $myDateTime->format('d-m-Y');
                                                 * 
                                                 */
                                            
                                            ?>
                                                <td class="text-center"><?php echo $lat->tarikhKursus2; ?></td>
                                                <td class="text-center"><?php echo Kehadiran::calculateMata($lat->siriLatihanID); ?></td>
                                            </tr>
                                            <?php
                                        }
                                }else { ?>
                                    <tr>
                                        <td colspan="3" class="align-center text-center"><i>Belum Hadir Latihan</i></td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <?php
                            } else if ($_GET['page'] == "viewElektifAca") {
                                ?><p>Kursus Elektif Akademik</p><?php
                                if ($elektif) {?>
                                    <table class="table table-striped jambo_table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Bil</th>
                                                <th class="text-center">Nama Kursus</th>
                                                <th class="text-center">Tarikh Kursus</th>
                                                <th class="text-center">Jumlah Mata</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        foreach ($elektif as $lat) {
                                        //echo $lat->latihan->vcsl_nama_latihan . '<br>';?>
                                            <tr>
                                                <td class="text-center"><?php echo $bil++ ?></td>
                                                <td class="text-left"><?php echo $lat->sasaran3->tajukLatihan;
                                                            //$lat->sasaran9->sasaran4->sasaran3->tajukLatihan; 
                                                                            //echo $lat->tajukLatihan; ?></td>
                                            <?php 
                                            
                                                /** old
                                                $tarikhKursus = $lat->sasaran9->sasaran4->tarikhMula;
                                                
                                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                                $formatteddate = $myDateTime->format('d-m-Y');
                                                 * 
                                                 */
                                            
                                            ?>
                                                <td class="text-center"><?php echo $lat->tarikhKursus2; ?></td>
                                                <td class="text-center"><?php echo Kehadiran::calculateMata($lat->siriLatihanID); ?></td>
                                            </tr>
                                            <?php
                                        }
                                }else { ?>
                                    <tr>
                                        <td colspan="3" class="align-center text-center"><i>Belum Hadir Latihan</i></td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <?php
                            } else {
                                ?><p>Kursus Umum Akademik</p><?php
                                if ($umum) {?>
                                    <table class="table table-striped jambo_table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Bil</th>
                                                <th class="text-center">Nama Kursus</th>
                                                <th class="text-center">Tarikh Kursus</th>
                                                <th class="text-center">Jumlah Mata</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        foreach ($umum as $lat) {
                                        //echo $lat->latihan->vcsl_nama_latihan . '<br>';?>
                                            <tr>
                                                <td class="text-center"><?php echo $bil++ ?></td>
                                                <td class="text-left"><?php echo $lat->sasaran3->tajukLatihan;
                                                            //$lat->sasaran9->sasaran4->sasaran3->tajukLatihan; 
                                                                            //echo $lat->tajukLatihan; ?></td>
                                            <?php 
                                            
                                                /** old
                                                $tarikhKursus = $lat->sasaran9->sasaran4->tarikhMula;
                                                
                                                $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                                $formatteddate = $myDateTime->format('d-m-Y');
                                                 * 
                                                 */
                                            
                                            ?>
                                                <td class="text-center"><?php echo $lat->tarikhKursus2; ?></td>
                                                <td class="text-center"><?php echo Kehadiran::calculateMataUmum($lat->siriLatihanID); ?></td>
                                            </tr>
                                            <?php
                                        }
                                }else { ?>
                                    <tr>
                                        <td colspan="3" class="align-center text-center"><i>Belum Hadir Latihan</i></td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <?php
                            } 
                        } else {
                            ?>
<!--                                <div class="well">-->
                                <div>
                                    <b>TEMPOH PERKHIDMATAN DI GRED SEMASA : <?php echo $model3->tempohKhidmatGredSemasa; ?>
                                    <br>TAHAP : 
                                        <?php 
                                            if ($model3->tahapKhidmat == '3'){
                                                echo "LANJUTAN";
                                            } elseif ($model3->tahapKhidmat == '2') {
                                                echo "PERTENGAHAN";
                                            } else {
                                                echo "ASAS";
                                            } 
                                        ?> 
                                    <br>
                                        <?php 
                                            if (!$model5){
                                                
                                                echo "<div style='color:red'>
                                                    SILA BERHUBUNG DENGAN PENYELIA CUTI/STARS UNTUK MENGEMASKINI MAKLUMAT PEGAWAI PERAKU/PELULUS.
                                                        </div>";
                                                
                                            } else {
                                                
                                                if ($model5->peraku || $model5->pelulus ){
                                        
                                                    if (($model4->DisplayPeraku($model3->ICNO))){
                                                        echo "PEGAWAI PERAKU : ";

                                                        if ($model4->DisplayPeraku($model3->ICNO) != "TERUS KEPADA PEGAWAI MELULUS") {
                                                            echo ucwords(strtoupper($model5->peraku->gelaran->Title));

                                                        }
                                                        echo ' ';
                                                        echo $model4->DisplayPeraku($model3->ICNO);
                                                        echo "<br>";
                                                        echo "PEGAWAI PELULUS : ";
                                                        echo ucwords(strtoupper($model5->pelulus->gelaran->Title)).' '.$model4->DisplayPelulus($model3->ICNO);

                                                    } else {
                                                        echo "PEGAWAI PELULUS : ";
                                                        echo ucwords(strtoupper($model5->pelulus->gelaran->Title)).' '.$model4->DisplayPelulus($model3->ICNO);
                                                    }
                                                }
                                            }
                                        ?>
                                    </b>
                                </div>  <!-- closed div class well -->
                            <?php
                            } ?>              
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
    
    <?php if (!isset($_GET['page'])) { ?>
    <div class="col-md-8 col-sm-8 col-xs-12">   
    <?php if ($akanDatang) { ?>
    
<!--    <div class="col-md-8 col-sm-8 col-xs-12">-->
        <div class="x_panel">
            <div class="x_title">
                <?php
                    echo '<h2>Kursus Akan Datang</h2>&nbsp;&nbsp;<span class="badge bg-red" style="color: white">BARU</span>';
                ?>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini -->
                    <?php
                                if ($akanDatang) {?>
                                    <table class="table table-striped jambo_table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Bil</th>
                                                <th class="text-left">Kursus</th>
                                                <th class="text-center">Tarikh</th>
                                                <th class="text-center">Tempat</th>
                                                <th class="text-center">Pautan</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        foreach ($akanDatang as $lat) {?>
                                            <tr>
                                                <td class="text-center"><?php echo $bil++ ?></td>
                                                <td class="text-left"><?php echo strtoupper($lat->sasaran6->sasaran3->tajukLatihan); ?></td>
                                                <td class="text-center"><?php echo $lat->sasaran6->tarikhKursus2; ?></td>
                                                <td class="text-center"><?php echo strtoupper($lat->sasaran6->lokasi); ?></td>
                                                <td class="text-center">
                                                    
                                                    <?php
                                                    if ($lat->sasaran6->linkZoom){
                                                        echo Html::a('<i class="fa fa-video-camera" aria-hidden="true" text-align="center"></i>', $lat->sasaran6->linkZoom, ['class' => 'btn-sm btn-info btn-block', 'target' => '_blank']);
                                                      } else {
                                                        echo Html::button('<i class="fa fa-ban" aria-hidden="true"></i>', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true]);
                                                      }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        } ?>
                                    </table><?php
                                } ?>
                            
                                </div>  <!-- closed div class well -->           
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
<!--        </div>-->
    
    <?php }

        if ($attended) { ?>
    
<!--    <div class="col-md-8 col-sm-8 col-xs-12">-->
        <div class="x_panel">
            <div class="x_title">
                <?php
                    echo '<h2>Menunggu Tindakan</h2>&nbsp;&nbsp;<span class="badge bg-red" style="color: white">'. count($attended).'</span>';
                ?>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini -->
                    <?php
                                if ($attended) {?>
                                    <table class="table table-striped jambo_table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Bil</th>
                                                <th class="text-center">Nama Kursus</th>
                                                <th class="text-center">Tarikh Kursus</th>
                                                <th class="text-center">Jumlah Mata</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        foreach ($attended as $lat) {?>
                                            <tr>
                                                <td class="text-center"><?php echo $bil++ ?></td>
                                                <td class="text-left"><?php echo $lat->sasaran3->tajukLatihan; ?></td>
                                                <td class="text-center"><?php echo $lat->tarikhKursus2; ?></td>
                                                <td class="text-center"><?php echo Kehadiran::calculateMata($lat->siriLatihanID); ?></td>
                                            </tr>
                                            <?php
                                        } ?>
                                    </table><?php
                                } ?>
                            
                                </div>  <!-- closed div class well -->           
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
<!--        </div>-->
    
<?php } ?> </div> <?php } ?>
    
</div>