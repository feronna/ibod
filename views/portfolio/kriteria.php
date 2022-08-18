<?php

use app\models\talent\GredSettings;
use yii\helpers\Html;
?>

<style>
    .staff-box {
        border: 1px outset black;
        text-align: center;
        width: 15%;
        padding: 10px;
        margin: 10px;
        font-weight: bold;
        justify-content: space-evenly;
    }

    .gred-box {
        border: 1px outset black;
        text-align: center;
        width: 100px;
        padding: 10px;
        margin: 10px;
        font-weight: bold;
        display: block;
    }


    .flex-container {
        padding: 0;
        margin: 0;
        list-style: none;
        /* border: 1px solid silver; */
        -ms-box-orient: horizontal;
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -moz-flex;
        display: -webkit-flex;
        display: flex;
        justify-content: space-evenly;
    }

    .wrap {
        -webkit-flex-wrap: wrap;
        flex-wrap: wrap;
    }

    .wrap li {
        background: none;
    }


    .flex-item {
        padding: 10px;
        width: 15%;
        /* height: 100px; */
        margin: 10px;

        /* line-height: 100px; */
        /* color: white; */
        font-weight: bold;
        font-size: 12px;
        text-align: center;
        border: 1px outset black;
    }
</style>



<div class="row">

    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-search"></i><?= $this->title ?></strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?= Html::beginForm(['kriteria2'], 'GET', ['class' => 'form-horizontal form-label-left disable-submit-buttons']); ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB</label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <?= Html::dropDownList('dept_id', $dept_id, $arrDept, ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>
            </div>
         
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                    <?= Html::submitButton('<i class="fa fa-search"></i> Carian', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
            <?= Html::endForm(); ?>

        </div>

    </div>

</div>

<div class="row">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-search"></i> Laporan</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-sm jambo_table table-bordered">
                    <thead>
                        <tr class="headings">
                            <th class="text-center" width="20%">Gred</th>
                            <th class="text-center">Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php if ($holder) { ?>
                            <tr style="background-color:#A7E2D7; font-weight:bold">
                                <td>
                                    <div class="gred-box center-box">
                                        <?php echo $holder->kakitangan->jawatan->gred; ?>
                                    </div>
                                </td>
                                <td>
                                    <ul class="flex-container wrap">
                                        <li class="flex-item">
                                            <?php echo $holder->kakitangan->displayTitleName; ?>
                                            <br>
                                            <?php echo $holder->kakitangan->tarikhtamatlantik; ?>
                                            <br>
                                            <?php echo $holder->kakitangan->department->shortname; ?>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="2">
                                    <font style="color: red;font-size:large"><i>-- Tiada penyandang bagi jawatan ini buat masa sekarang --</i></font>
                                </td>
                            </tr>
                        <?php } ?>
                            
                      <?php foreach ($gredList as $gredLists) { ?>
                                <?php if ($staff = \app\models\portfolio\TblCartaJabatan::getStaf($gredLists->level, $holder_icno, $dept_id)) { ?>
                                <tr>
                                    <td>
                                        <div class="gred-box center-box">
                                            <?= $gredLists->level; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <ul class="flex-container wrap">
                                            <?php foreach ($staff as $staffs) { ?>
                                                <li class="flex-item">
                                                    <?= $staffs->icno; ?>
                                                    <br>
                                                    <?= $staffs->icno; ?>
                                                    <br>
                                                    <?php

                                                    try {
                                                        echo $staffs->department->shortname;
                                                    } catch (Exception $e) {
                                                        echo '--No Dept--';
                                                    }

                                                    ?>
                                                </li>
                                            <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }
                         
                         ?>
                                
                    </tbody>
                    
                    
                </table>
                
            </div>
        </div>
    </div>
</div>