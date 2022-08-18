<?php

use app\models\cuti\Layak;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\widgets\DetailView;

?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <div class="x_panel">
            <div class="x_title">


                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <div class="table-responsive">

                </div>
            </div>

            <div class="clearfix">

                <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
                    <tr class="headings">
                        <th class="column-title text-center"><?php echo Html::img('@web/uploads/patrol/' . $model->bit_name . '.png') ?>
                    
                        <br>
                        <br>
                        <br>
                        <br>
                    </th>

                    </tr>
                    <tr>
                        <body>
                            <td style="padding-left: 210px;
                 padding-bottom: 3px;">
        <strong style="font-size: 35px;"><?php echo $model->bit_name?></td>
                        </body>
                    </tr>




                </table>
            </div>

        </div>
    </div>