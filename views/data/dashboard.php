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
    table,tr, th, td {
        border-collapse: collapse;
    }
    td{
        text-align:center;
        border: 1px solid black;
    }
    
    a:link {
  color: green;
  background-color: transparent;
  text-decoration: none;
}
a:visited {
  color: indigo;
  background-color: transparent;
  text-decoration: none;
}
a:hover {
  color: red;
  background-color: transparent;
  text-decoration: underline;
}
a:active {
  color: yellow;
  background-color: transparent;
  text-decoration: underline;
}
</style>

<?= $this->render('_topmenu') ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_content">
                <?php
                $forms = ActiveForm::begin([
                            'action' => [''],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]);
                ?>
                <!--                <div class="form-group">
                                    <div class="col-md-2 col-sm-2 col-xs-6">
                                        <?
                                        Select2::widget([
                                            'name' => 'jfpib',
                                            'value' => $jfpib,
                                            'data' => ArrayHelper::map(app\models\hronline\Department::find(['isActive' => 1])->all(), 'id', 'shortname'),
                                            'options' => ['placeholder' => 'JFPIB'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>-->

                <!--                <div class="form-group">
                                      <div class="col-md-2 col-sm-2 col-xs-6">
                <?=
                Select2::widget([
                    'name' => 'category',
                    'value' => $category,
                    'data' => [1 => 'Academic', 2 => 'Administration'],
                    'options' => ['placeholder' => 'Job category'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                                    </div>
                                </div>-->

                <div class="form-group">
                    <div class="col-md-2 col-sm-2 col-xs-6">
                        <?=
                        DatePicker::widget([
                            'name' => 'date',
                            'value' => $date,
                            'type' => DatePicker::TYPE_INPUT,
                            'options' => ['placeholder' => $date? : 'From 17 JUN 2020', 'autocomplete' => 'off',
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'allowClear' => true,
                                'format' => 'd M yyyy',
                            ]
                        ]);
                        ?>
                    </div>
                </div>


                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="row text-center">

    <?php
    $date1 = date_format(date_create($date), 'Y-m-d');
    $office = (TblSelfhealth::totalWfoKk($date1) +
            TblSelfhealth::totalWfoLabuan($date1) + TblSelfhealth::totalWfoSandakan($date1));
    $home = ($date1 >= '2020-06-24') ? (TblSelfhealth::totalBdr($date1, '', $jfpib) + TblSelfhealth::totalWfhLabuan($date1, '', $jfpib) + TblSelfhealth::totalWfhSandakan($date1, '', $jfpib)) : count(array_filter($model, function ($var) {
                        return ($var['status'] == 'Work from home');
                    }));
    $all = count($biodata);
    ?>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="row">
                <div class="progress progress-mini">
                    <div style="width: <?= $office / $all * 100 ?>%;color:black;" class="progress-bar bg-blue"><?= ' ' . number_format($office / $all * 100, 2) . '%' ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
                <div style="font-size: 25px; color: #7367F0"><b><i class="fa fa-building"></i></div>
                <div style="font-size: 40px;">

                    <?= $office ?>
                </div>
                <div style="font-size: 12px;">
                    <i style="color:green"> Work From Office</i>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                    <li>Kota Kinabalu : <?=
                       TblSelfhealth::totalWfoKk($date1);
                        ?></li>
                    <li>Labuan : <?=
                         TblSelfhealth::totalWfoLabuan($date1);
                                     
                        ?></li>
                    <li>Sandakan : <?=
                        TblSelfhealth::totalWfoSandakan($date1);
                                   
                        ?></li>
                    <li>Kudat : <?=
                        TblSelfhealth::totalWfoKudat($date1);
                        ?></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="row">
                <div class="progress progress-mini">
                    <div style="width: <?= $home / $all * 100 ?>%;color:black;" class="progress-bar bg-blue"><?= ' ' . number_format($home / $all * 100, 2) . '%' ?>
                    </div>
                </div></div>

            <div class="col-md-6 col-sm-6 col-xs-6">
                <div style="font-size: 25px; color: #7367F0"><b><i class="fa fa-home"></i></div>
                <div style="font-size: 40px;">
                    <?= $home; ?>
                </div>
                <div style="font-size: 12px;">
                    <i style="color:green"> Work From Home</i>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                    <li>Kota Kinabalu : <?=
                        ($date1 >= '2020-06-24') ? TblSelfhealth::totalBdr($date1, 1, $jfpib) : count(array_filter(TblSelfhealth::campus(1, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from home');
                                        }))
                        ?></li>
                    <li>Labuan : <?=
                        ($date1 >= '2020-06-24') ? TblSelfhealth::totalWfhLabuan($date1, 2, $jfpib) : count(array_filter(TblSelfhealth::campus(2, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from home');
                                        }))
                        ?></li>
                    <li>Sandakan : <?=
                        ($date1 >= '2020-06-24') ? TblSelfhealth::totalWfhSandakan($date1, 3, $jfpib) : count(array_filter(TblSelfhealth::campus(3, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from home');
                                        }))
                        ?></li>
                    <li>Kudat : <?=
                        count(array_filter(TblSelfhealth::campus(4, $date, $jfpib), function ($var) {
                                    return ($var['status'] == 'Work from home');
                                }))
                        ?></li>
                </ul>
            </div>
        </div>


    </div>

</div>


<div class ="row">  
    <div class="col-md-12 col-sm-12 col-xs-12">

        <div class ="x_panel">                    
            <div class="x_title">
                <h5>STATISTIK KEHADIRAN KAKITANGAN UNIVERSITI MALAYSIA SABAH KE PEJABAT BAGI TEMPOH PKP 3.0<br>
                    FASA 2 (PEMULIHAN SABAH): MULAI 21 JULAI 2021</h5>
                <?=
                Html::a('<div style="float: right; font-size:18px;">'
                        . '<i class="text-success fa fa-download fa-md"></i><small> Muat Turun</small></div>', ['laporan-kehadiran?date='.$date], ['target' => '_blank'])
                ?>

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
                </tr>



                <tr>
                    <td>UMS KOTA KINABALU</td>
                    <td class="text-center">60%</td>
                    <td class="text-center"><?php echo Html::a('<div style="text-decoration:underline";> '.Department::countStaffUms(3), ["list-kakitangan-keseluruhan"], ['target' => '_blank'])?></td>
                    <td class="text-center"><?php echo Html::a('<div style="text-decoration:underline";> '.Department::countStaffKampus(7), ["list-cb-kk"], ['target' => '_blank']); ?></td>
                    <td class="text-center"><?php echo Html::a('<div style="text-decoration:underline";> '. (Department::countStaffUms(3)-Department::countStaffKampus(7)), ["list-kakitangan-keseluruhan"], ['target' => '_blank'])?></td>
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
                      <td class="text-center"><?php echo Html::a
                      ('<div style="text-decoration:underline";> '. TblSelfhealth::totalBdr($date1, 1, $jfpib), ["list-wfh-kk?date=".$date], ['target' => '_blank']); ?></td>

<!--                    <td class="text-center">
                        
                        <
                        ($date1 >= '2020-06-24') ? TblSelfhealth::totalBdr($date1, 1, $jfpib) : count(array_filter(TblSelfhealth::campus(1, $date, $jfpib), function ($var) {
                                            return ($var['status'] == 'Work from home');
                                        }))
                        ?></td>-->
                    <td class="text-center"><?=
                        TblSelfhealth::totalWfoKk($date1, 1, $jfpib);
                                        
                        ?></td>
                    <td class="text-center">
                        <?php
                        $a = TblSelfhealth::totalWfoKk($date1, 1, $jfpib);
                        $b = Department::countStaffUms(3) - Department::countStaffKampus(7);

                        echo round((($a / $b) * 100), 2);
                        ?></td>

                </tr>
                <tr>
                    <td>FAKULTI PERTANIAN LESTARI (FPL), SANDAKAN</td>
                    <td class="text-center">60%</td>
                    <td class="text-center"><?php echo Html::a('<div style="text-decoration:underline";> '.Department::countStaffKampus(4), ["list-kakitangan-sandakan"], ['target' => '_blank']); ?></td>
                    <td class="text-center"><?php echo Html::a('<div style="text-decoration:underline";> '.Department::countStaffKampus(8), ["senarai-all-study", 'category' => 0], ['target' => '_blank']); ?></td>
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
                        TblSelfhealth::totalWfoSandakan($date1, 3, $jfpib) ;
                                        
                        ?></td>
                    <td class="text-center">
                        <?php
                        $a = TblSelfhealth::totalWfoSandakan($date1, 1, $jfpib);
                               
                        $b = Department::countStaffUms(4) - Department::countStaffKampus(8);

                        echo round((($a / $b) * 100), 2);
                        ?></td>

                </tr>
                <tr>
                    <td>PUSAT KESIHATAN KUDAT, UMS</td>
                    <td class="text-center">60%</td>
                    <td class="text-center"><?php echo Html::a('<div style="text-decoration:underline";> '.Department::countStaffKampus(6), ["list-kakitangan-kudat"], ['target' => '_blank']); ?></td>
                    <td class="text-center"><?php echo Html::a('<div style="text-decoration:underline";> '.Department::countStaffKampus(10), ["senarai-all-study", 'category' => 0], ['target' => '_blank']); ?></td>
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
                    <td class="text-center">80%%</td>
                    <td class="text-center"><?php echo Html::a('<div style="text-decoration:underline";> '.Department::countStaffKampus(5), ["list-kakitangan-labuan"], ['target' => '_blank']); ?></td>
                    <td class="text-center"><?php echo Html::a('<div style="text-decoration:underline";> '.Department::countStaffKampus(9), ["senarai-all-study", 'category' => 0], ['target' => '_blank']); ?></td>
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
                      TblSelfhealth::totalWfoLabuan($date1, 2, $jfpib);
                        ?></td>
                    <td class="text-center">
                        <?php
                        $a = TblSelfhealth::totalWfoLabuan($date1, 1, $jfpib)
                                       ;
                        $b = Department::countStaffUms(5) - Department::countStaffKampus(9);

                        echo round((($a / $b) * 100), 2);
                        ?></td>

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











