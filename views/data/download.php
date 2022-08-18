<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblSelfhealth;
use app\models\kehadiran\TblWfh;
use app\models\hronline\Department;

error_reporting(0);

?>
<style>
    table, th, td {
  border-collapse: collapse;
}
th{
    text-align:center;
    border: 1px solid black;
}
table, th, td {
  border-collapse: collapse;
}
td{
    text-align:center;
    border: 1px solid black;
}
</style>
<?= $this->render('_topmenu') ?>




<div class ="row">  
    <div class="col-md-12 col-sm-12 col-xs-12">

        <div class ="x_panel">                    
            <div class="x_title">
                <h5>STATISTIK KEHADIRAN KAKITANGAN UNIVERSITI MALAYSIA SABAH KE PEJABAT BAGI TEMPOH PKP 3.0<br>
                    FASA 2 (PEMULIHAN SABAH): MULAI 21 JULAI 2021</h5>
              

                <div class="clearfix"></div>
            </div>
            <table class="table table-sm table-bordered">
                <tr>
<!--                                            <th>TARIKH</th>-->
                    <th class="text-center">KAMPUS</th>
                    <th class="text-center">% DIBENARKAN WFO</th>
                    <th class="text-center">JUMLAH KAKITANGAN KESELURUHAN
                        <br><small> (TANPA MENGAMBIL KIRA PROF ADJUNG)</small></th>
                    <th class="text-center">JUMLAH KAKITANGAN CUTI BELAJAR</th>
                    <th class="text-center">JUMLAH KAKITANGAN KESELURUHAN
                        <br><small> (TANPA MENGAMBIL KIRA PROF ADJUNG)</small></th>
                    <th class="text-center">KAKITANGAN<br> <i>ESSENTIAL SERVICES (100%)</i></th>
                    <th class="text-center">KAKITANGAN<br> <i>NON- ESSENTIAL SERVICES (A)</i></th>
                    <th class="text-center">WFH (B)</th>
                    <th class="text-center">WFO (A-B)</th>
                    <th class="text-center">% WFO</th>
                    
                    <th class="text-center">CATATAN</th>
                </tr>



                <tr>
                    <td>UMS KOTA KINABALU</td>
                    <td class="text-center">60%</td>
                    <td class="text-center"><?php echo Html::a(Department::countStaffUms(3)); ?></td>
                    <td class="text-center"><?php echo Html::a(Department::countStaffKampus(7)); ?></td>
                    <td class="text-center">
                        <?= Department::countStaffUms(3) - Department::countStaffKampus(7) ?></td>
                    <td class="text-center"><?php
                        $a = Department::countStaffUms(3) - Department::countStaffKampus(7);

                        $b = ($date1 >= '2020-06-24') ? TblSelfhealth::totalNonEssentialKk($date1, 1, $jfpib) : count(array_filter(TblSelfhealth::campus(1, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from office');
                                        }));
                        echo $a - $b;
                        ?></td>
                    <td class="text-center"> 
                        <?php
                        $a = Department::countStaffUms(3) - Department::countStaffKampus(7);

                        $b = ($date1 >= '2020-06-24') ? TblSelfhealth::totalNonEssentialKk($date1, 1, $jfpib) : count(array_filter(TblSelfhealth::campus(1, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from office');
                                        }));
                        $c = $a - $b;
                        $d = Department::countStaffUms(3) - Department::countStaffKampus(7);
                        echo $d - $c;
                        ?></td>
                    <td class="text-center"><?=
                        ($date1 >= '2020-06-24') ? TblSelfhealth::totalBdr($date1, 1, $jfpib) : count(array_filter(TblSelfhealth::campus(1, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from home');
                                        }))
                        ?></td>
                    <td class="text-center"><?=
                        ($date1 >= '2020-06-24') ? TblSelfhealth::totalWfoKk($date1, 1, $jfpib) : count(array_filter(TblSelfhealth::campus(1, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from Office');
                                        }))
                        ?></td>
                    
                    <td class="text-center">
                        <?php
                        $a = ($date1 >= '2020-06-24') ? TblSelfhealth::totalWfoKk($date1, 1, $jfpib) : count(array_filter(TblSelfhealth::campus(1, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from Office');
                                        }));
                        $b = Department::countStaffUms(3) - Department::countStaffKampus(7);

                        echo round((($a / $b) * 100), 2);
                        ?></td>
                    <td class="text-center" rowspan="3">Sabah kini memasuki Fasa 2. Peratus kehadiran ke pejabat dinaikkan ke 60%  selaras dengan 
                        pelaksanaan Pelan Pemulihan Negara berfasa dan arahan dari KSN bertarikh 21 Julai 2021. </td>

                </tr>
                <tr>
                    <td>FAKULTI PERTANIAN LESTARI (FPL), SANDAKAN</td>
                    <td class="text-center">60%</td>
                    <td class="text-center"><?php echo Html::a(Department::countStaffKampus(4)); ?></td>
                    <td class="text-center"><?php echo Html::a(Department::countStaffKampus(8)); ?></td>
                    <td class="text-center"><?= Department::countStaffKampus(4) - Department::countStaffKampus(8) ?> </td>
                    <td class="text-center"><?php
                        $a = Department::countStaffUms(4) - Department::countStaffKampus(8);

                        $b = ($date1 >= '2020-06-24') ? TblSelfhealth::totalNonEssentialSdk($date1, 3, $jfpib) : count(array_filter(TblSelfhealth::campus(3, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from office');
                                        }));
                        echo $a - $b;
                        ?></td>
                    <td class="text-center"> 
                        <?php
                        $a = Department::countStaffUms(4) - Department::countStaffKampus(8);

                        $b = ($date1 >= '2020-06-24') ? TblSelfhealth::totalNonEssentialSdk($date1, 3, $jfpib) : count(array_filter(TblSelfhealth::campus(3, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from office');
                                        }));
                        $c = $a - $b;
                        $d = Department::countStaffUms(4) - Department::countStaffKampus(8);
                        echo $d - $c;
                        ?></td>
                    <td class="text-center"><?=
                        ($date1 >= '2020-06-24') ? TblSelfhealth::totalWfhSandakan($date1, 3, $jfpib) : count(array_filter(TblSelfhealth::campus(3, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from home');
                                        }))
                        ?></td>
                    <td class="text-center"><?=
                        ($date1 >= '2020-06-24') ? TblSelfhealth::totalWfoSandakan($date1, 3, $jfpib) : count(array_filter(TblSelfhealth::campus(3, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from Office');
                                        }))
                        ?></td>
                    <td class="text-center">
                        <?php
                        $a = ($date1 >= '2020-06-24') ? TblSelfhealth::totalWfoSandakan($date1, 1, $jfpib) : count(array_filter(TblSelfhealth::campus(1, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from Office');
                                        }));
                        $b = Department::countStaffUms(4) - Department::countStaffKampus(8);

                        echo round((($a / $b) * 100), 2);
                        ?></td>

                </tr>
                <tr>
                    <td>PUSAT KESIHATAN KUDAT, UMS</td>
                    <td class="text-center">60%</td>
                    <td class="text-center"><?php echo Html::a(Department::countStaffKampus(6)); ?></td>
                    <td class="text-center"><?php echo Html::a(Department::countStaffKampus(10)); ?></td>
                    <td class="text-center">
                        <?=
                        Department::countStaffKampus(6) -
                        Department::countStaffKampus(10)
                        ?></td>
                    <td class="text-center">14</td>
                    <td class="text-center">
                        <?=
                        (Department::countStaffKampus(6) -
                        Department::countStaffKampus(10)) - 14
                        ?></td>
                    <td class="text-center">0</td>
                    <td class="text-center">0</td>
                    <td class="text-center">0.00</td>


                </tr>
                <tr>
                    <td>UNIVERSITI MALAYSIA SABAH KAMPUS ANTARABANGSA LABUAN(KAL)</td>
                    <td class="text-center">40%</td>
                    <td class="text-center"><?php echo Html::a(Department::countStaffKampus(5)); ?></td>
                    <td class="text-center"><?php echo Html::a(Department::countStaffKampus(9)); ?></td>
                    <td class="text-center">
                        <?= Department::countStaffUms(5) - Department::countStaffKampus(9) ?></td>
                    <td class="text-center"><?php
                        $a = Department::countStaffUms(5) - Department::countStaffKampus(9);

                        $b = ($date1 >= '2020-06-24') ? TblSelfhealth::totalNonEssentialLbu($date1, 2, $jfpib) : count(array_filter(TblSelfhealth::campus(2, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from office');
                                        }));
                        echo $a - $b;
                        ?></td>
                    <td class="text-center"> 
                        <?php
                        $a = Department::countStaffUms(5) - Department::countStaffKampus(9);

                        $b = ($date1 >= '2020-06-24') ? TblSelfhealth::totalNonEssentialLbu($date1, 2, $jfpib) : count(array_filter(TblSelfhealth::campus(2, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from office');
                                        }));
                        $c = $a - $b;
                        $d = Department::countStaffUms(5) - Department::countStaffKampus(9);
                        echo $d - $c;
                        ?></td>
                    <td class="text-center"> <?=
                        ($date1 >= '2020-06-24') ? TblSelfhealth::totalWfhLabuan($date1, 2, $jfpib) : count(array_filter(TblSelfhealth::campus(2, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from home');
                                        }))
                        ?></td>
                    <td class="text-center"> <?=
                        ($date1 >= '2020-06-24') ? TblSelfhealth::totalWfoLabuan($date1, 2, $jfpib) : count(array_filter(TblSelfhealth::campus(2, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from Office');
                                        }))
                        ?></td>
                    <td class="text-center">
                        <?php
                        $a = ($date1 >= '2020-06-24') ? TblSelfhealth::totalWfoLabuan($date1, 1, $jfpib) : count(array_filter(TblSelfhealth::campus(1, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from Office');
                                        }));
                        $b = Department::countStaffUms(5) - Department::countStaffKampus(9);

                        echo round((($a / $b) * 100), 2);
                        ?></td>
                    <td class="text-center">WP Labuan masih lagi di Fasa 1. Peratus kehadiran ke pejabat masih kekal pada 40%</td>

                </tr>

            </table>
            <!--<div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Staf Pentadbiran</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_title">
                        <h2>Keseluruhan</h2><div  class="pull-right">
                        <? 
                        ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumnsP,
                            'filename' => 'laporan_myidp_pentadbiran_'.date('Y-m-d'),
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/myidp/.',
                            'linkPath' => '/files/myidp/',
                            'batchSize' => 10,
            //                'deleteAfterSave' => true
                        ]); 
                        ?></div>
                        <div class="clearfix"></div>
                        
                    </div>
                        <div class="x_content">
                           <? 
                                    GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        //'filterModel' => $kursusJemputan,
                                        'showFooter' => true,
                                        'emptyText' => 'Tiada data ditemui.',
                                        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                                        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                                        'columns' => $gridColumnsP,
                                    ]); ?> 
                        </div>  x_content 
                    </div>
                </div>
            </div>-->


        </div> <!-- x_content -->
    </div>
</div>











